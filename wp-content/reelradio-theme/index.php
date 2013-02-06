<?php
/**
 * The main template file. Loop separated in several files. Article content found in content.php
 *
 * @package reel_radio
 * @since reel_radio 1.0
 */

get_header(); ?>


		<section class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

		    <?php //_s_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* 
					 * Create content-___.php (where ___ is the Post Format name) 
					 * and that will be used instead depending on the post format.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php //_s_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		</section><!-- section.site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>