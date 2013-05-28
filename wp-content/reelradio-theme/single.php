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
                <div class="entry-meta">
					<div  class="meta-author clearfix">
						<h1> <span class="author-present">Écrit par</span> <?php the_author(); ?> <span class="author-present">, le <?php the_date(); ?></span> </h1>

						<div class="author-avatar"><?php echo get_avatar( get_the_author_id(), $size = '90' );?></div>
						<div class="author-about">
							<p><?php the_author_description(); ?></p>
										
								<!-- récupération des indormations sur l'auteur -->
								<?php 
								$twitter = get_the_author_meta('twitter'); 
								$googleplus = get_the_author_meta('googleplus'); 
								$url = get_the_author_meta('url'); 
								?>

							<ul>
								<?php if(!empty($twitter)) 
											{ ?>
								<li class="twitter"><a href="http://twitter.com/<?php the_author_meta('twitter'); ?>">@<?php the_author_meta('twitter'); ?></a></li>
								<?php } else {}?>


								<?php if(!empty($googleplus)) 
											{ ?>
								<li class="googleplus"><a href="<?php the_author_meta('googleplus'); ?>">google +</a></li>
								<?php } else {}?>


								<?php if(!empty($googleplus)) 
											{ ?>
								<li class="url"><a href="<?php the_author_meta('url'); ?>"><?php the_author_meta('url'); ?></a></li>
								<?php } else {}?>								
							</ul>
							
						</div>	 	 
					</div>
					<p class="meta-comments"><a href="<?php the_permalink(); ?>#comments"><?php comments_number('Aucun commentaire','1 commentaire','% commentaires'); ?></a></p>
					<?php if (get_the_tags()) : ?>
					<p class="meta-tags"><?php the_tags(); ?></p>
					<?php endif; ?>
				</div>
	     	</article>

				<?php get_sidebar(); ?>	
				
				<?php comments_template(); ?>
			
			<?php endwhile; ?>

			<?php //_s_content_nav( 'nav-below' ); ?>
		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

</div>


		</section><!-- section.site-content -->


<?php get_footer(); ?>