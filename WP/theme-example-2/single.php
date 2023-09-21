<?php
/**
 * The template for displaying all single post details
 *
 */
get_header();
if (!is_user_logged_in()) {
    pp_set_post_view();
}
while (have_posts()): the_post();?>
<div class="content-area">
    <main>
        <article class="container" id="<?php echo esc_attr(get_the_ID()); ?>">
            <?php
    $feature_image = get_the_post_thumbnail_url();
    $default_image = get_stylesheet_directory_uri() . '/images/default-image.jpg';
    ?>
            <section class="main-banner fullwidth-section blog-single-banner">
                <div class="container">
                    <div class="row">
                        <div class="col header-bg pb-5 d-xs-block">
                            <!-- Show for Category list-->
                            <?php $post_cats = get_the_terms($post->ID, 'category', array('exclude' => array(1)));
    if (!empty($post_cats)) {
        ?>
                            <div class="pol-post-cat">
                                <ul>
                                    <?php
    $links = array();
        foreach ($post_cats as $cat) {
            $link = get_term_link($cat, $cat);
            $links[] = '<a href="' . get_bloginfo("url") . '/blog/?_categories=' . $cat->slug . '" rel="cat" class="listing-cat ' . $cat->slug . '">' . $cat->name . '</a>';
        }
        $before = '<li>';
        $sep = ', ';
        $after = '</li>';
        echo $before . join($sep, $links) . $after;
        ?>
                                </ul>
                            </div>
                            <?php }?>
                            <h1><?php echo get_the_title(); ?></h1>
                        </div>
                        <?php if (!empty($feature_image)): ?>
                        <div class="col single-post-banner-img" style="background: url('<?php echo $feature_image ?>')">
                        </div>
                        <?php else: ?>
                        <div class="col single-post-banner-img" style="background: url('<?php echo $default_image ?>')">
                            <img src="<?php echo $default_image ?>" />
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </section>
            <section class="main-post-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 pol-content">
                            <div class="inner-content">
                                <?php
$authors_location = get_field('authors_location');
$postAuthor = get_field('blogAuthor');
$post_date = get_the_date('F jS, Y', get_the_ID());
?>
                                <div class="single-block-head">
                                    <p class="post-meta"><?php echo $post_date; ?></p>
                                    <?php if (!empty($authors_location)): ?>
                                    <p class="post-meta" tabindex="0"><?php echo $authors_location; ?></p>
                                    <?php endif?>
                                    <?php if (!empty($postAuthor)): ?>
                                    <p class="post-meta">By <?php echo $postAuthor; ?></p>
                                    <?php endif?>
                                </div>
                                <?php the_content();?>
                            </div>

                        </div>
                        <aside class="col-md-4 pol-recent-post-sidebar">
                            <!--Start Most recent post show code-->
                            <?php

$recentPostID = get_the_ID();

$customTaxonomyTerms = wp_get_object_terms($recentPostID, 'topic', array('fields' => 'ids'));

if (!empty($customTaxonomyTerms)) {

    $recent_posts = wp_get_recent_posts(array(
        'post_type' => 'post',
        'numberposts' => 3,
        'post_status' => 'publish',
        'post__not_in' => array($recentPostID),
        'tax_query' => array(
            array(
                'taxonomy' => 'topic',
                'field' => 'id',
                'terms' => $customTaxonomyTerms,
            )),
    ));
    if (empty($recent_posts)) {
        $recent_posts = wp_get_recent_posts(array(
            'post_type' => 'post',
            'numberposts' => 3,
            'post_status' => 'publish',
            'post__not_in' => array($recentPostID),
        ));
    }
} else {
    $recent_posts = wp_get_recent_posts(array(
        'post_type' => 'post',
        'numberposts' => 3,
        'post_status' => 'publish',
        'post__not_in' => array($recentPostID),
    ));
}
?>
                            <?php $post_topics = wp_get_object_terms($recentPostID, 'topic', array('fields' => 'all'))?>
                            <?php $post_roles = wp_get_object_terms($recentPostID, 'role', array('fields' => 'all'))?>

                            <?php if (!empty($post_topics)): ?>
                            <div class="recent-posts">
                                <h4 class="sidebar-heading"><?php _e('Topics');?></h4>
                                <ul class="recentpost-contentwrap">
                                    <?php foreach ($post_topics as $topic): ?>
                                    <?php
print_r("<li><a href='/blog/?_topics={$topic->slug}'>{$topic->name}</a></li>");
endforeach;?>
                                </ul>
                            </div>
                            <?php endif;?>

                            <?php if (!empty($post_roles)): ?>
                            <div class="recent-posts">
                                <h4 class="sidebar-heading"><?php _e('Roles');?></h4>
                                <ul class="recentpost-contentwrap">
                                    <?php foreach ($post_roles as $role): ?>
                                    <?php
print_r("<li><a href='/blog/?_roles={$role->slug}'>{$role->name}</a></li>");
endforeach;?>
                                </ul>
                            </div>
                            <?php endif;?>
                            <div class="recent-posts">
                                <h4 class="sidebar-heading"><?php _e('You Might Also Like');?></h4>
                                <div class="recentpost-contentwrap">
                                    <?php foreach ($recent_posts as $post): ?>
                                    <?php
printf('<p><a href="%1$s">%2$s</a></p>',
    esc_url(get_permalink($post['ID'])),
    apply_filters('the_title', $post['post_title'], $post['ID'])
);
endforeach;?>
                                </div>
                            </div>
                            <?php wp_reset_query();?>
                            <!--End Most recent post show code-->
                        </aside>
                    </div>
                </div>
            </section>
        </article>
    </main>
</div>
<?php endwhile;
get_footer();
