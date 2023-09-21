<?php

namespace THEME\Theme\Controller;

use THEME\Theme\Helper\ReadCounter;
use WP_REST_Controller;

class ReadCounterController extends WP_REST_Controller
{

    protected $namespace = 'read-counter';

    public function register_routes()
    {
        register_rest_route($this->namespace, '/increase/(?P<post_id>\d+)', [
            [
                'methods'  => 'POST',
                'callback' => [$this, 'increaseCounter']
            ]
        ]);
    }

    /**
     * Route: /read-counter/increase/<post_id>
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     */
    public function increaseCounter(\WP_REST_Request $request)
    {
        $post_id = +$request->get_param('post_id') ?? null;
        $counter = ReadCounter::increaseCounter($post_id);

        return new \WP_REST_Response([
            'success' => true
        ]);
    }


}
