<?php
/**
 * Template Name: FAQ Page
 */

get_header('section');?>
    <main class="main faq">
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
