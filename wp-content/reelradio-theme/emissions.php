<?php
/**
 * Emissions template page
 *
 * @package reel_radio
 * @since reel_radio 1.0
 *
 * Template Name: Page Emissions
 *
 * Selectable from a dropdown menu on the edit page screen.
 */

get_header(); ?>

     <section class="main-content clearfix">
     	<div class="wrapper">

      		<h1><?php the_title(); ?></h1>

	<?php $query = new WP_Query('post_type=emissions&post_count=-1');
	global $query;
	$query->in_the_loop = true;  
	
	if ($query->have_posts()) :
	
	while ($query->have_posts()) : $query->the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		      	<div class="entry-content">
			        <?php if ( has_post_thumbnail() ) : // check if the post has a Post Thumbnail assigned to it. ?>
			        <a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','rr'); the_title(); ?>" rel="bookmark" >
						<?php the_post_thumbnail('very-large'); ?>
					</a>
					<?php endif; ?>	
			        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','rr'); the_title(); ?>" rel="bookmark" ><?php the_title(); ?></a></h2>
		            <?php the_content(); ?>
			    </div>
	     	</article>

				<?php endwhile; ?>

			<?php //_s_content_nav( 'nav-below' ); ?>
		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>
</div>


		</section><!-- section.site-content -->


<?php get_footer(); ?>