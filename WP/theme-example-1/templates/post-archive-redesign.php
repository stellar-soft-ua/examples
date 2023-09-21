<?php
/**
 * Template Name: RD Post Archive
 */
?>

<?php get_header();
    // Page id
    global $post;
    $id = $post->ID;
    // Posts params
    $defaultVideoCat = get_field('default_video_cat', 'options');
    $tax = get_field('child_taxanomy', $id);
    $parentTax = get_field('parent_taxanomy', $id);
    $post = get_field('post_archive', $id);
    $postsPerPage;
    $posperPageMob = get_field('post_per_page_num_mob', $id);
    $postsPerPageDesk = get_field('post_per_page_num', $id);
    $defaultTax = 'all-posts';
    $in = 0;
    if (wp_is_mobile()) {
        $postsPerPage = $posperPageMob;
    } else {
        $postsPerPage = $postsPerPageDesk;
    };
    // Buttons fields
    $loadMoreBtn = get_field('rd_load_more', 'options');
    $watchNowBtn = get_field('rd_watch_webinar', 'options');
    $watchWebinarBtn = get_field('rd_master_class', 'options');
    $registerWebinar = get_field('rd_register', 'options');
    $watchVideo = get_field('rd_watch_video', 'options');
    $resetSearch = get_field('rd_reset_search', 'options');
    // Select fields
    $select1 = get_field('rd_select_text_asc', 'options');
    $select1Attr = get_field('rd_select_attr_asc', 'options');
    $select2 = get_field('rd_select_text_desc', 'options');
    $select2Attr = get_field('rd_select_attr_desc', 'options');
    $sortBy = get_field('rd_select_sort_text', 'options');
    // Search form fields
    $searchPh = get_field('rd_search_placeholder', $id);
    $searcText = get_field('rd_search_text', 'options');
    $searcTextResult = get_field('rd_search_text_result', 'options');
    // Filters form fields
    $filterBtn = get_field('rd_filter_form_button', 'options');
    $filterSubmitBtn = get_field('rd_filter_form_submit', 'options');
    $parCatHead = get_field('rd_parent_webinars_header', $id);
    // Webinar master class card
    $mcUl = 'mc_card_body_content';
    $mcSubtitleDefault = get_field('rd_mc_subttl_default', 'options');
    $mcBodytitleDefault = get_field('rd_mc_card_body_title_default', 'options');
    // Video card
    $publishVideo = get_field('rd_vc_card_publish', 'options');
    $viewVideo = get_field('rd_vc_card_view', 'options');
    // Header
    $tmplHeader = get_field('rd_archive_title', $id);
    // locale fields
    $usaLocale = get_field('rd_usa_locale', 'options');
    $espLocale = get_field('rd_esp_locale', 'options');
    $chiLocale = get_field('rd_chi_locale', 'options');
    // tooltip
    $tooltip = [];
    $tooltipText = get_field('tooltip_txt', 'options');
