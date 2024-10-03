<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$TaskerServiceEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fTaskerServiceedit" id="fTaskerServiceedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { TaskerService: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fTaskerServiceedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fTaskerServiceedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["TaskerServiceID", [fields.TaskerServiceID.visible && fields.TaskerServiceID.required ? ew.Validators.required(fields.TaskerServiceID.caption) : null], fields.TaskerServiceID.isInvalid],
            ["_UserID", [fields._UserID.visible && fields._UserID.required ? ew.Validators.required(fields._UserID.caption) : null, ew.Validators.integer], fields._UserID.isInvalid],
            ["ServiceID", [fields.ServiceID.visible && fields.ServiceID.required ? ew.Validators.required(fields.ServiceID.caption) : null, ew.Validators.integer], fields.ServiceID.isInvalid],
            ["AverageRating", [fields.AverageRating.visible && fields.AverageRating.required ? ew.Validators.required(fields.AverageRating.caption) : null, ew.Validators.integer], fields.AverageRating.isInvalid],
            ["ReviewCount", [fields.ReviewCount.visible && fields.ReviewCount.required ? ew.Validators.required(fields.ReviewCount.caption) : null, ew.Validators.integer], fields.ReviewCount.isInvalid],
            ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null, ew.Validators.integer], fields.Status.isInvalid],
            ["CreatedAt", [fields.CreatedAt.visible && fields.CreatedAt.required ? ew.Validators.required(fields.CreatedAt.caption) : null, ew.Validators.datetime(fields.CreatedAt.clientFormatPattern)], fields.CreatedAt.isInvalid],
            ["UpdatedAt", [fields.UpdatedAt.visible && fields.UpdatedAt.required ? ew.Validators.required(fields.UpdatedAt.caption) : null, ew.Validators.datetime(fields.UpdatedAt.clientFormatPattern)], fields.UpdatedAt.isInvalid]
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TaskerService">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->TaskerServiceID->Visible) { // TaskerServiceID ?>
    <div id="r_TaskerServiceID"<?= $Page->TaskerServiceID->rowAttributes() ?>>
        <label id="elh_TaskerService_TaskerServiceID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TaskerServiceID->caption() ?><?= $Page->TaskerServiceID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->TaskerServiceID->cellAttributes() ?>>
<span id="el_TaskerService_TaskerServiceID">
<span<?= $Page->TaskerServiceID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TaskerServiceID->getDisplayValue($Page->TaskerServiceID->EditValue))) ?>"></span>
<input type="hidden" data-table="TaskerService" data-field="x_TaskerServiceID" data-hidden="1" name="x_TaskerServiceID" id="x_TaskerServiceID" value="<?= HtmlEncode($Page->TaskerServiceID->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
    <div id="r__UserID"<?= $Page->_UserID->rowAttributes() ?>>
        <label id="elh_TaskerService__UserID" for="x__UserID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_UserID->caption() ?><?= $Page->_UserID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_UserID->cellAttributes() ?>>
<span id="el_TaskerService__UserID">
<input type="<?= $Page->_UserID->getInputTextType() ?>" name="x__UserID" id="x__UserID" data-table="TaskerService" data-field="x__UserID" value="<?= $Page->_UserID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_UserID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_UserID->formatPattern()) ?>"<?= $Page->_UserID->editAttributes() ?> aria-describedby="x__UserID_help">
<?= $Page->_UserID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_UserID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
    <div id="r_ServiceID"<?= $Page->ServiceID->rowAttributes() ?>>
        <label id="elh_TaskerService_ServiceID" for="x_ServiceID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ServiceID->caption() ?><?= $Page->ServiceID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ServiceID->cellAttributes() ?>>
