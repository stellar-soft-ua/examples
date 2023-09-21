(function() {
    $ = jQuery;
    $(document).ready(function() {
        removePrice($);
        var tabs = $('.tab-links li').length;
        if (tabs === 1) {
            $('.tab-links li').css('width', '100%');
            $('.tab-links li>a').css('width', '100%');
        }
        $('.continue-btn').click(function() {
            $('.close-modal')[0].click();
        });
    });

    $.ajaxSetup({
        complete: function () {
            removePrice($);
        }
    });

    function removePrice($) {
        var visitor_country = getCookie('country_name');
        visitor_country = visitor_country.toString().replace(/\+/g, ' ');
        if (blocked_countries.indexOf(visitor_country) === -1) {
            $('.product__price-block').remove();
            $('.product-preview__price').remove();
            $('.buy-button').remove();
            $('.blocked-1').remove();
        }
    }
    function getCookie(name) {
        var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
        return matches ? decodeURIComponent(matches[1]) : false;
    }
})();
