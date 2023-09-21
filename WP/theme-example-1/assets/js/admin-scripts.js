var ajaxurl = '/wp-admin/admin-ajax.php';
jQuery(document).ready(function ($) {
    $('#multiselect').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
        },
        fireSearch: function(value) {
            return value.length > 2;
        }
    });
    $('#chinese_select').multiselect();
    $('#portuguese_select').multiselect();
    $('#spanish_select').multiselect();
    $('#japanese_select').multiselect();
    save_countries($);
    save_chinese($);
    save_portuguese($);
    save_spanish($);
    save_japanese($)
    $('#meta-image-button').click(function() {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            $('#_review_software_image').val(attachment.url);
            $('#meta-image-preview').attr('src',attachment.url);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open();
        return false;
    });
    $('#review-meta-image-button').click(function() {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            $('#_review_image').val(attachment.url);
            $('#review-meta-image-preview').attr('src',attachment.url);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open();
        return false;
    });
    $('#video-meta-image-button').click(function() {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            $('#_video_image').val(attachment.url);
            $('#video-meta-image-preview').attr('src',attachment.url);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open();
        return false;
    });
});

function save_countries($){
    $('.black-list').on('click', function (event) {

        var button = $(this);
        button.prop("disabled", true);

        var new_list = [];
        $('.blocked option').each(function() {
            new_list.push($(this).val());
        });

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-select-country", country: new_list},
            success: function (response) {
                button.removeAttr( "disabled" );

                return false;
            }
        });
    });
}

function save_chinese($){
    $('.chinese-btn').on('click', function (event) {
        var new_list = [];
        $('.chinese option').each(function() {
            new_list.push($(this).val());
        });
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-select-chinese", country: new_list},
            success: function (response) {
                return false;
            }
        });
    });
}

function save_portuguese($){
    $('.portuguese-btn').on('click', function (event) {
        var new_list = [];
        $('.portuguese option').each(function() {
            new_list.push($(this).val());
        });
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-select-portuguese", country: new_list},
            success: function (response) {
                return false;
            }
        });
    });
}

function save_spanish($){
    $('.spanish-btn').on('click', function (event) {
        var new_list = [];
        $('.spanish option').each(function() {
            new_list.push($(this).val());
        });
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-select-spanish", country: new_list},
            success: function (response) {
                return false;
            }
        });
    });
}

function save_japanese($){
    $('.japanese-btn').on('click', function (event) {
        var new_list = [];
        $('.japanese option').each(function() {
            new_list.push($(this).val());
        });
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "load-select-japanese", country: new_list},
            success: function (response) {
                return false;
            }
        });
    });
}
