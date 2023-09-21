<?php get_header(); ?>
<section>
    <form role="search" method="get" id="searchform" class="serch-page-form" action="<?php echo home_url('/') ?>">
        <input type="text" value="<?php echo get_search_query() ?>" name="s" id="website-search-page"/>
        <input type="submit" value="Search"/>
        <input type="hidden" name="post_type" value="vna">
    </form>
    <h4 class="search-results">Search results</h4>
    <div class="container" role="main">
        <?php $post_search =  $_GET["post_type"];
        $search_value = $_GET["s"];
        if($post_search == 'webinar' || $post_search ==  'video'):
        $args = array(
            'post_status' => 'publish',
            'post_type' => $post_search,
            'posts_per_page' => -1,
            'suppress_filters' => false,
            's' => $search_value);
        $query=new WP_Query($args);

            if( $query->have_posts()):
                while( $query->have_posts()): $query->the_post();
                    $post_type = get_post_type();?>
                    <div class="search-item">
                        <h4 class="search-page-title"><a
                                    href="<?= chech_post_single_page($post_type) ?>"><?php the_title(); ?></a></h4>
                        <p class="short-search-text"><?= the_excerpt(); ?></p>
                    </div>
                <?php endwhile;
            else: ?>
                <p class="not-found-results">No Results</p>
            <?php  endif;
        else:?>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post();
                    $post_type = get_post_type(); ?>
                    <?php if ($post_type !== 'nav_menu_item'): ?>
                        <div class="search-item">
                            <h4 class="search-page-title"><a
                                        href="<?= chech_post_single_page($post_type) ?>"><?php the_title(); ?></a></h4>
                            <p class="short-search-text"><?= the_excerpt(); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="not-found-results">No Results</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php
wp_enqueue_script('cmt-highlight-words', get_template_directory_uri() . '/assets/js/website-search-highlight-words.js',
    ['cmt-jquery'], null, true);
get_footer();
?>
