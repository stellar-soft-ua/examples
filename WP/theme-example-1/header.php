<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="theme-color" content="#fff">
    <meta name="format-detection" content="telephone=no">
    <meta name="yandex-verification" content="0f646a329f50abf5" />
    <title><?php is_front_page() ? bloginfo('name') : wp_title(' | ' . get_bloginfo(), true, 'right'); ?></title>
    <!-- Global site tag (gtag.js) - Google Analytics
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91658573-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-91658573-1');
    </script>91658573-1 -->
	<!-- Global site tag (gtag.js) - Google Ads: 798851802 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-798851802"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-798851802');
</script>

	<script type="text/javascript">
__sf_config = {
customer_id: 97567,
host: 'emails.coppermountaintech.com',
ip_privacy: 0,
subsite: '9b3c09fb-78d8-4b2a-a6b2-d4890e986589',

__img_path: "/web-next.gif?"
};

(function() {
var s = function() {
var e, t;
var n = 10;
var r = 0;
e = document.createElement("script");
e.type = "text/javascript";
e.async = true;
e.src = "//" + __sf_config.host + "/js/frs-next.js";
t = document.getElementsByTagName("script")[0];
t.parentNode.insertBefore(e, t);
var i = function() {
if (r < n) {
r++;
if (typeof frt !== "undefined") {
frt(__sf_config);
} else {
setTimeout(function() { i(); }, 500);
}
}
};
i();
};
if (window.attachEvent) {
window.attachEvent("onload", s);
} else {
window.addEventListener("load", s, false);
}
})();
</script>
    <?php wp_head(); ?>
	

      <script>
        (function () {
          var zi = document.createElement('script');
          zi.type = 'text/javascript';
          zi.async = true;
          zi.src = 'https://ws.zoominfo.com/pixel/fiq3b36XqcqkDbkngtK1';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(zi, s);
        })();
        const ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
      </script>
      <noscript>
        <img src="https://ws.zoominfo.com/pixel/fiq3b36XqcqkDbkngtK1" width="1" height="1" style="display: none;" />
      </noscript>
  	
	
</head>

<body>
<div class="loader">
    <div class="lizard-spinner"></div>
</div>
<main class="page">
    <div class="shadow-block"></div>
    <!-- Header -->
    <header class="header <?= is_front_page() ? '' : 'not-home-header' ?>">
        <div class="latest-news-container">
            <label class="mb-hide">Latest News</label>
            <label class="abs-block mb-hide"></label>
            <label class="abs-block mb-hide"></label>
            <label class="abs-block mb-hide"></label>
            <label class="abs-block mb-hide"></label>
            <div class="marquee-slider mb-hide">
                <div id="marquee-container-1" class="marquee-container">
                    <?php
                    $query = new WP_Query([
                        'post_type'      => LATEST_NEWS,
                        'posts_per_page' => -1,
                        'orderby'        => 'post_date',
                        'order'          => 'DESC',
                        'post_status'    => 'publish'
                    ]);
                    ?>
                    <?php
                        foreach ($query->posts as $news_item){
                            $news_item_url = @get_post_custom_values('news_item_url', $news_item->ID)[0];
//                            $news_item_url = get_permalink($news_item->ID);
                    ?>
                    <div class="latest-news-bxslider-inner"><a class="news-item" href="<?= $news_item_url ? $news_item_url : '' ?>"><?=$news_item->post_title?></a></div>
                    <?php } ?>
                </div>
            </div>
            <div class="custom-top-bar">
                <div class="sub"><a href="/find-a-representative/" class=""> <i class="fa fa-map-marker-alt"></i><span>Find a Rep</span></a></div>
                <div><span> | </span></div>
                <div class="sub"><a href="/request-for-field-trial/" class=""> <i class="fa fa-hand-point-right"></i><span>Field Trial</span></a></div>
                <div><span> | </span></div>
                <div class="sub">
                    <div class="w-dropdown-h">
                        <div class="w-dropdown-current"><a class="w-dropdown-item" href="javascript:void(0)"><span>LANG</span></a></i></div>
                        <div class="w-dropdown-list">
                            <ul class="sub-menu">
                            	<li><a href="/">ENG</a></li>
                            	<li><a href="/es/">ESP</a></li>
                            	<li><a href="/zh/">CHI</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            

			
        </div>
        <div class="container">
            <div class="header__wrap">
                <div class="header__logo">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    global $post;
                    ?>
                    <a href="/" class="logo">
                        <img src="<?= $logo[0] ?>" alt="Logo" class="website-logo">
                    </a>
                </div>
                <?php
                wp_nav_menu([
                    'theme_location' => 'top',
                    'container' => 'nav',
                    'container_class' => 'header__nav',
                    'container_id' => 'header-menu',
                    'menu_class' => 'nav__list',
                    'depth' => 3
                ])
                ?>
                <div class="nav__search">
                    <img src="<?= get_template_directory_uri() ?>/assets/img/search.png" alt="Search"
                         class="search-header-btn">
                    <?php get_search_form(); ?>
                </div>
            </div>
            <div class="menu btn slide-menu-control" data-target="mobile-menu" data-action="toggle">
                <span class="menu-global menu-top"></span>
                <span class="menu-global menu-middle"></span>
                <span class="menu-global menu-bottom"></span>
            </div>
        </div>
    </header>
    <!-- End header -->
    <?php
    wp_nav_menu([
        'theme_location' => 'top',
        'container' => 'nav',
        'container_class' => 'slide-menu',
        'container_id' => 'mobile-menu',
        'menu_class' => 'mobile-menu',
        'depth' => 3
    ])
    ?>
