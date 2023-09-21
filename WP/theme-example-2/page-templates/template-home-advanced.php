<?php
/**
 * Template Name: Home Advanced
 */

get_header('section'); ?>
    <main class="main home advanced">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </main>
<?php get_footer('advanced'); ?>

