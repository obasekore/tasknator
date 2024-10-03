<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$TasksEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fTasksedit" id="fTasksedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Tasks: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fTasksedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fTasksedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["TaskID", [fields.TaskID.visible && fields.TaskID.required ? ew.Validators.required(fields.TaskID.caption) : null], fields.TaskID.isInvalid],
            ["_UserID", [fields._UserID.visible && fields._UserID.required ? ew.Validators.required(fields._UserID.caption) : null, ew.Validators.integer], fields._UserID.isInvalid],
            ["TaskerID", [fields.TaskerID.visible && fields.TaskerID.required ? ew.Validators.required(fields.TaskerID.caption) : null], fields.TaskerID.isInvalid],
            ["Location", [fields.Location.visible && fields.Location.required ? ew.Validators.required(fields.Location.caption) : null], fields.Location.isInvalid],
            ["StartTime", [fields.StartTime.visible && fields.StartTime.required ? ew.Validators.required(fields.StartTime.caption) : null, ew.Validators.datetime(fields.StartTime.clientFormatPattern)], fields.StartTime.isInvalid],
            ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null, ew.Validators.integer], fields.Status.isInvalid],
            ["Duration", [fields.Duration.visible && fields.Duration.required ? ew.Validators.required(fields.Duration.caption) : null, ew.Validators.integer], fields.Duration.isInvalid],
            ["CreatedAt", [fields.CreatedAt.visible && fields.CreatedAt.required ? ew.Validators.required(fields.CreatedAt.caption) : null, ew.Validators.datetime(fields.CreatedAt.clientFormatPattern)], fields.CreatedAt.isInvalid],
            ["UpdatedAt", [fields.UpdatedAt.visible && fields.UpdatedAt.required ? ew.Validators.required(fields.UpdatedAt.caption) : null, ew.Validators.datetime(fields.UpdatedAt.clientFormatPattern)], fields.UpdatedAt.isInvalid],
            ["ServiceID", [fields.ServiceID.visible && fields.ServiceID.required ? ew.Validators.required(fields.ServiceID.caption) : null, ew.Validators.integer], fields.ServiceID.isInvalid]
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
            "TaskerID": <?= $Page->TaskerID->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="Tasks">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->TaskID->Visible) { // TaskID ?>
    <div id="r_TaskID"<?= $Page->TaskID->rowAttributes() ?>>
        <label id="elh_Tasks_TaskID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TaskID->caption() ?><?= $Page->TaskID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->TaskID->cellAttributes() ?>>
<span id="el_Tasks_TaskID">
<span<?= $Page->TaskID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TaskID->getDisplayValue($Page->TaskID->EditValue))) ?>"></span>
<input type="hidden" data-table="Tasks" data-field="x_TaskID" data-hidden="1" name="x_TaskID" id="x_TaskID" value="<?= HtmlEncode($Page->TaskID->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
    <div id="r__UserID"<?= $Page->_UserID->rowAttributes() ?>>
        <label id="elh_Tasks__UserID" for="x__UserID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_UserID->caption() ?><?= $Page->_UserID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_UserID->cellAttributes() ?>>
