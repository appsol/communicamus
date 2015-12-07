<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package communicamus
 */

if (! is_active_sidebar('sidebar-1')) {
    return;
}
?>

<div id="secondary" class="widget-area secondary" role="complementary">
	<?php dynamic_sidebar('sidebar-1'); ?>
</div><!-- #secondary -->
