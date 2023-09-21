var ajaxurl = '/wp-admin/admin-ajax.php';
var number_of_clicks = 1;
var selected = '';

$(document.body).on('touchmove', onScroll);
$(window).on('scroll', onScroll);

function onScroll() {
    if ((window.innerHeight + window.scrollY + 50) >= $(document).height() && $('.product-preview--posts:hidden').length) {
        $('.product-preview--posts:hidden').slice(0, 4).slideDown();
        shave('p.blog-short-description', 90);
    }
}

jQuery(document).ready(function ($) {

    show_product_on_page();

    $('.tech-category-filter').on('click', function (e) {
        selected = $('.tech-category-filter').find(":selected").val();
    });

    $('.tech-category-filter').change(function (e) {
        selected = $('.tech-category-filter').find(":selected").val();
        search_posts(e);
    });

    $('#search-blog-post').bind("enterKey", function (e) {
        search_posts(e);
    });

    $('#search-blog-post').keyup(function (e) {
        if (e.keyCode === 13) {
            $(this).trigger("enterKey");
        }
    });

    $('.search-icon').click(function (e) {
        e.preventDefault();
        search_posts(e);
    });

    $('.clear-icon').click(function (e) {
        e.preventDefault();
        $('#search-blog-post').val('');
        search_posts(e);
    })
});

function check_value() {
    const value = $('#search-blog-post').val();
    $('.clear-icon').toggle(value !== '');
}

function search_posts(e) {
    e.preventDefault();
    // $("a.load-more").show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {"action": "load-search-documentation-posts", search: $('#search-blog-post').val(), cat_filter: selected},
        success: function (response) {
            if (response) {
                // number_of_clicks = 0;
                jQuery('.posts__products').html(response);
                show_product_on_page();
                // jQuery('.posts__button').show();
                // hide_load_more();
                $('.product-preview__title').wrapInTag({
                    tag: 'b',
                    words: [$('#search-blog-post').val()]
                });
                // show_four_first_utems();
                // shave('p.blog-short-description', 90);
                $('.blog-short-description').wrapInTag({
                    tag: 'b',
                    words: [$('#search-blog-post').val()]
                });
                check_value();
            } else {
                jQuery('.posts__products').html('<h3 style="margin: 0 auto">No matches found</h3>');
                jQuery('.posts__button').hide();
            }
            return false;
        }
    });
}
//No more needed
function show_four_first_utems() {
    $('.product-preview').each(function (i) {
        if (i < 4) {
            $(this).css('display', 'block');
        }
    });
}
//No more needed
function hide_load_more() {
    number_of_clicks++;
    var items = $('.posts-count').val();
    var p = Math.round(items / 4);
    if (jQuery(".product-preview").length < 5) {
        jQuery('.posts__button').hide();
    } else if (number_of_clicks === p) {
        // jQuery('.posts__button').hide();
        jQuery('.posts__button').css('pointer-events', 'none');
        jQuery('.posts__button a').css('background-color', '#e6e6e6');
        jQuery('.posts__button a').css('color', '#c6c6c6');
        jQuery('.posts__button a').css('border', '0');
    } else {
        jQuery('.posts__button').css('pointer-events', 'auto');
        jQuery('.posts__button a').css('background-color', 'rgba(184,150,94,0.2)');
        jQuery('.posts__button a').css('color', '#b3874c');
        jQuery('.posts__button a').css('border', '1px solid #b3874c');
    }
    if (jQuery(".product-preview").length === 0) {
        jQuery('.posts__products').html('<h3 style="margin: 20px auto">' +
            'We could not find any existing technical articles matching your search. However, our expert engineers are available and happy to help you with any questions you may have. Contact them by using the button below.' +
            '</h3>' + '<a style="margin: 0" class="application__btn btn" href="http://usb-vna.coppermountaintech.com/acton/media/24246/askanengineer" target="_blank">Ask an Engineer</a>');
    }
}

//Don't know if it works well
//wrap search words in tags
$.fn.wrapInTag = function (opts) {

    var tag = opts.tag || 'strong',
        words = opts.words || [],
        regex = RegExp(words.join('|'), 'gi'),
        replacement = '<' + tag + '>$&</' + tag + '>';
    if (words[0].length > 0) {
        return this.html(function () {
            return $(this).text().replace(regex, replacement);
        });
    }
};

function show_product_on_page() {
  const windowHeight = window.innerHeight - 125;
  const productCart = $('.product-preview--posts')[0];
  if (productCart) {
    const productCartHeight = $(productCart).height();
    const initialRows = Math.round(windowHeight/productCartHeight);
    const initialElementsCount = initialRows * 4;
    $('.product-preview--posts').each((index,el) => {
      if (index < initialElementsCount) {
        $(el).show();
      }
    });
    shave('p.blog-short-description', 90);
  }
}
