/*jQuery(document).ready(function($){ 
if ($(window).width() <= 1024) {
    jQuery('.genesis-nav-menu li').click(function(e) {
     e.stopPropagation();
     jQuery('.genesis-nav-menu li').not(this).removeClass('sub-menu-active');
     jQuery('.genesis-nav-menu li').not(this).prev('.menu-item-has-children').removeClass('sub-menu-active');
   // jQuery('.genesis-nav-menu li').not(this).find('>[class*="sub-menu"]').slideUp('slow');
    //jQuery(this).prev('.menu-item-has-children').addClass("ttt");
    jQuery(this).toggleClass('sub-menu-active');
    jQuery(this).toggleClass('sub-menu-active');
    jQuery(this).prev('.menu-item-has-children').find('ul.sub-menu').slideToggle('slow');
    jQuery(this).prev('li').toggleClass("sub-active-class");
  //jQuery(this).prev('.menu-item-has-children').
  jQuery(this).find('.sub-menu-icon').parent('li').find('ul.sub-menu').slideToggle('slow');
  jQuery(this).find('.sub-menu-icon').parent('li').toggleClass("sub-active-class");
  jQuery('body').toggleClass('menu-open');
});
  }
  jQuery(function() {                       
    jQuery(".open-menu").click(function() {  
      jQuery(this).toggleClass("open");     
    });
  }); 
}); */


//Scroll Bar JS Code
jQuery(document).ready(function()
{
  var socialFloat = document.querySelector('.aiq-bar');
  if(socialFloat != null){
    var footer = document.querySelector('#footer');
    function checkOffset() {
      function getRectTop(el) {
        var rect = el.getBoundingClientRect();
        return rect.top;
      }
      if ((getRectTop(socialFloat) + document.body.scrollTop) + socialFloat.offsetHeight >= (getRectTop(footer) + document.body.scrollTop) - 10)
        socialFloat.style.position = 'static';
      if (document.body.scrollTop + window.innerHeight < (getRectTop(footer) + document.body.scrollTop))
        socialFloat.style.position = 'fixed'; // restore when you scroll up
    }
    document.addEventListener("scroll", function() {
      checkOffset();
    });
  }
});

/* Add class in body on scroll header */
jQuery(window).scroll(function(){
  if (jQuery(window).scrollTop() >= 1) {
    jQuery('body').addClass('header-fixed');
   }
   else {
    jQuery('body').removeClass('header-fixed');
   }
});

/*Header Search form js*/
jQuery(document).ready(function(){
 jQuery('.main-search-form').click(function(e){
    e.stopPropagation();
});
jQuery(".search-wpb").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    //jQuery('.poli-top-header .main-search-form').show('slide', {direction: 'left'}, 5000);
    jQuery('.main-search-form').show();
    jQuery('.poli-top-header .main-search-form').css('width','350px');
    jQuery('body').addClass('searchform-open');
    //jQuery('.search-icon').addClass('search-close-icon');

    if (jQuery(".menu-toggle").hasClass("activated") && jQuery(window).width() <= 1024) {
      var $this = jQuery( '.menu-toggle' );
      //_toggleAria( $this, 'aria-pressed' );
      //_toggleAria( $this, 'aria-expanded' );
      $this.toggleClass( 'activated' );
      $this.next( 'nav' ).slideToggle( 'fast' );
    }
});
jQuery(document).click(function() {
    //jQuery('.poli-top-header .main-search-form').hide('slide', {direction: 'right'}, 5000);
    jQuery('.main-search-form').hide();
    jQuery('body').removeClass('searchform-open');
    jQuery('.poli-top-header .main-search-form').css('width','0px');
    //jQuery('.search-icon').removeClass('search-close-icon');
});
//jQuery(document).on("click", ".poli-top-header .search-close-icon", function(e) {
jQuery(".search-close-icon").click(function(e) {
console.log('testsclick');
    e.preventDefault();
    e.stopPropagation();
    jQuery('.main-search-form').hide();
    jQuery('body').removeClass('searchform-open');
});

});

/*equal height js*/  
jQuery(function(jQuery) {
jQuery('.height').responsiveEqualHeightGrid();  
});
(function($) {
  $(document).on('facetwp-loaded', function() {
      if ('undefined' !== typeof FWP.extras.sort ) {
          $( '.facetwp-sort-radio input:radio[name="sort"]').filter('[value="'+FWP.extras.sort+'"]').prop("checked", true).closest('.facetwp-sort-radio label').addClass('checked-active');
      }
  });
  // Sorting
  $(document).on('change', '.facetwp-sort-radio input', function() {
   $('.facetwp-sort-radio label').removeClass('checked-active');
   $(this).closest('.facetwp-sort-radio label').addClass('checked-active', this.checked);
      FWP.extras.sort = $(this).val();
      FWP.soft_refresh = true;
      FWP.autoload();
  });
})(jQuery);