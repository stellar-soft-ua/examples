var ajaxurl="/wp-admin/admin-ajax.php",selected="";function slickCarousel(){$(".webinars__cards").slick({prevArrow:$(".webinars .arrow-left, .arrow-slider--left"),nextArrow:$(".webinars .arrow-right, .arrow-slider--right"),mobileFirst:!0,arrows:!0,infinite:!0,slidesToShow:5,slidesToScroll:1,centerMode:!1,responsive:[{breakpoint:1330,settings:{slidesToShow:5,slidesToScroll:1,infinite:!0,centerMode:!1}},{breakpoint:1024,settings:{slidesToShow:4,slidesToScroll:1,infinite:!0,centerMode:!1}},{breakpoint:768,settings:{slidesToShow:3,slidesToScroll:1,infinite:!0,centerMode:!1}},{breakpoint:480,settings:{slidesToShow:2,slidesToScroll:1,infinite:!0,centerMode:!1}},{breakpoint:200,settings:{slidesToShow:1,slidesToScroll:1,infinite:!0,centerMode:!1}}]})}function destroyCarousel(){$(".webinars__cards").hasClass("slick-initialized")&&$(".webinars__cards").slick("destroy")}function search_webinars(e){e.preventDefault(),$(".webinars__cards").slick("unslick"),jQuery.ajax({type:"POST",url:ajaxurl,data:{action:"load-search-webinars",search:$("#webinarSearch").val(),cat_filter:selected},success:function(e){return $.trim(e)?($(".not-found-results").remove(),$(".webinars__cards").html(""),destroyCarousel(),$(".webinars__cards").html(e),slickCarousel(),formatDate(),shave("div.blog-short-description",90),$(".webinars__cards .slick-slide").css("margin","10px"),$(".webinars__cards .slick-slide").css("padding","0"),wrapInTag($("#webinarSearch").val(),"b",".product-preview__title"),wrapInTag($("#webinarSearch").val(),"b",".blog-short-description"),$(".webinars__cards").css("opacity","1")):($(".webinars__cards").slick("unslick"),$(".testimonials__arrow ").hide(),$(".webinars__cards").html("").html('<p class="not-found-results" style="font-size: 25px">No matches found</p>'),$(".webinars__cards").css("opacity","1")),!1}}),check_value()}function wrapInTag(e,i,r){var s=new RegExp(e,"gi"),a="<"+i+">$&</"+i+">";e&&$(r).each(function(){$(this).html($(this).html().replace(s,a))})}function check_value(){const e=$("#webinarSearch").val();$(".clear-icon").toggle(""!==e)}jQuery(document).ready(function(e){e(".tech-category-filter").on("click",function(i){selected=e(".tech-category-filter").find(":selected").val()}),e(".tech-category-filter").change(function(i){selected=e(".tech-category-filter").find(":selected").val(),e(".webinars__cards").css("opacity","0"),e(".testimonials__arrow ").hide(),search_webinars(i)}),e("#webinarSearch").bind("enterKey",function(i){e(".webinars__cards").css("opacity","0"),e(".testimonials__arrow ").hide(),search_webinars(i)}),e("#webinarSearch").keyup(function(i){13===i.keyCode&&e(this).trigger("enterKey")}),e(".search-icon").click(function(e){e.preventDefault(),search_webinars(e)}),e(".clear-icon").click(function(i){i.preventDefault(),e("#webinarSearch").val(""),search_webinars(i)})});