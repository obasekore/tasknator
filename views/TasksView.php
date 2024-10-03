<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$TasksView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="fTasksview" id="fTasksview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Tasks: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fTasksview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fTasksview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="Tasks">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->TaskID->Visible) { // TaskID ?>
    <tr id="r_TaskID"<?= $Page->TaskID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_TaskID"><?= $Page->TaskID->caption() ?></span></td>
        <td data-name="TaskID"<?= $Page->TaskID->cellAttributes() ?>>
<span id="el_Tasks_TaskID">
<span<?= $Page->TaskID->viewAttributes() ?>>
<?= $Page->TaskID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
    <tr id="r__UserID"<?= $Page->_UserID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks__UserID"><?= $Page->_UserID->caption() ?></span></td>
        <td data-name="_UserID"<?= $Page->_UserID->cellAttributes() ?>>
<span id="el_Tasks__UserID">
<span<?= $Page->_UserID->viewAttributes() ?>>
<?= $Page->_UserID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TaskerID->Visible) { // TaskerID ?>
    <tr id="r_TaskerID"<?= $Page->TaskerID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_TaskerID"><?= $Page->TaskerID->caption() ?></span></td>
        <td data-name="TaskerID"<?= $Page->TaskerID->cellAttributes() ?>>
<span id="el_Tasks_TaskerID">
<span<?= $Page->TaskerID->viewAttributes() ?>>
<?= $Page->TaskerID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Location->Visible) { // Location ?>
    <tr id="r_Location"<?= $Page->Location->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_Location"><?= $Page->Location->caption() ?></span></td>
        <td data-name="Location"<?= $Page->Location->cellAttributes() ?>>
<span id="el_Tasks_Location">
<span<?= $Page->Location->viewAttributes() ?>>
<?= $Page->Location->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->StartTime->Visible) { // StartTime ?>
    <tr id="r_StartTime"<?= $Page->StartTime->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_StartTime"><?= $Page->StartTime->caption() ?></span></td>
        <td data-name="StartTime"<?= $Page->StartTime->cellAttributes() ?>>
<span id="el_Tasks_StartTime">
<span<?= $Page->StartTime->viewAttributes() ?>>
<?= $Page->StartTime->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <tr id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_Status"><?= $Page->Status->caption() ?></span></td>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el_Tasks_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Duration->Visible) { // Duration ?>
    <tr id="r_Duration"<?= $Page->Duration->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_Duration"><?= $Page->Duration->caption() ?></span></td>
        <td data-name="Duration"<?= $Page->Duration->cellAttributes() ?>>
<span id="el_Tasks_Duration">
<span<?= $Page->Duration->viewAttributes() ?>>
<?= $Page->Duration->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <tr id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_CreatedAt"><?= $Page->CreatedAt->caption() ?></span></td>
        <td data-name="CreatedAt"<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_Tasks_CreatedAt">
<span<?= $Page->CreatedAt->viewAttributes() ?>>
<?= $Page->CreatedAt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <tr id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_UpdatedAt"><?= $Page->UpdatedAt->caption() ?></span></td>
        <td data-name="UpdatedAt"<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_Tasks_UpdatedAt">
<span<?= $Page->UpdatedAt->viewAttributes() ?>>
<?= $Page->UpdatedAt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
    <tr id="r_ServiceID"<?= $Page->ServiceID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Tasks_ServiceID"><?= $Page->ServiceID->caption() ?></span></td>
        <td data-name="ServiceID"<?= $Page->ServiceID->cellAttributes() ?>>
<span id="el_Tasks_ServiceID">
<span<?= $Page->ServiceID->viewAttributes() ?>>
<?= $Page->ServiceID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
