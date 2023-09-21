var ajaxurl = '/wp-admin/admin-ajax.php';

$(document).ready(function ($) {
  $(document).on('click', '.click-me', function (event) {
    event.preventDefault();
    var el = $(event.target);
    var h5p_video_id = el.data('h5p_video_id');
    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: {
        action: "load-h5p-content",
        h5p_video_id: h5p_video_id
      },
      success: function (response) {

        var magnific = $.magnificPopup.instance;
        magnific.open({
          items: {
            src: '<div class="foo-test">'+response+'</div>',
            type: 'inline',
          }
        }, 0);
        if ((typeof H5P == 'undefined') && (typeof H5PIntegration != 'undefined')) {
          H5PIntegration.core.scripts.forEach(function(el)  {
            var script = document.createElement( 'script' );
            document.head.appendChild(script);
            script.async=false;
            script.src = el;
          });
        } else {
          if (typeof H5P != 'undefined') {
            H5P.init();
          }
        }

        return false;
      }
    });
  });
});
