<?php
add_shortcode("application-pages", "show_application_pages");

function show_application_pages($atts)
{
    $atts = shortcode_atts([
        'title' => '',
    ], $atts);

    ob_start();
    $args = [
        'posts_per_page' => -1,
        'post_type' => APP_PAGE_POST_TYPE,
    ];
    $query = new WP_Query;
    $posts = $query->query($args);
    $page_data = get_page_by_path('application-pages');
    ?>
    <?php if (is_front_page()): ?>
    <section class="copy-block-section">
        <?= $atts['title'] === '' ? "<h1>$page_data->post_title</h1>" : "<h2>{$atts['title']}</h2>" ?>
        <div class="copy-block-text">
            <?= apply_filters('the_content', $page_data->post_content) ?>
        </div>
    </section>
<?php endif; ?>
    <section class="application-pages-section">
        <div class="application-pages-list">
            <?php foreach ($posts as $post): ?>
                <a class="app-card" href="<?= @get_post_custom_values('cmt_app_page_btn_link', $post->ID)[0] ?>"
                   target="_blank">
                    <div class="app-image-container" style="background: url('<?=get_the_post_thumbnail_url($post->ID)?>')">
                    </div>
                    <div class="app-title">
                        <p><?= $post->post_title ?></p>
                    </div>
                    <div class="app-btn-container">
                        <?php $btn_text = @get_post_custom_values('cmt_app_page_btn_text', $post->ID)[0]; if($btn_text!==''): ?>
                            <div class="btn"><?= $btn_text ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
    wp_enqueue_script('search-integrations',get_template_directory_uri().'/assets/js/search-integrations.js',['cmt-jquery'],false,true);
    return ob_get_clean();
}
