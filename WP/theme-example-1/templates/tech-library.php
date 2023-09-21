<?php
/**
 * Template Name: Blog List
 */
?>

<?php get_header(); ?>
<?php
$category = get_terms([
    'taxonomy'   => 'category',
    'hide_empty' => true,
]);
?>
<section class="technical-library">
    <h1><?=get_the_title()?></h1>
</section>

<section class="posts">
    <div class="container">
        <div class="form-wrap">
        <div class="input-search__wrap">
            <input type="text" name="search-faqs" placeholder="Search" id="search-blog-post"/>
            <span class="clear-icon"></span>
            <span class="search-icon"></span>
        </div>
        <select id="selectField" class="tech-category-filter">
            <option selected disabled value="">Choose category</option>
            <option value="">All</option>
            <?php foreach ($category as $cat): ?>
                <option value="<?= $cat->slug ?>"><?= $cat->name ?></option>
            <?php endforeach; ?>
        </select>
        </div>
        <div class="posts__products" id="posts__products">
            <?php
            $posts_per_page = -1;
            $args = [
                'posts_per_page' => $posts_per_page,
                'post_type' => 'post',

            ];
            $query = new WP_Query;
            $posts = $query->query($args); ?>
            <?php foreach ($posts as $post): ?>
                <div class="product-preview product-preview--posts" id="product-preview">
                    <div class="image-block">
                        <?php $product_preview = get_the_post_thumbnail_url($post->ID, 'product-preview'); ?>
                        <img src="<?= $product_preview ? $product_preview : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                             alt="Image">
                    </div>
                    <div class="product-preview__text">
                        <div class="product-preview__wrap">
                            <p class="product-preview__title"><?= the_title() ?></p>
                            <p class="product-preview__description"><?= get_the_date() ?></p>
                        </div>
                        <div class="hover-block hover-block--posts">
                            <div class="hover-block__text">
                                <div>
                                    <p class="blog-short-description"><?= get_post_custom_values('blog_description', $post->ID)[0] ?></p>
                                </div>
                            </div>
                            <a href="<?= get_permalink($post->ID) ?>" class="hover-block__link btn">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <input type="hidden" value="<?= count($posts); ?>" class="posts-count"/>
    </div>
</section>

<?php
wp_enqueue_script('cmt-search-blog-posts',get_template_directory_uri().'/assets/js/blog-posts-search.js',['cmt-jquery'],false,true);
get_footer(); ?>
