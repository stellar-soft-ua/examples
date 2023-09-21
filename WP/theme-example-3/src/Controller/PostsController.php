<?php

namespace THEME\Theme\Controller;

use THEME\Theme\Repositories\ProjectRepository;
use WP_REST_Controller;

class PostsController extends WP_REST_Controller
{

    protected $namespace = 'posts';

    public function register_routes()
    {
        register_rest_route($this->namespace, '/events-projects', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'getEventsAndProjects']
            ]
        ]);
    }

    /**
     * Route: /posts/events-projects
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     */
    public function getEventsAndProjects(\WP_REST_Request $request)
    {
        $projects = ProjectRepository::builder()
                                     ->limit($request->get_param('per_page') ?: 10)
                                     ->withTopic()
                                     ->withEvents()
                                     ->whereEventsShouldShowUpInTopicOverview()
                                     ->orderByMetaKey($request->get_param('meta_key') ?: 'starts_at', $request->get_param('order') ?: 'desc')
                                     ->page($request->get_param('page') ?: 1)
                                     ->get();


        return new \WP_REST_Response($projects);
    }


}
