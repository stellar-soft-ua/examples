<?php

namespace THEME\Theme\Providers;

use Illuminate\Support\Str;
use THEME\Framework\Providers\PluginProvider;

class RelevanssiSearchProvider extends PluginProvider
{
    private function shouldUseRelevanssi(\WP_Query $query)
    {
        if ($query->is_search() && defined('REST_REQUEST') && REST_REQUEST) {
            return true;
        }

        return false;
    }

    /**
     * Adds the post excerpt to the REST search results.
     *
     * @Action()
     * @return void
     */
    public function rest_api_init()
    {
        // Registers a REST field for the /wp/v2/search endpoint.
        register_rest_field('search-result', 'excerpt', [
            'get_callback' => function ($post) {
                $post = get_post($post['id']);

                return $post->post_excerpt;
            },
        ]);
    }

    /**
     * Filters the indexed custom fields.
     *
     * @Action()
     */
    public function relevanssi_index_custom_fields(array $custom_fields, int $post_id)
    {
        $customFieldsWhitelist = [
            'startsWith' => [
                '_sections',
            ],
        ];

        return collect($custom_fields)->filter(function ($field) use ($customFieldsWhitelist) {
            if (Str::startsWith($field, $customFieldsWhitelist['startsWith'])) {
                return true;
            }

            return false;
        })->toArray();
    }

    /**
     * Enable relevanssi for REST API search requests.
     *
     * @Action()
     * @param $check
     * @param $query
     * @return array
     */
    public function posts_pre_query($check, $query)
    {
        if ($this->shouldUseRelevanssi($query)) {
            $posts = relevanssi_do_query($query);

            $query->relevanssi_found_posts = $query->found_posts;

            return $posts;
        }
        return $check;
    }

    /**
     * Because “relevanssi” does not properly account for code run in WP_Query, like
     * the wordpress filter “found_posts_query”, which undoes “found_posts”, it must
     * be reset. This is primarily evident with code that fully use WP_Query, such
     * as the REST API.
     *
     * @Action()
     * @param $found_posts
     * @param $query
     */
    public function found_posts($found_posts, $query)
    {
        if ($this->shouldUseRelevanssi($query)) {
            return $query->relevanssi_found_posts;
        }

        return $found_posts;
    }
}