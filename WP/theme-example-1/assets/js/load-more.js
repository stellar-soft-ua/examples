var ias = jQuery.ias({
    container: ".products__list.load-more",
    item: ".product-preview.load-more",
    pagination: ".navigation",
    next: ".pagination__next"
});

ias.extension(new IASTriggerExtension({offset: 999999}));
// ias.extension(new IASSpinnerExtension({src:false}));
ias.extension(new IASNoneLeftExtension());
