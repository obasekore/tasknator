<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$TaskerServiceView = &$Page;
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
<form name="fTaskerServiceview" id="fTaskerServiceview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { TaskerService: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fTaskerServiceview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fTaskerServiceview")
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
<input type="hidden" name="t" value="TaskerService">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->TaskerServiceID->Visible) { // TaskerServiceID ?>
    <tr id="r_TaskerServiceID"<?= $Page->TaskerServiceID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService_TaskerServiceID"><?= $Page->TaskerServiceID->caption() ?></span></td>
        <td data-name="TaskerServiceID"<?= $Page->TaskerServiceID->cellAttributes() ?>>
<span id="el_TaskerService_TaskerServiceID">
<span<?= $Page->TaskerServiceID->viewAttributes() ?>>
<?= $Page->TaskerServiceID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
    <tr id="r__UserID"<?= $Page->_UserID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService__UserID"><?= $Page->_UserID->caption() ?></span></td>
        <td data-name="_UserID"<?= $Page->_UserID->cellAttributes() ?>>
<span id="el_TaskerService__UserID">
<span<?= $Page->_UserID->viewAttributes() ?>>
<?= $Page->_UserID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
    <tr id="r_ServiceID"<?= $Page->ServiceID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService_ServiceID"><?= $Page->ServiceID->caption() ?></span></td>
        <td data-name="ServiceID"<?= $Page->ServiceID->cellAttributes() ?>>
<span id="el_TaskerService_ServiceID">
<span<?= $Page->ServiceID->viewAttributes() ?>>
<?= $Page->ServiceID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AverageRating->Visible) { // AverageRating ?>
    <tr id="r_AverageRating"<?= $Page->AverageRating->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService_AverageRating"><?= $Page->AverageRating->caption() ?></span></td>
        <td data-name="AverageRating"<?= $Page->AverageRating->cellAttributes() ?>>
<span id="el_TaskerService_AverageRating">
<span<?= $Page->AverageRating->viewAttributes() ?>>
<?= $Page->AverageRating->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ReviewCount->Visible) { // ReviewCount ?>
    <tr id="r_ReviewCount"<?= $Page->ReviewCount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService_ReviewCount"><?= $Page->ReviewCount->caption() ?></span></td>
        <td data-name="ReviewCount"<?= $Page->ReviewCount->cellAttributes() ?>>
<span id="el_TaskerService_ReviewCount">
<span<?= $Page->ReviewCount->viewAttributes() ?>>
<?= $Page->ReviewCount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <tr id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService_Status"><?= $Page->Status->caption() ?></span></td>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el_TaskerService_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <tr id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService_CreatedAt"><?= $Page->CreatedAt->caption() ?></span></td>
        <td data-name="CreatedAt"<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_TaskerService_CreatedAt">
<span<?= $Page->CreatedAt->viewAttributes() ?>>
<?= $Page->CreatedAt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <tr id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_TaskerService_UpdatedAt"><?= $Page->UpdatedAt->caption() ?></span></td>
        <td data-name="UpdatedAt"<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_TaskerService_UpdatedAt">
<span<?= $Page->UpdatedAt->viewAttributes() ?>>
<?= $Page->UpdatedAt->getViewValue() ?></span>
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
