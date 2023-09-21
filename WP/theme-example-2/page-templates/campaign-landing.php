<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Campaign Landing
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */
get_header('campaign');
while (have_posts()) : the_post(); ?>
	<div class="content-area container">
        <main class="content" id="genesis-content">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content" itemprop="text">
				<?php the_content(); ?>
            </div>
	        </article>
        </main>
    </div>
<?php endwhile; ?>
<?php get_footer('campaign');
