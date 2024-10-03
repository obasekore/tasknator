<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$UserLevelPermissionsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { UserLevelPermissions: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fUserLevelPermissionsadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fUserLevelPermissionsadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["UserLevelID", [fields.UserLevelID.visible && fields.UserLevelID.required ? ew.Validators.required(fields.UserLevelID.caption) : null, ew.Validators.integer], fields.UserLevelID.isInvalid],
            ["_TableName", [fields._TableName.visible && fields._TableName.required ? ew.Validators.required(fields._TableName.caption) : null], fields._TableName.isInvalid],
            ["_Permission", [fields._Permission.visible && fields._Permission.required ? ew.Validators.required(fields._Permission.caption) : null, ew.Validators.integer], fields._Permission.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fUserLevelPermissionsadd" id="fUserLevelPermissionsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="UserLevelPermissions">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <div id="r_UserLevelID"<?= $Page->UserLevelID->rowAttributes() ?>>
        <label id="elh_UserLevelPermissions_UserLevelID" for="x_UserLevelID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelID->caption() ?><?= $Page->UserLevelID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UserLevelID->cellAttributes() ?>>
<span id="el_UserLevelPermissions_UserLevelID">
<input type="<?= $Page->UserLevelID->getInputTextType() ?>" name="x_UserLevelID" id="x_UserLevelID" data-table="UserLevelPermissions" data-field="x_UserLevelID" value="<?= $Page->UserLevelID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->UserLevelID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UserLevelID->formatPattern()) ?>"<?= $Page->UserLevelID->editAttributes() ?> aria-describedby="x_UserLevelID_help">
<?= $Page->UserLevelID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_TableName->Visible) { // TableName ?>
    <div id="r__TableName"<?= $Page->_TableName->rowAttributes() ?>>
        <label id="elh_UserLevelPermissions__TableName" for="x__TableName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_TableName->caption() ?><?= $Page->_TableName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_TableName->cellAttributes() ?>>
<span id="el_UserLevelPermissions__TableName">
<input type="<?= $Page->_TableName->getInputTextType() ?>" name="x__TableName" id="x__TableName" data-table="UserLevelPermissions" data-field="x__TableName" value="<?= $Page->_TableName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_TableName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_TableName->formatPattern()) ?>"<?= $Page->_TableName->editAttributes() ?> aria-describedby="x__TableName_help">
<?= $Page->_TableName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_TableName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Permission->Visible) { // Permission ?>
    <div id="r__Permission"<?= $Page->_Permission->rowAttributes() ?>>
        <label id="elh_UserLevelPermissions__Permission" for="x__Permission" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Permission->caption() ?><?= $Page->_Permission->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Permission->cellAttributes() ?>>
<span id="el_UserLevelPermissions__Permission">
<input type="<?= $Page->_Permission->getInputTextType() ?>" name="x__Permission" id="x__Permission" data-table="UserLevelPermissions" data-field="x__Permission" value="<?= $Page->_Permission->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_Permission->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Permission->formatPattern()) ?>"<?= $Page->_Permission->editAttributes() ?> aria-describedby="x__Permission_help">
<?= $Page->_Permission->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Permission->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fUserLevelPermissionsadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fUserLevelPermissionsadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("UserLevelPermissions");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
