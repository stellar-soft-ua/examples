import $ from 'jquery';

$(() => {
    const $navbar = $('.navbar');

    $navbar.on('show.bs.collapse', function () {
        $('body').addClass('menu-open');
    });

    $navbar.on('hide.bs.collapse', function () {
        $('body').removeClass('menu-open');
    });
});
