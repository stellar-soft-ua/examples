<?php

namespace THEME\Theme\Controller;

use Illuminate\Support\Arr;
use THEME\Framework\Cache\Transient;
use WP_REST_Controller;

class HubController extends WP_REST_Controller
{

    protected $namespace = 'hub';

    public function register_routes()
    {
        register_rest_route($this->namespace, '/sitemap', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'getSitemap']
            ]
        ]);

        register_rest_route($this->namespace, '/news/(?P<post_id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'getNews']
            ]
        ]);

        register_rest_route($this->namespace, '/agenda/(?P<post_id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'getAgenda']
            ]
        ]);
    }

    /**
     * Route: GET /wp-json/hub/sitemap
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     */
    public function getSitemap(\WP_REST_Request $request)
    {
        $ids = Transient::remember('theme_hub_sitemap', 600, function () {
            $projects = array_map(function ($id) {
                return get_rest_url(null, '/hub/news/') . $id;
            }, get_posts([
                'post_type'      => 'project',
                'fields'         => 'ids', // Only get post IDs
                'posts_per_page' => -1
            ]));

            $events = array_map(function ($id) {
                return get_rest_url(null, '/hub/agenda/') . $id;
            }, get_posts([
                'post_type'      => 'event',
                'fields'         => 'ids', // Only get post IDs
                'posts_per_page' => -1
            ]));

            return array_merge($projects, $events);
        });

        return $this->response($ids);
    }

    /**
     * Route: GET /wp-json/hub/news/:post_id
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     * @throws \Exception
     */
    public function getNews(\WP_REST_Request $request)
    {
        $post_id = +$request->get_param('post_id') ?? null;
        $post = get_post($post_id);

        if ($post instanceof \WP_Post && $post->post_type === 'project') {
            return $this->response($this->transformProject($post));
        } else {
            return $this->response(['error' => 'News not found'], 404);
        }
    }

    /**
     * Route: GET /wp-json/hub/agenda/:post_id
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     * @throws \Exception
     */
    public function getAgenda(\WP_REST_Request $request)
    {
        $post_id = +$request->get_param('post_id') ?? null;
        $post = get_post($post_id);

        if ($post instanceof \WP_Post && $post->post_type === 'event') {
            return $this->response($this->transformEvent($post));
        } else {
            return $this->response(['error' => 'Event not found'], 404);
        }
    }

    /**
     * Transforms the project according to the API specs.
     *
     * @see https://md.novu.ch/s/HkcDzX0LH#
     *
     * @param \WP_Post $project
     *
     * @return array
     * @throws \Exception
     */
    private function transformProject(\WP_Post $project)
    {
        $language = apply_filters('wpml_post_language_details', null, $project->ID);
        $published_at = (new \DateTime())->setTimestamp(get_post_meta($project->ID, 'starts_at', true))->format(\DateTime::ISO8601) ?? null;

        $data = [
            "type"         => "news-entry",
            "language"     => Arr::get($language, 'language_code'),
            "url"          => get_the_permalink($project),
            "title"        => $project->post_title,
            "published_at" => $published_at,
            "summary"      => $project->post_excerpt,

        ];

        if (has_post_thumbnail($project)) {
            $data["image"] = get_the_post_thumbnail_url($project);
            $data["image_alt"] = get_post_meta($project->ID, '_wp_attachment_image_alt', true) ?: $project->post_title;
        }

        return $data;
    }

    /**
     * Transforms the project according to the API specs.
     *
     * @see https://md.novu.ch/s/HkcDzX0LH#
     *
     * @param \WP_Post $event
     *
     * @return array
     * @throws \Exception
     */
    private function transformEvent(\WP_Post $event)
    {
        $language = apply_filters('wpml_post_language_details', null, $event->ID);
        $startsAt = (new \DateTime())->setTimestamp(get_post_meta($event->ID, 'starts_at', true) ?: 0)->format(\DateTime::ISO8601);
        $endsAt = (new \DateTime())->setTimestamp(get_post_meta($event->ID, 'ends_at', true) ?: 0)->format(\DateTime::ISO8601);

        if ($endsAt < $startsAt) {
            $endsAt = $startsAt;
        }

        $data = [
            "type"     => "agenda",
            "language" => Arr::get($language, 'language_code'),
            "url"      => get_the_permalink($event),
            "title"    => $event->post_title,
            "start_at" => $startsAt,
            "end_at"   => $endsAt,
            "place"    => get_post_meta($event->ID, 'place', true),
            "summary"  => $event->post_excerpt
        ];

        if (has_post_thumbnail($event)) {
            $data["image"] = get_the_post_thumbnail_url($event);
            $data["image_alt"] = get_post_meta($event->ID, '_wp_attachment_image_alt', true) ?: $event->post_title;
        }

        return $data;
    }

    /**
     * @param     $data
     * @param int $status
     *
     * @return \WP_REST_Response
     */
    private function response($data, $status = 200)
    {
        return new \WP_REST_Response([
            'data' => $data
        ], $status);
    }

}
