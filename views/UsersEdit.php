<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$UsersEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fUsersedit" id="fUsersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Users: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fUsersedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fUsersedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
            ["FirstName", [fields.FirstName.visible && fields.FirstName.required ? ew.Validators.required(fields.FirstName.caption) : null], fields.FirstName.isInvalid],
            ["LastName", [fields.LastName.visible && fields.LastName.required ? ew.Validators.required(fields.LastName.caption) : null], fields.LastName.isInvalid],
            ["_Email", [fields._Email.visible && fields._Email.required ? ew.Validators.required(fields._Email.caption) : null], fields._Email.isInvalid],
            ["_Password", [fields._Password.visible && fields._Password.required ? ew.Validators.required(fields._Password.caption) : null], fields._Password.isInvalid],
            ["_Token", [fields._Token.visible && fields._Token.required ? ew.Validators.required(fields._Token.caption) : null, ew.Validators.integer], fields._Token.isInvalid],
            ["_Profile", [fields._Profile.visible && fields._Profile.required ? ew.Validators.required(fields._Profile.caption) : null], fields._Profile.isInvalid],
            ["Avatar", [fields.Avatar.visible && fields.Avatar.required ? ew.Validators.required(fields.Avatar.caption) : null], fields.Avatar.isInvalid],
            ["CreatedAt", [fields.CreatedAt.visible && fields.CreatedAt.required ? ew.Validators.required(fields.CreatedAt.caption) : null, ew.Validators.datetime(fields.CreatedAt.clientFormatPattern)], fields.CreatedAt.isInvalid],
            ["UpdatedAt", [fields.UpdatedAt.visible && fields.UpdatedAt.required ? ew.Validators.required(fields.UpdatedAt.caption) : null, ew.Validators.datetime(fields.UpdatedAt.clientFormatPattern)], fields.UpdatedAt.isInvalid],
            ["_UserLevel", [fields._UserLevel.visible && fields._UserLevel.required ? ew.Validators.required(fields._UserLevel.caption) : null], fields._UserLevel.isInvalid],
            ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null, ew.Validators.integer], fields.Status.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "_UserLevel": <?= $Page->_UserLevel->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="Users">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <label id="elh_Users_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ID->cellAttributes() ?>>
<span id="el_Users_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
<input type="hidden" data-table="Users" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
    <div id="r_FirstName"<?= $Page->FirstName->rowAttributes() ?>>
        <label id="elh_Users_FirstName" for="x_FirstName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FirstName->caption() ?><?= $Page->FirstName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->FirstName->cellAttributes() ?>>
<span id="el_Users_FirstName">
<input type="<?= $Page->FirstName->getInputTextType() ?>" name="x_FirstName" id="x_FirstName" data-table="Users" data-field="x_FirstName" value="<?= $Page->FirstName->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->FirstName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->FirstName->formatPattern()) ?>"<?= $Page->FirstName->editAttributes() ?> aria-describedby="x_FirstName_help">
<?= $Page->FirstName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FirstName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
    <div id="r_LastName"<?= $Page->LastName->rowAttributes() ?>>
        <label id="elh_Users_LastName" for="x_LastName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LastName->caption() ?><?= $Page->LastName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->LastName->cellAttributes() ?>>
<span id="el_Users_LastName">
<input type="<?= $Page->LastName->getInputTextType() ?>" name="x_LastName" id="x_LastName" data-table="Users" data-field="x_LastName" value="<?= $Page->LastName->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->LastName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->LastName->formatPattern()) ?>"<?= $Page->LastName->editAttributes() ?> aria-describedby="x_LastName_help">
<?= $Page->LastName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LastName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
    <div id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <label id="elh_Users__Email" for="x__Email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Email->cellAttributes() ?>>
<span id="el_Users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="Users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="256" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
    <div id="r__Password"<?= $Page->_Password->rowAttributes() ?>>
        <label id="elh_Users__Password" for="x__Password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Password->cellAttributes() ?>>
<span id="el_Users__Password">
<input type="<?= $Page->_Password->getInputTextType() ?>" name="x__Password" id="x__Password" data-table="Users" data-field="x__Password" value="<?= $Page->_Password->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Password->formatPattern()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Token->Visible) { // Token ?>
    <div id="r__Token"<?= $Page->_Token->rowAttributes() ?>>
        <label id="elh_Users__Token" for="x__Token" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Token->caption() ?><?= $Page->_Token->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Token->cellAttributes() ?>>
