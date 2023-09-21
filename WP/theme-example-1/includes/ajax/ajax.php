<?php function show_posts() {
    if (isset($_GET) && !empty($_GET)) {
        $formData = $_GET;
        $termsId = $formData['form_data']['application[term'];
        $parentTax = $formData['form_data']['input-parent-tax'];
        $tax = $formData['form_data']['input-tax'];
        $termsArr = [];
        $cat = $formData['form_data']['category'] !== 'all-posts' ? (int) $formData['form_data']['category'] : $formData['form_data']['category'];
        $args = '';
        // Buttons fields
        $loadMoreBtn = get_field('rd_load_more', 'options');
        $watchNowBtn = get_field('rd_watch_webinar', 'options');
        $watchWebinarBtn = get_field('rd_master_class', 'options');
        $registerWebinar = get_field('rd_register', 'options');
        $watchVideo = get_field('rd_watch_video', 'options');
        // Webinar master class card
        $mcUl = 'mc_card_body_content';
        $mcSubtitleDefault = get_field('rd_mc_subttl_default', 'options');
        $mcBodytitleDefault = get_field('rd_mc_card_body_title_default', 'options');
        // Video card
        $publishVideo = get_field('rd_vc_card_publish', 'options');
        $viewVideo = get_field('rd_vc_card_view', 'options');

        foreach ($termsId as $term) {
            $termsArr[] = (int) $term;
        };

        if (!empty($termsArr)) {
            $args = [
                'post_type' => $formData['form_data']['input-post'],
                'post_status'=> 'publish',
                'posts_per_page' => $formData['form_data']['input-post-pages'],
                'paged' => $formData['paged'],
                'order' => $formData['form_data']['select-input'],
                'tax_query' => [
                    'relation' => 'AND',
                    ['taxonomy' => $parentTax,
                        'field' => 'term_id',
                        'terms' => $cat
                    ],
                    ['taxonomy' => $tax,
                        'field' => 'term_id',
                        'terms' => $termsArr
                    ]
                ],
            ];
        } elseif (empty($termsArr)) {
            $args = [
                'post_type' => $formData['form_data']['input-post'],
                'post_status'=> 'publish',
                'posts_per_page' => $formData['form_data']['input-post-pages'],
                'paged' => $formData['paged'],
                'order' => $formData['form_data']['select-input'],
                'tax_query' => [
                ['taxonomy' => $parentTax,
                    'field' => 'term_id',
                    'terms' => $cat
                    ]
                ],
            ];
        }; 
        
        if ($cat == 'all-posts' && empty($termsArr)) {
            $args = [
                'post_type' => $formData['form_data']['input-post'],
                'post_status'=> 'publish',
                'posts_per_page' => $formData['form_data']['input-post-pages'],
                'paged' => $formData['paged'],
                'order' => $formData['form_data']['select-input'],
            ];
        } elseif ($cat == 'all-posts' && !empty($termsArr)) {
            $args = [
                'post_type' => $formData['form_data']['input-post'],
                'post_status'=> 'publish',
                'posts_per_page' => $formData['form_data']['input-post-pages'],
                'paged' => $formData['paged'],
                'order' => $formData['form_data']['select-input'],
                'tax_query' => [
                    ['taxonomy' => $tax,
                        'field' => 'term_id',
                        'terms' => $termsArr
                    ]
                ],
            ];
        };
    
        $query = new WP_Query($args);
        $max_pages = $query->max_num_pages;

        ob_start();
    
        if($query->found_posts) {
            while ($query->have_posts()): $query->the_post();
                if ($parentTax == 'webinar_parent_category'):
                    $author_id = get_the_author_meta('ID');
                    $thisTerm = wp_get_post_terms(get_the_ID(), $parentTax, array('fields' => 'all'));
                    if ($thisTerm[0]->slug !== 'master-class-webinar' && $thisTerm[0]->slug !== 'videocontent'):
                        // Other webinar card
                        $wbText = get_field('rd_wc_text');
                        $authorCheck = get_field('rd_wc_check');
                        $authorWebinar = get_field('rd_wc_author');
                        $authorPhoto = get_field('rd_wc_author_photo');
                        $webinarDate = get_field('rd_wc_date');
                        $webinarDateSet = get_field('rd_wc_date_set'); ?>
                        <article class="webinar-card webinar-card-video">
                            <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty(get_the_post_thumbnail())):
                                    echo get_the_post_thumbnail(); ?>
                                <?php else: ?>
                                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/placeholder.png" alt="Placeholder">
                                <?php endif;
                                if (!empty($webinarDate)): ?>
                                    <div class="date-wrapper">
                                        <time class="created-post-time" datetime="<?php echo $webinarDate; ?>">
                                            <?php if (!empty($webinarDate)): echo $webinarDate; endif;
                                            if (!empty($webinarDateSet)): ?>
                                                <span>
                                                    <?php echo ' '.$webinarDateSet; ?>
                                                </span>
                                            <?php endif; ?>
                                        </time>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="webinar-card-body">
                                <?php if ($authorCheck[0] !== 'hide'):
                                    if (!empty($authorWebinar) || !empty($authorPhoto)): ?>
                                        <div class="author-wrapper">
                                            <?php if (!empty($authorWebinar)): ?>
                                                <span class="author-name"><?php echo $authorWebinar; ?></span>
                                            <?php endif;
                                            if (!empty($authorPhoto)): ?>
                                                <span class="author-img">
                                                    <img src="<?php echo esc_url($authorPhoto['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($authorPhoto['alt']); ?>">
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <hr>
                                <?php endif;
                                if (!empty(get_the_title())): ?>
                                    <div class="post-title-wrapper">
                                        <h3 class="post-title"><?php the_title(); ?></h3>
                                    </div>
                                <?php endif;
                                if (!empty($wbText)): ?>
                                    <div class="post-content-wrapper">
                                        <span class="post-content"><?php echo $wbText; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="webinar-card-footer">
                                <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                    <?php if (!empty($watchNowBtn)): ?>
                                        <span class="btn-text"><?php echo $watchNowBtn; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </article>
                    <?php elseif ($thisTerm[0]->slug == 'videocontent'):
                        // Webinar video card
                        $videoCardImg = get_field('video_card_img');
                        $videoCardTxt = get_field('video_card_text');
                        $viewNum = get_field('rd_vc_view_num');
                        $timeVideo = get_field('rd_vc_time_video');
                        $wbText = get_field('rd_wc_text');
                        $authorCheck = get_field('rd_wc_check');
                        $authorWebinar = get_field('rd_wc_author');
                        $authorPhoto = get_field('rd_wc_author_photo'); ?>
                        <article class="webinar-card video-card video-card-webinar">
                            <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty(get_the_post_thumbnail())):
                                    echo get_the_post_thumbnail(); ?>
                                <?php else: ?>
                                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/placeholder.png" alt="Placeholder">
                                <?php endif;
                                if (!empty($timeVideo)): ?>
                                    <div class="time-code">
                                        <span><?php echo $timeVideo; ?></span>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="webinar-card-body">
                                <?php if ($authorCheck[0] !== 'hide'):
                                    if (!empty($authorWebinar) || !empty($authorPhoto)): ?>
                                        <div class="author-wrapper">
                                            <?php if (!empty($authorWebinar)): ?>
                                                <span class="author-name"><?php echo $authorWebinar; ?></span>
                                            <?php endif;
                                            if (!empty($authorPhoto)): ?>
                                                <span class="author-img">
                                                    <img src="<?php echo esc_url($authorPhoto['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($authorPhoto['alt']); ?>">
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <hr>
                                <?php endif;
                                if (!empty(get_the_title())): ?>
                                    <div class="post-title-wrapper">
                                        <h3 class="post-title"><?php the_title(); ?></h3>
                                    </div>
                                <?php endif;
                                if (!empty($videoCardTxt)): ?>
                                    <div class="post-content-wrapper">
                                        <span class="post-content"><?php echo $videoCardTxt; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($viewNum) || !empty(get_the_date())): ?>
                                <div class="views-publish-wrapper">
                                    <div class="views-publish">
                                        <?php if (!empty($viewNum)): ?>
                                            <div class="views-block">
                                                <?php if (!empty($viewVideo)): ?>
                                                    <span class="up-case"><?php echo $viewVideo; ?>&nbsp;</span>
                                                <?php endif; ?>
                                                <span><?php echo $viewNum; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty(get_the_date())): ?>
                                            <div class="date-wrapper">
                                                <time class="created-post-time" datetime="<?php echo get_the_date(); ?>"><?php echo $publishVideo; ?>&nbsp;<?php echo get_the_date(); ?></time>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="webinar-card-footer">
                                <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                    <?php if (!empty($watchWebinarBtn)): ?>
                                        <span class="btn-text"><?php echo $watchWebinarBtn; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </article>
                    <?php elseif ($thisTerm[0]->slug == 'master-class-webinar'):
                        // Webinar master class card
                        $mcBodytitle = get_field('mc_card_body_title');
                        $mcSubtitle = get_field('mc_card_subtitle');
                        $mcButtonText = get_field('wm_card_btn');
                        $authorCheck = get_field('rd_wc_check');
                        $authorWebinar = get_field('rd_wc_author');
                        $authorPhoto = get_field('rd_wc_author_photo');
                        $webinarDate = get_field('rd_wc_date');
                        $webinarDateSet = get_field('rd_wc_date_set'); ?>
                        <article class="webinar-card webinar-card-master-class">
                            <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty(get_the_title())): ?>
                                    <p class="post-title-master-class"><?php the_title(); ?></p>
                                <?php endif;
                                if (!empty($mcSubtitle)): ?>
                                    <p class="post-subtitle-master-class"><?php echo $mcSubtitle; ?></p>
                                <?php else: ?>
                                    <p class="post-subtitle-master-class"><?php echo $mcSubtitleDefault; ?></p>
                                <?php endif;
                                if (!empty($webinarDate)): ?>
                                    <div class="date-wrapper">
                                        <time class="created-post-time" datetime="<?php echo $webinarDate; ?>">
                                            <?php if (!empty($webinarDate)): echo $webinarDate; endif;
                                            if (!empty($webinarDateSet)): ?>
                                                <span>
                                                    <?php echo ' '.$webinarDateSet; ?>
                                                </span>
                                            <?php endif; ?>
                                        </time>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="webinar-card-body">
                                <?php if ($authorCheck[0] !== 'hide'):
                                    if (!empty($authorWebinar) || !empty($authorPhoto)): ?>
                                        <div class="author-wrapper">
                                            <?php if (!empty($authorWebinar)): ?>
                                                <span class="author-name"><?php echo $authorWebinar; ?></span>
                                            <?php endif;
                                            if (!empty($authorPhoto)): ?>
                                                <span class="author-img">
                                                    <img src="<?php echo esc_url($authorPhoto['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($authorPhoto['alt']); ?>">
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <hr>
                                <?php endif;
                                if (!empty($mcBodytitle) && $mcBodytitle !== 'false'): ?>
                                    <div class="post-title-wrapper">
                                        <h3 class="post-title"><?php echo $mcBodytitle; ?></h3>
                                    </div>
                                <?php endif;
                                if (have_rows('mc_card_body_content')): ?>
                                    <div class="post-content-wrapper">
                                        <ul class="ul-master-class">
                                            <?php while (have_rows('mc_card_body_content')):
                                                the_row();
                                                $li = get_sub_field('mc_list_item'); ?>
                                                <li class="li-master-class"><?php echo $li; ?></li>
                                            <?php endwhile; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="webinar-card-footer">
                                <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                    <?php if (!empty($mcButtonText) && $mcButtonText == 'register'): ?>
                                        <span class="btn-text"><?php echo $registerWebinar; ?></span>
                                    <?php elseif (!empty($mcButtonText) && $mcButtonText == 'watch'): ?>
                                        <span class="btn-text"><?php echo $watchWebinarBtn; ?></span>
                                    <?php else: ?>
                                        <span class="btn-text"><?php echo $watchNowBtn; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php else:
                    // Video card
                    $videoCardImg = get_field('video_card_img');
                    $videoCardTxt = get_field('video_card_text');
                    $viewNum = get_field('rd_vc_view_num');
                    $timeVideo = get_field('rd_vc_time_video');
                    $wbText = get_field('rd_wc_text'); ?>
                    <article class="webinar-card video-card">
                        <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                            <?php if (!empty(get_the_post_thumbnail())):
                                echo get_the_post_thumbnail(); ?>
                            <?php else: ?>
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/placeholder.png" alt="Placeholder">
                            <?php endif;
                            if (!empty($timeVideo)): ?>
                                <div class="time-code">
                                    <span><?php echo $timeVideo; ?></span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="webinar-card-body">
                            <?php if (!empty(get_the_title())): ?>
                                <div class="post-title-wrapper">
                                    <h3 class="post-title"><?php the_title(); ?></h3>
                                </div>
                            <?php endif;
                            if (!empty($videoCardTxt)): ?>
                                <div class="post-content-wrapper">
                                    <span class="post-content"><?php echo $videoCardTxt; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($viewNum) || !empty(get_the_date())): ?>
                            <div class="views-publish-wrapper">
                                <div class="views-publish">
                                    <?php if (!empty($viewNum)): ?>
                                        <div class="views-block">
                                            <?php if (!empty($viewVideo)): ?>
                                                <span class="up-case"><?php echo $viewVideo; ?>&nbsp;</span>
                                            <?php endif; ?>
                                            <span><?php echo $viewNum; ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty(get_the_date())): ?>
                                        <div class="date-wrapper">
                                            <time class="created-post-time" datetime="<?php echo get_the_date(); ?>"><?php echo $publishVideo; ?>&nbsp;<?php echo get_the_date(); ?></time>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="webinar-card-footer">
                            <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty($watchVideo)): ?>
                                    <span class="btn-text"><?php echo $watchVideo; ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    </article>
                <?php endif;
            endwhile;
            wp_reset_postdata();
        };

        $result = ['html' => ob_get_contents(), 'max_pages' => $max_pages];
        ob_end_clean();
        print_r(json_encode($result));

        die();
    };
};

