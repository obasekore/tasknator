<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$Register = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Users: currentTable } });
var currentPageID = ew.PAGE_ID = "register";
var currentForm;
var fregister;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fregister")
        .setPageId("register")

        // Add fields
        .setFields([
            ["FirstName", [fields.FirstName.visible && fields.FirstName.required ? ew.Validators.required(fields.FirstName.caption) : null], fields.FirstName.isInvalid],
            ["LastName", [fields.LastName.visible && fields.LastName.required ? ew.Validators.required(fields.LastName.caption) : null], fields.LastName.isInvalid],
            ["_Email", [fields._Email.visible && fields._Email.required ? ew.Validators.required(fields._Email.caption) : null, ew.Validators.username(fields._Email.raw)], fields._Email.isInvalid],
            ["c__Password", [ew.Validators.required(ew.language.phrase("ConfirmPassword")), ew.Validators.mismatchPassword], fields._Password.isInvalid],
            ["_Password", [fields._Password.visible && fields._Password.required ? ew.Validators.required(fields._Password.caption) : null, ew.Validators.password(fields._Password.raw)], fields._Password.isInvalid],
            ["Avatar", [fields.Avatar.visible && fields.Avatar.required ? ew.Validators.required(fields.Avatar.caption) : null], fields.Avatar.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)
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
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="Users">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<div class="ew-register-div"><!-- page* -->
<?php if ($Page->FirstName->Visible) { // FirstName ?>
    <div id="r_FirstName"<?= $Page->FirstName->rowAttributes() ?>>
        <label id="elh_Users_FirstName" for="x_FirstName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FirstName->caption() ?><?= $Page->FirstName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->FirstName->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_Users_FirstName">
<input type="<?= $Page->FirstName->getInputTextType() ?>" name="x_FirstName" id="x_FirstName" data-table="Users" data-field="x_FirstName" value="<?= $Page->FirstName->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->FirstName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->FirstName->formatPattern()) ?>"<?= $Page->FirstName->editAttributes() ?> aria-describedby="x_FirstName_help">
<?= $Page->FirstName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FirstName->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_Users_FirstName">
<span<?= $Page->FirstName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->FirstName->getDisplayValue($Page->FirstName->ViewValue))) ?>"></span>
<input type="hidden" data-table="Users" data-field="x_FirstName" data-hidden="1" name="x_FirstName" id="x_FirstName" value="<?= HtmlEncode($Page->FirstName->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
    <div id="r_LastName"<?= $Page->LastName->rowAttributes() ?>>
        <label id="elh_Users_LastName" for="x_LastName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LastName->caption() ?><?= $Page->LastName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->LastName->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_Users_LastName">
<input type="<?= $Page->LastName->getInputTextType() ?>" name="x_LastName" id="x_LastName" data-table="Users" data-field="x_LastName" value="<?= $Page->LastName->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->LastName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->LastName->formatPattern()) ?>"<?= $Page->LastName->editAttributes() ?> aria-describedby="x_LastName_help">
<?= $Page->LastName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LastName->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_Users_LastName">
<span<?= $Page->LastName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->LastName->getDisplayValue($Page->LastName->ViewValue))) ?>"></span>
<input type="hidden" data-table="Users" data-field="x_LastName" data-hidden="1" name="x_LastName" id="x_LastName" value="<?= HtmlEncode($Page->LastName->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
    <div id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <label id="elh_Users__Email" for="x__Email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Email->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_Users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="Users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="256" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_Users__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Email->getDisplayValue($Page->_Email->ViewValue))) ?>"></span>
<input type="hidden" data-table="Users" data-field="x__Email" data-hidden="1" name="x__Email" id="x__Email" value="<?= HtmlEncode($Page->_Email->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
    <div id="r__Password"<?= $Page->_Password->rowAttributes() ?>>
        <label id="elh_Users__Password" for="x__Password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_Users__Password">
<input type="<?= $Page->_Password->getInputTextType() ?>" name="x__Password" id="x__Password" data-table="Users" data-field="x__Password" value="<?= $Page->_Password->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Password->formatPattern()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_Users__Password">
<span<?= $Page->_Password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Password->getDisplayValue($Page->_Password->ViewValue))) ?>"></span>
<input type="hidden" data-table="Users" data-field="x__Password" data-hidden="1" name="x__Password" id="x__Password" value="<?= HtmlEncode($Page->_Password->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
    <div id="r_c__Password" class="row">
        <label id="elh_c_Users__Password" for="c__Password" class="<?= $Page->LeftColumnClass ?>"><?= $Language->phrase("Confirm") ?> <?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_c_Users__Password">
<input type="<?= $Page->_Password->getInputTextType() ?>" name="c__Password" id="c__Password" data-table="Users" data-field="x__Password" value="<?= $Page->_Password->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Password->formatPattern()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_c_Users__Password">
<span<?= $Page->_Password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Password->getDisplayValue($Page->_Password->ViewValue))) ?>"></span>
<input type="hidden" data-table="Users" data-field="x__Password" data-hidden="1" name="c__Password" id="c__Password" value="<?= HtmlEncode($Page->_Password->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Avatar->Visible) { // Avatar ?>
    <div id="r_Avatar"<?= $Page->Avatar->rowAttributes() ?>>
        <label id="elh_Users_Avatar" for="x_Avatar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Avatar->caption() ?><?= $Page->Avatar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Avatar->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_Users_Avatar">
<input type="<?= $Page->Avatar->getInputTextType() ?>" name="x_Avatar" id="x_Avatar" data-table="Users" data-field="x_Avatar" value="<?= $Page->Avatar->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->Avatar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Avatar->formatPattern()) ?>"<?= $Page->Avatar->editAttributes() ?> aria-describedby="x_Avatar_help">
<?= $Page->Avatar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Avatar->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_Users_Avatar">
<span<?= $Page->Avatar->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Avatar->getDisplayValue($Page->Avatar->ViewValue))) ?>"></span>
<input type="hidden" data-table="Users" data-field="x_Avatar" data-hidden="1" name="x_Avatar" id="x_Avatar" value="<?= HtmlEncode($Page->Avatar->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn disabled enable-on-init" name="btn-action" id="btn-action" type="submit" form="fregister" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fregister"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="fregister" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("Users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
