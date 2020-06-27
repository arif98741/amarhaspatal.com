<?php


class LocationClass
{

    /**
     * register postType
     * @param $labels
     */
    public static function registerPostType($labels)
    {
        $args = array(
            'labels' => $labels,
            'has_archive' => false,
            'public' => true,
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'custom-fields',
                'revisions'
            ),
        );
        register_post_type('sidebar_post', $args);
    }
}