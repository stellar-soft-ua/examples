<?php
/**
 * Template Name: Pro Reporting Advanced
 */

get_header('section');?>
<main class="main pro-reporting advanced">
    <?php if (have_posts()):
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
    endif; ?>
</main>
<?php get_footer('advanced');?>
