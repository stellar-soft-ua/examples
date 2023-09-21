<?php
/**
 * Template Name: About Pro Advanced
 */

get_header('section');?>
<main class="main about-pro advanced">
    <?php if (have_posts()):
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
    endif; ?>
</main>
<?php get_footer('advanced');?>
