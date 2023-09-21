<?php
/**
 * The template for displaying all single post details
 *
 */
get_header('section');?>
    <main class="main policy-resources">
        <article id="post-<?php the_ID();?>" <?php post_class();?>>
            <div class="entry-content" itemprop="text">
                <?php the_content();?>
            </div>
        </article>
    </main>
<?php get_footer('section');?>