add_action('wp_ajax_show_posts', 'show_posts');
add_action('wp_ajax_nopriv_show_posts', 'show_posts');

function show_search_result() {
    $numResults = $_GET['num'];
    $maxReluts = 0;
    // Buttons fields
    $loadMoreBtn = get_field('rd_load_more', 'options');
    $watchNowBtn = get_field('rd_watch_webinar', 'options');
    $watchWebinarBtn = get_field('rd_master_class', 'options');
    $registerWebinar = get_field('rd_register', 'options');
    $watchVideo = get_field('rd_watch_video', 'options');
    // Webinar master class card
    $mcUl = 'mc_card_body_content';
    $mcSubtitleDefault = get_field('rd_mc_subttl_default', 'options');
    $mcBodytitleDefault = get_field('rd_mc_card_body_title_default', 'options');
    // Video card
    $publishVideo = get_field('rd_vc_card_publish', 'options');
    $viewVideo = get_field('rd_vc_card_view', 'options');

    $args = ['posts_per_page' => -1,
                's' => $_GET['request'],
                'post_type' => $_GET['post'],
                'post_status'=> 'publish',
            ];
    $the_query = new WP_Query($args);

    ob_start();
    if ($numResults > -1):
        if($the_query->have_posts()):
            while($the_query->have_posts()): $the_query->the_post();
                if ($maxReluts < $numResults): ?>
                    <a class="result-block" href="<?php echo get_permalink(); ?>" target="_blank">
                        <?php if (!empty(get_the_post_thumbnail())): ?>
                            <span class="result-block-img">
                                <?php echo get_the_post_thumbnail(); ?>
                            </span>
                        <?php else: ?>
                            <span class="result-block-img">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/placeholder.png" alt="Placeholder">
                            </span>
                        <?php endif; ?>
                        <span class="result-block-text"><?php the_title(); ?></span>
                    </a>
                <?php endif;
                $maxReluts++;
            endwhile;
            wp_reset_postdata();  
        endif;
    else:
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()): $the_query->the_post();
                $parentTax = get_post_taxonomies();
                if ($parentTax == 'webinar_parent_category'):
                    $author_id = get_the_author_meta('ID');
                    $thisTerm = wp_get_post_terms(get_the_ID(), $parentTax, array('fields' => 'all'));
                    if ($thisTerm[0]->slug !== 'master-class-webinar' && $thisTerm[0]->slug !== 'videocontent'):
                        // Other webinar card
                        $wbText = get_field('rd_wc_text');
                        $authorCheck = get_field('rd_wc_check');
                        $authorWebinar = get_field('rd_wc_author');
                        $authorPhoto = get_field('rd_wc_author_photo');
                        $webinarDate = get_field('rd_wc_date');
                        $webinarDateSet = get_field('rd_wc_date_set'); ?>
                        <article class="webinar-card webinar-card-video">
                            <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty(get_the_post_thumbnail())):
                                    echo get_the_post_thumbnail(); ?>
                                <?php else: ?>
                                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/placeholder.png" alt="Placeholder">
                                <?php endif;
                                if (!empty($webinarDate)): ?>
                                    <div class="date-wrapper">
                                        <time class="created-post-time" datetime="<?php echo $webinarDate; ?>">
                                            <?php if (!empty($webinarDate)): echo $webinarDate; endif;
                                            if (!empty($webinarDateSet)): ?>
                                                <span>
                                                    <?php echo ' '.$webinarDateSet; ?>
                                                </span>
                                            <?php endif; ?>
                                        </time>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="webinar-card-body">
                                <?php if ($authorCheck[0] !== 'hide'):
                                    if (!empty($authorWebinar) || !empty($authorPhoto)): ?>
                                        <div class="author-wrapper">
                                            <?php if (!empty($authorWebinar)): ?>
                                                <span class="author-name"><?php echo $authorWebinar; ?></span>
                                            <?php endif;
                                            if (!empty($authorPhoto)): ?>
                                                <span class="author-img">
                                                    <img src="<?php echo esc_url($authorPhoto['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($authorPhoto['alt']); ?>">
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <hr>
                                <?php endif;
                                if (!empty(get_the_title())): ?>
                                    <div class="post-title-wrapper">
                                        <h3 class="post-title"><?php the_title(); ?></h3>
                                    </div>
                                <?php endif;
                                if (!empty($wbText)): ?>
                                    <div class="post-content-wrapper">
                                        <span class="post-content"><?php echo $wbText; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="webinar-card-footer">
                                <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                    <?php if (!empty($watchNowBtn)): ?>
                                        <span class="btn-text"><?php echo $watchNowBtn; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </article>
                    <?php elseif ($thisTerm[0]->slug == 'videocontent'):
                        // Webinar video card
                        $videoCardImg = get_field('video_card_img');
                        $videoCardTxt = get_field('video_card_text');
                        $viewNum = get_field('rd_vc_view_num');
                        $timeVideo = get_field('rd_vc_time_video');
                        $wbText = get_field('rd_wc_text');
                        $authorCheck = get_field('rd_wc_check');
                        $authorWebinar = get_field('rd_wc_author');
                        $authorPhoto = get_field('rd_wc_author_photo'); ?>
                        <article class="webinar-card video-card video-card-webinar">
                            <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty(get_the_post_thumbnail())):
                                    echo get_the_post_thumbnail(); ?>
                                <?php else: ?>
                                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/placeholder.png" alt="Placeholder">
                                <?php endif;
                                if (!empty($timeVideo)): ?>
                                    <div class="time-code">
                                        <span><?php echo $timeVideo; ?></span>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="webinar-card-body">
                                <?php if ($authorCheck[0] !== 'hide'):
                                    if (!empty($authorWebinar) || !empty($authorPhoto)): ?>
                                        <div class="author-wrapper">
                                            <?php if (!empty($authorWebinar)): ?>
                                                <span class="author-name"><?php echo $authorWebinar; ?></span>
                                            <?php endif;
                                            if (!empty($authorPhoto)): ?>
                                                <span class="author-img">
                                                    <img src="<?php echo esc_url($authorPhoto['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($authorPhoto['alt']); ?>">
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <hr>
                                <?php endif;
                                if (!empty(get_the_title())): ?>
                                    <div class="post-title-wrapper">
                                        <h3 class="post-title"><?php the_title(); ?></h3>
                                    </div>
                                <?php endif;
                                if (!empty($videoCardTxt)): ?>
                                    <div class="post-content-wrapper">
                                        <span class="post-content"><?php echo $videoCardTxt; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($viewNum) || !empty(get_the_date())): ?>
                                <div class="views-publish-wrapper">
                                    <div class="views-publish">
                                        <?php if (!empty($viewNum)): ?>
                                            <div class="views-block">
                                                <?php if (!empty($viewVideo)): ?>
                                                    <span class="up-case"><?php echo $viewVideo; ?>&nbsp;</span>
                                                <?php endif; ?>
                                                <span><?php echo $viewNum; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty(get_the_date())): ?>
                                            <div class="date-wrapper">
                                                <time class="created-post-time" datetime="<?php echo get_the_date(); ?>"><?php echo $publishVideo; ?>&nbsp;<?php echo get_the_date(); ?></time>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="webinar-card-footer">
                                <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                    <?php if (!empty($watchWebinarBtn)): ?>
                                        <span class="btn-text"><?php echo $watchWebinarBtn; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </article>
                    <?php elseif ($thisTerm[0]->slug == 'master-class-webinar'):
                        // Webinar master class card
                        $mcBodytitle = get_field('mc_card_body_title');
                        $mcSubtitle = get_field('mc_card_subtitle');
                        $mcButtonText = get_field('wm_card_btn');
                        $authorCheck = get_field('rd_wc_check');
                        $authorWebinar = get_field('rd_wc_author');
                        $authorPhoto = get_field('rd_wc_author_photo');
                        $webinarDate = get_field('rd_wc_date');
                        $webinarDateSet = get_field('rd_wc_date_set'); ?>
                        <article class="webinar-card webinar-card-master-class">
                            <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty(get_the_title())): ?>
                                    <p class="post-title-master-class"><?php the_title(); ?></p>
                                <?php endif;
                                if (!empty($mcSubtitle)): ?>
                                    <p class="post-subtitle-master-class"><?php echo $mcSubtitle; ?></p>
                                <?php else: ?>
                                    <p class="post-subtitle-master-class"><?php echo $mcSubtitleDefault; ?></p>
                                <?php endif;
                                if (!empty($webinarDate)): ?>
                                    <div class="date-wrapper">
                                        <time class="created-post-time" datetime="<?php echo $webinarDate; ?>">
                                            <?php if (!empty($webinarDate)): echo $webinarDate; endif;
                                            if (!empty($webinarDateSet)): ?>
                                                <span>
                                                    <?php echo ' '.$webinarDateSet; ?>
                                                </span>
                                            <?php endif; ?>
                                        </time>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="webinar-card-body">
                                <?php if ($authorCheck[0] !== 'hide'):
                                    if (!empty($authorWebinar) || !empty($authorPhoto)): ?>
                                        <div class="author-wrapper">
                                            <?php if (!empty($authorWebinar)): ?>
                                                <span class="author-name"><?php echo $authorWebinar; ?></span>
                                            <?php endif;
                                            if (!empty($authorPhoto)): ?>
                                                <span class="author-img">
                                                    <img src="<?php echo esc_url($authorPhoto['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($authorPhoto['alt']); ?>">
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <hr>
                                <?php endif;
                                if (!empty($mcBodytitle) && $mcBodytitle !== 'false'): ?>
                                    <div class="post-title-wrapper">
                                        <h3 class="post-title"><?php echo $mcBodytitle; ?></h3>
                                    </div>
                                <?php endif;
                                if (have_rows('mc_card_body_content')): ?>
                                    <div class="post-content-wrapper">
                                        <ul class="ul-master-class">
                                            <?php while (have_rows('mc_card_body_content')):
                                                the_row();
                                                $li = get_sub_field('mc_list_item'); ?>
                                                <li class="li-master-class"><?php echo $li; ?></li>
                                            <?php endwhile; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="webinar-card-footer">
                                <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                    <?php if (!empty($mcButtonText) && $mcButtonText == 'register'): ?>
                                        <span class="btn-text"><?php echo $registerWebinar; ?></span>
                                    <?php elseif (!empty($mcButtonText) && $mcButtonText == 'watch'): ?>
                                        <span class="btn-text"><?php echo $watchWebinarBtn; ?></span>
                                    <?php else: ?>
                                        <span class="btn-text"><?php echo $watchNowBtn; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php else:
                    // Video card
                    $videoCardImg = get_field('video_card_img');
                    $videoCardTxt = get_field('video_card_text');
                    $viewNum = get_field('rd_vc_view_num');
                    $timeVideo = get_field('rd_vc_time_video');
                    $wbText = get_field('rd_wc_text'); ?>
                    <article class="webinar-card video-card">
                        <a class="webinar-card-head" href="<?php echo get_permalink(); ?>">
                            <?php if (!empty(get_the_post_thumbnail())):
                                echo get_the_post_thumbnail(); ?>
                            <?php else: ?>
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/placeholder.png" alt="Placeholder">
                            <?php endif;
                            if (!empty($timeVideo)): ?>
                                <div class="time-code">
                                    <span><?php echo $timeVideo; ?></span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="webinar-card-body">
                            <?php if (!empty(get_the_title())): ?>
                                <div class="post-title-wrapper">
                                    <h3 class="post-title"><?php the_title(); ?></h3>
                                </div>
                            <?php endif;
                            if (!empty($videoCardTxt)): ?>
                                <div class="post-content-wrapper">
                                    <span class="post-content"><?php echo $videoCardTxt; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($viewNum) || !empty(get_the_date())): ?>
                            <div class="views-publish-wrapper">
                                <div class="views-publish">
                                    <?php if (!empty($viewNum)): ?>
                                        <div class="views-block">
                                            <?php if (!empty($viewVideo)): ?>
                                                <span class="up-case"><?php echo $viewVideo; ?>&nbsp;</span>
                                            <?php endif; ?>
                                            <span><?php echo $viewNum; ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty(get_the_date())): ?>
                                        <div class="date-wrapper">
                                            <time class="created-post-time" datetime="<?php echo get_the_date(); ?>"><?php echo $publishVideo; ?>&nbsp;<?php echo get_the_date(); ?></time>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="webinar-card-footer">
                            <a class="btn post-card-btn" href="<?php echo get_permalink(); ?>">
                                <?php if (!empty($watchVideo)): ?>
                                    <span class="btn-text"><?php echo $watchVideo; ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    </article>
                <?php endif;
            endwhile;
            wp_reset_postdata();
        };
    endif;

    $result = ['html' => ob_get_contents(), 'max' => $maxReluts];
    ob_end_clean();
    print_r(json_encode($result));

    die();
}

add_action('wp_ajax_show_search_result', 'show_search_result');
add_action('wp_ajax_nopriv_show_search_result', 'show_search_result');