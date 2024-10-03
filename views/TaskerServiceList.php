<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$TaskerServiceList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { TaskerService: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
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
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TaskerService">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_TaskerService" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_TaskerServicelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->TaskerServiceID->Visible) { // TaskerServiceID ?>
        <th data-name="TaskerServiceID" class="<?= $Page->TaskerServiceID->headerCellClass() ?>"><div id="elh_TaskerService_TaskerServiceID" class="TaskerService_TaskerServiceID"><?= $Page->renderFieldHeader($Page->TaskerServiceID) ?></div></th>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
        <th data-name="_UserID" class="<?= $Page->_UserID->headerCellClass() ?>"><div id="elh_TaskerService__UserID" class="TaskerService__UserID"><?= $Page->renderFieldHeader($Page->_UserID) ?></div></th>
<?php } ?>
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
        <th data-name="ServiceID" class="<?= $Page->ServiceID->headerCellClass() ?>"><div id="elh_TaskerService_ServiceID" class="TaskerService_ServiceID"><?= $Page->renderFieldHeader($Page->ServiceID) ?></div></th>
<?php } ?>
<?php if ($Page->AverageRating->Visible) { // AverageRating ?>
        <th data-name="AverageRating" class="<?= $Page->AverageRating->headerCellClass() ?>"><div id="elh_TaskerService_AverageRating" class="TaskerService_AverageRating"><?= $Page->renderFieldHeader($Page->AverageRating) ?></div></th>
<?php } ?>
<?php if ($Page->ReviewCount->Visible) { // ReviewCount ?>
        <th data-name="ReviewCount" class="<?= $Page->ReviewCount->headerCellClass() ?>"><div id="elh_TaskerService_ReviewCount" class="TaskerService_ReviewCount"><?= $Page->renderFieldHeader($Page->ReviewCount) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_TaskerService_Status" class="TaskerService_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
        <th data-name="CreatedAt" class="<?= $Page->CreatedAt->headerCellClass() ?>"><div id="elh_TaskerService_CreatedAt" class="TaskerService_CreatedAt"><?= $Page->renderFieldHeader($Page->CreatedAt) ?></div></th>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
        <th data-name="UpdatedAt" class="<?= $Page->UpdatedAt->headerCellClass() ?>"><div id="elh_TaskerService_UpdatedAt" class="TaskerService_UpdatedAt"><?= $Page->renderFieldHeader($Page->UpdatedAt) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->TaskerServiceID->Visible) { // TaskerServiceID ?>
        <td data-name="TaskerServiceID"<?= $Page->TaskerServiceID->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService_TaskerServiceID" class="el_TaskerService_TaskerServiceID">
<span<?= $Page->TaskerServiceID->viewAttributes() ?>>
<?= $Page->TaskerServiceID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_UserID->Visible) { // UserID ?>
        <td data-name="_UserID"<?= $Page->_UserID->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService__UserID" class="el_TaskerService__UserID">
<span<?= $Page->_UserID->viewAttributes() ?>>
<?= $Page->_UserID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ServiceID->Visible) { // ServiceID ?>
        <td data-name="ServiceID"<?= $Page->ServiceID->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService_ServiceID" class="el_TaskerService_ServiceID">
<span<?= $Page->ServiceID->viewAttributes() ?>>
<?= $Page->ServiceID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AverageRating->Visible) { // AverageRating ?>
        <td data-name="AverageRating"<?= $Page->AverageRating->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService_AverageRating" class="el_TaskerService_AverageRating">
<span<?= $Page->AverageRating->viewAttributes() ?>>
<?= $Page->AverageRating->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ReviewCount->Visible) { // ReviewCount ?>
        <td data-name="ReviewCount"<?= $Page->ReviewCount->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService_ReviewCount" class="el_TaskerService_ReviewCount">
<span<?= $Page->ReviewCount->viewAttributes() ?>>
<?= $Page->ReviewCount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService_Status" class="el_TaskerService_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
        <td data-name="CreatedAt"<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService_CreatedAt" class="el_TaskerService_CreatedAt">
<span<?= $Page->CreatedAt->viewAttributes() ?>>
<?= $Page->CreatedAt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
        <td data-name="UpdatedAt"<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_TaskerService_UpdatedAt" class="el_TaskerService_UpdatedAt">
<span<?= $Page->UpdatedAt->viewAttributes() ?>>
<?= $Page->UpdatedAt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
<?php } ?>
