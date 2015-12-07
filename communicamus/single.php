<?php
/**
 * The template for displaying all single posts.
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

		<?php while (have_posts()) : the_post(); ?>

			<?php get_template_part('template-parts/content', 'single'); ?>

			<?php the_post_navigation(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
<?php if (is_active_sidebar('post-content')): ?>
        <div class="widget-area post-content">
            <?php dynamic_sidebar('post-content'); ?>
        </div><!-- .post-content -->
<?php endif; ?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer();
