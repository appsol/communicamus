<?php
/**
 * Custom functionality that is not included in the theme core
 *
 * Not added to extras.php to avoid being overwritten when updating _s
 *
 * @package communicamus
 */

/**
 * Returns the registered image size names and dimensions
 *
 * @global type $_wp_additional_image_sizes
 * @return array Registered image sizes
 */
function communicamus_get_thumbnail_sizes()
{
    global $_wp_additional_image_sizes;
    $sizes = [];
    foreach (get_intermediate_image_sizes() as $s) {
        $sizes[$s] = [0, 0];
        if (in_array($s, ['thumbnail', 'medium', 'large'])) {
            $sizes[$s][0] = get_option($s . '_size_w');
            $sizes[$s][1] = get_option($s . '_size_h');
        } else {
            if (isset($_wp_additional_image_sizes[$s])) {
                $sizes[$s] = [
                    $_wp_additional_image_sizes[$s]['width'],
                    $_wp_additional_image_sizes[$s]['height']
                    ];
            }
        }
    }

    return $sizes;
}


/**
 * Alternative Post Navigation to improve the classes and layout of the original
 *
 * @return string
 * @author Stuart Laverick
 **/
function communicamus_get_the_posts_pagination($args = [])
{
    $navigation = '';

    // Don't print empty markup if there's only one page.
    if ($GLOBALS['wp_query']->max_num_pages > 1) {
        $args = wp_parse_args($args, [
            'mid_size'           => 1,
            'prev_text'          => _x('Previous', 'previous post', 'communicamus'),
            'next_text'          => _x('Next', 'next post', 'communicamus'),
            'screen_reader_text' => __('Posts navigation', 'communicamus'),
            'type'               => 'array'
        ]);

        // Set up paginated links.
        $links = paginate_links($args);

        if ($links) {
            $pagelinks = sprintf("<ul>\n\t<li>%s</li>\n</ul>\n", join("</li>\n\t<li>", $links));
            $navigation = _navigation_markup($pagelinks, 'posts-pagination', $args['screen_reader_text']);
        }
    }

    return $navigation;
}

/**
 * Displays the Post Navigation returned from communicamus_get_the_posts_pagination
 *
 * @return void
 * @author Stuart Laverick
 **/
function communicamus_the_posts_pagination($args = [])
{
    echo communicamus_get_the_posts_pagination($args);
}
