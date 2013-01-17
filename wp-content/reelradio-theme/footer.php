<?php
/**
 * Document footer for theme
 *
 * Contains the closing of the main content <section> and includes scripts to be run at end of document
 *
 * @package reel_radio
 * @since reel_radio 1.0
 */
?>

	</section><!-- #main .site-main -->

	<footer class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( '_s_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', '_s' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', '_s' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', '_s' ), '_s', '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>