<?php

namespace THEME\Theme\Repositories;

use THEME\Framework\Database\Repositories\PostRepository;
use THEME\Theme\Helper\ReadCounter;

class ProjectRepository extends PostRepository
{
    protected $model = 'project';

    private $withTopic = false;

    public function withEvents()
    {
        $this->setArgument('post_type', ['project', 'event']);

        return $this;
    }

    /**
     * Only get events in the future.
     *
     * @param int $offset The offset to todays date in seconds
     *
     * @return $this
     */
    public function whereIsFuture($offset = 0)
    {
        $this->addMetaQuery([
            'key'     => 'starts_at',
            'value'   => microtime(true) + $offset,
            'compare' => '>',
        ]);

        return $this;
    }

    public function withTopic()
    {
        $this->withTopic = true;

        return $this;
    }

    public function orderByMetaKey($key, $direction = 'asc'){
        $this->setArgument('order', $direction);
        $this->setArgument('orderby', 'meta_value_num');
        $this->setArgument('meta_key', $key);

        return $this;
    }

    public function page($page = 1) {
        $this->setArgument('page', $page);

        return $this;
    }

    public function mostRead($limit = 5)
    {
        $this->setArgument('meta_query', [
            'relation'       => 'AND',
            'counter_clause' => [
                'key'     => ReadCounter::COUNTER_META_KEY,
                'compare' => '>',
                'value'   => 0,
                'type'    => 'numeric',
            ]
        ]);

        $this->setArgument('meta_key', 'is_featured');
        $this->setArgument('orderby', [
            'is_featured'    => 'DESC',
            'counter_clause' => 'DESC'
        ]);

        $this->setArgument('posts_per_page', $limit);

        return $this;
    }

    public function whereProjectStatus($status)
    {
        $this->addMetaQuery([
            'key'     => 'project_status',
            'value'   => $status,
            'compare' => '='
        ]);

        return $this;
    }

    public function whereEventsShouldShowUpInTopicOverview() {
        $this->addMetaQuery([
            'relation' => 'OR',
            [
                'key'     => 'show_on_topic_page',
                'value'   => '1',
                'compare' => '='
            ],
            [
                'key'     => 'show_on_topic_page',
                'compare' => 'NOT EXISTS'
            ]
        ]);

        return $this;
    }

    protected function postQuery(array $posts)
    {
        foreach ($posts as $post) {
            if ($this->withTopic) {
                $terms = get_the_terms($post, 'topic');

                $topic = is_array($terms) ? $terms[0] : null;

                if ($topic) {
                    $post->topic = $topic;
                    $post->topic->color_primary = get_term_meta($topic->term_id, '_theme_color_primary', true);
                    $post->topic->color_secondary = get_term_meta($topic->term_id, '_theme_color_secondary', true);
                }
            }

            $post->link = get_the_permalink($post);

            $post->title = [
                'rendered' => $post->post_title
            ];

            $post->excerpt = [
                'rendered' => $post->post_excerpt
            ];
        }

        return $posts;
    }
}