?>
    <section class="archive-section">
        <?php if (get_locale() == 'en_US'): ?>
            <div class="locale-lang-wrapper">
                <img src="<?php echo esc_url($usaLocale['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($usaLocale['alt']); ?>"/>
            </div>
        <?php elseif (get_locale() == 'es_ES'): ?>
            <div class="locale-lang-wrapper">
                <img src="<?php echo esc_url($espLocale['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($espLocale['alt']); ?>"/>
            </div>
        <?php elseif (get_locale() == 'zh_CN'): ?>
            <div class="locale-lang-wrapper">
                <img src="<?php echo esc_url($chiLocale['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($chiLocale['alt']); ?>"/>
            </div>
        <?php endif; ?>
        <div class="archive-container">
            <?php if (!empty($tmplHeader)): ?>
                <div class="title-wrapper">
                    <h1 class="h1"><?php echo $tmplHeader; ?></h1>
                </div>
            <?php endif; ?>
            <div class="posts-wrapper">
                <div class="posts-archive-wrap">
                    <div class="posts-archive-body">
                        <div class="form-filter-wrap" id="form-filter-wrap">
                            <form class="form-filter" id="form-filter" action="GET">
                                <div class="form-filter-head-body-wrap">
                                    <?php if (!empty($filterBtn)): ?>
                                        <div class="form-filter-head">
                                            <button class="filter-close-btn" id="filter-close-btn" type="button" aria-label="Filter close button">
                                                <span><?php echo $filterBtn; ?></span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-filter-body">
                                    <?php $parentTermArgs = ['taxonomy' => $parentTax,
                                                            'hide_empty' => false,
                                                            'order' => 'DESC'
                                                            ];

                                        $parTerms = get_terms($parentTermArgs); ?>
                                        <div class="filter-block">
                                            <?php if (!empty($filterBtn)): ?>
                                                <div class="filter-block-title-wrap">
                                                    <span class="filter-block-title"><?php echo $parCatHead; ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="filter-block-content radio-btn-wrap">
                                                <?php if ($parentTax == 'video_parent_category'): ?>
                                                    <div class="filter-label-wrap">
                                                        <label class="filter-label">
                                                            <input data-radio="all-posts" value="all-posts" type="radio" name="category">
                                                            <span class="radio-checkmark"></span>
                                                            <span class="filter-label-text"><?php echo $defaultVideoCat; ?></span>
                                                        </label>
                                                    </div>
                                                <?php endif;
                                                foreach($parTerms as $parTerm):
                                                    $tooltipTxt = get_field('tooltip_content', $parTerm, $parTerm->term_id); ?>
                                                    <div class="filter-label-wrap">
                                                        <label class="filter-label">
                                                            <input data-radio="<?php echo  $parTerm->name; ?>" value="<?php echo  $parTerm->term_id; ?>" type="radio" name="category">
                                                            <span class="radio-checkmark"></span>
                                                            <span class="filter-label-text"><?php echo $parTerm->name; ?></span>
                                                        </label>
                                                        <?php if (!empty($tooltipTxt)):
                                                            $arr = [
                                                                'id' => $parTerm->term_id,
                                                                'cont' => $tooltipTxt
                                                            ];
                                                            $tooltip[] = $arr; ?>
                                                            <span class="tooltip" data-id="<?php echo $parTerm->term_id; ?>">
                                                                <?php $svg_markup = file_get_contents(get_attached_file($tooltipText['ID']));
                                                                echo $svg_markup; ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach;
                                                $jsonTooltip = json_encode($tooltip); ?>
                                            </div>
                                        </div>
                                        <div class="filter-block-accordion-wrap">
                                            <?php $termArgs = ['taxonomy' => $tax,
                                                            'hide_empty' => false,
                                                            'orderby' => 'none',
                                                          ];

                                            $terms = get_terms($termArgs);

                                            foreach($terms as $term):
                                                $term_childs = get_term_children($term->term_id, $term->taxonomy);

                                                if (isset($term_childs) && !empty($term_childs)): ?>
                                                    <div class="filter-block filter-block-accordion">
                                                        <div class="filter-block-accordion-head filter-block-title-wrap">
                                                            <span class="filter-block-title"><?php echo $term->name; ?>:</span>
                                                        </div>
                                                        <div class="filter-block-accordion-body-wrap">
                                                            <div class="filter-block-accordion-body filter-block-content">
                                                                <?php foreach($term_childs as $child): $in++;
                                                                $term = get_term_by('ID', $child, $term->taxonomy); ?>
                                                                    <div class="filter-label-wrap">
                                                                        <label class="filter-label">
                                                                            <input data-checkbox="<?php echo  $term->name; ?>" type="checkbox" value="<?php echo  $child; ?>" name="application[term][<?php echo $in ?>]">
                                                                            <span class="checkbox-checkmark"></span>
                                                                            <span class="filter-label-text"><?php echo $term->name; ?></span>
                                                                        </label>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($filterSubmitBtn)): ?>
                                    <div class="form-filter-footer">
                                        <button class="btn apply-filter-btn" type="button" id="apply-btn">
                                            <span class="btn-text"><?php echo $filterSubmitBtn; ?></span>
                                        </button>
                                    </div>
                                <?php endif;
                                if (!empty($select1) || !empty($select2) || !empty($select1Attr) || !empty($select2Attr)): ?>
                                    <select class="filter-select" name="select-input" id="select-input" style="display: none;">
                                        <?php if (!empty($select2) && !empty($select2Attr)): ?>
                                            <option class="filter-option" data-option="<?php echo $select2Attr; ?>" value="<?php echo $select2Attr; ?>"><?php echo $select2; ?></option>
                                        <?php endif;
                                        if (!empty($select1) && !empty($select1Attr)): ?>
                                            <option class="filter-option" data-option="<?php echo $select1Attr; ?>" value="<?php echo $select1Attr; ?>"><?php echo $select1; ?></option>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>
                                <input class="input-post-pages" id="input-post-pages" name="input-post-pages" value="<?php echo $postsPerPage; ?>" type="hidden">
                                <input class="input-tax" id="input-tax" name="input-tax" value="<?php echo $tax; ?>" type="hidden">
                                <input class="input-parent-tax" id="input-parent-tax" name="input-parent-tax" value="<?php echo $parentTax; ?>" type="hidden">
                                <input class="input-post" id="input-post" name="input-post" value="<?php echo $post; ?>" type="hidden">
                            </form>
                        </div>
                        <div class="main-content-wrapper">
                            <div class="posts-archive-head">
                                <div class="button-filter-wrap">
                                    <?php if (!empty($filterBtn)): ?>
                                        <button class="btn btn-filter" type="button" id="btn-filter" aria-label="Filter button">
                                            <span class="btn-filter-icon">
                                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/icon-filters.svg" alt="Filter icon">
                                            </span>
                                            <span class="btn-text btn-filter-text"><?php echo $filterBtn; ?></span>
                                        </button>
                                    <?php endif;
                                    if (!empty($select1) && !empty($select2) && !empty($select1Attr) && !empty($select2Attr)): ?>
                                        <div class="select-filter" id="select-filter">
                                            <div class="select-filter-head">
                                                <span class="select-filter-head-wrap">
                                                    <?php if (!empty($sortBy)): ?>
                                                        <span class="select-filter-head-text grey"><?php echo $sortBy; ?>&nbsp;</span>
                                                    <?php endif;
                                                    if (!empty($select2) && !empty($select2Attr)): ?>
                                                        <span class="select-filter-head-text" id="selected" data-selected="<?php echo $select2Attr; ?>"><?php echo $select2; ?></span>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                            <div class="select-filter-body">
                                                <span class="select-filter-body-text active" data-select="<?php echo $select2Attr; ?>"><?php echo $select2; ?></span>
                                                <span class="select-filter-body-text" data-select="<?php echo $select1Attr; ?>"><?php echo $select1; ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="search-form-wrap">
                                    <?php 
                                        $placeholder = '';

                                        if (is_page_template('templates/post-archive-redesign.php')) {
                                            $placeholder = ' placeholder="'.$searchPh.'"';
                                        };
                                    ?>
                                    <form role="search" method="get" id="searchform-posts" action="<?php echo home_url('/') ?>" class="search-page-form">
                                        <div class="search-page-form-wrapper">
                                            <button class="website-search-page-submit" type="button" aria-label="Search button">
                                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/img/icon-search.svg" alt="Search icon">
                                            </button>
                                            <input class="input-search-posts" id="search-input" type="text" value="<?php echo get_search_query() ?>" name="s" id="website-search"
                                                class="website-search-page"<?php echo $placeholder; ?>/>
                                            <input id="iput-post-type" type="hidden" name="post_type" value="<?php echo $post; ?>">
                                            <div class="btn-search-wrap">
                                                <button class="btn-search-clear" type="button" aria-label="Clear search value">
                                                    <span>.</span>
                                                </button>
                                                <button class="btn-search-reset" type="button" aria-label="Reset all search">
                                                    <?php if (!empty($resetSearch)): ?>
                                                        <span class="btn-search-reset-text"><?php echo $resetSearch; ?></span>
                                                    <?php endif; ?>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="search-results">
                                            <div class="search-results-body">
                                            </div>
                                            <div class="search-results-footer">
                                                <div class="search-results-wrapper">
                                                    <div class="search-results-footer-wrap start">
                                                        <span class="search-results-footer-text"><?php echo $searcText; ?> “<span data-search></span>”</span>
                                                    </div>
                                                    <div class="search-results-footer-wrap center mt-10">
                                                        <span class="result-num-wrap"><span class="result-num" data-result></span><span class="result-text"><?php echo $searcTextResult; ?></span></span>
                                                    </div>
                                                </div>
                                                <div class="search-results-footer-wrap end">
                                                    <button class="search-results-btn" type="button" aria-label="Show search result button">
                                                        <span>.</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="filter-block-choosed" id="filter-block-choosed">
                                <div class="filter-block-choosed-head" id="filter-block-choosed-head"></div>
                                <div class="filter-block-choosed-body" id="filter-block-choosed-body"></div>
                            </div>
                            <div class="posts-archive-body-wrap">
                                <?php
                                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                                $args;
                                if ($defaultTax == 'all-posts') {
                                    $args = ['post_type' => $post,
                                            'posts_per_page' => $postsPerPage,
                                            'paged' => $paged,
                                            'post_status'=> 'publish',
                                            ];
                                } else {
                                    $args = ['post_type' => $post,
                                            'posts_per_page' => $postsPerPage,
                                            'paged' => $paged,
                                            'post_status'=> 'publish',
                                            'tax_query' => [
                                                ['taxonomy' => $parentTax,
                                                'field' => 'term_id',
                                                'terms' => $defaultTax]
                                                ],
                                            ];
                                };
                                $query = new WP_Query($args);
                                $max_pages = $query->max_num_pages;
                                while ($query->have_posts()):
                                    $query->the_post();
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
                                                        <?php if (!empty($watchVideo)): ?>
                                                            <span class="btn-text"><?php echo $watchVideo; ?></span>
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
                                                    if (have_rows($mcUl)): ?>
                                                        <div class="post-content-wrapper">
                                                            <ul class="ul-master-class">
                                                                <?php while (have_rows($mcUl)):
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
                                wp_reset_postdata();?>
                            </div>
                            <?php if (!empty($loadMoreBtn)): ?>
                                <div class="btn-wrap" id="load-more">
                                    <button class="load-more btn" type="button">
                                        <span class="btn-text"><?php echo $loadMoreBtn; ?><span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($tooltip) && isset($tooltip)): ?>
            <span class="tooltiptext" id ="tooltiptext" data-tooltip><span></span></span>
        <?php endif; ?>
    </section>
    <script>
        let pagedTmpl = <?php echo $paged; ?>;
        let maxPagesTmpl = <?php echo $max_pages; ?>;
        let tooltipArr = <?php echo $jsonTooltip; ?>;
    </script>
<input type="hidden" id="popup-id" data-id-popup="<?php echo get_field('popup_form','options') ?>">
<?php echo do_shortcode('[elementor-template id="' . get_field('popup_form','options') . '"]') ?>
<?php get_footer(); ?>
