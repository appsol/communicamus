<?php
/**
 * communicamus functions and definitions
 *
 * @package communicamus
 */

define('PATH_TO_COMMUNICAMUS', plugin_dir_path(__FILE__));

class Communicamus
{

    /**
     * Singleton class instance
     *
     * @var object Communicamus
     **/
    private static $instance = null;

    /**
     * Widget loading locations
     *
     * @var array
     **/
    public $widget_locations = array(
        array(
            'id' => 'header-top',
            'name' => 'Header Top',
            'description' => 'Allows placement of Widgets before the logo in the header'
        ),
        array(
            'id' => 'header-bottom',
            'name' => 'Header Bottom',
            'description' => 'Allows placement of Widgets after the menu in the header'
        ),
        array(
            'id' => 'pre-content',
            'name' => 'Pre Content',
            'description' => 'Allows placement of Widgets just prior to the post content'
        ),
        array(
            'id' => 'post-content',
            'name' => 'Post Content',
            'description' => 'Allows placement of Widgets just after the post content'
        ),
        array(
            'id' => 'footer',
            'name' => 'Footer',
            'description' => 'Allows placement of Widgets in the footer'
        )
    );

    /**
     * Creates or returns an instance of this class
     *
     * @return A single instance of this class
     * @author Stuart Laverick
     **/
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'actionRegisterMenus']);
        add_action('after_setup_theme', [$this, 'actionAddThemeSupport']);
        add_action('after_setup_theme', [$this, 'actionLoadThemeTextDomain']);
        add_action('widgets_init', [$this, 'actionWidgetsInit']);
        add_action('wp_enqueue_scripts', [$this, 'actionEnqueueAssets']);
        add_filter('comments_open', [$this, 'filterDisablePageComments'], 10, 2);
        add_filter('img_caption_shortcode', [$this, 'filterImgCaptionShortcode'], 10, 3);
        add_filter('excerpt_length', [$this, 'filterExcerptLength']);
        add_filter('excerpt_more', [$this, 'filterExcerptMore']);
    }

    /**
	 * Register all the widget loading areas
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
    public function actionWidgetsInit()
    {
        register_sidebar(
            [
                'name'          => __('Sidebar', 'communicamus'),
                'id'            => 'sidebar-1',
                'description'   => 'Main left or right side bar',
                'before_widget' => '<aside id="%1$s" class="block widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ]
        );

        // Register the location sidebars
        foreach ($this->widget_locations as $location) {
            register_sidebar(
                [
                    'name' => __($location['name'],'communicamus'),
                    'id' => $location['id'],
                    'description' => $location['description'],
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => "\n</div>\n",
                    'before_title' => "<h3 class=\"hd widget-title\">",
                    'after_title' => "</h3>\n",
                ]
            );
        }
    }

    /**
     * Registers the available menus
     *
     * @return null
     * @author Stuart Laverick
     */
    public function actionRegisterMenus()
    {
        $menus = array(
                    'header-menu' => __('Header Menu'),
                    'sidebar-menu' => __('Sidebar Menu'),
                    'footer-menu' => __('Footer Menu')
                );
        register_nav_menus($menus);
    }

    /**
     * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on communicamus, use a find and replace
	 * to change 'communicamus' to the name of your theme in all the template files
     *
     * @return void
     * @author 
     **/
    public function actionLoadThemeTextDomain()
    {
		load_theme_textdomain( 'communicamus', get_template_directory() . '/languages' );
    }

    /**
     * Register the optional functionality the theme supports
     *
     * @return void
     * @author Stuart Laverick
     **/
    public function actionAddThemeSupport()
    {
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption'
            ]
        );

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support(
            'post-formats',
            [
                'aside',
                'image',
                'video',
                'quote',
                'link'
            ]
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters('communicamus_custom_background_args', [
                'default-color' => 'ffffff',
                'default-image' => '',
            ])
        );
    }

    /**
     * Load any scripts and styles needed in the page
     *
     * @return void
     * @author Stuart Laverick
     **/
    public function actionEnqueueAssets()
    {
    	if ($style_uri = $this->getThemeFileUri('dist/css/style.css')) {
            wp_register_style('communicamus', $style_uri);
            wp_enqueue_style('communicamus');
        }

        if ($js_uri = $this->getThemeFileUri('dist/js/script.js')) {
            wp_enqueue_script('communicamus', $js_uri, null, '', true);
            $context = array(
            	'themeRoot' => is_child_theme() ?
	                get_stylesheet_directory_uri() . '/' : get_template_directory_uri() . '/'
            	);
            wp_localize_script('communicamus', 'communicamus', $context);
        }

    	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
    }

    /**
     * Disables comments on all page post types
     *
     * @param $open Bool comment open flag
     * @param $post_id Int current post ID
     * @return Bool comment open flag
     * @author Stuart Laverick
     **/
    public function filterDisablePageComments($open, $post_id)
    {
    	$post = get_post( $post_id );

		if ( 'page' == $post->post_type ) {
			$open = false;
		}

		return $open;
    }

    /**
     * Gets the path to a file.
     * Looks in the child theme first, then falls back to the template directory.
     *
     * @return String the path to the file
     * @author Stuart Laverick
     **/
    public function getThemeFilePath($filename)
    {
        if (file_exists(get_stylesheet_directory() . '/' . $filename)) {
            return get_stylesheet_directory() . '/' . $filename;
        }
        if (file_exists(get_template_directory() . '/' . $filename)) {
            return get_template_directory() . '/' . $filename;
        }
        return false;
    }

    /**
     * Gets the uri of a file.
     * Looks in the child theme first, then falls back to the template directory.
     *
     * @return String the uri of the file
     * @author Stuart Laverick
     **/
    public function getThemeFileUri($filename)
    {
        $fileUri = false;
        $minFilename = implode('.min.', explode('.', $filename));
        if (file_exists(get_stylesheet_directory() . '/' . $minFilename)) {
            $fileUri = get_stylesheet_directory_uri() . '/' . $minFilename;
        } elseif (file_exists(get_stylesheet_directory() . '/' . $filename)) {
            $fileUri = get_stylesheet_directory_uri() . '/' . $filename;
        } elseif (file_exists(get_template_directory() . '/' . $minFilename)) {
            $fileUri = get_template_directory_uri() . '/' . $minFilename;
        } elseif (file_exists(get_template_directory() . '/' . $filename)) {
            $fileUri = get_template_directory_uri() . '/' . $filename;
        }
        return $fileUri;
    }

    /**
     * Filter to remove the inline style from figure elements
     * This prevented them acting as responsive images with Bootstrap CSS
     *
     * @see wp-includes/media.php img_caption_shortcode()
     * @param string $output  The caption output. Default empty.
     * @param array  $attr    Attributes of the caption shortcode.
     * @param string $content The image element, possibly wrapped in a hyperlink.
     * @return string
     * @author Stuart Laverick
     **/
    public function filterImgCaptionShortcode($output, $attr, $content)
    {
        $atts = shortcode_atts( array(
            'id'      => '',
            'align'   => 'alignnone',
            'width'   => '',
            'caption' => '',
            'class'   => '',
        ), $attr, 'caption' );

        $atts['width'] = (int) $atts['width'];
        if ( $atts['width'] < 1 || empty( $atts['caption'] ) ) {
            return $content;
        }

        if ( ! empty( $atts['id'] ) ) {
            $atts['id'] = 'id="' . esc_attr( $atts['id'] ) . '" ';
        }

        $class = trim( 'wp-caption ' . $atts['align'] . ' ' . $atts['class'] );

        if ( current_theme_supports( 'html5', 'caption' ) ) {
            return '<figure ' . $atts['id'] . ' class="' . esc_attr( $class ) . '">'
            . do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
        }

        $caption_width = 10 + $atts['width'];

        $caption_width = apply_filters( 'img_caption_shortcode_width', $caption_width, $atts, $content );

        $style = '';
        if ( $caption_width ) {
            $style = 'style="width: ' . (int) $caption_width . 'px" ';
        }

        return '<div ' . $atts['id'] . $style . 'class="' . esc_attr( $class ) . '">'
        . do_shortcode( $content ) . '<p class="wp-caption-text">' . $atts['caption'] . '</p></div>';
    }

    /**
     * Filter to alter the default excerpt length
     *
     * @return int the new excerpt length
     * @author Stuart Laverick
     **/
    public function filterExcerptLength($length)
    {
        return 35;
    }

    /**
     * Filter to replace the standard 'more' elipses
     *
     * @return string the replacement 'more' text
     * @author Stuart Laverick
     **/
    public function filterExcerptMore($more)
    {
        return sprintf(
            __('<a class="read-more" href="%s">Continue reading %s <span class="meta-nav">&hellip;</span></a>', 'communicamus'),
            get_permalink(get_the_ID()),
            the_title('<span class="screen-reader-text">"', '"</span>', false)
        );
    }
}

// Instantiate the theme object as early as possible
$communicamus = Communicamus::getInstance();

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom functions not inherited from _s.
 */
require get_template_directory() . '/inc/helpers.php';

/**
 * Customizer additions.
 */
// require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/jetpack.php';

/**
 * Load menu walker class for Bootstrap 3 Navbar menu
 */
// require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

/**
 * Load the Picturefill.js featured image functionality
 */
require get_template_directory() . '/inc/picturefill-featured-image.php';
