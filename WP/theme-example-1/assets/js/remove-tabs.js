(function () {
    $ = jQuery;
    $(document).ready(function () {
        var tabs = $('.tab-links li').length;
        if(tabs===1){
            $('.tab-links li').css('width','100%');
            $('.tab-links li>a').css('width','100%');
        }
    });
})();