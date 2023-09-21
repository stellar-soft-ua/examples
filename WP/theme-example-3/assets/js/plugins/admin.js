import $ from 'jquery';

$.ready(() => {
    $('#createflydir').click(function () {
        const data = {
            createflydir: 1
        };

        const parent = $(this).parent();

        jQuery.post('/wp/wp-admin/admin-ajax.php', data, function (response) {
            if (response.success) {
                parent.html('<span class="dashicons dashicons-yes"></span> Der Ordner <code>uploads/fly</code> existiert.');
            } else {
//                console.log(response);
            }
        });
    });


    $('#renderbootstrap').click(function () {
        const data = {
            action: 'renderbootstrap_action',
            security: theme.nonceb
        };

        // Since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(ajaxurl, data, function (response) {
        });
    });

    $('#rendermaterializecss').click(function () {
        const data = {
            action: 'rendermaterializecss_action',
            security: theme.nonce
        };

        // Since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(ajaxurl, data, function (response) {
        });
    });
});
