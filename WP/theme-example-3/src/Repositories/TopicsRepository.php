<?php

namespace THEME\Theme\Repositories;

class TopicsRepository
{
    /**
     * @return \WP_Term[]|int|\WP_Error
     */
    public static function all()
    {
        return array_filter(get_terms([
            'taxonomy'   => 'topic',
            'hide_empty' => false
        ]), function (\WP_Term $term) {
            return get_term_meta($term->term_id, '_theme_is_hidden', true) !== 'yes';
        });
    }
}
