<?php
/**
 * Template Name: Pro Plans Advanced
 */

get_header('section');?>
<main class="main pro-plans advanced">
    <?php if (have_posts()):
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
    endif; ?>
</main>
<?php get_footer('advanced');?>
