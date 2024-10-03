<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$TasksDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Tasks: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fTasksdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fTasksdelete")
        .setPageId("delete")
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
<form name="fTasksdelete" id="fTasksdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="Tasks">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->TaskID->Visible) { // TaskID ?>
        <th class="<?= $Page->TaskID->headerCellClass() ?>"><span id="elh_Tasks_TaskID" class="Tasks_TaskID"><?= $Page->TaskID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
        <th class="<?= $Page->_UserID->headerCellClass() ?>"><span id="elh_Tasks__UserID" class="Tasks__UserID"><?= $Page->_UserID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TaskerID->Visible) { // TaskerID ?>
        <th class="<?= $Page->TaskerID->headerCellClass() ?>"><span id="elh_Tasks_TaskerID" class="Tasks_TaskerID"><?= $Page->TaskerID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Location->Visible) { // Location ?>
        <th class="<?= $Page->Location->headerCellClass() ?>"><span id="elh_Tasks_Location" class="Tasks_Location"><?= $Page->Location->caption() ?></span></th>
<?php } ?>
<?php if ($Page->StartTime->Visible) { // StartTime ?>
        <th class="<?= $Page->StartTime->headerCellClass() ?>"><span id="elh_Tasks_StartTime" class="Tasks_StartTime"><?= $Page->StartTime->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th class="<?= $Page->Status->headerCellClass() ?>"><span id="elh_Tasks_Status" class="Tasks_Status"><?= $Page->Status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Duration->Visible) { // Duration ?>
        <th class="<?= $Page->Duration->headerCellClass() ?>"><span id="elh_Tasks_Duration" class="Tasks_Duration"><?= $Page->Duration->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
        <th class="<?= $Page->CreatedAt->headerCellClass() ?>"><span id="elh_Tasks_CreatedAt" class="Tasks_CreatedAt"><?= $Page->CreatedAt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
        <th class="<?= $Page->UpdatedAt->headerCellClass() ?>"><span id="elh_Tasks_UpdatedAt" class="Tasks_UpdatedAt"><?= $Page->UpdatedAt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
        <th class="<?= $Page->ServiceID->headerCellClass() ?>"><span id="elh_Tasks_ServiceID" class="Tasks_ServiceID"><?= $Page->ServiceID->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->TaskID->Visible) { // TaskID ?>
        <td<?= $Page->TaskID->cellAttributes() ?>>
<span id="">
<span<?= $Page->TaskID->viewAttributes() ?>>
<?= $Page->TaskID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
        <td<?= $Page->_UserID->cellAttributes() ?>>
<span id="">
<span<?= $Page->_UserID->viewAttributes() ?>>
<?= $Page->_UserID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TaskerID->Visible) { // TaskerID ?>
        <td<?= $Page->TaskerID->cellAttributes() ?>>
<span id="">
<span<?= $Page->TaskerID->viewAttributes() ?>>
<?= $Page->TaskerID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Location->Visible) { // Location ?>
        <td<?= $Page->Location->cellAttributes() ?>>
<span id="">
<span<?= $Page->Location->viewAttributes() ?>>
<?= $Page->Location->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->StartTime->Visible) { // StartTime ?>
        <td<?= $Page->StartTime->cellAttributes() ?>>
<span id="">
<span<?= $Page->StartTime->viewAttributes() ?>>
<?= $Page->StartTime->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <td<?= $Page->Status->cellAttributes() ?>>
<span id="">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Duration->Visible) { // Duration ?>
        <td<?= $Page->Duration->cellAttributes() ?>>
<span id="">
<span<?= $Page->Duration->viewAttributes() ?>>
<?= $Page->Duration->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
        <td<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="">
<span<?= $Page->CreatedAt->viewAttributes() ?>>
<?= $Page->CreatedAt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
        <td<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="">
<span<?= $Page->UpdatedAt->viewAttributes() ?>>
<?= $Page->UpdatedAt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
        <td<?= $Page->ServiceID->cellAttributes() ?>>
<span id="">
<span<?= $Page->ServiceID->viewAttributes() ?>>
<?= $Page->ServiceID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
