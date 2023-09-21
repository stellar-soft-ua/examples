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

(function ($) {
    $(document).ready(function () {
        appendMobileSearch();
        radioButtons();
        loadMore();
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
            data: {"action": "load-filter2", term: data},
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
                    // hidePrice();
                    jQuery("#loading-animation").hide();
                    return false;
                }
            });
        });

        $('.filter-accept-btn').click(function () {
            $('.filters__title').click();
        });


        $('.sp-menu').click(function (e) {
            e.preventDefault();
            window.location = $('a', this).attr('href');
            return false;
        });

        var mobileMenu = $('#mobile-menu').slideMenu({
            backLinkBefore: '',
            position: 'left',
            showBackLink: true,
            submenuLinkBefore: '',
            submenuLinkAfter: '',
            backLinkAfter: ''
        });

        $('a.slide-menu-control').each(function () {
            $(this).text('Back')
        });

        $("ul.mobile-menu li").removeClassExcept('item-bordered'); //delete all classes

        showMenu($(window).innerWidth());

        $('div.menu.btn.slide-menu-control').click(function () {
            $(this).toggleClass('close-btn');
            if ($('.shadow-block').css('display') === 'none') {
                $('#mobile-menu').removeClass('force-menu-show');
            }
        });

        let isCopied = false;

        $('ul.sub-menu li').click(function (e) {
            let mainItemLink = $(this).find('a')[0];
            const linkHref = $(mainItemLink).attr('href');
            const isHadSubMenu = $(this).find('ul')[0];
            console.log(isHadSubMenu);
            if(mainItemLink && !isCopied && linkHref && isHadSubMenu){
                let clonedElement = $(mainItemLink).clone();
                $(clonedElement).addClass('copied-item');
                $("ul.sub-menu.active li:first-child").after(clonedElement);
                isCopied = true;
            }
            $('ul.sub-menu.active .slide-menu-control').click(function(){
                $('.copied-item').remove();
                setTimeout(function () {
                    isCopied = false;
                })
            });
        });

        let languages = $('.languages-selector').html();

        if (languages !== undefined) {
            $("#mobile-menu").prepend("<ul class='languages-selector-mobile'>" + languages + "</ul>");
        }

        $(window).on('resize', function (e) {
            showMenu(e.target.innerWidth);
            if ($('div.menu.btn.slide-menu-control').hasClass('close-btn')) {
                $('div.menu.btn.slide-menu-control').click();
            }
            if ($('.shadow-block').css('display') === 'none') {
                $('#mobile-menu').removeClass('force-menu-show');
            }
            $('div.menu.btn.slide-menu-control').removeClass('close-btn');
        });

        function showMenu(innerWidth) {
            if (innerWidth < 1090) {
                $('body > main > header > div > div.menu.btn.slide-menu-control').show();
            } else {
                $('body > main > header > div > div.menu.btn.slide-menu-control').hide();
            }
        }

        moreLess(170,'.testimonials__text');
        moreLess(165,'.text-readmore');
        moreLess(216,'.review__text');
        $('.partner-item').each(function () {
            var text_block = $(this).find('.partner-text');
            var modal_element = $(this).find('.partner-bottom-text');
            text_block.click(function (e) {
                modal_element.click();
            })
        });

        scrollApplications('.anchor-vnas','features-item ');
        equalHeightBlocks('.inserted-product-preview__text');
        setCookie("rand_article", $("#rand_post").text(), 3600);

        //call old version Latest News scroll in top header
        //const marqueeNews = marqueeNewsF($, ".marquee div");
        //New version Latest News scroll in top header
        const bxSliderNews = bxSliderNewsF($, "#marquee-container-1");
    });
})(jQuery);

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$.fn.removeClassExcept = function (val) {
    return this.each(function (index, el) {
        var keep = val.split(" "),
            reAdd = [],
            $el = $(el);

        for (var i = 0; i < keep.length; i++) {
            if ($el.hasClass(keep[i])) reAdd.push(keep[i]);
        }
        $el
            .removeClass()
            .addClass(reAdd.join(' '));
    });
};

$.fn.equivalent = function() {
    var $blocks = $(this),
        maxH = $blocks.eq(0).height();

    $blocks.each(function() {
        maxH = ($(this).height() > maxH) ? $(this).height() : maxH;
    });

    $blocks.css('min-height', maxH);
};

