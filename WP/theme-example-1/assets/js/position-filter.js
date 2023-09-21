var ajaxurl = '/wp-admin/admin-ajax.php';

jQuery(document).ready(function ($) {
    $(document).on('click.nice_select', '.nice-select .option:not(.disabled)', function (event) {
        var el = $('.nice-select.select.select--positions span.current');
        var selected = el.text()
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-position-filter", term: selected},
            success: function (response) {
                jQuery(".positions__info").html(response);
                jQuery("#loading-animation").hide();
                return false;
            }
        });
    });


    var el = $('.nice-select.select.select--positions span.current');
    var selected = el.text();
    $("select.select.select--positions option").change(function (e) {
        console.log('s');
    });
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {"action": "load-position-filter", term: selected},
        success: function (response) {
            jQuery(".positions__info").html(response);
            jQuery("#loading-animation").hide();
            return false;
        }
    });

});

function hover(element) {
    var img = $(element).find('.product-card-image')[0];
    var newImg = img.getAttribute('data-second-image');
    if(newImg===''){
        newImg = img.getAttribute('data-main-image');
    }
    img.setAttribute('src', newImg);
}

function unhover(element) {
    var img = $(element).find('.product-card-image')[0];
    var oldImg = img.getAttribute('data-main-image');
    img.setAttribute('src', oldImg);
}
