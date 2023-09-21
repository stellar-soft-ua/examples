<?php 
/* POL Register Block*/
add_action('acf/init', 'pol_custom_acf_init');
function pol_custom_acf_init() {

  /*check function exists*/
  if( function_exists('acf_register_block') ) {

    /* ACF block of the Polticopro */

    acf_register_block(array(
      'name'              => 'secondary-banner',
      'title'             => __('Secondary Banner'),
      'description'       => __('Secondary banner block Module'),
      'render_template'   => '/page-templates/blocks/secondary-banner/secondary-hero.php',
      'enqueue_assets' => function(){
        assetEnqueue('secondary-hero-block-style', '/page-templates/blocks/secondary-banner/secondary-hero.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'secondry', 'hero','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'home-hero-block',
      'title'             => __('Home Hero block'),
      'description'       => __(' Home Hero block Module'),
      'render_template'   => '/page-templates/blocks/home-hero-block/home-hero.php',
      'enqueue_assets' => function(){
        assetEnqueue('home-hero-block-style', '/page-templates/blocks/home-hero-block/home-hero.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'homehero', 'hero','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'client-block',
      'title'             => __('Clients block'),
      'description'       => __('Clients block Module'),
      'render_template'   => '/page-templates/blocks/client-block/client-block.php',
      'enqueue_assets' => function(){
        assetEnqueue('client-style', '/page-templates/blocks/client-block/client-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'groups',
      'keywords'          => array( 'client', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'two-column-image-content-block',
      'title'             => __('Two column Image Content Block'),
      'description'       => __('Two column Image Content Block Module'),
      'render_template'   => '/page-templates/blocks/two-column-image-content-block/two-column-image-content-block.php',
      'enqueue_assets' => function(){
        assetEnqueue('two-column-image-content-block-style', '/page-templates/blocks/two-column-image-content-block/two-column-image-content-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Two column Image Content Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'learn-more-cta-block',
      'title'             => __('Learn More CTA Block'),
      'description'       => __('Learn More CTA Block Module'),
      'render_template'   => '/page-templates/blocks/learn-more-cta-block/learn-more-cta.php',
      'enqueue_assets'    => function(){
        assetEnqueue('learn-more-cta-style', '/page-templates/blocks/learn-more-cta-block/learn-more-cta.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Learn More CTA Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'four-column-image-grid-block',
      'title'             => __('Four Column Image Grid Block'),
      'description'       => __('Four Column Image Grid Block'),
      'render_template'   => '/page-templates/blocks/four-column-image-grid-block/four-column-image-grid-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('four-column-image-grid-block-style', '/page-templates/blocks/four-column-image-grid-block/four-column-image-grid-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Four Column Image Grid Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'four-column-icon-grid-block',
      'title'             => __('Four Column Icon Grid Block'),
      'description'       => __('Four Column Icon Grid Block Module'),
      'render_template'   => '/page-templates/blocks/four-column-icon-grid-block/four-column-icon-grid-block.php',
      'enqueue_assets' => function(){
        assetEnqueue('four-column-icon-grid-block-style', '/page-templates/blocks/four-column-icon-grid-block/four-column-icon-grid-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Four Column Icon Grid Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'stats-block',
      'title'             => __('Stats block'),
      'description'       => __('Stats block'),
      'render_template'   => '/page-templates/blocks/stats-block/stats-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('stats-block-style', '/page-templates/blocks/stats-block/stats-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'format-status',
      'keywords'          => array( 'Stats block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'fact-sheet',
      'title'             => __('Fact sheet'),
      'description'       => __('Fact sheet'),
      'render_template'   => '/page-templates/blocks/fact-sheet/fact-sheet.php',
      'enqueue_assets'    => function(){
        assetEnqueue('fact-sheet-block-style', '/page-templates/blocks/fact-sheet/fact-sheet.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Fact sheet', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'left-accordion-block',
      'title'             => __('Left Accordion block'),
      'description'       => __('Left Accordion block Module'),
      'render_template'   => '/page-templates/blocks/left-accordion-block/left-accordion.php',
      'enqueue_assets'    => function(){
        assetEnqueue('left-accordion-style', '/page-templates/blocks/left-accordion-block/left-accordion.css', true, false);
        assetEnqueue('left-accordion-script', '/page-templates/blocks/left-accordion-block/left-accordion.js');
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Left Accordion block', '','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'three-column-image-block',
      'title'             => __('Three Column Image Block'),
      'description'       => __('Three Column Image Block'),
      'render_template'   => '/page-templates/blocks/three-column-image-block/three-column-image-block.php',
      'enqueue_assets'    => function(){
         assetEnqueue('three-column-image-block-style', '/page-templates/blocks/three-column-image-block/three-column-image-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Three Column Image Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'quote-block',
      'title'             => __('Quote Block'),
      'description'       => __('Quote Block'),
      'render_template'   => '/page-templates/blocks/quote-block/quote-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('quote-block-style', '/page-templates/blocks/quote-block/quote-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Quote Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'content-block',
      'title'             => __('Content Block'),
      'description'       => __('Content Block'),
      'render_template'   => '/page-templates/blocks/content-block/content-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('content-block-style', '/page-templates/blocks/content-block/content-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Content Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    
    acf_register_block(array(
      'name'              => 'full-width-banner-block',
      'title'             => __('Full Width Banner block'),
      'description'       => __(' Full Width Banner block'),
      'render_template'   => '/page-templates/blocks/full-width-banner-block/full-width-banner.php',
      'enqueue_assets'    => function(){
        assetEnqueue('full-width-style', '/page-templates/blocks/full-width-banner-block/full-width-banner.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'Full Width Banner', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'plans-grid-block',
      'title'             => __('Plans Grid Block'),
      'description'       => __('Plans Grid Block'),
      'render_template'   => '/page-templates/blocks/plans-grid-block/plans-grid-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('plans-grid-block-style', '/page-templates/blocks/plans-grid-block/plans-grid-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Plans Grid Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'leadership-block',
      'title'             => __('Leadership Block'),
      'description'       => __(' Leadership Block'),
      'render_template'   => '/page-templates/blocks/leadership-block/leadership-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('leadership-block-style', '/page-templates/blocks/leadership-block/leadership-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Leadership Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'values-block',
      'title'             => __('Values block'),
      'description'       => __(' Values block'),
      'render_template'   => '/page-templates/blocks/values-block/values-block.php',
      'enqueue_assets'    => function(){
         assetEnqueue('values-block-style', '/page-templates/blocks/values-block/values-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Values Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));
    
    acf_register_block(array(
      'name'              => 'top-accordion-block',
      'title'             => __('Top Accordion block'),
      'description'       => __('Top Accordion block'),
      'render_template'   => '/page-templates/blocks/top-accordion-block/top-accordion-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('top-accordion-block-style', '/page-templates/blocks/top-accordion-block/top-accordion-block.css', true, false);
        assetEnqueue('top-accordion-block-script', '/page-templates/blocks/top-accordion-block/top-accordion-block.js');
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Top Accordion block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'faq-three-column-block',
      'title'             => __('Faq Three Column block'),
      'description'       => __('Faq Three Column block'),
      'render_template'   => '/page-templates/blocks/faq-three-column-block/faq-three-column-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('faq-three-column-block-style', '/page-templates/blocks/faq-three-column-block/faq-three-column-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Faq Three Column block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'left-content-with-form-block',
      'title'             => __('Left Content with Form'),
      'description'       => __('Left Content with Form'),
      'render_template'   => '/page-templates/blocks/left-content-with-form-block/left-content-with-form.php',
      'enqueue_assets' => function(){
        assetEnqueue('left-content-with-form-style', '/page-templates/blocks/left-content-with-form-block/left-content-with-form.css', true, false);
        assetEnqueue('left-content-with-form-block-script', '/page-templates/blocks/left-content-with-form-block/left-content-with-form.js');
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Left Content with Form', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'faqs-block',
      'title'             => __('Faqs blocks'),
      'description'       => __('Faqs blocks'),
      'render_template'   => '/page-templates/blocks/faqs-block/faqs-block.php',
      'enqueue_assets' => function(){
        assetEnqueue('faqs-block-style', '/page-templates/blocks/faqs-block/faqs-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Faqs blocks', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'testimonial-block',
      'title'             => __('Testimonial blocks'),
      'description'       => __('Testimonial blocks'),
      'render_template'   => '/page-templates/blocks/testimonial-block/testimonial-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('testimonial-block-style', '/page-templates/blocks/testimonial-block/testimonial-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Testimonial blocks', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'explore-grid-block',
      'title'             => __('Explore Grid block'),
      'description'       => __('Explore Grid block'),
      'render_template'   => '/page-templates/blocks/explore-grid-block/explore-grid.php',
      'enqueue_assets'    => function(){
        assetEnqueue('explore-grid-style', '/page-templates/blocks/explore-grid-block/explore-grid.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Explore Grid block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'two-column-request-grid-block',
      'title'             => __('Two Column Request Grid Block'),
      'description'       => __('Two Column Request Grid Block'),
      'render_template'   => '/page-templates/blocks/two-column-request-grid-block/two-column-request-grid.php',
      'enqueue_assets' => function(){
        assetEnqueue('two-column-request-grid-style', '/page-templates/blocks/two-column-request-grid-block/two-column-request-grid.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Two Column Request Grid block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'two-column-image-center-block',
      'title'             => __('Two Column Image Center Block'),
      'description'       => __('Two Column Image Center Block'),
      'render_template'   => '/page-templates/blocks/two-column-image-center-block/two-column-image-center-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('two-column-image-center-block-style', '/page-templates/blocks/two-column-image-center-block/two-column-image-center-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Two Column Image Center Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'pricing-table-block',
      'title'             => __('Pricing Table Block'),
      'description'       => __('Pricing Table Block'),
      'render_template'   => '/page-templates/blocks/pricing-table-block/pricing-table-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('pricing-table-block-style', '/page-templates/blocks/pricing-table-block/pricing-table-block.css', true, false);
        assetEnqueue('pricing-table-block-script', '/page-templates/blocks/pricing-table-block/pricing-table-block.js');
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Pricing Table Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));


    acf_register_block(array(
      'name'              => 'resource-cta-block',
      'title'             => __('Resource CTA Block'),
      'description'       => __('Resource CTA Block'),
      'render_template'   => '/page-templates/blocks/resource-cta-block/resource-cta-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('resource-cta-block-style', '/page-templates/blocks/resource-cta-block/resource-cta-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'Resource CTA Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));
    
    acf_register_block(array(
      'name'              => 'cta-with-icon',
      'title'             => __('CTA With Icon Block'),
      'description'       => __('CTA With Icon Block'),
      'render_template'   => '/page-templates/blocks/cta-with-icon/cta-with-icon.php',
      'enqueue_assets'    => function(){
        assetEnqueue('cta-with-icon-style', '/page-templates/blocks/cta-with-icon/cta-with-icon.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'CTA With Icon Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'three-column-icon-grid-block',
      'title'             => __('Three Column Icon Grid Block'),
      'description'       => __('Three Column Icon Grid Block'),
      'render_template'   => '/page-templates/blocks/three-column-icon-grid-block/three-column-icon-grid-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('three-column-icon-grid-block-style', '/page-templates/blocks/three-column-icon-grid-block/three-column-icon-grid-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Three Column Icon Grid Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'inner-banner',
      'title'             => __('Inner Banner Block'),
      'description'       => __('Inner Banner Block'),
      'render_template'   => '/page-templates/blocks/inner-banner-block/inner-banner.php',
      'enqueue_assets'    => function(){
        assetEnqueue('inner-banner-style', '/page-templates/blocks/inner-banner-block/inner-banner.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'Inner Banner Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'download-block',
      'title'             => __('Download Block'),
      'description'       => __('Dowload Block'),
      'render_template'   => '/page-templates/blocks/download-block/download-block.php',
      'enqueue_assets' => function(){
        assetEnqueue('download-block-style', '/page-templates/blocks/download-block/download-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Download Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'banner-with-download-links',
      'title'             => __('Banner With Download Links'),
      'description'       => __('Banner With Download Links'),
      'render_template'   => '/page-templates/blocks/banner-with-download-links/banner-with-download-links.php',
      'enqueue_assets'    => function(){
        assetEnqueue('banner-with-download-links', '/page-templates/blocks/banner-with-download-links/banner-with-download-links.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'Banner with download links Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'success-banner-block',
      'title'             => __('Success Banner Block'),
      'description'       => __('Success Banner Block'),
      'render_template'   => '/page-templates/blocks/success-banner-block/success-banner-block.php',
      'enqueue_assets' => function(){
        assetEnqueue('success-banner-block', '/page-templates/blocks/success-banner-block/success-banner-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'Success Banner Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'two-column-success-grid-block',
      'title'             => __('Two Column Success Grid Block'),
      'description'       => __('Two Column Success Grid Block'),
      'render_template'   => '/page-templates/blocks/two-column-success-grid-block/two-column-success-grid-block.php',
      'enqueue_assets' => function(){
        assetEnqueue('two-column-success-grid-block', '/page-templates/blocks/two-column-success-grid-block/two-column-success-grid-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Two Column Success Grid Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'two-column-content-block',
      'title'             => __('Two Column Content Block'),
      'description'       => __('Two Column Content Grid Block'),
      'render_template'   => '/page-templates/blocks/two-column-content-block/two-column-content-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('two-column-content-block', '/page-templates/blocks/two-column-content-block/two-column-content-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Two Column Content Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'three-column-cta-block',
      'title'             => __('Three Column CTA Block'),
      'description'       => __('Three Column CTA Block'),
      'render_template'   => '/page-templates/blocks/three-column-cta-block/three-column-cta-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('three-column-cta-block', '/page-templates/blocks/three-column-cta-block/three-column-cta-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Three Column CTA Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'resource-banner-block',
      'title'             => __('Resource Banner Block'),
      'description'       => __('Resource Banner Block'),
      'render_template'   => '/page-templates/blocks/resource-banner-block/resource-banner-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('resource-banner-block', '/page-templates/blocks/resource-banner-block/resource-banner-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'cover-image',
      'keywords'          => array( 'Resource Banner Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'dark-cta-block',
      'title'             => __('Dark CTA Block'),
      'description'       => __('Dark CTA Block'),
      'render_template'   => '/page-templates/blocks/dark-cta-block/dark-cta-block.php',
      'enqueue_assets'    => function(){
        assetEnqueue('dark-cta-block', '/page-templates/blocks/dark-cta-block/dark-cta-block.css', true, false);
      },
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Dark CTA Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));
    acf_register_block(array(
      'name'              => 'secondary-pricing-table-block',
      'title'             => __('Secondary Pricing Table Block'),
      'description'       => __('Secondary Pricing Table Block'),
      'render_template'   => '/page-templates/blocks/secondary-pricing-table-block/secondary-pricing-table-block.php',
      'enqueue_assets' => 'blockname_assets',
      'enqueue_style'     => get_stylesheet_directory_uri() .'/page-templates/blocks/secondary-pricing-table-block/secondary-pricing-table-block.css',
      'enqueue_script'     => get_stylesheet_directory_uri() .'/page-templates/blocks/secondary-pricing-table-block/secondary-pricing-table-block.js',      
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Secondary Pricing Table Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-text-block',
      'title'             => __('Rd Highlight Section Image Background'),
      'description'       => __('Rd Highlight Section Image Background'),
      'render_template'   => '/page-templates/blocks/rd-highlight-section-image-background/rd-highlight-section-image-background.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Highlight Section Image Background', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-first-counter-block',
      'title'             => __('Rd Two Column CTA & Stats Counter Block'),
      'description'       => __('Rd Two Column CTA & Stats Counter Block'),
      'render_template'   => '/page-templates/blocks/rd-two-column-cta-and-stats-counter-block/rd-two-column-cta-and-stats-counter-block.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Two Column CTA & Stats Counter Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-title-block',
      'title'             => __('Rd Horizontal Accordion (Header)'),
      'description'       => __('Rd Horizontal Accordion (Header)'),
      'render_template'   => '/page-templates/blocks/rd-horizontal-accordion-header/rd-horizontal-accordion-header.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Horizontal Accordion (Header)', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-find-your-place',
      'title'             => __('Rd Horizontal Accordion'),
      'description'       => __('Rd Horizontal Accordion'),
      'render_template'   => '/page-templates/blocks/rd-horizontal-accordion/rd-horizontal-accordion.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Horizontal Accordion', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-gold-standart-block',
      'title'             => __('Rd Logo Wall & Quote'),
      'description'       => __('Rd Logo Wall & Quote'),
      'render_template'   => '/page-templates/blocks/rd-logo-wall-and-quote/rd-logo-wall-and-quote.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Logo Wall & Quote', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-platform-features-block',
      'title'             => __('Rd Vertical Accordion'),
      'description'       => __('Rd Vertical Accordion'),
      'render_template'   => '/page-templates/blocks/rd-vertical-accordion/rd-vertical-accordion.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Vertical Accordion', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-glimpse-block',
      'title'             => __('Rd Features Image Version Block'),
      'description'       => __('Rd Features Image Version Block'),
      'render_template'   => '/page-templates/blocks/rd-features-image-version-block/rd-features-image-version-block.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Features Image Version Block', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-300-experts-block',
      'title'             => __('Rd Images Group Pattern'),
      'description'       => __('Rd Images Group Pattern'),
      'render_template'   => '/page-templates/blocks/rd-images-group-pattern/rd-images-group-pattern.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Images Group Pattern', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-features-hero-block',
      'title'             => __('Rd Hero Full Image Background'),
      'description'       => __('Rd Hero Full Image Background'),
      'render_template'   => '/page-templates/blocks/rd-hero-full-image-background/rd-hero-full-image-background.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Hero Full Image Background', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-1000-topics-block',
      'title'             => __('Rd Experts Images Group Pattern Section'),
      'description'       => __('Rd Experts Images Group Pattern Section'),
      'render_template'   => '/page-templates/blocks/rd-experts-images-group-pattern-section/rd-experts-images-group-pattern-section.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Experts Images Group Pattern Section', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-police-news-block',
      'title'             => __('Rd Floating Image'),
      'description'       => __('Rd Floating Image'),
      'render_template'   => '/page-templates/blocks/rd-floating-image/rd-floating-image.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Floating Image', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-additional-features-block',
      'title'             => __('Rd Features Icons Version'),
      'description'       => __('Rd Features Icons Version'),
      'render_template'   => '/page-templates/blocks/rd-features-icons-version/rd-features-icons-version.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Features Icons Version', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-single-stats-pattern',
      'title'             => __('Rd Single Stats Pattern'),
      'description'       => __('Rd Single Stats Pattern'),
      'render_template'   => '/page-templates/blocks/rd-single-stats-pattern/rd-single-stats-pattern.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Single Stats Pattern', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-two-column-cta-and-rotating-text-pattern',
      'title'             => __('Rd Two Column CTA & Rotating Text Pattern'),
      'description'       => __('Rd Two Column CTA & Rotating Text Pattern'),
      'render_template'   => '/page-templates/blocks/rd-two-column-cta-and-rotating-text-pattern/rd-two-column-cta-and-rotating-text-pattern.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Two Column CTA & Rotating Text Pattern', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-text-and-image-pattern',
      'title'             => __('Rd Text & Image Pattern'),
      'description'       => __('Rd Text & Image Pattern'),
      'render_template'   => '/page-templates/blocks/rd-text-and-image-pattern/rd-text-and-image-pattern.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Text & Image Pattern', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-cards-scroller',
      'title'             => __('Rd Cards Scroller'),
      'description'       => __('Rd Cards Scroller'),
      'render_template'   => '/page-templates/blocks/rd-cards-scroller/rd-cards-scroller.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Cards Scroller', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-vertical-timeline-accordion',
      'title'             => __('Rd Vertical Timeline Accordion'),
      'description'       => __('Rd Vertical Timeline Accordion'),
      'render_template'   => '/page-templates/blocks/rd-vertical-timeline-accordion/rd-vertical-timeline-accordion.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Vertical Timeline Accordion', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    acf_register_block(array(
      'name'              => 'rd-two-column-icon-card-blocks',
      'title'             => __('Rd Two Column Icon Card Blocks'),
      'description'       => __('Rd Two Column Icon Card Blocks'),
      'render_template'   => '/page-templates/blocks/rd-two-column-icon-card-blocks/rd-two-column-icon-card-blocks.php',
      'category'          => 'Politicopro',
      'icon'              => 'welcome-add-page',
      'keywords'          => array( 'Rd Two Column Icon Card Blocks', 'post','' ),
      'multiple'          => true,
      'mode'              => 'edit',
    ));

    /* Enqueue scripts & styles if frontend */
    function blockname_assets() {
      /* Backend loading CSS */
       if(is_admin()) {
        wp_enqueue_script('blockname', get_stylesheet_directory_uri() . '/assets/css/bootstrap/js/bootstrap.js' );
        wp_enqueue_style('blockname', get_stylesheet_directory_uri() . '/assets/css/bootstrap/css/bootstrap.css' );
      }
    }
  }
}

/* Define Politico category module gutenburg */
function pol_block_category( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'Politicopro',
                'title' => __( 'Politico Modules', 'custom-blocks' ),
            ),
        )
    );
    }
add_filter( 'block_categories', 'pol_block_category', 10, 2);