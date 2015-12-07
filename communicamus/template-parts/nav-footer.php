<?php
/**
 * Default partial for footer navigation
 * Override with:
 * nav-footer.php
 *
 * @package communicamus
 */

$defaults = array(
    'theme_location'  => 'footer-menu',
    'container'       => 'nav',
    'container_id'    => 'footer-menu',
    'menu_class'      => 'nav nav-pills',
    'fallback_cb'     => 'wp_page_menu',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
);

wp_nav_menu($defaults);
