<?php
/**
 * Template Name: Home Page Gutenberg
 */

get_header('section'); ?>
    <main class="main home">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </main>
<?php get_footer('section'); ?>

