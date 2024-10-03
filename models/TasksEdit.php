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
class TasksEdit extends Tasks
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "TasksEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "TasksEdit";

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
        $this->TaskID->setVisibility();
        $this->_UserID->setVisibility();
        $this->TaskerID->setVisibility();
        $this->Location->setVisibility();
        $this->StartTime->setVisibility();
        $this->Status->setVisibility();
        $this->Duration->setVisibility();
        $this->CreatedAt->setVisibility();
        $this->UpdatedAt->setVisibility();
        $this->ServiceID->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'Tasks';
        $this->TableName = 'Tasks';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (Tasks)
        if (!isset($GLOBALS["Tasks"]) || $GLOBALS["Tasks"]::class == PROJECT_NAMESPACE . "Tasks") {
            $GLOBALS["Tasks"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'Tasks');
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
                        $result["view"] = SameString($pageName, "TasksView"); // If View page, no primary button
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
            $key .= @$ar['TaskID'];
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
            $this->TaskID->Visible = false;
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
        $this->setupLookupOptions($this->TaskerID);

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
            if (($keyValue = Get("TaskID") ?? Key(0) ?? Route(2)) !== null) {
                $this->TaskID->setQueryStringValue($keyValue);
                $this->TaskID->setOldValue($this->TaskID->QueryStringValue);
            } elseif (Post("TaskID") !== null) {
                $this->TaskID->setFormValue(Post("TaskID"));
                $this->TaskID->setOldValue($this->TaskID->FormValue);
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
                if (($keyValue = Get("TaskID") ?? Route("TaskID")) !== null) {
                    $this->TaskID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->TaskID->CurrentValue = null;
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
                        $this->terminate("TasksList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "TasksList") {
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
                        if (GetPageName($returnUrl) != "TasksList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "TasksList"; // Return list page content
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

        // Check field name 'TaskID' first before field var 'x_TaskID'
        $val = $CurrentForm->hasValue("TaskID") ? $CurrentForm->getValue("TaskID") : $CurrentForm->getValue("x_TaskID");
        if (!$this->TaskID->IsDetailKey) {
            $this->TaskID->setFormValue($val);
        }

        // Check field name 'UserID' first before field var 'x__UserID'
        $val = $CurrentForm->hasValue("UserID") ? $CurrentForm->getValue("UserID") : $CurrentForm->getValue("x__UserID");
        if (!$this->_UserID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_UserID->Visible = false; // Disable update for API request
            } else {
                $this->_UserID->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'TaskerID' first before field var 'x_TaskerID'
        $val = $CurrentForm->hasValue("TaskerID") ? $CurrentForm->getValue("TaskerID") : $CurrentForm->getValue("x_TaskerID");
        if (!$this->TaskerID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TaskerID->Visible = false; // Disable update for API request
            } else {
                $this->TaskerID->setFormValue($val);
            }
        }

        // Check field name 'Location' first before field var 'x_Location'
        $val = $CurrentForm->hasValue("Location") ? $CurrentForm->getValue("Location") : $CurrentForm->getValue("x_Location");
        if (!$this->Location->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Location->Visible = false; // Disable update for API request
            } else {
                $this->Location->setFormValue($val);
            }
        }

        // Check field name 'StartTime' first before field var 'x_StartTime'
        $val = $CurrentForm->hasValue("StartTime") ? $CurrentForm->getValue("StartTime") : $CurrentForm->getValue("x_StartTime");
        if (!$this->StartTime->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->StartTime->Visible = false; // Disable update for API request
            } else {
                $this->StartTime->setFormValue($val, true, $validate);
            }
            $this->StartTime->CurrentValue = UnFormatDateTime($this->StartTime->CurrentValue, $this->StartTime->formatPattern());
        }

        // Check field name 'Status' first before field var 'x_Status'
        $val = $CurrentForm->hasValue("Status") ? $CurrentForm->getValue("Status") : $CurrentForm->getValue("x_Status");
        if (!$this->Status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status->Visible = false; // Disable update for API request
            } else {
                $this->Status->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Duration' first before field var 'x_Duration'
        $val = $CurrentForm->hasValue("Duration") ? $CurrentForm->getValue("Duration") : $CurrentForm->getValue("x_Duration");
        if (!$this->Duration->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Duration->Visible = false; // Disable update for API request
            } else {
                $this->Duration->setFormValue($val, true, $validate);
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

        // Check field name 'ServiceID' first before field var 'x_ServiceID'
        $val = $CurrentForm->hasValue("ServiceID") ? $CurrentForm->getValue("ServiceID") : $CurrentForm->getValue("x_ServiceID");
        if (!$this->ServiceID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ServiceID->Visible = false; // Disable update for API request
            } else {
                $this->ServiceID->setFormValue($val, true, $validate);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->TaskID->CurrentValue = $this->TaskID->FormValue;
        $this->_UserID->CurrentValue = $this->_UserID->FormValue;
        $this->TaskerID->CurrentValue = $this->TaskerID->FormValue;
        $this->Location->CurrentValue = $this->Location->FormValue;
        $this->StartTime->CurrentValue = $this->StartTime->FormValue;
        $this->StartTime->CurrentValue = UnFormatDateTime($this->StartTime->CurrentValue, $this->StartTime->formatPattern());
        $this->Status->CurrentValue = $this->Status->FormValue;
        $this->Duration->CurrentValue = $this->Duration->FormValue;
        $this->CreatedAt->CurrentValue = $this->CreatedAt->FormValue;
        $this->CreatedAt->CurrentValue = UnFormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern());
        $this->UpdatedAt->CurrentValue = $this->UpdatedAt->FormValue;
        $this->UpdatedAt->CurrentValue = UnFormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern());
        $this->ServiceID->CurrentValue = $this->ServiceID->FormValue;
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
        $this->TaskID->setDbValue($row['TaskID']);
        $this->_UserID->setDbValue($row['UserID']);
        $this->TaskerID->setDbValue($row['TaskerID']);
        $this->Location->setDbValue($row['Location']);
        $this->StartTime->setDbValue($row['StartTime']);
        $this->Status->setDbValue($row['Status']);
        $this->Duration->setDbValue($row['Duration']);
        $this->CreatedAt->setDbValue($row['CreatedAt']);
        $this->UpdatedAt->setDbValue($row['UpdatedAt']);
        $this->ServiceID->setDbValue($row['ServiceID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['TaskID'] = $this->TaskID->DefaultValue;
        $row['UserID'] = $this->_UserID->DefaultValue;
        $row['TaskerID'] = $this->TaskerID->DefaultValue;
        $row['Location'] = $this->Location->DefaultValue;
        $row['StartTime'] = $this->StartTime->DefaultValue;
        $row['Status'] = $this->Status->DefaultValue;
        $row['Duration'] = $this->Duration->DefaultValue;
        $row['CreatedAt'] = $this->CreatedAt->DefaultValue;
        $row['UpdatedAt'] = $this->UpdatedAt->DefaultValue;
        $row['ServiceID'] = $this->ServiceID->DefaultValue;
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

        // TaskID
        $this->TaskID->RowCssClass = "row";

        // UserID
        $this->_UserID->RowCssClass = "row";

        // TaskerID
        $this->TaskerID->RowCssClass = "row";

        // Location
        $this->Location->RowCssClass = "row";

        // StartTime
        $this->StartTime->RowCssClass = "row";

        // Status
        $this->Status->RowCssClass = "row";

        // Duration
        $this->Duration->RowCssClass = "row";

        // CreatedAt
        $this->CreatedAt->RowCssClass = "row";

        // UpdatedAt
        $this->UpdatedAt->RowCssClass = "row";

        // ServiceID
        $this->ServiceID->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // TaskID
            $this->TaskID->ViewValue = $this->TaskID->CurrentValue;

            // UserID
            $this->_UserID->ViewValue = $this->_UserID->CurrentValue;
            $this->_UserID->ViewValue = FormatNumber($this->_UserID->ViewValue, $this->_UserID->formatPattern());

            // TaskerID
            $curVal = strval($this->TaskerID->CurrentValue);
            if ($curVal != "") {
                $this->TaskerID->ViewValue = $this->TaskerID->lookupCacheOption($curVal);
                if ($this->TaskerID->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->TaskerID->Lookup->getTable()->Fields["ID"]->searchExpression(), "=", $curVal, $this->TaskerID->Lookup->getTable()->Fields["ID"]->searchDataType(), "");
                    $lookupFilter = $this->TaskerID->getSelectFilter($this); // PHP
                    $sqlWrk = $this->TaskerID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->TaskerID->Lookup->renderViewRow($rswrk[0]);
                        $this->TaskerID->ViewValue = $this->TaskerID->displayValue($arwrk);
                    } else {
                        $this->TaskerID->ViewValue = FormatNumber($this->TaskerID->CurrentValue, $this->TaskerID->formatPattern());
                    }
                }
            } else {
                $this->TaskerID->ViewValue = null;
            }

            // Location
            $this->Location->ViewValue = $this->Location->CurrentValue;

            // StartTime
            $this->StartTime->ViewValue = $this->StartTime->CurrentValue;
            $this->StartTime->ViewValue = FormatDateTime($this->StartTime->ViewValue, $this->StartTime->formatPattern());

            // Status
            $this->Status->ViewValue = $this->Status->CurrentValue;
            $this->Status->ViewValue = FormatNumber($this->Status->ViewValue, $this->Status->formatPattern());

            // Duration
            $this->Duration->ViewValue = $this->Duration->CurrentValue;
            $this->Duration->ViewValue = FormatNumber($this->Duration->ViewValue, $this->Duration->formatPattern());

            // CreatedAt
            $this->CreatedAt->ViewValue = $this->CreatedAt->CurrentValue;
            $this->CreatedAt->ViewValue = FormatDateTime($this->CreatedAt->ViewValue, $this->CreatedAt->formatPattern());

            // UpdatedAt
            $this->UpdatedAt->ViewValue = $this->UpdatedAt->CurrentValue;
            $this->UpdatedAt->ViewValue = FormatDateTime($this->UpdatedAt->ViewValue, $this->UpdatedAt->formatPattern());

            // ServiceID
            $this->ServiceID->ViewValue = $this->ServiceID->CurrentValue;
            $this->ServiceID->ViewValue = FormatNumber($this->ServiceID->ViewValue, $this->ServiceID->formatPattern());

            // TaskID
            $this->TaskID->HrefValue = "";

            // UserID
            $this->_UserID->HrefValue = "";

            // TaskerID
            $this->TaskerID->HrefValue = "";

            // Location
            $this->Location->HrefValue = "";

            // StartTime
            $this->StartTime->HrefValue = "";

            // Status
            $this->Status->HrefValue = "";

            // Duration
            $this->Duration->HrefValue = "";

            // CreatedAt
            $this->CreatedAt->HrefValue = "";

            // UpdatedAt
            $this->UpdatedAt->HrefValue = "";

            // ServiceID
            $this->ServiceID->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // TaskID
            $this->TaskID->setupEditAttributes();
            $this->TaskID->EditValue = $this->TaskID->CurrentValue;

            // UserID
            $this->_UserID->setupEditAttributes();
            $this->_UserID->EditValue = $this->_UserID->CurrentValue;
            $this->_UserID->PlaceHolder = RemoveHtml($this->_UserID->caption());
            if (strval($this->_UserID->EditValue) != "" && is_numeric($this->_UserID->EditValue)) {
                $this->_UserID->EditValue = FormatNumber($this->_UserID->EditValue, null);
            }

            // TaskerID
            $this->TaskerID->setupEditAttributes();
            $curVal = trim(strval($this->TaskerID->CurrentValue));
            if ($curVal != "") {
                $this->TaskerID->ViewValue = $this->TaskerID->lookupCacheOption($curVal);
            } else {
                $this->TaskerID->ViewValue = $this->TaskerID->Lookup !== null && is_array($this->TaskerID->lookupOptions()) && count($this->TaskerID->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->TaskerID->ViewValue !== null) { // Load from cache
                $this->TaskerID->EditValue = array_values($this->TaskerID->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->TaskerID->Lookup->getTable()->Fields["ID"]->searchExpression(), "=", $this->TaskerID->CurrentValue, $this->TaskerID->Lookup->getTable()->Fields["ID"]->searchDataType(), "");
                }
                $lookupFilter = $this->TaskerID->getSelectFilter($this); // PHP
                $sqlWrk = $this->TaskerID->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->TaskerID->EditValue = $arwrk;
            }
            $this->TaskerID->PlaceHolder = RemoveHtml($this->TaskerID->caption());

            // Location
            $this->Location->setupEditAttributes();
            if (!$this->Location->Raw) {
                $this->Location->CurrentValue = HtmlDecode($this->Location->CurrentValue);
            }
            $this->Location->EditValue = HtmlEncode($this->Location->CurrentValue);
            $this->Location->PlaceHolder = RemoveHtml($this->Location->caption());

            // StartTime
            $this->StartTime->setupEditAttributes();
            $this->StartTime->EditValue = HtmlEncode(FormatDateTime($this->StartTime->CurrentValue, $this->StartTime->formatPattern()));
            $this->StartTime->PlaceHolder = RemoveHtml($this->StartTime->caption());

            // Status
            $this->Status->setupEditAttributes();
            $this->Status->EditValue = $this->Status->CurrentValue;
            $this->Status->PlaceHolder = RemoveHtml($this->Status->caption());
            if (strval($this->Status->EditValue) != "" && is_numeric($this->Status->EditValue)) {
                $this->Status->EditValue = FormatNumber($this->Status->EditValue, null);
            }

            // Duration
            $this->Duration->setupEditAttributes();
            $this->Duration->EditValue = $this->Duration->CurrentValue;
            $this->Duration->PlaceHolder = RemoveHtml($this->Duration->caption());
            if (strval($this->Duration->EditValue) != "" && is_numeric($this->Duration->EditValue)) {
                $this->Duration->EditValue = FormatNumber($this->Duration->EditValue, null);
            }

            // CreatedAt
            $this->CreatedAt->setupEditAttributes();
            $this->CreatedAt->EditValue = HtmlEncode(FormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern()));
            $this->CreatedAt->PlaceHolder = RemoveHtml($this->CreatedAt->caption());

            // UpdatedAt
            $this->UpdatedAt->setupEditAttributes();
            $this->UpdatedAt->EditValue = HtmlEncode(FormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern()));
            $this->UpdatedAt->PlaceHolder = RemoveHtml($this->UpdatedAt->caption());

            // ServiceID
            $this->ServiceID->setupEditAttributes();
            $this->ServiceID->EditValue = $this->ServiceID->CurrentValue;
            $this->ServiceID->PlaceHolder = RemoveHtml($this->ServiceID->caption());
            if (strval($this->ServiceID->EditValue) != "" && is_numeric($this->ServiceID->EditValue)) {
                $this->ServiceID->EditValue = FormatNumber($this->ServiceID->EditValue, null);
            }

            // Edit refer script

            // TaskID
            $this->TaskID->HrefValue = "";

            // UserID
            $this->_UserID->HrefValue = "";

            // TaskerID
            $this->TaskerID->HrefValue = "";

            // Location
            $this->Location->HrefValue = "";

            // StartTime
            $this->StartTime->HrefValue = "";

            // Status
            $this->Status->HrefValue = "";

            // Duration
            $this->Duration->HrefValue = "";

            // CreatedAt
            $this->CreatedAt->HrefValue = "";

            // UpdatedAt
            $this->UpdatedAt->HrefValue = "";

            // ServiceID
            $this->ServiceID->HrefValue = "";
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
            if ($this->TaskID->Visible && $this->TaskID->Required) {
                if (!$this->TaskID->IsDetailKey && EmptyValue($this->TaskID->FormValue)) {
                    $this->TaskID->addErrorMessage(str_replace("%s", $this->TaskID->caption(), $this->TaskID->RequiredErrorMessage));
                }
            }
            if ($this->_UserID->Visible && $this->_UserID->Required) {
                if (!$this->_UserID->IsDetailKey && EmptyValue($this->_UserID->FormValue)) {
                    $this->_UserID->addErrorMessage(str_replace("%s", $this->_UserID->caption(), $this->_UserID->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->_UserID->FormValue)) {
                $this->_UserID->addErrorMessage($this->_UserID->getErrorMessage(false));
            }
            if ($this->TaskerID->Visible && $this->TaskerID->Required) {
                if (!$this->TaskerID->IsDetailKey && EmptyValue($this->TaskerID->FormValue)) {
                    $this->TaskerID->addErrorMessage(str_replace("%s", $this->TaskerID->caption(), $this->TaskerID->RequiredErrorMessage));
                }
            }
            if ($this->Location->Visible && $this->Location->Required) {
                if (!$this->Location->IsDetailKey && EmptyValue($this->Location->FormValue)) {
                    $this->Location->addErrorMessage(str_replace("%s", $this->Location->caption(), $this->Location->RequiredErrorMessage));
                }
            }
            if ($this->StartTime->Visible && $this->StartTime->Required) {
                if (!$this->StartTime->IsDetailKey && EmptyValue($this->StartTime->FormValue)) {
                    $this->StartTime->addErrorMessage(str_replace("%s", $this->StartTime->caption(), $this->StartTime->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->StartTime->FormValue, $this->StartTime->formatPattern())) {
                $this->StartTime->addErrorMessage($this->StartTime->getErrorMessage(false));
            }
            if ($this->Status->Visible && $this->Status->Required) {
                if (!$this->Status->IsDetailKey && EmptyValue($this->Status->FormValue)) {
                    $this->Status->addErrorMessage(str_replace("%s", $this->Status->caption(), $this->Status->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Status->FormValue)) {
                $this->Status->addErrorMessage($this->Status->getErrorMessage(false));
            }
            if ($this->Duration->Visible && $this->Duration->Required) {
                if (!$this->Duration->IsDetailKey && EmptyValue($this->Duration->FormValue)) {
                    $this->Duration->addErrorMessage(str_replace("%s", $this->Duration->caption(), $this->Duration->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Duration->FormValue)) {
                $this->Duration->addErrorMessage($this->Duration->getErrorMessage(false));
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
            if ($this->ServiceID->Visible && $this->ServiceID->Required) {
                if (!$this->ServiceID->IsDetailKey && EmptyValue($this->ServiceID->FormValue)) {
                    $this->ServiceID->addErrorMessage(str_replace("%s", $this->ServiceID->caption(), $this->ServiceID->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->ServiceID->FormValue)) {
                $this->ServiceID->addErrorMessage($this->ServiceID->getErrorMessage(false));
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

        // UserID
        $this->_UserID->setDbValueDef($rsnew, $this->_UserID->CurrentValue, $this->_UserID->ReadOnly);

        // TaskerID
        $this->TaskerID->setDbValueDef($rsnew, $this->TaskerID->CurrentValue, $this->TaskerID->ReadOnly);

        // Location
        $this->Location->setDbValueDef($rsnew, $this->Location->CurrentValue, $this->Location->ReadOnly);

        // StartTime
        $this->StartTime->setDbValueDef($rsnew, UnFormatDateTime($this->StartTime->CurrentValue, $this->StartTime->formatPattern()), $this->StartTime->ReadOnly);

        // Status
        $this->Status->setDbValueDef($rsnew, $this->Status->CurrentValue, $this->Status->ReadOnly);

        // Duration
        $this->Duration->setDbValueDef($rsnew, $this->Duration->CurrentValue, $this->Duration->ReadOnly);

        // CreatedAt
        $this->CreatedAt->setDbValueDef($rsnew, UnFormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern()), $this->CreatedAt->ReadOnly);

        // UpdatedAt
        $this->UpdatedAt->setDbValueDef($rsnew, UnFormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern()), $this->UpdatedAt->ReadOnly);

        // ServiceID
        $this->ServiceID->setDbValueDef($rsnew, $this->ServiceID->CurrentValue, $this->ServiceID->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['UserID'])) { // UserID
            $this->_UserID->CurrentValue = $row['UserID'];
        }
        if (isset($row['TaskerID'])) { // TaskerID
            $this->TaskerID->CurrentValue = $row['TaskerID'];
        }
        if (isset($row['Location'])) { // Location
            $this->Location->CurrentValue = $row['Location'];
        }
        if (isset($row['StartTime'])) { // StartTime
            $this->StartTime->CurrentValue = $row['StartTime'];
        }
        if (isset($row['Status'])) { // Status
            $this->Status->CurrentValue = $row['Status'];
        }
        if (isset($row['Duration'])) { // Duration
            $this->Duration->CurrentValue = $row['Duration'];
        }
        if (isset($row['CreatedAt'])) { // CreatedAt
            $this->CreatedAt->CurrentValue = $row['CreatedAt'];
        }
        if (isset($row['UpdatedAt'])) { // UpdatedAt
            $this->UpdatedAt->CurrentValue = $row['UpdatedAt'];
        }
        if (isset($row['ServiceID'])) { // ServiceID
            $this->ServiceID->CurrentValue = $row['ServiceID'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("splash");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TasksList"), "", $this->TableVar, true);
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
                case "x_TaskerID":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
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
