<?php

namespace THEME\Theme\Helper;

class ReadCounter
{
    const COUNTER_META_KEY = 'post_views_count';


    /**
     * Get the read counter.
     *
     * @param int $post_id
     *
     * @return int
     */
    public static function getCounter(int $post_id)
    {
        return +get_post_meta($post_id, self::COUNTER_META_KEY, true);
    }

    /**
     * Increase the read counter by one.
     *
     * @param int $post_id
     *
     * @return int
     */
    public static function increaseCounter(int $post_id)
    {
        $counter = intval(get_post_meta($post_id, self::COUNTER_META_KEY, true));

        if ( ! $counter) {
            $counter = 1;
        } else {
            $counter++;
        }

        update_post_meta($post_id, self::COUNTER_META_KEY, $counter);

        return $counter;
    }
}