function appendMobileSearch(){
    const site_url = document.location.origin;
    const search_element = '<form role="search" method="get" id="searchform" action="' + site_url + '" class="search-page-form search-page-mobile">' +
        '    <input type="text" value="" name="s" id="website-search" class="website-search-page-mobile" placeholder="Search">' +
        '    <input type="hidden" name="post_type" value="vna">' +
        '<span class="search-icon-mobile"></span></form>';
    $(document).ready(function () {
        if (window.innerWidth < 1090) {
            $('.mobile-menu').append(search_element);
            bindEvent($);
        }
        $(window).on('resize', function (e) {
            var appended_element = $('.search-page-mobile').length;
            if (e.target.innerWidth < 1090 && appended_element === 0) {
                $('.mobile-menu').append(search_element);
                bindEvent($);
            }
            if (e.target.innerWidth > 1090 && appended_element === 1) {
                $('.search-page-mobile').remove();
            }
        });
    });
    $(document).mouseup(function (e) {
        const container = $('.search-icon-mobile');
        if (container.is(e.target) && container.has(e.target).length === 0) {
            $('.search-page-mobile').submit();
        }
    });

    $(document).bind('touchend', function (e) {
        const container = $('.search-icon-mobile');
        if (container.is(e.target) && container.has(e.target).length === 0) {
            $('.search-page-mobile').submit();
        }
    });
}

function radioButtons() {
    $.each($('#requestRadioBtns .wpcf7-list-item'), function (index, el) {

        var input = $(el).find('input[type=radio]');
        input.parent().css('display', 'flex');
        input.css('display', 'none');
        input.next().remove();
        var inputValue = input.val();
        input.attr('id', inputValue);
        input.after(generateRadioBtnLayout(inputValue));
    });
}

function loadMore(){
    var ias = $.ias({
        container: ".products__list.load-more",
        item: ".product-preview.load-more",
        pagination: ".navigation",
        next: ".pagination__next"
    });

    ias.extension(new IASTriggerExtension({ offset: 999999 }));
// ias.extension(new IASSpinnerExtension({src:false}));
    ias.extension(new IASNoneLeftExtension());
}

function bindEvent($) {
    var searchField = $('.website-search-page-mobile');
    $(searchField).on('focus', function (e) {
        $('#mobile-menu').toggleClass('force-menu-show');
        $(searchField).css('margin-bottom', '70px');
        $('.mobile-menu').animate({
            scrollTop: $(searchField).offset().top
        }, 2000);
    });
    $(searchField).on('focusout', function (e) {
        $(searchField).css('margin-bottom', '0');
    });
}

function generateRadioBtnLayout(value) {
    var label = '<label for="' + value + '"></label>';
    var span = '<span class="title-checkbox">' + value + '</span>';
    return label + span;
}

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
//     visitor_country = visitor_country.toString().replace(/\+/g, ' ');
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

function moreLess(initiallyVisibleCharacters, readmoreContainer) {
    const visibleCharacters = initiallyVisibleCharacters;
    const paragraph = $(readmoreContainer);

    paragraph.each(function() {
        const text = $(this).text();
        const button = $(this).next();
        const more = button.find('.more');
        const less = button.find('.less');
        const el = $(this);
        if (el[0].scrollHeight > visibleCharacters) {
            more.show();
        } else {
            more.hide();
        }
        more.click(function(e) {
            e.preventDefault();
            el.attr('id','full-text');
            more.css('display','none');
        });
        less.click(function(e) {
            hideShowMore(more,el,visibleCharacters);
        });
    });

    $('.less').click(function(e) {
        e.preventDefault();
        $(readmoreContainer).attr('id','');
    });
    $(document).mouseup(function(e) {
        const container = $(readmoreContainer);
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $('.less').click();
        }
    });

    $(document).bind( 'touchend', function(e) {
        const container = $(readmoreContainer);
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $('.less').click();
        }
    });
}

function hideShowMore(more,el,visibleCharacters) {
    more.toggle(el[0].scrollHeight > visibleCharacters);
}

function scrollApplications(container, containerTo){
    $(container).click(function(event) {
        event.preventDefault();
        const anchor = $(this).data('anchor');
        var el = document.getElementById(containerTo+anchor);
        $('html, body').animate({
            scrollTop: $(el).offset().top - 100
        }, 1500);
    });
}

function equalHeightBlocks(selector){
    var highestBox = 0;
    $(selector).each(function(){
        if($(this).height() > highestBox) {
            highestBox = $(this).height();
        }
    });
    $(selector).height(highestBox);
}

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

function redirect(element) {
    window.location = $(element).data('new-location');
}

$(document).on('click','.categories__item label', function () {
    $('.filters__title').click();
});

function marqueeNewsF($, element) {
  const marquee = $(element).marquee({
    speed: 50,
    pauseOnHover: true,
    direction: 'up',
    duplicated: true,
    startVisible: true,
    gap: 0,
  });
  return marquee;
}

function bxSliderNewsF($, element) {
  return $("div").is(element)
    ? $(element).bxSlider({
      mode: "vertical",
      speed: 5500,
      auto: true,
      controls: false,
      pager: false,
      autoDirection: "next",
      autoHover: true,
      autoDelay: 10000,
      pause: 10000,
      touchEnabled: false,
    })
    : false;
}
