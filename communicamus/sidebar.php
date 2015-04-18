<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package communicamus
 */

if (is_active_sidebar('sidebar-1') ): ?>

    <div id="secondary" class="sidebar sidebar-1 widget-area" role="complementary">
    	<?php dynamic_sidebar('sidebar-1'); ?>
    </div><!-- #secondary -->

<?php endif; ?>