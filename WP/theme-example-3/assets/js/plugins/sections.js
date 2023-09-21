import $ from 'jquery';

$(() => {
    const collapses = document.querySelectorAll('.section');

    for (let el of collapses) {
        $(el).on('show.bs.collapse', function () {
            $(this).closest('.section').addClass('show');
        });

        $(el).on('hide.bs.collapse', function () {
            $(this).closest('.section').removeClass('show');
        });
    }
});
