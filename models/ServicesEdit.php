<?php

namespace PHPMaker2024\taskinator_project_file;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Page class
 */
class ServicesEdit extends Services
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ServicesEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ServicesEdit";

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->ServiceID->setVisibility();
        $this->ServiceName->setVisibility();
        $this->ParentService->setVisibility();
        $this->Status->setVisibility();
        $this->Options->setVisibility();
        $this->CreatedAt->setVisibility();
        $this->UpdatedAt->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'Services';
        $this->TableName = 'Services';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (Services)
        if (!isset($GLOBALS["Services"]) || $GLOBALS["Services"]::class == PROJECT_NAMESPACE . "Services") {
            $GLOBALS["Services"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'Services');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "ServicesView"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['ServiceID'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->ServiceID->Visible = false;
        }
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->ParentService);
        $this->setupLookupOptions($this->Status);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ServiceID") ?? Key(0) ?? Route(2)) !== null) {
                $this->ServiceID->setQueryStringValue($keyValue);
                $this->ServiceID->setOldValue($this->ServiceID->QueryStringValue);
            } elseif (Post("ServiceID") !== null) {
                $this->ServiceID->setFormValue(Post("ServiceID"));
                $this->ServiceID->setOldValue($this->ServiceID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("ServiceID") ?? Route("ServiceID")) !== null) {
                    $this->ServiceID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ServiceID->CurrentValue = null;
                }
            }

            // Load result set
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ServicesList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ServicesList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ServicesList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ServicesList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'ServiceID' first before field var 'x_ServiceID'
        $val = $CurrentForm->hasValue("ServiceID") ? $CurrentForm->getValue("ServiceID") : $CurrentForm->getValue("x_ServiceID");
        if (!$this->ServiceID->IsDetailKey) {
            $this->ServiceID->setFormValue($val);
        }

        // Check field name 'ServiceName' first before field var 'x_ServiceName'
        $val = $CurrentForm->hasValue("ServiceName") ? $CurrentForm->getValue("ServiceName") : $CurrentForm->getValue("x_ServiceName");
        if (!$this->ServiceName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ServiceName->Visible = false; // Disable update for API request
            } else {
                $this->ServiceName->setFormValue($val);
            }
        }

        // Check field name 'ParentService' first before field var 'x_ParentService'
        $val = $CurrentForm->hasValue("ParentService") ? $CurrentForm->getValue("ParentService") : $CurrentForm->getValue("x_ParentService");
        if (!$this->ParentService->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ParentService->Visible = false; // Disable update for API request
            } else {
                $this->ParentService->setFormValue($val);
            }
        }

        // Check field name 'Status' first before field var 'x_Status'
        $val = $CurrentForm->hasValue("Status") ? $CurrentForm->getValue("Status") : $CurrentForm->getValue("x_Status");
        if (!$this->Status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status->Visible = false; // Disable update for API request
            } else {
                $this->Status->setFormValue($val);
            }
        }

        // Check field name 'Options' first before field var 'x_Options'
        $val = $CurrentForm->hasValue("Options") ? $CurrentForm->getValue("Options") : $CurrentForm->getValue("x_Options");
        if (!$this->Options->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Options->Visible = false; // Disable update for API request
            } else {
                $this->Options->setFormValue($val);
            }
        }

        // Check field name 'CreatedAt' first before field var 'x_CreatedAt'
        $val = $CurrentForm->hasValue("CreatedAt") ? $CurrentForm->getValue("CreatedAt") : $CurrentForm->getValue("x_CreatedAt");
        if (!$this->CreatedAt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CreatedAt->Visible = false; // Disable update for API request
            } else {
                $this->CreatedAt->setFormValue($val, true, $validate);
            }
            $this->CreatedAt->CurrentValue = UnFormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern());
        }

        // Check field name 'UpdatedAt' first before field var 'x_UpdatedAt'
        $val = $CurrentForm->hasValue("UpdatedAt") ? $CurrentForm->getValue("UpdatedAt") : $CurrentForm->getValue("x_UpdatedAt");
        if (!$this->UpdatedAt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->UpdatedAt->Visible = false; // Disable update for API request
            } else {
                $this->UpdatedAt->setFormValue($val, true, $validate);
            }
            $this->UpdatedAt->CurrentValue = UnFormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern());
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ServiceID->CurrentValue = $this->ServiceID->FormValue;
        $this->ServiceName->CurrentValue = $this->ServiceName->FormValue;
        $this->ParentService->CurrentValue = $this->ParentService->FormValue;
        $this->Status->CurrentValue = $this->Status->FormValue;
        $this->Options->CurrentValue = $this->Options->FormValue;
        $this->CreatedAt->CurrentValue = $this->CreatedAt->FormValue;
        $this->CreatedAt->CurrentValue = UnFormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern());
        $this->UpdatedAt->CurrentValue = $this->UpdatedAt->FormValue;
        $this->UpdatedAt->CurrentValue = UnFormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern());
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
        $this->ServiceID->setDbValue($row['ServiceID']);
        $this->ServiceName->setDbValue($row['ServiceName']);
        $this->ParentService->setDbValue($row['ParentService']);
        $this->Status->setDbValue($row['Status']);
        $this->Options->setDbValue($row['Options']);
        $this->CreatedAt->setDbValue($row['CreatedAt']);
        $this->UpdatedAt->setDbValue($row['UpdatedAt']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ServiceID'] = $this->ServiceID->DefaultValue;
        $row['ServiceName'] = $this->ServiceName->DefaultValue;
        $row['ParentService'] = $this->ParentService->DefaultValue;
        $row['Status'] = $this->Status->DefaultValue;
        $row['Options'] = $this->Options->DefaultValue;
        $row['CreatedAt'] = $this->CreatedAt->DefaultValue;
        $row['UpdatedAt'] = $this->UpdatedAt->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ServiceID
        $this->ServiceID->RowCssClass = "row";

        // ServiceName
        $this->ServiceName->RowCssClass = "row";

        // ParentService
        $this->ParentService->RowCssClass = "row";

        // Status
        $this->Status->RowCssClass = "row";

        // Options
        $this->Options->RowCssClass = "row";

        // CreatedAt
        $this->CreatedAt->RowCssClass = "row";

        // UpdatedAt
        $this->UpdatedAt->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // ServiceID
            $this->ServiceID->ViewValue = $this->ServiceID->CurrentValue;

            // ServiceName
            $this->ServiceName->ViewValue = $this->ServiceName->CurrentValue;

            // ParentService
            $curVal = strval($this->ParentService->CurrentValue);
            if ($curVal != "") {
                $this->ParentService->ViewValue = $this->ParentService->lookupCacheOption($curVal);
                if ($this->ParentService->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->ParentService->Lookup->getTable()->Fields["ServiceID"]->searchExpression(), "=", $curVal, $this->ParentService->Lookup->getTable()->Fields["ServiceID"]->searchDataType(), "");
                    $sqlWrk = $this->ParentService->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ParentService->Lookup->renderViewRow($rswrk[0]);
                        $this->ParentService->ViewValue = $this->ParentService->displayValue($arwrk);
                    } else {
                        $this->ParentService->ViewValue = FormatNumber($this->ParentService->CurrentValue, $this->ParentService->formatPattern());
                    }
                }
            } else {
                $this->ParentService->ViewValue = null;
            }

            // Status
            if (strval($this->Status->CurrentValue) != "") {
                $this->Status->ViewValue = $this->Status->optionCaption($this->Status->CurrentValue);
            } else {
                $this->Status->ViewValue = null;
            }

            // Options
            $this->Options->ViewValue = $this->Options->CurrentValue;

            // CreatedAt
            $this->CreatedAt->ViewValue = $this->CreatedAt->CurrentValue;
            $this->CreatedAt->ViewValue = FormatDateTime($this->CreatedAt->ViewValue, $this->CreatedAt->formatPattern());

            // UpdatedAt
            $this->UpdatedAt->ViewValue = $this->UpdatedAt->CurrentValue;
            $this->UpdatedAt->ViewValue = FormatDateTime($this->UpdatedAt->ViewValue, $this->UpdatedAt->formatPattern());

            // ServiceID
            $this->ServiceID->HrefValue = "";

            // ServiceName
            $this->ServiceName->HrefValue = "";

            // ParentService
            $this->ParentService->HrefValue = "";

            // Status
            $this->Status->HrefValue = "";

            // Options
            $this->Options->HrefValue = "";

            // CreatedAt
            $this->CreatedAt->HrefValue = "";

            // UpdatedAt
            $this->UpdatedAt->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // ServiceID
            $this->ServiceID->setupEditAttributes();
            $this->ServiceID->EditValue = $this->ServiceID->CurrentValue;

            // ServiceName
            $this->ServiceName->setupEditAttributes();
            if (!$this->ServiceName->Raw) {
                $this->ServiceName->CurrentValue = HtmlDecode($this->ServiceName->CurrentValue);
            }
            $this->ServiceName->EditValue = HtmlEncode($this->ServiceName->CurrentValue);
            $this->ServiceName->PlaceHolder = RemoveHtml($this->ServiceName->caption());

            // ParentService
            $this->ParentService->setupEditAttributes();
            $curVal = trim(strval($this->ParentService->CurrentValue));
            if ($curVal != "") {
                $this->ParentService->ViewValue = $this->ParentService->lookupCacheOption($curVal);
            } else {
                $this->ParentService->ViewValue = $this->ParentService->Lookup !== null && is_array($this->ParentService->lookupOptions()) && count($this->ParentService->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->ParentService->ViewValue !== null) { // Load from cache
                $this->ParentService->EditValue = array_values($this->ParentService->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->ParentService->Lookup->getTable()->Fields["ServiceID"]->searchExpression(), "=", $this->ParentService->CurrentValue, $this->ParentService->Lookup->getTable()->Fields["ServiceID"]->searchDataType(), "");
                }
                $sqlWrk = $this->ParentService->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ParentService->EditValue = $arwrk;
            }
            $this->ParentService->PlaceHolder = RemoveHtml($this->ParentService->caption());

            // Status
            $this->Status->EditValue = $this->Status->options(false);
            $this->Status->PlaceHolder = RemoveHtml($this->Status->caption());

            // Options
            $this->Options->setupEditAttributes();
            $this->Options->EditValue = HtmlEncode($this->Options->CurrentValue);
            $this->Options->PlaceHolder = RemoveHtml($this->Options->caption());

            // CreatedAt
            $this->CreatedAt->setupEditAttributes();
            $this->CreatedAt->EditValue = HtmlEncode(FormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern()));
            $this->CreatedAt->PlaceHolder = RemoveHtml($this->CreatedAt->caption());

            // UpdatedAt
            $this->UpdatedAt->setupEditAttributes();
            $this->UpdatedAt->EditValue = HtmlEncode(FormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern()));
            $this->UpdatedAt->PlaceHolder = RemoveHtml($this->UpdatedAt->caption());

            // Edit refer script

            // ServiceID
            $this->ServiceID->HrefValue = "";

            // ServiceName
            $this->ServiceName->HrefValue = "";

            // ParentService
            $this->ParentService->HrefValue = "";

            // Status
            $this->Status->HrefValue = "";

            // Options
            $this->Options->HrefValue = "";

            // CreatedAt
            $this->CreatedAt->HrefValue = "";

            // UpdatedAt
            $this->UpdatedAt->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->ServiceID->Visible && $this->ServiceID->Required) {
                if (!$this->ServiceID->IsDetailKey && EmptyValue($this->ServiceID->FormValue)) {
                    $this->ServiceID->addErrorMessage(str_replace("%s", $this->ServiceID->caption(), $this->ServiceID->RequiredErrorMessage));
                }
            }
            if ($this->ServiceName->Visible && $this->ServiceName->Required) {
                if (!$this->ServiceName->IsDetailKey && EmptyValue($this->ServiceName->FormValue)) {
                    $this->ServiceName->addErrorMessage(str_replace("%s", $this->ServiceName->caption(), $this->ServiceName->RequiredErrorMessage));
                }
            }
            if ($this->ParentService->Visible && $this->ParentService->Required) {
                if (!$this->ParentService->IsDetailKey && EmptyValue($this->ParentService->FormValue)) {
                    $this->ParentService->addErrorMessage(str_replace("%s", $this->ParentService->caption(), $this->ParentService->RequiredErrorMessage));
                }
            }
            if ($this->Status->Visible && $this->Status->Required) {
                if ($this->Status->FormValue == "") {
                    $this->Status->addErrorMessage(str_replace("%s", $this->Status->caption(), $this->Status->RequiredErrorMessage));
                }
            }
            if ($this->Options->Visible && $this->Options->Required) {
                if (!$this->Options->IsDetailKey && EmptyValue($this->Options->FormValue)) {
                    $this->Options->addErrorMessage(str_replace("%s", $this->Options->caption(), $this->Options->RequiredErrorMessage));
                }
            }
            if ($this->CreatedAt->Visible && $this->CreatedAt->Required) {
                if (!$this->CreatedAt->IsDetailKey && EmptyValue($this->CreatedAt->FormValue)) {
                    $this->CreatedAt->addErrorMessage(str_replace("%s", $this->CreatedAt->caption(), $this->CreatedAt->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->CreatedAt->FormValue, $this->CreatedAt->formatPattern())) {
                $this->CreatedAt->addErrorMessage($this->CreatedAt->getErrorMessage(false));
            }
            if ($this->UpdatedAt->Visible && $this->UpdatedAt->Required) {
                if (!$this->UpdatedAt->IsDetailKey && EmptyValue($this->UpdatedAt->FormValue)) {
                    $this->UpdatedAt->addErrorMessage(str_replace("%s", $this->UpdatedAt->caption(), $this->UpdatedAt->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->UpdatedAt->FormValue, $this->UpdatedAt->formatPattern())) {
                $this->UpdatedAt->addErrorMessage($this->UpdatedAt->getErrorMessage(false));
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // ServiceName
        $this->ServiceName->setDbValueDef($rsnew, $this->ServiceName->CurrentValue, $this->ServiceName->ReadOnly);

        // ParentService
        $this->ParentService->setDbValueDef($rsnew, $this->ParentService->CurrentValue, $this->ParentService->ReadOnly);

        // Status
        $this->Status->setDbValueDef($rsnew, $this->Status->CurrentValue, $this->Status->ReadOnly);

        // Options
        $this->Options->setDbValueDef($rsnew, $this->Options->CurrentValue, $this->Options->ReadOnly);

        // CreatedAt
        $this->CreatedAt->setDbValueDef($rsnew, UnFormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern()), $this->CreatedAt->ReadOnly);

        // UpdatedAt
        $this->UpdatedAt->setDbValueDef($rsnew, UnFormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern()), $this->UpdatedAt->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['ServiceName'])) { // ServiceName
            $this->ServiceName->CurrentValue = $row['ServiceName'];
        }
        if (isset($row['ParentService'])) { // ParentService
            $this->ParentService->CurrentValue = $row['ParentService'];
        }
        if (isset($row['Status'])) { // Status
            $this->Status->CurrentValue = $row['Status'];
        }
        if (isset($row['Options'])) { // Options
            $this->Options->CurrentValue = $row['Options'];
        }
        if (isset($row['CreatedAt'])) { // CreatedAt
            $this->CreatedAt->CurrentValue = $row['CreatedAt'];
        }
        if (isset($row['UpdatedAt'])) { // UpdatedAt
            $this->UpdatedAt->CurrentValue = $row['UpdatedAt'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("splash");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ServicesList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_ParentService":
                    break;
                case "x_Status":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