<span id="el_Users__Token">
<input type="<?= $Page->_Token->getInputTextType() ?>" name="x__Token" id="x__Token" data-table="Users" data-field="x__Token" value="<?= $Page->_Token->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_Token->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Token->formatPattern()) ?>"<?= $Page->_Token->editAttributes() ?> aria-describedby="x__Token_help">
<?= $Page->_Token->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Token->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Profile->Visible) { // Profile ?>
    <div id="r__Profile"<?= $Page->_Profile->rowAttributes() ?>>
        <label id="elh_Users__Profile" for="x__Profile" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Profile->caption() ?><?= $Page->_Profile->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Profile->cellAttributes() ?>>
<span id="el_Users__Profile">
<input type="<?= $Page->_Profile->getInputTextType() ?>" name="x__Profile" id="x__Profile" data-table="Users" data-field="x__Profile" value="<?= $Page->_Profile->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->_Profile->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Profile->formatPattern()) ?>"<?= $Page->_Profile->editAttributes() ?> aria-describedby="x__Profile_help">
<?= $Page->_Profile->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Profile->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Avatar->Visible) { // Avatar ?>
    <div id="r_Avatar"<?= $Page->Avatar->rowAttributes() ?>>
        <label id="elh_Users_Avatar" for="x_Avatar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Avatar->caption() ?><?= $Page->Avatar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Avatar->cellAttributes() ?>>
<span id="el_Users_Avatar">
<input type="<?= $Page->Avatar->getInputTextType() ?>" name="x_Avatar" id="x_Avatar" data-table="Users" data-field="x_Avatar" value="<?= $Page->Avatar->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->Avatar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Avatar->formatPattern()) ?>"<?= $Page->Avatar->editAttributes() ?> aria-describedby="x_Avatar_help">
<?= $Page->Avatar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Avatar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <div id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <label id="elh_Users_CreatedAt" for="x_CreatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CreatedAt->caption() ?><?= $Page->CreatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_Users_CreatedAt">
<input type="<?= $Page->CreatedAt->getInputTextType() ?>" name="x_CreatedAt" id="x_CreatedAt" data-table="Users" data-field="x_CreatedAt" value="<?= $Page->CreatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->CreatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->CreatedAt->formatPattern()) ?>"<?= $Page->CreatedAt->editAttributes() ?> aria-describedby="x_CreatedAt_help">
<?= $Page->CreatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CreatedAt->getErrorMessage() ?></div>
<?php if (!$Page->CreatedAt->ReadOnly && !$Page->CreatedAt->Disabled && !isset($Page->CreatedAt->EditAttrs["readonly"]) && !isset($Page->CreatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fUsersedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fUsersedit", "x_CreatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <div id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <label id="elh_Users_UpdatedAt" for="x_UpdatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UpdatedAt->caption() ?><?= $Page->UpdatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_Users_UpdatedAt">
<input type="<?= $Page->UpdatedAt->getInputTextType() ?>" name="x_UpdatedAt" id="x_UpdatedAt" data-table="Users" data-field="x_UpdatedAt" value="<?= $Page->UpdatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->UpdatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UpdatedAt->formatPattern()) ?>"<?= $Page->UpdatedAt->editAttributes() ?> aria-describedby="x_UpdatedAt_help">
<?= $Page->UpdatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UpdatedAt->getErrorMessage() ?></div>
<?php if (!$Page->UpdatedAt->ReadOnly && !$Page->UpdatedAt->Disabled && !isset($Page->UpdatedAt->EditAttrs["readonly"]) && !isset($Page->UpdatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fUsersedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fUsersedit", "x_UpdatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_UserLevel->Visible) { // UserLevel ?>
    <div id="r__UserLevel"<?= $Page->_UserLevel->rowAttributes() ?>>
        <label id="elh_Users__UserLevel" for="x__UserLevel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_UserLevel->caption() ?><?= $Page->_UserLevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_UserLevel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_Users__UserLevel">
<span class="form-control-plaintext"><?= $Page->_UserLevel->getDisplayValue($Page->_UserLevel->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_Users__UserLevel">
    <select
        id="x__UserLevel"
        name="x__UserLevel"
        class="form-select ew-select<?= $Page->_UserLevel->isInvalidClass() ?>"
        <?php if (!$Page->_UserLevel->IsNativeSelect) { ?>
        data-select2-id="fUsersedit_x__UserLevel"
        <?php } ?>
        data-table="Users"
        data-field="x__UserLevel"
        data-value-separator="<?= $Page->_UserLevel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_UserLevel->getPlaceHolder()) ?>"
        <?= $Page->_UserLevel->editAttributes() ?>>
        <?= $Page->_UserLevel->selectOptionListHtml("x__UserLevel") ?>
    </select>
    <?= $Page->_UserLevel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_UserLevel->getErrorMessage() ?></div>
<?= $Page->_UserLevel->Lookup->getParamTag($Page, "p_x__UserLevel") ?>
<?php if (!$Page->_UserLevel->IsNativeSelect) { ?>
<script>
loadjs.ready("fUsersedit", function() {
    var options = { name: "x__UserLevel", selectId: "fUsersedit_x__UserLevel" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fUsersedit.lists._UserLevel?.lookupOptions.length) {
        options.data = { id: "x__UserLevel", form: "fUsersedit" };
    } else {
        options.ajax = { id: "x__UserLevel", form: "fUsersedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.Users.fields._UserLevel.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <div id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <label id="elh_Users_Status" for="x_Status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status->caption() ?><?= $Page->Status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status->cellAttributes() ?>>
<span id="el_Users_Status">
<input type="<?= $Page->Status->getInputTextType() ?>" name="x_Status" id="x_Status" data-table="Users" data-field="x_Status" value="<?= $Page->Status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Status->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status->formatPattern()) ?>"<?= $Page->Status->editAttributes() ?> aria-describedby="x_Status_help">
<?= $Page->Status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fUsersedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fUsersedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("Users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