<span id="el_TaskerService_ServiceID">
<input type="<?= $Page->ServiceID->getInputTextType() ?>" name="x_ServiceID" id="x_ServiceID" data-table="TaskerService" data-field="x_ServiceID" value="<?= $Page->ServiceID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ServiceID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ServiceID->formatPattern()) ?>"<?= $Page->ServiceID->editAttributes() ?> aria-describedby="x_ServiceID_help">
<?= $Page->ServiceID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ServiceID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AverageRating->Visible) { // AverageRating ?>
    <div id="r_AverageRating"<?= $Page->AverageRating->rowAttributes() ?>>
        <label id="elh_TaskerService_AverageRating" for="x_AverageRating" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AverageRating->caption() ?><?= $Page->AverageRating->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->AverageRating->cellAttributes() ?>>
<span id="el_TaskerService_AverageRating">
<input type="<?= $Page->AverageRating->getInputTextType() ?>" name="x_AverageRating" id="x_AverageRating" data-table="TaskerService" data-field="x_AverageRating" value="<?= $Page->AverageRating->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->AverageRating->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->AverageRating->formatPattern()) ?>"<?= $Page->AverageRating->editAttributes() ?> aria-describedby="x_AverageRating_help">
<?= $Page->AverageRating->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AverageRating->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ReviewCount->Visible) { // ReviewCount ?>
    <div id="r_ReviewCount"<?= $Page->ReviewCount->rowAttributes() ?>>
        <label id="elh_TaskerService_ReviewCount" for="x_ReviewCount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ReviewCount->caption() ?><?= $Page->ReviewCount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ReviewCount->cellAttributes() ?>>
<span id="el_TaskerService_ReviewCount">
<input type="<?= $Page->ReviewCount->getInputTextType() ?>" name="x_ReviewCount" id="x_ReviewCount" data-table="TaskerService" data-field="x_ReviewCount" value="<?= $Page->ReviewCount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ReviewCount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ReviewCount->formatPattern()) ?>"<?= $Page->ReviewCount->editAttributes() ?> aria-describedby="x_ReviewCount_help">
<?= $Page->ReviewCount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ReviewCount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <div id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <label id="elh_TaskerService_Status" for="x_Status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status->caption() ?><?= $Page->Status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status->cellAttributes() ?>>
<span id="el_TaskerService_Status">
<input type="<?= $Page->Status->getInputTextType() ?>" name="x_Status" id="x_Status" data-table="TaskerService" data-field="x_Status" value="<?= $Page->Status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Status->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status->formatPattern()) ?>"<?= $Page->Status->editAttributes() ?> aria-describedby="x_Status_help">
<?= $Page->Status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <div id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <label id="elh_TaskerService_CreatedAt" for="x_CreatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CreatedAt->caption() ?><?= $Page->CreatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_TaskerService_CreatedAt">
<input type="<?= $Page->CreatedAt->getInputTextType() ?>" name="x_CreatedAt" id="x_CreatedAt" data-table="TaskerService" data-field="x_CreatedAt" value="<?= $Page->CreatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->CreatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->CreatedAt->formatPattern()) ?>"<?= $Page->CreatedAt->editAttributes() ?> aria-describedby="x_CreatedAt_help">
<?= $Page->CreatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CreatedAt->getErrorMessage() ?></div>
<?php if (!$Page->CreatedAt->ReadOnly && !$Page->CreatedAt->Disabled && !isset($Page->CreatedAt->EditAttrs["readonly"]) && !isset($Page->CreatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTaskerServiceedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fTaskerServiceedit", "x_CreatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <div id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <label id="elh_TaskerService_UpdatedAt" for="x_UpdatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UpdatedAt->caption() ?><?= $Page->UpdatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_TaskerService_UpdatedAt">
<input type="<?= $Page->UpdatedAt->getInputTextType() ?>" name="x_UpdatedAt" id="x_UpdatedAt" data-table="TaskerService" data-field="x_UpdatedAt" value="<?= $Page->UpdatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->UpdatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UpdatedAt->formatPattern()) ?>"<?= $Page->UpdatedAt->editAttributes() ?> aria-describedby="x_UpdatedAt_help">
<?= $Page->UpdatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UpdatedAt->getErrorMessage() ?></div>
<?php if (!$Page->UpdatedAt->ReadOnly && !$Page->UpdatedAt->Disabled && !isset($Page->UpdatedAt->EditAttrs["readonly"]) && !isset($Page->UpdatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTaskerServiceedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fTaskerServiceedit", "x_UpdatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fTaskerServiceedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fTaskerServiceedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("TaskerService");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
