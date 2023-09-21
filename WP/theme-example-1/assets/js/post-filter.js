data = {};
taxes = [];
ports = [];
post_types = [];
cal_kits_type = [];
cal_kits_length = [];
cal_kits_compatible_prod = [];

var impedance = '';
var ajaxurl = '/wp-admin/admin-ajax.php';
// var visitor_country = getCookie('country_name');

jQuery.fn.equivalent = function() {
    var $blocks = $(this),
        maxH = $blocks.eq(0).height();

    $blocks.each(function() {
        maxH = ($(this).height() > maxH) ? $(this).height() : maxH;
    });

    $blocks.css('min-height', maxH);
};

jQuery(document).ready(function ($) {
    // hidePrice();
    var post_type = $('#post_type').data('type');
    var product_category_name = $('#product_category_name').val();
    var product_ports_name = $('#product_ports_name').val();
    impedance = $('#impedance').val();
    data.post_type = post_type;
    data.product_category_name = product_category_name;
    data.product_ports_name = product_ports_name;
    data.impedance = impedance;
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {"action": "load-upperfilter", term: data},
        success: function (response) {
            jQuery(".products__list.load-more").html(response);
            bindEvents();
            // hidePrice();
            jQuery("#loading-animation").hide();
            return false;
        }
    });

    $('.tax-filter').click(function (event) {
        var selecetd_taxonomy = $(this).attr('name');
        selecetd_taxonomy = make_slug(selecetd_taxonomy);

        if ($(this).prop("checked")) {
            taxes.push(selecetd_taxonomy);
            data.category = taxes;
        } else {
            for (var i = taxes.length - 1; i >= 0; i--) {
                if (taxes[i] === selecetd_taxonomy) {
                    taxes.splice(i, 1);
                }
            }
        }
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-filter2", term: data},
            success: function (response) {
                jQuery(".products__list.load-more").html(response);
                bindEvents();
                // hidePrice();
                jQuery("#loading-animation").hide();
                return false;
            }
        });

    });

    $('.type-filter').click(function (event) {
        var selected_type = $(this).attr('name');
        if ($(this).prop("checked")) {
            post_types.push(selected_type);
            data.post_type = post_types;
        } else {
            for (var i = post_types.length - 1; i >= 0; i--) {
                if (post_types[i] === selected_type) {
                    post_types.splice(i, 1);
                }
            }
        }
        if(post_types.length===0){
            data.post_type = $('#post_type').data('type');
        }
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-filter2", term: data},
            success: function (response) {
                jQuery(".products__list.load-more").html(response);
                bindEvents();
//                hidePrice();
                jQuery("#loading-animation").hide();
                return false;
            }
        });
    });

    $('.filter-accept-btn').click(function () {
        $('.filters__title').click();
    });

});

window.onbeforeunload = function () {
    $(".type-filter").prop("checked", false);
    $(".tax-filter").prop("checked", false);
};

function make_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/[^a-z0-9]+/g, '-');
    str = str.replace(/^-|-$/g, '');
    return str;
}

function bindEvents() {
    $('.products__list .product-preview__wrap').equivalent();
    $('.product-preview.product-preview--single').mouseenter(function() {
        var heightForWrapText = $(this).find('.product-preview__wrap').outerHeight(true);
        $(this).css('margin','0 1% ' + (heightForWrapText + 40) + 'px');
    });
    $('.product-preview.product-preview--single').mouseleave(function() {
        $(this).css('margin','0 1% 15px');
    });
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : false;
}

// function hidePrice(){
//     if(blocked_countries.indexOf(visitor_country)>0){
//         $('.product__price-block').remove();
//         $('.product-preview__price').remove();
//     }
// }

$.fn.equivalent = function() {
    var $blocks = $(this),
        maxH = $blocks.eq(0).height();
    $blocks.each(function() {
        maxH = ($(this).height() > maxH) ? $(this).height() : maxH;
    });
    $blocks.css('min-height', maxH);
};
