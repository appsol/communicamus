<?php
/**
 * Returns an array of the current post featured image sizes and urls
 *
 * @return Array the image sizes
 * @author Stuart Laverick
 **/
function getTheFeaturedImages(&$alt, $postId)
{
    if ($postId) {
        $thePost = get_post($postId);
    } else {
        $thePost = get_queried_object();
    }

    $images = array();
    $imageId = get_post_thumbnail_id($thePost->ID);
    if (!$imageId && isset($thePost->post_parent)) {
        $parent = get_post($thePost->post_parent);
        $imageId = get_post_thumbnail_id($parent->ID);
    }
    if ($imageId) {
        $alt = trim(strip_tags(get_post_meta($imageId, '_wp_attachment_image_alt', true) ));
        $imageSizes = communicamus_get_thumbnail_sizes();
        foreach ($imageSizes as $key => $value) {
            $images[$key] = array_merge(
                array(wp_get_attachment_image_src($imageId, $key)),
                $value
            );
        }
        // Add the full size image to the array
        $fullImage = wp_get_attachment_image_src($imageId, 'full');
        $images['full'] = array_merge(
            array($fullImage),
            array($fullImage[1], $fullImage[2])
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
function printPictureFillFeaturedImage($postId=null)
{
    $alt = '';
    $images = getTheFeaturedImages($alt, $postId);
    if (count($images['medium'])):
    ?>
    <div id="featuredimage" class="header-image">
        <picture>
            <!--[if IE 9]><video style="display: none;"><![endif]-->
    <?php foreach ($images as $key => $value): ?>
            <source srcset="<?php print $value[0][0]; ?>" media="(max-width: <?php print $value[1]; ?>px)">
    <?php endforeach; ?>
            <source srcset="<?php print $value[0][0]; ?>">
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