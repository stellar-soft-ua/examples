<?php get_header(); ?>
<section class="faqs">
    <div class="container">
        <h1>FAQS</h1>
        <div class="input-search__wrap" style="max-width: none">
            <input type="text" name="search-faqs" placeholder="Search" id="search-faq"/>
            <span class="search-icon"></span>
        </div>
        <div class="accardion-collapse" data-accordion-group>
            <?= get_faq_list(FAQ_POST_TYPE) ?>
        </div>
    </div>
</section>

<!--To update accordion after ajax request need to enqueue this script. Accordion need to be destroyed and reinitialize-->
<?php
wp_enqueue_script('cmt-jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', ['cmt-jquery'],null, true);
wp_enqueue_script('cmt-faq-search', get_template_directory_uri() . '/assets/js/search-faq.js', ['cmt-jquery'], false,true);
?>
<?php get_footer(); ?>
