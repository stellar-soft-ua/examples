var ajaxurl = cmt_elementor_pages_cpm_php_var.ajaxurl;
var cmp_key = cmt_elementor_pages_cpm_php_var.cpm_key;

$(document).ready(function ($) {
  var form = $('#searchFormId');
  var input = form.find('.elementor-search-form__input').eq(0);

  var marker = $('#marker-section-on-elementor-archive-page-id');
  var searchResultsContainer = $('#search-results-wrapper-id');
  var searchResults = $('#search-results-content-wrapper-id');

  var clearIcon = form.find('.clear-icon').eq(0);

  input.change(function (e) {
    check_value();
  });

  clearIcon.click(function () {
    input.val('');
    check_value();
  })

  form.on('submit', function (e) {
    e.preventDefault();
    //var formData  = $(this).serializeArray(); // get data like [{name: "s", value: "foo"}]
    var formDataReduce  = $(this).serializeArray().reduce(function (obj, item) {
      obj[item.name] = item.value;
      return obj;
    }, {}); // get data like {s : "foo"}

    formDataReduce.action = "load-search-elementor-pages";
    formDataReduce.cmp_key = cmp_key;

    if (formDataReduce.s) {
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: formDataReduce,
        success: function (response) {
          marker.nextAll().hide('fast');
          searchResults.empty();
          searchResults.append(response);
          searchResultsContainer.show('fast');
          return false;
        }
      });
    }
  });


  function clear_search_result() {
    searchResultsContainer.hide();
    marker.nextAll().show();
  }

  function check_value() {
    var value = input.val();
    clearIcon.toggle(value !== '');
    if (value === '') {
      clear_search_result();
    }
  }

});
