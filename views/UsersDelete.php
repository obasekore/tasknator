<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$UsersDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Users: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fUsersdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fUsersdelete")
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
<form name="fUsersdelete" id="fUsersdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="Users">
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
<?php if ($Page->ID->Visible) { // ID ?>
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_Users_ID" class="Users_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
        <th class="<?= $Page->FirstName->headerCellClass() ?>"><span id="elh_Users_FirstName" class="Users_FirstName"><?= $Page->FirstName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
        <th class="<?= $Page->LastName->headerCellClass() ?>"><span id="elh_Users_LastName" class="Users_LastName"><?= $Page->LastName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th class="<?= $Page->_Email->headerCellClass() ?>"><span id="elh_Users__Email" class="Users__Email"><?= $Page->_Email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
        <th class="<?= $Page->_Password->headerCellClass() ?>"><span id="elh_Users__Password" class="Users__Password"><?= $Page->_Password->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Token->Visible) { // Token ?>
        <th class="<?= $Page->_Token->headerCellClass() ?>"><span id="elh_Users__Token" class="Users__Token"><?= $Page->_Token->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Profile->Visible) { // Profile ?>
        <th class="<?= $Page->_Profile->headerCellClass() ?>"><span id="elh_Users__Profile" class="Users__Profile"><?= $Page->_Profile->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Avatar->Visible) { // Avatar ?>
        <th class="<?= $Page->Avatar->headerCellClass() ?>"><span id="elh_Users_Avatar" class="Users_Avatar"><?= $Page->Avatar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
        <th class="<?= $Page->CreatedAt->headerCellClass() ?>"><span id="elh_Users_CreatedAt" class="Users_CreatedAt"><?= $Page->CreatedAt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
        <th class="<?= $Page->UpdatedAt->headerCellClass() ?>"><span id="elh_Users_UpdatedAt" class="Users_UpdatedAt"><?= $Page->UpdatedAt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_UserLevel->Visible) { // UserLevel ?>
        <th class="<?= $Page->_UserLevel->headerCellClass() ?>"><span id="elh_Users__UserLevel" class="Users__UserLevel"><?= $Page->_UserLevel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th class="<?= $Page->Status->headerCellClass() ?>"><span id="elh_Users_Status" class="Users_Status"><?= $Page->Status->caption() ?></span></th>
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
<?php if ($Page->ID->Visible) { // ID ?>
        <td<?= $Page->ID->cellAttributes() ?>>
<span id="">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FirstName->Visible) { // FirstName ?>
        <td<?= $Page->FirstName->cellAttributes() ?>>
<span id="">
<span<?= $Page->FirstName->viewAttributes() ?>>
<?= $Page->FirstName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->LastName->Visible) { // LastName ?>
        <td<?= $Page->LastName->cellAttributes() ?>>
<span id="">
<span<?= $Page->LastName->viewAttributes() ?>>
<?= $Page->LastName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <td<?= $Page->_Email->cellAttributes() ?>>
<span id="">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
        <td<?= $Page->_Password->cellAttributes() ?>>
<span id="">
<span<?= $Page->_Password->viewAttributes() ?>>
<?= $Page->_Password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Token->Visible) { // Token ?>
        <td<?= $Page->_Token->cellAttributes() ?>>
<span id="">
<span<?= $Page->_Token->viewAttributes() ?>>
<?= $Page->_Token->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Profile->Visible) { // Profile ?>
        <td<?= $Page->_Profile->cellAttributes() ?>>
<span id="">
<span<?= $Page->_Profile->viewAttributes() ?>>
<?= $Page->_Profile->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Avatar->Visible) { // Avatar ?>
        <td<?= $Page->Avatar->cellAttributes() ?>>
<span id="">
<span<?= $Page->Avatar->viewAttributes() ?>>
<?= $Page->Avatar->getViewValue() ?></span>
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
<?php if ($Page->_UserLevel->Visible) { // UserLevel ?>
        <td<?= $Page->_UserLevel->cellAttributes() ?>>
<span id="">
<span<?= $Page->_UserLevel->viewAttributes() ?>>
<?= $Page->_UserLevel->getViewValue() ?></span>
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
