<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package communicamus
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'communicamus' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
<?php if (is_active_sidebar('header-top')): ?>
	    <div class="widget-area header-top">
	    	<?php dynamic_sidebar('header-top'); ?>
	    </div><!-- .header-top -->
<?php endif; ?>
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->
<?php if (has_nav_menu('header-menu')): ?>
    <?php set_query_var('menu_location', 'header-menu'); ?>
    <?php get_template_part('partials/nav', 'header'); ?>
<?php endif; ?><!-- #site-navigation -->
<?php if (is_active_sidebar('header-bottom')): ?>
	    <div class="widget-area header-bottom">
	    	<?php dynamic_sidebar('header-bottom'); ?>
	    </div><!-- .header-bottom -->
<?php endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
