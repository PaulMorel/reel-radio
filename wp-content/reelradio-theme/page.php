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
						the_post_thumbnail();
					} ?>				
					<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rr' ), 'after' => '</div>' ) ); ?>
				</div>
                <!--<div lass="entry-meta">
					<span class="meta-date">Posted on <time datetime="<?php the_time('c'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time></span>
					<span class="meta-comments"><a href="<?php the_permalink(); ?>#comments"><?php comments_number('No Comments','1 Comment','% Comments'); ?></a></span>
					<?php if (get_the_tags()) : ?>
					<span class="meta-tags"><?php _e('Filed under', 'rr') ?><?php the_tags(); ?></span>
					<?php endif; ?>
				</div>-->
	     	</article>

				<?php endwhile; ?>

			<?php //_s_content_nav( 'nav-below' ); ?>
		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>
</div>


		</section><!-- section.site-content -->


<?php get_footer(); ?>