<?php
/**
 * Default partial for header navigation
 * Override with:
 * nav-header.php
 *
 * @package communicamus
 */

$pre_menu = array('<div class="container">',
                '<div class="navbar-header">',
                '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-menu">',
                '<span class="sr-only">Toggle navigation</span>',
                '<span class="icon-bar"></span>',
                '<span class="icon-bar"></span>',
                '<span class="icon-bar"></span>',
                '</button>',
                '<a class="navbar-brand" href="' . get_option('home') . '/">' . get_bloginfo('name') . '</a>',
                '</div>',
                '<div class="navbar-collapse collapse" id="primary-menu">'
                );

$post_menu = array('</div><!-- #primary-menu -->', '</div><!-- .container -->');

$defaults = array(
    'theme_location'  => 'header-menu',
    'container'       => 'nav',
    'container_class' => 'navbar navbar-default',
    'menu_class'      => 'nav navbar-nav',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => implode("\n", $pre_menu) . '<ul id="%1$s" class="%2$s">%3$s</ul>' . implode("\n", $post_menu),
    'depth'           => 0,
    'walker'          => ''
);

wp_nav_menu($defaults);
