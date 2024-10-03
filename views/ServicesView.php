<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$ServicesView = &$Page;
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
<form name="fServicesview" id="fServicesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Services: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fServicesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fServicesview")
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
<input type="hidden" name="t" value="Services">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
    <tr id="r_ServiceID"<?= $Page->ServiceID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Services_ServiceID"><?= $Page->ServiceID->caption() ?></span></td>
        <td data-name="ServiceID"<?= $Page->ServiceID->cellAttributes() ?>>
<span id="el_Services_ServiceID">
<span<?= $Page->ServiceID->viewAttributes() ?>>
<?= $Page->ServiceID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ServiceName->Visible) { // ServiceName ?>
    <tr id="r_ServiceName"<?= $Page->ServiceName->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Services_ServiceName"><?= $Page->ServiceName->caption() ?></span></td>
        <td data-name="ServiceName"<?= $Page->ServiceName->cellAttributes() ?>>
<span id="el_Services_ServiceName">
<span<?= $Page->ServiceName->viewAttributes() ?>>
<?= $Page->ServiceName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ParentService->Visible) { // ParentService ?>
    <tr id="r_ParentService"<?= $Page->ParentService->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Services_ParentService"><?= $Page->ParentService->caption() ?></span></td>
        <td data-name="ParentService"<?= $Page->ParentService->cellAttributes() ?>>
<span id="el_Services_ParentService">
<span<?= $Page->ParentService->viewAttributes() ?>>
<?= $Page->ParentService->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <tr id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Services_Status"><?= $Page->Status->caption() ?></span></td>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el_Services_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Options->Visible) { // Options ?>
    <tr id="r_Options"<?= $Page->Options->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Services_Options"><?= $Page->Options->caption() ?></span></td>
        <td data-name="Options"<?= $Page->Options->cellAttributes() ?>>
<span id="el_Services_Options">
<span<?= $Page->Options->viewAttributes() ?>>
<?= $Page->Options->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <tr id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Services_CreatedAt"><?= $Page->CreatedAt->caption() ?></span></td>
        <td data-name="CreatedAt"<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_Services_CreatedAt">
<span<?= $Page->CreatedAt->viewAttributes() ?>>
<?= $Page->CreatedAt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <tr id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_Services_UpdatedAt"><?= $Page->UpdatedAt->caption() ?></span></td>
        <td data-name="UpdatedAt"<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_Services_UpdatedAt">
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
