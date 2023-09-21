<?php

if (is_day()) {
    $title = __('Archive: ', 'theme') . ' ' . get_the_date('D M Y');
} elseif (is_month()) {
    $title = __('Archive:', 'theme') . ' ' . get_the_date('M Y');
} elseif (is_year()) {
    $title = __('Archive:', 'theme') . ' ' . get_the_date('Y');
} elseif (is_tag()) {
    $title = __('Tag:', 'theme') . ' ' . single_tag_title('', false);
} elseif (is_category()) {
    $title = __('Category:', 'theme') . ' ' . single_cat_title('', false);
} elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
}

return [
    'title' => $title
];
