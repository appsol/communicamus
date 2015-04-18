<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package communicamus
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
<?php if (is_active_sidebar('footer')): ?>
        <div class="widget-area footer">
            <?php dynamic_sidebar('footer'); ?>
        </div><!-- .footer -->
<?php endif; ?>
<?php if (has_nav_menu('footer-menu')): ?>
    <?php set_query_var('menu_location', 'footer-menu'); ?>
    <?php get_template_part('partials/nav', 'footer'); ?>
<?php endif; ?>
		<div class="site-info">
            <span class="copyright">All Content and Design &copy;<?php bloginfo('name'); ?> <?php echo date('Y'); ?> All Rights Reserved</span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
