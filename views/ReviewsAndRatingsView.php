<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$ReviewsAndRatingsView = &$Page;
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
<form name="fReviewsAndRatingsview" id="fReviewsAndRatingsview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { ReviewsAndRatings: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fReviewsAndRatingsview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fReviewsAndRatingsview")
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
<input type="hidden" name="t" value="ReviewsAndRatings">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->ReviewRatingID->Visible) { // ReviewRatingID ?>
    <tr id="r_ReviewRatingID"<?= $Page->ReviewRatingID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings_ReviewRatingID"><?= $Page->ReviewRatingID->caption() ?></span></td>
        <td data-name="ReviewRatingID"<?= $Page->ReviewRatingID->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_ReviewRatingID">
<span<?= $Page->ReviewRatingID->viewAttributes() ?>>
<?= $Page->ReviewRatingID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TaskID->Visible) { // TaskID ?>
    <tr id="r_TaskID"<?= $Page->TaskID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings_TaskID"><?= $Page->TaskID->caption() ?></span></td>
        <td data-name="TaskID"<?= $Page->TaskID->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_TaskID">
<span<?= $Page->TaskID->viewAttributes() ?>>
<?= $Page->TaskID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Review->Visible) { // Review ?>
    <tr id="r_Review"<?= $Page->Review->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings_Review"><?= $Page->Review->caption() ?></span></td>
        <td data-name="Review"<?= $Page->Review->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_Review">
<span<?= $Page->Review->viewAttributes() ?>>
<?= $Page->Review->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Rating->Visible) { // Rating ?>
    <tr id="r_Rating"<?= $Page->Rating->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings_Rating"><?= $Page->Rating->caption() ?></span></td>
        <td data-name="Rating"<?= $Page->Rating->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_Rating">
<span<?= $Page->Rating->viewAttributes() ?>>
<?= $Page->Rating->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
    <tr id="r__UserID"<?= $Page->_UserID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings__UserID"><?= $Page->_UserID->caption() ?></span></td>
        <td data-name="_UserID"<?= $Page->_UserID->cellAttributes() ?>>
<span id="el_ReviewsAndRatings__UserID">
<span<?= $Page->_UserID->viewAttributes() ?>>
<?= $Page->_UserID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <tr id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings_Status"><?= $Page->Status->caption() ?></span></td>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <tr id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings_CreatedAt"><?= $Page->CreatedAt->caption() ?></span></td>
        <td data-name="CreatedAt"<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_CreatedAt">
<span<?= $Page->CreatedAt->viewAttributes() ?>>
<?= $Page->CreatedAt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <tr id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ReviewsAndRatings_UpdatedAt"><?= $Page->UpdatedAt->caption() ?></span></td>
        <td data-name="UpdatedAt"<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_UpdatedAt">
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
