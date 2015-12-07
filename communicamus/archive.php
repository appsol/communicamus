<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package communicamus
 */

get_header(); ?>

	<div id="primary" class="content-area primary">
<?php if (is_active_sidebar('pre-content')): ?>
	    <div class="widget-area pre-content">
	    	<?php dynamic_sidebar('pre-content'); ?>
	    </div><!-- .pre-content -->
<?php endif; ?>
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<?php
					the_archive_title( '<h1 class="archive-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .archive-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php communicamus_the_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
<?php if (is_active_sidebar('post-content')): ?>
	    <div class="widget-area post-content">
	    	<?php dynamic_sidebar('post-content'); ?>
	    </div><!-- .post-content -->
<?php endif; ?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