<span id="el_Tasks__UserID">
<input type="<?= $Page->_UserID->getInputTextType() ?>" name="x__UserID" id="x__UserID" data-table="Tasks" data-field="x__UserID" value="<?= $Page->_UserID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_UserID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_UserID->formatPattern()) ?>"<?= $Page->_UserID->editAttributes() ?> aria-describedby="x__UserID_help">
<?= $Page->_UserID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_UserID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TaskerID->Visible) { // TaskerID ?>
    <div id="r_TaskerID"<?= $Page->TaskerID->rowAttributes() ?>>
        <label id="elh_Tasks_TaskerID" for="x_TaskerID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TaskerID->caption() ?><?= $Page->TaskerID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->TaskerID->cellAttributes() ?>>
<span id="el_Tasks_TaskerID">
    <select
        id="x_TaskerID"
        name="x_TaskerID"
        class="form-select ew-select<?= $Page->TaskerID->isInvalidClass() ?>"
        <?php if (!$Page->TaskerID->IsNativeSelect) { ?>
        data-select2-id="fTasksedit_x_TaskerID"
        <?php } ?>
        data-table="Tasks"
        data-field="x_TaskerID"
        data-value-separator="<?= $Page->TaskerID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->TaskerID->getPlaceHolder()) ?>"
        <?= $Page->TaskerID->editAttributes() ?>>
        <?= $Page->TaskerID->selectOptionListHtml("x_TaskerID") ?>
    </select>
    <?= $Page->TaskerID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->TaskerID->getErrorMessage() ?></div>
<?= $Page->TaskerID->Lookup->getParamTag($Page, "p_x_TaskerID") ?>
<?php if (!$Page->TaskerID->IsNativeSelect) { ?>
<script>
loadjs.ready("fTasksedit", function() {
    var options = { name: "x_TaskerID", selectId: "fTasksedit_x_TaskerID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fTasksedit.lists.TaskerID?.lookupOptions.length) {
        options.data = { id: "x_TaskerID", form: "fTasksedit" };
    } else {
        options.ajax = { id: "x_TaskerID", form: "fTasksedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.Tasks.fields.TaskerID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Location->Visible) { // Location ?>
    <div id="r_Location"<?= $Page->Location->rowAttributes() ?>>
        <label id="elh_Tasks_Location" for="x_Location" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Location->caption() ?><?= $Page->Location->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Location->cellAttributes() ?>>
<span id="el_Tasks_Location">
<input type="<?= $Page->Location->getInputTextType() ?>" name="x_Location" id="x_Location" data-table="Tasks" data-field="x_Location" value="<?= $Page->Location->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->Location->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Location->formatPattern()) ?>"<?= $Page->Location->editAttributes() ?> aria-describedby="x_Location_help">
<?= $Page->Location->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Location->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->StartTime->Visible) { // StartTime ?>
    <div id="r_StartTime"<?= $Page->StartTime->rowAttributes() ?>>
        <label id="elh_Tasks_StartTime" for="x_StartTime" class="<?= $Page->LeftColumnClass ?>"><?= $Page->StartTime->caption() ?><?= $Page->StartTime->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->StartTime->cellAttributes() ?>>
<span id="el_Tasks_StartTime">
<input type="<?= $Page->StartTime->getInputTextType() ?>" name="x_StartTime" id="x_StartTime" data-table="Tasks" data-field="x_StartTime" value="<?= $Page->StartTime->EditValue ?>" placeholder="<?= HtmlEncode($Page->StartTime->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->StartTime->formatPattern()) ?>"<?= $Page->StartTime->editAttributes() ?> aria-describedby="x_StartTime_help">
<?= $Page->StartTime->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->StartTime->getErrorMessage() ?></div>
<?php if (!$Page->StartTime->ReadOnly && !$Page->StartTime->Disabled && !isset($Page->StartTime->EditAttrs["readonly"]) && !isset($Page->StartTime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTasksedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fTasksedit", "x_StartTime", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <div id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <label id="elh_Tasks_Status" for="x_Status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status->caption() ?><?= $Page->Status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status->cellAttributes() ?>>
<span id="el_Tasks_Status">
<input type="<?= $Page->Status->getInputTextType() ?>" name="x_Status" id="x_Status" data-table="Tasks" data-field="x_Status" value="<?= $Page->Status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Status->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status->formatPattern()) ?>"<?= $Page->Status->editAttributes() ?> aria-describedby="x_Status_help">
<?= $Page->Status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Duration->Visible) { // Duration ?>
    <div id="r_Duration"<?= $Page->Duration->rowAttributes() ?>>
        <label id="elh_Tasks_Duration" for="x_Duration" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Duration->caption() ?><?= $Page->Duration->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Duration->cellAttributes() ?>>
<span id="el_Tasks_Duration">
<input type="<?= $Page->Duration->getInputTextType() ?>" name="x_Duration" id="x_Duration" data-table="Tasks" data-field="x_Duration" value="<?= $Page->Duration->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Duration->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Duration->formatPattern()) ?>"<?= $Page->Duration->editAttributes() ?> aria-describedby="x_Duration_help">
<?= $Page->Duration->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Duration->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <div id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <label id="elh_Tasks_CreatedAt" for="x_CreatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CreatedAt->caption() ?><?= $Page->CreatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_Tasks_CreatedAt">
<input type="<?= $Page->CreatedAt->getInputTextType() ?>" name="x_CreatedAt" id="x_CreatedAt" data-table="Tasks" data-field="x_CreatedAt" value="<?= $Page->CreatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->CreatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->CreatedAt->formatPattern()) ?>"<?= $Page->CreatedAt->editAttributes() ?> aria-describedby="x_CreatedAt_help">
<?= $Page->CreatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CreatedAt->getErrorMessage() ?></div>
<?php if (!$Page->CreatedAt->ReadOnly && !$Page->CreatedAt->Disabled && !isset($Page->CreatedAt->EditAttrs["readonly"]) && !isset($Page->CreatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTasksedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fTasksedit", "x_CreatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <div id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <label id="elh_Tasks_UpdatedAt" for="x_UpdatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UpdatedAt->caption() ?><?= $Page->UpdatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_Tasks_UpdatedAt">
<input type="<?= $Page->UpdatedAt->getInputTextType() ?>" name="x_UpdatedAt" id="x_UpdatedAt" data-table="Tasks" data-field="x_UpdatedAt" value="<?= $Page->UpdatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->UpdatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UpdatedAt->formatPattern()) ?>"<?= $Page->UpdatedAt->editAttributes() ?> aria-describedby="x_UpdatedAt_help">
<?= $Page->UpdatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UpdatedAt->getErrorMessage() ?></div>
<?php if (!$Page->UpdatedAt->ReadOnly && !$Page->UpdatedAt->Disabled && !isset($Page->UpdatedAt->EditAttrs["readonly"]) && !isset($Page->UpdatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fTasksedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fTasksedit", "x_UpdatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
    <div id="r_ServiceID"<?= $Page->ServiceID->rowAttributes() ?>>
        <label id="elh_Tasks_ServiceID" for="x_ServiceID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ServiceID->caption() ?><?= $Page->ServiceID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ServiceID->cellAttributes() ?>>
<span id="el_Tasks_ServiceID">
<input type="<?= $Page->ServiceID->getInputTextType() ?>" name="x_ServiceID" id="x_ServiceID" data-table="Tasks" data-field="x_ServiceID" value="<?= $Page->ServiceID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ServiceID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ServiceID->formatPattern()) ?>"<?= $Page->ServiceID->editAttributes() ?> aria-describedby="x_ServiceID_help">
<?= $Page->ServiceID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ServiceID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fTasksedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fTasksedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("Tasks");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
