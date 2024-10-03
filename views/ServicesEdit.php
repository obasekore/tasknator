<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$ServicesEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fServicesedit" id="fServicesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Services: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fServicesedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fServicesedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["ServiceID", [fields.ServiceID.visible && fields.ServiceID.required ? ew.Validators.required(fields.ServiceID.caption) : null], fields.ServiceID.isInvalid],
            ["ServiceName", [fields.ServiceName.visible && fields.ServiceName.required ? ew.Validators.required(fields.ServiceName.caption) : null], fields.ServiceName.isInvalid],
            ["ParentService", [fields.ParentService.visible && fields.ParentService.required ? ew.Validators.required(fields.ParentService.caption) : null], fields.ParentService.isInvalid],
            ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null], fields.Status.isInvalid],
            ["Options", [fields.Options.visible && fields.Options.required ? ew.Validators.required(fields.Options.caption) : null], fields.Options.isInvalid],
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
            "ParentService": <?= $Page->ParentService->toClientList($Page) ?>,
            "Status": <?= $Page->Status->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="Services">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
    <div id="r_ServiceID"<?= $Page->ServiceID->rowAttributes() ?>>
        <label id="elh_Services_ServiceID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ServiceID->caption() ?><?= $Page->ServiceID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ServiceID->cellAttributes() ?>>
<span id="el_Services_ServiceID">
<span<?= $Page->ServiceID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ServiceID->getDisplayValue($Page->ServiceID->EditValue))) ?>"></span>
<input type="hidden" data-table="Services" data-field="x_ServiceID" data-hidden="1" name="x_ServiceID" id="x_ServiceID" value="<?= HtmlEncode($Page->ServiceID->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ServiceName->Visible) { // ServiceName ?>
    <div id="r_ServiceName"<?= $Page->ServiceName->rowAttributes() ?>>
        <label id="elh_Services_ServiceName" for="x_ServiceName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ServiceName->caption() ?><?= $Page->ServiceName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ServiceName->cellAttributes() ?>>
<span id="el_Services_ServiceName">
<input type="<?= $Page->ServiceName->getInputTextType() ?>" name="x_ServiceName" id="x_ServiceName" data-table="Services" data-field="x_ServiceName" value="<?= $Page->ServiceName->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->ServiceName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ServiceName->formatPattern()) ?>"<?= $Page->ServiceName->editAttributes() ?> aria-describedby="x_ServiceName_help">
<?= $Page->ServiceName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ServiceName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ParentService->Visible) { // ParentService ?>
    <div id="r_ParentService"<?= $Page->ParentService->rowAttributes() ?>>
        <label id="elh_Services_ParentService" for="x_ParentService" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ParentService->caption() ?><?= $Page->ParentService->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ParentService->cellAttributes() ?>>
<span id="el_Services_ParentService">
    <select
        id="x_ParentService"
        name="x_ParentService"
        class="form-select ew-select<?= $Page->ParentService->isInvalidClass() ?>"
        <?php if (!$Page->ParentService->IsNativeSelect) { ?>
        data-select2-id="fServicesedit_x_ParentService"
        <?php } ?>
        data-table="Services"
        data-field="x_ParentService"
        data-value-separator="<?= $Page->ParentService->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ParentService->getPlaceHolder()) ?>"
        <?= $Page->ParentService->editAttributes() ?>>
        <?= $Page->ParentService->selectOptionListHtml("x_ParentService") ?>
    </select>
    <?= $Page->ParentService->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ParentService->getErrorMessage() ?></div>
<?= $Page->ParentService->Lookup->getParamTag($Page, "p_x_ParentService") ?>
<?php if (!$Page->ParentService->IsNativeSelect) { ?>
<script>
loadjs.ready("fServicesedit", function() {
    var options = { name: "x_ParentService", selectId: "fServicesedit_x_ParentService" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fServicesedit.lists.ParentService?.lookupOptions.length) {
        options.data = { id: "x_ParentService", form: "fServicesedit" };
    } else {
        options.ajax = { id: "x_ParentService", form: "fServicesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.Services.fields.ParentService.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <div id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <label id="elh_Services_Status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status->caption() ?><?= $Page->Status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status->cellAttributes() ?>>
<span id="el_Services_Status">
<template id="tp_x_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="Services" data-field="x_Status" name="x_Status" id="x_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x_Status"
    name="x_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Status"
    data-target="dsl_x_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="Services"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<?= $Page->Status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Options->Visible) { // Options ?>
    <div id="r_Options"<?= $Page->Options->rowAttributes() ?>>
        <label id="elh_Services_Options" for="x_Options" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Options->caption() ?><?= $Page->Options->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Options->cellAttributes() ?>>
<span id="el_Services_Options">
<textarea data-table="Services" data-field="x_Options" name="x_Options" id="x_Options" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Options->getPlaceHolder()) ?>"<?= $Page->Options->editAttributes() ?> aria-describedby="x_Options_help"><?= $Page->Options->EditValue ?></textarea>
<?= $Page->Options->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Options->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <div id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <label id="elh_Services_CreatedAt" for="x_CreatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CreatedAt->caption() ?><?= $Page->CreatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_Services_CreatedAt">
<input type="<?= $Page->CreatedAt->getInputTextType() ?>" name="x_CreatedAt" id="x_CreatedAt" data-table="Services" data-field="x_CreatedAt" value="<?= $Page->CreatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->CreatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->CreatedAt->formatPattern()) ?>"<?= $Page->CreatedAt->editAttributes() ?> aria-describedby="x_CreatedAt_help">
<?= $Page->CreatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CreatedAt->getErrorMessage() ?></div>
<?php if (!$Page->CreatedAt->ReadOnly && !$Page->CreatedAt->Disabled && !isset($Page->CreatedAt->EditAttrs["readonly"]) && !isset($Page->CreatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fServicesedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fServicesedit", "x_CreatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <div id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <label id="elh_Services_UpdatedAt" for="x_UpdatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UpdatedAt->caption() ?><?= $Page->UpdatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_Services_UpdatedAt">
<input type="<?= $Page->UpdatedAt->getInputTextType() ?>" name="x_UpdatedAt" id="x_UpdatedAt" data-table="Services" data-field="x_UpdatedAt" value="<?= $Page->UpdatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->UpdatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UpdatedAt->formatPattern()) ?>"<?= $Page->UpdatedAt->editAttributes() ?> aria-describedby="x_UpdatedAt_help">
<?= $Page->UpdatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UpdatedAt->getErrorMessage() ?></div>
<?php if (!$Page->UpdatedAt->ReadOnly && !$Page->UpdatedAt->Disabled && !isset($Page->UpdatedAt->EditAttrs["readonly"]) && !isset($Page->UpdatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fServicesedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fServicesedit", "x_UpdatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fServicesedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fServicesedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("Services");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
