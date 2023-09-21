import $ from 'jquery';

$(() => {

    // Scroll to
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - 91
        }, 1000);
    });

    // Akkordeon
    $('.theme-accordeon__title').click(function() {
        $(this).parent().toggleClass('active');
        $(this).parent().siblings('.theme-accordeon__item').removeClass('active');

        $('.theme-accordeon__item').each(function() {
            if ($( this ).hasClass('active')) {
                $(this).children('.theme-accordeon__content').slideDown();
            } else {
                $(this).removeClass('active');
                $(this).children('.theme-accordeon__content').slideUp();
            }
        });
    });

    // Navigation Touch Geräte
    $('ul.navbar-nav > li.parent > a').on('touchstart', function(e) {
        if (!$(this).parent().hasClass('hovered')) {
            e.preventDefault();
            $(this).parent().toggleClass('hovered');
            $(this).parent().siblings().removeClass('hovered');
        }
    });

});