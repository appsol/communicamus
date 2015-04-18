<?php
/**
 * Default partial for navigation
 * Override with any of:
 * nav-header.php
 * nav-sidebar-php
 * nav-footer.php
 *
 * @package communicamus
 */

$defaults = array(
    'theme_location'  => get_query_var('menu_location', 'header-menu'),
    'container'       => 'nav',
    'container_id'    => 'primary-menu',
    'menu_class'      => 'nav',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
);

wp_nav_menu($defaults);
