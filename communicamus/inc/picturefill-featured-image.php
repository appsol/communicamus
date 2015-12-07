<?php
/**
 * Returns an array of the current post featured image sizes and urls
 *
 * @return Array the image sizes
 * @author Stuart Laverick
 **/
function getTheFeaturedImages(&$alt)
{
    $post = get_queried_object();
    $images = [];
    $imageId = get_post_thumbnail_id($post->ID);
    if (!$imageId && isset($post->post_parent)) {
        $parent = get_post($post->post_parent);
        $imageId = get_post_thumbnail_id($parent->ID);
    }
    if ($imageId) {
        $alt = trim(strip_tags(get_post_meta($imageId, '_wp_attachment_image_alt', true) ));
        $imageSizes = communicamus_get_thumbnail_sizes();
        foreach ($imageSizes as $key => $value) {
            $images[$key] = array_merge(
                [wp_get_attachment_image_src($imageId, $key)],
                $value
            );
        }
        // Add the full size image to the array
        $fullImage = wp_get_attachment_image_src($imageId, 'full');
        $images['full'] = array_merge(
            [$fullImage],
            [1600, 1280]
        );
        uasort($images, function($a, $b){
            if ($a[0][1] == $b[0][1]) {
                return 0;
            }
            return ($a[0][1] < $b[0][1]) ? -1 : 1;
        });
    }
    return $images;
}

/**
 * Template tag to display the post featured image as a Picture element
 * Uses the media image sizes to create the srcset attributes
 *
 * @return void
 * @author Stuart Laverick
 **/
function printPictureFillFeaturedImage()
{
    $alt = '';
    $images = getTheFeaturedImages($alt);
    if (count($images['medium'])):
    ?>
    <div id="featuredimage" class="header-image">
        <picture>
            <!--[if IE 9]><video style="display: none;"><![endif]-->
    <?php foreach ($images as $key => $value): ?>
            <source srcset="<?php print $value[0][0]; ?>" media="(max-width: <?php print $value[1]; ?>px)">
    <?php endforeach; ?>
            <!--[if IE 9]></video><![endif]-->
            <img srcset="<?php print $images['medium'][0][0]; ?>" alt="<?php print $alt; ?>">
        </picture>
    </div>
    <?php endif; 
}

/**
 * Prints the required picturefill.js script tags in the head
 *
 * @return void
 * @author Stuart Laverick
 **/
function printPictureFillScript()
{
    echo "\n<script>\n
            document.createElement( \"picture\" );\n
        </script>\n
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/picturefill/3.0.0-beta1/picturefill.min.js\" async></script>\n";
}

add_action('wp_head', 'printPictureFillScript');