<?php
/**
 * The Sidebar/alternate footer containing widget area
 *
 * @package reel_radio
 * @since reel_radio 1.0
 */
?>
		<section class="widget-area" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'Sidebar' ) ) : ?>
			<?php endif; // end sidebar widget area ?>
		</section><!-- #secondary .widget-area -->
