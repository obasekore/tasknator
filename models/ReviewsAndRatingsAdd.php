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
class ReviewsAndRatingsAdd extends ReviewsAndRatings
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ReviewsAndRatingsAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ReviewsAndRatingsAdd";

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
        $this->ReviewRatingID->Visible = false;
        $this->TaskID->setVisibility();
        $this->Review->setVisibility();
        $this->Rating->setVisibility();
        $this->_UserID->setVisibility();
        $this->Status->setVisibility();
        $this->CreatedAt->setVisibility();
        $this->UpdatedAt->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'ReviewsAndRatings';
        $this->TableName = 'ReviewsAndRatings';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (ReviewsAndRatings)
        if (!isset($GLOBALS["ReviewsAndRatings"]) || $GLOBALS["ReviewsAndRatings"]::class == PROJECT_NAMESPACE . "ReviewsAndRatings") {
            $GLOBALS["ReviewsAndRatings"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'ReviewsAndRatings');
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
                        $result["view"] = SameString($pageName, "ReviewsAndRatingsView"); // If View page, no primary button
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
            $key .= @$ar['ReviewRatingID'];
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
            $this->ReviewRatingID->Visible = false;
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

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

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("ReviewRatingID") ?? Route("ReviewRatingID")) !== null) {
                $this->ReviewRatingID->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("ReviewsAndRatingsList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "ReviewsAndRatingsList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ReviewsAndRatingsView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ReviewsAndRatingsList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ReviewsAndRatingsList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
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
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
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

    // Load default values
    protected function loadDefaultValues()
    {
        $this->Status->DefaultValue = $this->Status->getDefault(); // PHP
        $this->Status->OldValue = $this->Status->DefaultValue;
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
            if (IsApi() && $val === null) {
                $this->TaskID->Visible = false; // Disable update for API request
            } else {
                $this->TaskID->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Review' first before field var 'x_Review'
        $val = $CurrentForm->hasValue("Review") ? $CurrentForm->getValue("Review") : $CurrentForm->getValue("x_Review");
        if (!$this->Review->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Review->Visible = false; // Disable update for API request
            } else {
                $this->Review->setFormValue($val);
            }
        }

        // Check field name 'Rating' first before field var 'x_Rating'
        $val = $CurrentForm->hasValue("Rating") ? $CurrentForm->getValue("Rating") : $CurrentForm->getValue("x_Rating");
        if (!$this->Rating->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Rating->Visible = false; // Disable update for API request
            } else {
                $this->Rating->setFormValue($val, true, $validate);
            }
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

        // Check field name 'Status' first before field var 'x_Status'
        $val = $CurrentForm->hasValue("Status") ? $CurrentForm->getValue("Status") : $CurrentForm->getValue("x_Status");
        if (!$this->Status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status->Visible = false; // Disable update for API request
            } else {
                $this->Status->setFormValue($val, true, $validate);
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

        // Check field name 'ReviewRatingID' first before field var 'x_ReviewRatingID'
        $val = $CurrentForm->hasValue("ReviewRatingID") ? $CurrentForm->getValue("ReviewRatingID") : $CurrentForm->getValue("x_ReviewRatingID");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->TaskID->CurrentValue = $this->TaskID->FormValue;
        $this->Review->CurrentValue = $this->Review->FormValue;
        $this->Rating->CurrentValue = $this->Rating->FormValue;
        $this->_UserID->CurrentValue = $this->_UserID->FormValue;
        $this->Status->CurrentValue = $this->Status->FormValue;
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
        $this->ReviewRatingID->setDbValue($row['ReviewRatingID']);
        $this->TaskID->setDbValue($row['TaskID']);
        $this->Review->setDbValue($row['Review']);
        $this->Rating->setDbValue($row['Rating']);
        $this->_UserID->setDbValue($row['UserID']);
        $this->Status->setDbValue($row['Status']);
        $this->CreatedAt->setDbValue($row['CreatedAt']);
        $this->UpdatedAt->setDbValue($row['UpdatedAt']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ReviewRatingID'] = $this->ReviewRatingID->DefaultValue;
        $row['TaskID'] = $this->TaskID->DefaultValue;
        $row['Review'] = $this->Review->DefaultValue;
        $row['Rating'] = $this->Rating->DefaultValue;
        $row['UserID'] = $this->_UserID->DefaultValue;
        $row['Status'] = $this->Status->DefaultValue;
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

        // ReviewRatingID
        $this->ReviewRatingID->RowCssClass = "row";

        // TaskID
        $this->TaskID->RowCssClass = "row";

        // Review
        $this->Review->RowCssClass = "row";

        // Rating
        $this->Rating->RowCssClass = "row";

        // UserID
        $this->_UserID->RowCssClass = "row";

        // Status
        $this->Status->RowCssClass = "row";

        // CreatedAt
        $this->CreatedAt->RowCssClass = "row";

        // UpdatedAt
        $this->UpdatedAt->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // ReviewRatingID
            $this->ReviewRatingID->ViewValue = $this->ReviewRatingID->CurrentValue;

            // TaskID
            $this->TaskID->ViewValue = $this->TaskID->CurrentValue;
            $this->TaskID->ViewValue = FormatNumber($this->TaskID->ViewValue, $this->TaskID->formatPattern());

            // Review
            $this->Review->ViewValue = $this->Review->CurrentValue;

            // Rating
            $this->Rating->ViewValue = $this->Rating->CurrentValue;
            $this->Rating->ViewValue = FormatNumber($this->Rating->ViewValue, $this->Rating->formatPattern());

            // UserID
            $this->_UserID->ViewValue = $this->_UserID->CurrentValue;
            $this->_UserID->ViewValue = FormatNumber($this->_UserID->ViewValue, $this->_UserID->formatPattern());

            // Status
            $this->Status->ViewValue = $this->Status->CurrentValue;
            $this->Status->ViewValue = FormatNumber($this->Status->ViewValue, $this->Status->formatPattern());

            // CreatedAt
            $this->CreatedAt->ViewValue = $this->CreatedAt->CurrentValue;
            $this->CreatedAt->ViewValue = FormatDateTime($this->CreatedAt->ViewValue, $this->CreatedAt->formatPattern());

            // UpdatedAt
            $this->UpdatedAt->ViewValue = $this->UpdatedAt->CurrentValue;
            $this->UpdatedAt->ViewValue = FormatDateTime($this->UpdatedAt->ViewValue, $this->UpdatedAt->formatPattern());

            // TaskID
            $this->TaskID->HrefValue = "";

            // Review
            $this->Review->HrefValue = "";

            // Rating
            $this->Rating->HrefValue = "";

            // UserID
            $this->_UserID->HrefValue = "";

            // Status
            $this->Status->HrefValue = "";

            // CreatedAt
            $this->CreatedAt->HrefValue = "";

            // UpdatedAt
            $this->UpdatedAt->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // TaskID
            $this->TaskID->setupEditAttributes();
            $this->TaskID->EditValue = $this->TaskID->CurrentValue;
            $this->TaskID->PlaceHolder = RemoveHtml($this->TaskID->caption());
            if (strval($this->TaskID->EditValue) != "" && is_numeric($this->TaskID->EditValue)) {
                $this->TaskID->EditValue = FormatNumber($this->TaskID->EditValue, null);
            }

            // Review
            $this->Review->setupEditAttributes();
            if (!$this->Review->Raw) {
                $this->Review->CurrentValue = HtmlDecode($this->Review->CurrentValue);
            }
            $this->Review->EditValue = HtmlEncode($this->Review->CurrentValue);
            $this->Review->PlaceHolder = RemoveHtml($this->Review->caption());

            // Rating
            $this->Rating->setupEditAttributes();
            $this->Rating->EditValue = $this->Rating->CurrentValue;
            $this->Rating->PlaceHolder = RemoveHtml($this->Rating->caption());
            if (strval($this->Rating->EditValue) != "" && is_numeric($this->Rating->EditValue)) {
                $this->Rating->EditValue = FormatNumber($this->Rating->EditValue, null);
            }

            // UserID
            $this->_UserID->setupEditAttributes();
            $this->_UserID->EditValue = $this->_UserID->CurrentValue;
            $this->_UserID->PlaceHolder = RemoveHtml($this->_UserID->caption());
            if (strval($this->_UserID->EditValue) != "" && is_numeric($this->_UserID->EditValue)) {
                $this->_UserID->EditValue = FormatNumber($this->_UserID->EditValue, null);
            }

            // Status
            $this->Status->setupEditAttributes();
            $this->Status->EditValue = $this->Status->CurrentValue;
            $this->Status->PlaceHolder = RemoveHtml($this->Status->caption());
            if (strval($this->Status->EditValue) != "" && is_numeric($this->Status->EditValue)) {
                $this->Status->EditValue = FormatNumber($this->Status->EditValue, null);
            }

            // CreatedAt
            $this->CreatedAt->setupEditAttributes();
            $this->CreatedAt->EditValue = HtmlEncode(FormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern()));
            $this->CreatedAt->PlaceHolder = RemoveHtml($this->CreatedAt->caption());

            // UpdatedAt
            $this->UpdatedAt->setupEditAttributes();
            $this->UpdatedAt->EditValue = HtmlEncode(FormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern()));
            $this->UpdatedAt->PlaceHolder = RemoveHtml($this->UpdatedAt->caption());

            // Add refer script

            // TaskID
            $this->TaskID->HrefValue = "";

            // Review
            $this->Review->HrefValue = "";

            // Rating
            $this->Rating->HrefValue = "";

            // UserID
            $this->_UserID->HrefValue = "";

            // Status
            $this->Status->HrefValue = "";

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
            if ($this->TaskID->Visible && $this->TaskID->Required) {
                if (!$this->TaskID->IsDetailKey && EmptyValue($this->TaskID->FormValue)) {
                    $this->TaskID->addErrorMessage(str_replace("%s", $this->TaskID->caption(), $this->TaskID->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->TaskID->FormValue)) {
                $this->TaskID->addErrorMessage($this->TaskID->getErrorMessage(false));
            }
            if ($this->Review->Visible && $this->Review->Required) {
                if (!$this->Review->IsDetailKey && EmptyValue($this->Review->FormValue)) {
                    $this->Review->addErrorMessage(str_replace("%s", $this->Review->caption(), $this->Review->RequiredErrorMessage));
                }
            }
            if ($this->Rating->Visible && $this->Rating->Required) {
                if (!$this->Rating->IsDetailKey && EmptyValue($this->Rating->FormValue)) {
                    $this->Rating->addErrorMessage(str_replace("%s", $this->Rating->caption(), $this->Rating->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Rating->FormValue)) {
                $this->Rating->addErrorMessage($this->Rating->getErrorMessage(false));
            }
            if ($this->_UserID->Visible && $this->_UserID->Required) {
                if (!$this->_UserID->IsDetailKey && EmptyValue($this->_UserID->FormValue)) {
                    $this->_UserID->addErrorMessage(str_replace("%s", $this->_UserID->caption(), $this->_UserID->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->_UserID->FormValue)) {
                $this->_UserID->addErrorMessage($this->_UserID->getErrorMessage(false));
            }
            if ($this->Status->Visible && $this->Status->Required) {
                if (!$this->Status->IsDetailKey && EmptyValue($this->Status->FormValue)) {
                    $this->Status->addErrorMessage(str_replace("%s", $this->Status->caption(), $this->Status->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Status->FormValue)) {
                $this->Status->addErrorMessage($this->Status->getErrorMessage(false));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // TaskID
        $this->TaskID->setDbValueDef($rsnew, $this->TaskID->CurrentValue, false);

        // Review
        $this->Review->setDbValueDef($rsnew, $this->Review->CurrentValue, false);

        // Rating
        $this->Rating->setDbValueDef($rsnew, $this->Rating->CurrentValue, false);

        // UserID
        $this->_UserID->setDbValueDef($rsnew, $this->_UserID->CurrentValue, false);

        // Status
        $this->Status->setDbValueDef($rsnew, $this->Status->CurrentValue, strval($this->Status->CurrentValue) == "");

        // CreatedAt
        $this->CreatedAt->setDbValueDef($rsnew, UnFormatDateTime($this->CreatedAt->CurrentValue, $this->CreatedAt->formatPattern()), false);

        // UpdatedAt
        $this->UpdatedAt->setDbValueDef($rsnew, UnFormatDateTime($this->UpdatedAt->CurrentValue, $this->UpdatedAt->formatPattern()), false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['TaskID'])) { // TaskID
            $this->TaskID->setFormValue($row['TaskID']);
        }
        if (isset($row['Review'])) { // Review
            $this->Review->setFormValue($row['Review']);
        }
        if (isset($row['Rating'])) { // Rating
            $this->Rating->setFormValue($row['Rating']);
        }
        if (isset($row['UserID'])) { // UserID
            $this->_UserID->setFormValue($row['UserID']);
        }
        if (isset($row['Status'])) { // Status
            $this->Status->setFormValue($row['Status']);
        }
        if (isset($row['CreatedAt'])) { // CreatedAt
            $this->CreatedAt->setFormValue($row['CreatedAt']);
        }
        if (isset($row['UpdatedAt'])) { // UpdatedAt
            $this->UpdatedAt->setFormValue($row['UpdatedAt']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("splash");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ReviewsAndRatingsList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
