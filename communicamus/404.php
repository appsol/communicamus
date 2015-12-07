<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package communicamus
 */

get_header(); ?>

	<div id="primary" class="content-area primary no-sidebar">
<?php if (is_active_sidebar('pre-content')): ?>
	    <div class="widget-area pre-content">
	    	<?php dynamic_sidebar('pre-content'); ?>
	    </div><!-- .pre-content -->
<?php endif; ?>
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'communicamus' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'communicamus' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php if ( communicamus_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'communicamus' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>

					<?php
						/* translators: %1$s: smiley */
						$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'communicamus' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
<?php if (is_active_sidebar('post-content')): ?>
	    <div class="widget-area post-content">
	    	<?php dynamic_sidebar('post-content'); ?>
	    </div><!-- .post-content -->
<?php endif; ?>
	</div><!-- #primary -->

<?php get_footer(); ?>
