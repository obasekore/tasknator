<?php

namespace PHPMaker2024\taskinator_project_file;

// Page object
$ReviewsAndRatingsEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fReviewsAndRatingsedit" id="fReviewsAndRatingsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { ReviewsAndRatings: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fReviewsAndRatingsedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fReviewsAndRatingsedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["ReviewRatingID", [fields.ReviewRatingID.visible && fields.ReviewRatingID.required ? ew.Validators.required(fields.ReviewRatingID.caption) : null], fields.ReviewRatingID.isInvalid],
            ["TaskID", [fields.TaskID.visible && fields.TaskID.required ? ew.Validators.required(fields.TaskID.caption) : null, ew.Validators.integer], fields.TaskID.isInvalid],
            ["Review", [fields.Review.visible && fields.Review.required ? ew.Validators.required(fields.Review.caption) : null], fields.Review.isInvalid],
            ["Rating", [fields.Rating.visible && fields.Rating.required ? ew.Validators.required(fields.Rating.caption) : null, ew.Validators.integer], fields.Rating.isInvalid],
            ["_UserID", [fields._UserID.visible && fields._UserID.required ? ew.Validators.required(fields._UserID.caption) : null, ew.Validators.integer], fields._UserID.isInvalid],
            ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null, ew.Validators.integer], fields.Status.isInvalid],
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
<input type="hidden" name="t" value="ReviewsAndRatings">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ReviewRatingID->Visible) { // ReviewRatingID ?>
    <div id="r_ReviewRatingID"<?= $Page->ReviewRatingID->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings_ReviewRatingID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ReviewRatingID->caption() ?><?= $Page->ReviewRatingID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ReviewRatingID->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_ReviewRatingID">
<span<?= $Page->ReviewRatingID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ReviewRatingID->getDisplayValue($Page->ReviewRatingID->EditValue))) ?>"></span>
<input type="hidden" data-table="ReviewsAndRatings" data-field="x_ReviewRatingID" data-hidden="1" name="x_ReviewRatingID" id="x_ReviewRatingID" value="<?= HtmlEncode($Page->ReviewRatingID->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TaskID->Visible) { // TaskID ?>
    <div id="r_TaskID"<?= $Page->TaskID->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings_TaskID" for="x_TaskID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TaskID->caption() ?><?= $Page->TaskID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->TaskID->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_TaskID">
<input type="<?= $Page->TaskID->getInputTextType() ?>" name="x_TaskID" id="x_TaskID" data-table="ReviewsAndRatings" data-field="x_TaskID" value="<?= $Page->TaskID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->TaskID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->TaskID->formatPattern()) ?>"<?= $Page->TaskID->editAttributes() ?> aria-describedby="x_TaskID_help">
<?= $Page->TaskID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TaskID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Review->Visible) { // Review ?>
    <div id="r_Review"<?= $Page->Review->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings_Review" for="x_Review" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Review->caption() ?><?= $Page->Review->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Review->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_Review">
<input type="<?= $Page->Review->getInputTextType() ?>" name="x_Review" id="x_Review" data-table="ReviewsAndRatings" data-field="x_Review" value="<?= $Page->Review->EditValue ?>" size="30" maxlength="1000" placeholder="<?= HtmlEncode($Page->Review->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Review->formatPattern()) ?>"<?= $Page->Review->editAttributes() ?> aria-describedby="x_Review_help">
<?= $Page->Review->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Review->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Rating->Visible) { // Rating ?>
    <div id="r_Rating"<?= $Page->Rating->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings_Rating" for="x_Rating" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rating->caption() ?><?= $Page->Rating->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rating->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_Rating">
<input type="<?= $Page->Rating->getInputTextType() ?>" name="x_Rating" id="x_Rating" data-table="ReviewsAndRatings" data-field="x_Rating" value="<?= $Page->Rating->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Rating->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rating->formatPattern()) ?>"<?= $Page->Rating->editAttributes() ?> aria-describedby="x_Rating_help">
<?= $Page->Rating->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rating->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_UserID->Visible) { // UserID ?>
    <div id="r__UserID"<?= $Page->_UserID->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings__UserID" for="x__UserID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_UserID->caption() ?><?= $Page->_UserID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_UserID->cellAttributes() ?>>
<span id="el_ReviewsAndRatings__UserID">
<input type="<?= $Page->_UserID->getInputTextType() ?>" name="x__UserID" id="x__UserID" data-table="ReviewsAndRatings" data-field="x__UserID" value="<?= $Page->_UserID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_UserID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_UserID->formatPattern()) ?>"<?= $Page->_UserID->editAttributes() ?> aria-describedby="x__UserID_help">
<?= $Page->_UserID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_UserID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <div id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings_Status" for="x_Status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status->caption() ?><?= $Page->Status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_Status">
<input type="<?= $Page->Status->getInputTextType() ?>" name="x_Status" id="x_Status" data-table="ReviewsAndRatings" data-field="x_Status" value="<?= $Page->Status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Status->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status->formatPattern()) ?>"<?= $Page->Status->editAttributes() ?> aria-describedby="x_Status_help">
<?= $Page->Status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CreatedAt->Visible) { // CreatedAt ?>
    <div id="r_CreatedAt"<?= $Page->CreatedAt->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings_CreatedAt" for="x_CreatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CreatedAt->caption() ?><?= $Page->CreatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->CreatedAt->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_CreatedAt">
<input type="<?= $Page->CreatedAt->getInputTextType() ?>" name="x_CreatedAt" id="x_CreatedAt" data-table="ReviewsAndRatings" data-field="x_CreatedAt" value="<?= $Page->CreatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->CreatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->CreatedAt->formatPattern()) ?>"<?= $Page->CreatedAt->editAttributes() ?> aria-describedby="x_CreatedAt_help">
<?= $Page->CreatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CreatedAt->getErrorMessage() ?></div>
<?php if (!$Page->CreatedAt->ReadOnly && !$Page->CreatedAt->Disabled && !isset($Page->CreatedAt->EditAttrs["readonly"]) && !isset($Page->CreatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fReviewsAndRatingsedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fReviewsAndRatingsedit", "x_CreatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UpdatedAt->Visible) { // UpdatedAt ?>
    <div id="r_UpdatedAt"<?= $Page->UpdatedAt->rowAttributes() ?>>
        <label id="elh_ReviewsAndRatings_UpdatedAt" for="x_UpdatedAt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UpdatedAt->caption() ?><?= $Page->UpdatedAt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UpdatedAt->cellAttributes() ?>>
<span id="el_ReviewsAndRatings_UpdatedAt">
<input type="<?= $Page->UpdatedAt->getInputTextType() ?>" name="x_UpdatedAt" id="x_UpdatedAt" data-table="ReviewsAndRatings" data-field="x_UpdatedAt" value="<?= $Page->UpdatedAt->EditValue ?>" placeholder="<?= HtmlEncode($Page->UpdatedAt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UpdatedAt->formatPattern()) ?>"<?= $Page->UpdatedAt->editAttributes() ?> aria-describedby="x_UpdatedAt_help">
<?= $Page->UpdatedAt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UpdatedAt->getErrorMessage() ?></div>
<?php if (!$Page->UpdatedAt->ReadOnly && !$Page->UpdatedAt->Disabled && !isset($Page->UpdatedAt->EditAttrs["readonly"]) && !isset($Page->UpdatedAt->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fReviewsAndRatingsedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fReviewsAndRatingsedit", "x_UpdatedAt", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fReviewsAndRatingsedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fReviewsAndRatingsedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("ReviewsAndRatings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
