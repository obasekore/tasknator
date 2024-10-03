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
class Register extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "register";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "Register";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "register";

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

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'Users';
        $this->TableName = 'Users';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-register-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (Users)
        if (!isset($GLOBALS["Users"]) || $GLOBALS["Users"]::class == PROJECT_NAMESPACE . "Users") {
            $GLOBALS["Users"] = &$this;
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
                WriteJson(["url" => $url]);
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
            $key .= @$ar['ID'];
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
            $this->ID->Visible = false;
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
    public $FormClassName = "ew-form ew-register-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $UserTable, $CurrentLanguage, $Breadcrumb, $SkipHeaderFooter;

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

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Set up Breadcrumb
        $Breadcrumb = Breadcrumb::create("splash")->add("register", "RegisterPage", CurrentUrl(), "", "", true);
        $this->Heading = $Language->phrase("RegisterPage");

        // Load default values
        $this->loadRowValues();

        // Get action
        $action = "";
        if (IsApi()) {
            $action = "insert";
        } elseif (Post("action") != "") {
            $action = Post("action");
        }

        // Check action
        if ($action != "") {
            // Get action
            $this->CurrentAction = $action;
            $this->loadFormValues(); // Get form values

            // Validate form
            if (!$this->validateForm()) {
                if (IsApi()) {
                    WriteJson([
                        "success" => false,
                        "validation" => $this->getValidationErrors(),
                        "error" => $this->getFailureMessage()
                    ]);
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        } elseif (IsRegistering()) { // Return from 2FA
            $this->CurrentAction = "insert";
            $this->restoreAddFormFromRow(Session(SESSION_USER_PROFILE_RECORD)); // Restore add form values
        } else {
            $this->CurrentAction = "show"; // Display blank record
        }

        // Set up return page
        $returnPage = "";
        if (EmptyValue($returnPage)) {
            $returnPage = Config("REGISTER_AUTO_LOGIN") ? "index" : "login";
        }

        // Handle email activation
        $action = Get("action");
        if (Config("REGISTER_ACTIVATE") && !EmptyValue(Config("REGISTER_ACTIVATE_FIELD_NAME")) && SameText($action, "confirm")) {
            $user = Get("user", "");
            $token = Get("token", "");
            $userName = DecodeJwt($token)["username"] ?? "";
            if (!EmptyValue($userName) && $user == $userName) {
                if ($this->activateUser($userName)) { // Activate user
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("ActivateAccount")); // Set up message acount activated
                    }
                    if (Config("REGISTER_AUTO_LOGIN") && !EmptyValue(Config("LOGIN_USERNAME_FIELD_NAME")) && !EmptyValue(Config("LOGIN_PASSWORD_FIELD_NAME"))) {
                        if ($Security->validateUser($userName, $token, "token")) {
                            $this->terminate($returnPage); // Go to return page
                            return;
                        } else {
                            $this->setFailureMessage($Language->phrase("AutoLoginFailed")); // Set auto login failed message
                            $this->terminate("login"); // Go to login page
                            return;
                        }
                    } else {
                        $this->terminate("login"); // Go to login page
                        return;
                    }
                }
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("ActivateFailed")); // Set activate failed message
            }
            $this->terminate("login"); // Go to login page
            return;
        }

        // Insert record
        if ($this->isInsert()) {
            // Check for duplicate User ID
            $user = FindUserByUserName($this->_Email->CurrentValue);
            if ($user) {
                $this->restoreFormValues(); // Restore form values
                $this->setFailureMessage($Language->phrase("UserExists")); // Set user exist message
            }
            if (!$user) {
                // Handle two factor authentication
                if (
                    Config("USE_TWO_FACTOR_AUTHENTICATION") &&
                    Config("FORCE_TWO_FACTOR_AUTHENTICATION") &&
                    in_array(strtolower(Config("TWO_FACTOR_AUTHENTICATION_TYPE")), ["email", "sms"]) &&
                    !IsRegistering2FA() &&
                    !IsRegistering()
                ) {
                    $_SESSION[SESSION_USER_PROFILE_RECORD] = $this->getAddRow(); // Save record
                    $res = TwoFactorAuthenticationClass()::sendOneTimePassword($this->_Email->CurrentValue); // Send one time password
                    if ($res === true) {
                        $_SESSION[SESSION_STATUS] = "registering2fa";
                        $_SESSION[SESSION_USER_PROFILE_USER_NAME] = $this->_Email->CurrentValue;
                        if (Config("REGISTER_AUTO_LOGIN") && !EmptyValue(Config("LOGIN_USERNAME_FIELD_NAME")) && !EmptyValue(Config("LOGIN_PASSWORD_FIELD_NAME"))) {
                            $_SESSION[SESSION_USER_PROFILE_PASSWORD] = $this->_Password->FormValue;
                        } else {
                            $_SESSION[SESSION_USER_PROFILE_PASSWORD] = ""; // DO NOT auto login
                        }
                        $this->terminate("login2fa"); // Go to two factor authentication
                        return;
                    } else {
                        $_SESSION[SESSION_USER_PROFILE_RECORD] = ""; // Clear record
                        $this->setFailureMessage($res);
                        $this->CurrentAction = "show"; // Reset action
                        $this->EventCancelled = true; // Event cancelled
                    }
                } else {
                    $res = true;
                }
                $this->SendEmail = true; // Send email on add success
                if ($res === true && $this->addRow()) { // Add record
                    if (IsRegistering()) { // Update user profile and clear status
                        $usr = $_SESSION[SESSION_USER_PROFILE_USER_NAME];
                        $code = $_SESSION[SESSION_USER_PROFILE_SECURITY_CODE];
                        $row = $_SESSION[SESSION_USER_PROFILE_RECORD];
                        $_SESSION[SESSION_USER_PROFILE_RECORD] = "";
                        $_SESSION[SESSION_USER_PROFILE_SECURITY_CODE] = "";
                        $_SESSION[SESSION_USER_PROFILE_USER_NAME] = "";
                        $_SESSION[SESSION_STATUS] = "";
                        $profile = new UserProfile($usr);
                        $account = SameText(Config("TWO_FACTOR_AUTHENTICATION_TYPE"), "email")
                            ? $row[Config("USER_EMAIL_FIELD_NAME")]
                            : $row[Config("USER_PHONE_FIELD_NAME")];
                        $profile->setOneTimePassword($account, $code);
                        $profile->verify2FACode($code);
                    }
                    if (Config("REGISTER_ACTIVATE") && !EmptyValue(Config("REGISTER_ACTIVATE_FIELD_NAME"))) {
                        if ($this->getSuccessMessage() == "") {
                            $this->setSuccessMessage($Language->phrase("RegisterSuccessActivate")); // Activate success
                        }
                    } else {
                        if ($this->getSuccessMessage() == "") {
                            $this->setSuccessMessage($Language->phrase("RegisterSuccess")); // Register success
                        }
                        // Auto login user after registration
                        if (Config("REGISTER_AUTO_LOGIN") && !EmptyValue(Config("LOGIN_USERNAME_FIELD_NAME")) && !EmptyValue(Config("LOGIN_PASSWORD_FIELD_NAME"))) {
                            if (!$Security->validateUser($this->_Email->CurrentValue, $this->_Password->FormValue, "register")) {
                                $this->setFailureMessage($Language->phrase("AutoLoginFailed")); // Set auto login failure message
                            }
                        }
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnPage); // Return
                        return;
                    }
                } else {
                    $this->restoreFormValues(); // Restore form values
                }
            }
        }

        // API request, return
        if (IsApi()) {
            $this->terminate();
            return;
        }

        // Render row
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = RowType::VIEW; // Render view
        } else {
            $this->RowType = RowType::ADD; // Render add
        }
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

    // Activate account based on user
    protected function activateUser($usr)
    {
        global $Language;
        if (!Config("REGISTER_ACTIVATE") || EmptyValue(Config("REGISTER_ACTIVATE_FIELD_NAME"))) {
            return false;
        }
        if ($this->UpdateTable != $this->TableName) { // Note: The username and password field name must be the same
            $entityClass = GetEntityClass($this->UpdateTable);
            if ($entityClass) {
                $user = GetUserEntityManager()->getRepository($entityClass)->findOneBy(["email" => $usr]);
            } else {
                throw new \Exception("Entity class for UpdateTable not found.");
            }
        } else {
            $user = FindUserByUserName($usr);
        }
        if ($user) {
            $this->loadRowValues($user->toArray()); // Load row values
            try {
                if (!ConvertToBool($user->get(Config("REGISTER_ACTIVATE_FIELD_NAME")))) {
                    $user->set(Config("REGISTER_ACTIVATE_FIELD_NAME"), Config("REGISTER_ACTIVATE_FIELD_VALUE")); // Auto register
                    GetUserEntityManager()->flush();

                    // Call User Activated event
                    $this->userActivated($user->toArray());
                    return true;
                } else {
                    $this->setFailureMessage($Language->phrase("ActivateAgain"));
                    return false;
                }
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
                return false;
            }
        } else {
            $this->setFailureMessage($Language->phrase("NoRecord"));
            return false;
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
        $this->_UserLevel->DefaultValue = $this->_UserLevel->getDefault(); // PHP
        $this->_UserLevel->OldValue = $this->_UserLevel->DefaultValue;
        $this->Status->DefaultValue = $this->Status->getDefault(); // PHP
        $this->Status->OldValue = $this->Status->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'FirstName' first before field var 'x_FirstName'
        $val = $CurrentForm->hasValue("FirstName") ? $CurrentForm->getValue("FirstName") : $CurrentForm->getValue("x_FirstName");
        if (!$this->FirstName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FirstName->Visible = false; // Disable update for API request
            } else {
                $this->FirstName->setFormValue($val);
            }
        }

        // Check field name 'LastName' first before field var 'x_LastName'
        $val = $CurrentForm->hasValue("LastName") ? $CurrentForm->getValue("LastName") : $CurrentForm->getValue("x_LastName");
        if (!$this->LastName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LastName->Visible = false; // Disable update for API request
            } else {
                $this->LastName->setFormValue($val);
            }
        }

        // Check field name 'Email' first before field var 'x__Email'
        $val = $CurrentForm->hasValue("Email") ? $CurrentForm->getValue("Email") : $CurrentForm->getValue("x__Email");
        if (!$this->_Email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Email->Visible = false; // Disable update for API request
            } else {
                $this->_Email->setFormValue($val);
            }
        }

        // Check field name 'Password' first before field var 'x__Password'
        $val = $CurrentForm->hasValue("Password") ? $CurrentForm->getValue("Password") : $CurrentForm->getValue("x__Password");
        if (!$this->_Password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Password->Visible = false; // Disable update for API request
            } else {
                $this->_Password->setFormValue($val);
            }
        }

        // Note: ConfirmValue will be compared with FormValue
        if (Config("ENCRYPTED_PASSWORD")) { // Encrypted password, use raw value
            $this->_Password->ConfirmValue = $CurrentForm->getValue("c__Password");
        } else {
            $this->_Password->ConfirmValue = RemoveXss($CurrentForm->getValue("c__Password"));
        }

        // Check field name 'Avatar' first before field var 'x_Avatar'
        $val = $CurrentForm->hasValue("Avatar") ? $CurrentForm->getValue("Avatar") : $CurrentForm->getValue("x_Avatar");
        if (!$this->Avatar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Avatar->Visible = false; // Disable update for API request
            } else {
                $this->Avatar->setFormValue($val);
            }
        }

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->FirstName->CurrentValue = $this->FirstName->FormValue;
        $this->LastName->CurrentValue = $this->LastName->FormValue;
        $this->_Email->CurrentValue = $this->_Email->FormValue;
        $this->_Password->CurrentValue = $this->_Password->FormValue;
        $this->Avatar->CurrentValue = $this->Avatar->FormValue;
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
        $this->ID->setDbValue($row['ID']);
        $this->FirstName->setDbValue($row['FirstName']);
        $this->LastName->setDbValue($row['LastName']);
        $this->_Email->setDbValue($row['Email']);
        $this->_Password->setDbValue($row['Password']);
        $this->_Token->setDbValue($row['Token']);
        $this->_Profile->setDbValue($row['Profile']);
        $this->Avatar->setDbValue($row['Avatar']);
        $this->CreatedAt->setDbValue($row['CreatedAt']);
        $this->UpdatedAt->setDbValue($row['UpdatedAt']);
        $this->_UserLevel->setDbValue($row['UserLevel']);
        $this->Status->setDbValue($row['Status']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ID'] = $this->ID->DefaultValue;
        $row['FirstName'] = $this->FirstName->DefaultValue;
        $row['LastName'] = $this->LastName->DefaultValue;
        $row['Email'] = $this->_Email->DefaultValue;
        $row['Password'] = $this->_Password->DefaultValue;
        $row['Token'] = $this->_Token->DefaultValue;
        $row['Profile'] = $this->_Profile->DefaultValue;
        $row['Avatar'] = $this->Avatar->DefaultValue;
        $row['CreatedAt'] = $this->CreatedAt->DefaultValue;
        $row['UpdatedAt'] = $this->UpdatedAt->DefaultValue;
        $row['UserLevel'] = $this->_UserLevel->DefaultValue;
        $row['Status'] = $this->Status->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ID
        $this->ID->RowCssClass = "row";

        // FirstName
        $this->FirstName->RowCssClass = "row";

        // LastName
        $this->LastName->RowCssClass = "row";

        // Email
        $this->_Email->RowCssClass = "row";

        // Password
        $this->_Password->RowCssClass = "row";

        // Token
        $this->_Token->RowCssClass = "row";

        // Profile
        $this->_Profile->RowCssClass = "row";

        // Avatar
        $this->Avatar->RowCssClass = "row";

        // CreatedAt
        $this->CreatedAt->RowCssClass = "row";

        // UpdatedAt
        $this->UpdatedAt->RowCssClass = "row";

        // UserLevel
        $this->_UserLevel->RowCssClass = "row";

        // Status
        $this->Status->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;

            // FirstName
            $this->FirstName->ViewValue = $this->FirstName->CurrentValue;

            // LastName
            $this->LastName->ViewValue = $this->LastName->CurrentValue;

            // Email
            $this->_Email->ViewValue = $this->_Email->CurrentValue;

            // Password
            $this->_Password->ViewValue = $this->_Password->CurrentValue;

            // Token
            $this->_Token->ViewValue = $this->_Token->CurrentValue;
            $this->_Token->ViewValue = FormatNumber($this->_Token->ViewValue, $this->_Token->formatPattern());

            // Profile
            $this->_Profile->ViewValue = $this->_Profile->CurrentValue;

            // Avatar
            $this->Avatar->ViewValue = $this->Avatar->CurrentValue;

            // CreatedAt
            $this->CreatedAt->ViewValue = $this->CreatedAt->CurrentValue;
            $this->CreatedAt->ViewValue = FormatDateTime($this->CreatedAt->ViewValue, $this->CreatedAt->formatPattern());

            // UpdatedAt
            $this->UpdatedAt->ViewValue = $this->UpdatedAt->CurrentValue;
            $this->UpdatedAt->ViewValue = FormatDateTime($this->UpdatedAt->ViewValue, $this->UpdatedAt->formatPattern());

            // UserLevel
            if ($Security->canAdmin()) { // System admin
                $curVal = strval($this->_UserLevel->CurrentValue);
                if ($curVal != "") {
                    $this->_UserLevel->ViewValue = $this->_UserLevel->lookupCacheOption($curVal);
                    if ($this->_UserLevel->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->_UserLevel->Lookup->getTable()->Fields["UserLevelID"]->searchExpression(), "=", $curVal, $this->_UserLevel->Lookup->getTable()->Fields["UserLevelID"]->searchDataType(), "");
                        $sqlWrk = $this->_UserLevel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->_UserLevel->Lookup->renderViewRow($rswrk[0]);
                            $this->_UserLevel->ViewValue = $this->_UserLevel->displayValue($arwrk);
                        } else {
                            $this->_UserLevel->ViewValue = FormatNumber($this->_UserLevel->CurrentValue, $this->_UserLevel->formatPattern());
                        }
                    }
                } else {
                    $this->_UserLevel->ViewValue = null;
                }
            } else {
                $this->_UserLevel->ViewValue = $Language->phrase("PasswordMask");
            }

            // Status
            $this->Status->ViewValue = $this->Status->CurrentValue;
            $this->Status->ViewValue = FormatNumber($this->Status->ViewValue, $this->Status->formatPattern());

            // FirstName
            $this->FirstName->HrefValue = "";
            $this->FirstName->TooltipValue = "";

            // LastName
            $this->LastName->HrefValue = "";
            $this->LastName->TooltipValue = "";

            // Email
            $this->_Email->HrefValue = "";
            $this->_Email->TooltipValue = "";

            // Password
            $this->_Password->HrefValue = "";
            $this->_Password->TooltipValue = "";

            // Avatar
            $this->Avatar->HrefValue = "";
            $this->Avatar->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // FirstName
            $this->FirstName->setupEditAttributes();
            if (!$this->FirstName->Raw) {
                $this->FirstName->CurrentValue = HtmlDecode($this->FirstName->CurrentValue);
            }
            $this->FirstName->EditValue = HtmlEncode($this->FirstName->CurrentValue);
            $this->FirstName->PlaceHolder = RemoveHtml($this->FirstName->caption());

            // LastName
            $this->LastName->setupEditAttributes();
            if (!$this->LastName->Raw) {
                $this->LastName->CurrentValue = HtmlDecode($this->LastName->CurrentValue);
            }
            $this->LastName->EditValue = HtmlEncode($this->LastName->CurrentValue);
            $this->LastName->PlaceHolder = RemoveHtml($this->LastName->caption());

            // Email
            $this->_Email->setupEditAttributes();
            if (!$this->_Email->Raw) {
                $this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
            }
            $this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
            $this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

            // Password
            $this->_Password->setupEditAttributes();
            if (!$this->_Password->Raw) {
                $this->_Password->CurrentValue = HtmlDecode($this->_Password->CurrentValue);
            }
            $this->_Password->EditValue = HtmlEncode($this->_Password->CurrentValue);
            $this->_Password->PlaceHolder = RemoveHtml($this->_Password->caption());

            // Avatar
            $this->Avatar->setupEditAttributes();
            if (!$this->Avatar->Raw) {
                $this->Avatar->CurrentValue = HtmlDecode($this->Avatar->CurrentValue);
            }
            $this->Avatar->EditValue = HtmlEncode($this->Avatar->CurrentValue);
            $this->Avatar->PlaceHolder = RemoveHtml($this->Avatar->caption());

            // Add refer script

            // FirstName
            $this->FirstName->HrefValue = "";

            // LastName
            $this->LastName->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";

            // Password
            $this->_Password->HrefValue = "";

            // Avatar
            $this->Avatar->HrefValue = "";
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
            if ($this->FirstName->Visible && $this->FirstName->Required) {
                if (!$this->FirstName->IsDetailKey && EmptyValue($this->FirstName->FormValue)) {
                    $this->FirstName->addErrorMessage(str_replace("%s", $this->FirstName->caption(), $this->FirstName->RequiredErrorMessage));
                }
            }
            if ($this->LastName->Visible && $this->LastName->Required) {
                if (!$this->LastName->IsDetailKey && EmptyValue($this->LastName->FormValue)) {
                    $this->LastName->addErrorMessage(str_replace("%s", $this->LastName->caption(), $this->LastName->RequiredErrorMessage));
                }
            }
            if ($this->_Email->Visible && $this->_Email->Required) {
                if (!$this->_Email->IsDetailKey && EmptyValue($this->_Email->FormValue)) {
                    $this->_Email->addErrorMessage($Language->phrase("EnterUserName"));
                }
            }
            if (!$this->_Email->Raw && Config("REMOVE_XSS") && CheckUsername($this->_Email->FormValue)) {
                $this->_Email->addErrorMessage($Language->phrase("InvalidUsernameChars"));
            }
            if ($this->_Password->Visible && $this->_Password->Required) {
                if (!$this->_Password->IsDetailKey && EmptyValue($this->_Password->FormValue)) {
                    $this->_Password->addErrorMessage($Language->phrase("EnterPassword"));
                }
            }
            if (!$this->_Password->Raw && Config("REMOVE_XSS") && CheckPassword($this->_Password->FormValue)) {
                $this->_Password->addErrorMessage($Language->phrase("InvalidPasswordChars"));
            }
            if ($this->Avatar->Visible && $this->Avatar->Required) {
                if (!$this->Avatar->IsDetailKey && EmptyValue($this->Avatar->FormValue)) {
                    $this->Avatar->addErrorMessage(str_replace("%s", $this->Avatar->caption(), $this->Avatar->RequiredErrorMessage));
                }
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
        if ($this->_Email->CurrentValue != "") { // Check field with unique index
            $filter = "(`Email` = '" . AdjustSql($this->_Email->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->_Email->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->_Email->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
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

            // Call User Registered event
            $this->userRegistered($rsnew);
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

        // FirstName
        $this->FirstName->setDbValueDef($rsnew, $this->FirstName->CurrentValue, false);

        // LastName
        $this->LastName->setDbValueDef($rsnew, $this->LastName->CurrentValue, false);

        // Email
        $this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, false);

        // Password
        $this->_Password->setDbValueDef($rsnew, $this->_Password->CurrentValue, false);

        // Avatar
        $this->Avatar->setDbValueDef($rsnew, $this->Avatar->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['FirstName'])) { // FirstName
            $this->FirstName->setFormValue($row['FirstName']);
        }
        if (isset($row['LastName'])) { // LastName
            $this->LastName->setFormValue($row['LastName']);
        }
        if (isset($row['Email'])) { // Email
            $this->_Email->setFormValue($row['Email']);
        }
        if (isset($row['Password'])) { // Password
            $this->_Password->setFormValue($row['Password']);
        }
        if (isset($row['Avatar'])) { // Avatar
            $this->Avatar->setFormValue($row['Avatar']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("splash");
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
                case "x__UserLevel":
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
    // $type = ''|'success'|'failure'
    public function messageShowing(&$msg, $type)
    {
        // Example:
        //if ($type == "success") $msg = "your success message";
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

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }

    // User Registered event
    public function userRegistered($rs)
    {
        //Log("User_Registered");
    }

    // User Activated event
    public function userActivated($rs)
    {
        //Log("User_Activated");
    }
}
