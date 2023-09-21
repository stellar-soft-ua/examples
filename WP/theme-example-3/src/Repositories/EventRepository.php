<?php

namespace THEME\Theme\Repositories;

use THEME\Framework\Database\Repositories\PostRepository;

class EventRepository extends PostRepository
{
    protected $model = 'event';

    private $withTopic = false;

    public function withTopic()
    {
        $this->withTopic = true;

        return $this;
    }

    /**
     * Order by date descending.
     *
     * @return $this
     */
    public function latest()
    {
        $this->setArgument('meta_key', 'starts_at');
        $this->setArgument('orderby', 'meta_value_num');
        $this->setArgument('order', 'desc');

        return $this;
    }

    /**
     * Only get events in the future.
     *
     * @return $this
     */
    public function whereIsFuture()
    {
        $this->addMetaQuery([
            'key'     => 'starts_at',
            'value'   => microtime(true),
            'compare' => '>',
        ]);

        return $this;
    }

    protected function postQuery(array $posts)
    {
        if ($this->withTopic) {
            foreach ($posts as $event) {
                $terms        = get_the_terms($event, 'topic');
                $event->topic = is_array($terms) ? $terms[0] : null;
            }
        }

        return $posts;
    }
}
