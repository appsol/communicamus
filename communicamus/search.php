<?php
/**
 * The template for displaying search results pages.
 *
 * @package communicamus
 */

get_header(); ?>

	<section id="primary" class="content-area primary">
<?php if (is_active_sidebar('pre-content')): ?>
	    <div class="widget-area pre-content">
	    	<?php dynamic_sidebar('pre-content'); ?>
	    </div><!-- .pre-content -->
<?php endif; ?>
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'communicamus' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
<?php if (is_active_sidebar('post-content')): ?>
        <div class="widget-area post-content">
            <?php dynamic_sidebar('post-content'); ?>
        </div><!-- .post-content -->
<?php endif; ?>
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer();
