<?php
/**
 * The main template file. Loop separated in several files. Article content found in content.php
 *
 * @package reel_radio
 * @since reel_radio 1.0
 */

get_header(); ?>

     <section class="main-content clearfix">
     	<div class="wrapper">

      <h1><?php the_title(); ?></h1>

		<?php if ( have_posts() ) : ?>
		    <?php //_s_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		      	<div class="entry-content">
				<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						the_post_thumbnail('very-large-full');
					} ?>				
					<?php the_content(); ?>
					<?php $emission_slug = $post->post_name; ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rr' ), 'after' => '</div>' ) ); ?>
				</div>
	     	</article>
			
			<?php 
			$query_args = array(
				'post_type' => 'episodes',
				'meta_query' => array(
					array(
						'key' => 'rr_emission',
						'value' => $emission_slug,
						'compare' => '='
					)
				)
			);
			$episode_query = new WP_Query($query_args);
			global $episode_query;
			$episode_query->in_the_loop = true;  
			
			if ($episode_query->have_posts()) : ?>
				<div class="episodes">
				<h2>Épisodes</h2>
				<table>
					<tbody>
			<?php while ($episode_query->have_posts()) : $episode_query->the_post(); ?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<td class="episode-title"><h3 class="post-title"><?php the_title(); ?></a></td>
						<td class="episode-date"><p>Publié le <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_time('j F Y'); ?></time></p></td>
						<td class="episode-content"><?php the_content(); ?></td>
						</tr>	       	
		
			<?php endwhile; ?>
					</tbody>
				</table>
				</div>
		<?php endif;  ?>
			<?php endwhile; ?>

			
		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>
</div>


		</section><!-- section.site-content -->


<?php get_footer(); ?>