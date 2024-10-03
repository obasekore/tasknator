<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$ServicesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Services: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fServicesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fServicesdelete")
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
<form name="fServicesdelete" id="fServicesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="Services">
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
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
        <th class="<?= $Page->ServiceID->headerCellClass() ?>"><span id="elh_Services_ServiceID" class="Services_ServiceID"><?= $Page->ServiceID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ServiceName->Visible) { // ServiceName ?>
        <th class="<?= $Page->ServiceName->headerCellClass() ?>"><span id="elh_Services_ServiceName" class="Services_ServiceName"><?= $Page->ServiceName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ParentService->Visible) { // ParentService ?>
        <th class="<?= $Page->ParentService->headerCellClass() ?>"><span id="elh_Services_ParentService" class="Services_ParentService"><?= $Page->ParentService->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th class="<?= $Page->Status->headerCellClass() ?>"><span id="elh_Services_Status" class="Services_Status"><?= $Page->Status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
        <th class="<?= $Page->CreatedAt->headerCellClass() ?>"><span id="elh_Services_CreatedAt" class="Services_CreatedAt"><?= $Page->CreatedAt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
        <th class="<?= $Page->UpdatedAt->headerCellClass() ?>"><span id="elh_Services_UpdatedAt" class="Services_UpdatedAt"><?= $Page->UpdatedAt->caption() ?></span></th>
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
<?php if ($Page->ServiceID->Visible) { // ServiceID ?>
        <td<?= $Page->ServiceID->cellAttributes() ?>>
<span id="">
<span<?= $Page->ServiceID->viewAttributes() ?>>
<?= $Page->ServiceID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ServiceName->Visible) { // ServiceName ?>
        <td<?= $Page->ServiceName->cellAttributes() ?>>
<span id="">
<span<?= $Page->ServiceName->viewAttributes() ?>>
<?= $Page->ServiceName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ParentService->Visible) { // ParentService ?>
        <td<?= $Page->ParentService->cellAttributes() ?>>
<span id="">
<span<?= $Page->ParentService->viewAttributes() ?>>
<?= $Page->ParentService->getViewValue() ?></span>
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
