<?php
/**
 * Template Name: Form Template
 * Template Post Type: post, page, policy_resources
 */

get_header('section');?>
    <main class="main demo">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </main>
<?php get_footer('section');?>
