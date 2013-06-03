<?php
/**
 * The main template file. Loop separated in several files. Article content found in content.php
 *
 * @package reel_radio
 * @since reel_radio 1.0
 */

get_header(); ?>


     <section class="main-content">
     	<div class="wrapper">

      <h1>Accueil</h1>

		<?php if ( have_posts() ) : ?>
			<div class="articles">
		   			
			<!-- Listen -->
				<article class="listen">
		        <div class="article-content">
		        	<p class="large-play"><i class="icon"><a href=" <?php bloginfo('url'); ?>/?page_id=826" title="Écouter la radio!" target="_blank">P</a></i></p>
			        <h2 class="entry-title">Écouter <span class="highlight">Réél-Radio</span></h2>
		        </div>
		        </article>
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<?php if(rwmb_meta( 'rr_dimensions' ) == 'is-long') : ?> 
			<article id="post-<?php the_ID(); ?>" <?php post_class('is-long'); ?>>
			<?php else : ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php endif; ?>
		      	<div class="article-content">
			        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','rr'); the_title(); ?>" rel="bookmark" ><?php the_title(); ?></a></h2>
			        <div class="excerpt">
			        	<p><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_time('j F Y'); ?></time></p>
				        <p><?php the_excerpt(); ?></p>
				        <?php the_category(); ?>
			        </div>
			    </div>
			    <div class="article-image">
			    	<?php if ( has_post_thumbnail() ) : ?>
			    	<a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','rr'); the_title(); ?>" rel="bookmark" >
			    		<?php if(rwmb_meta( 'rr_dimensions' ) == 'is-long') :
							the_post_thumbnail('long'); 
						else:
							the_post_thumbnail('short'); ?>
					</a>
						<?php endif;
					endif; //test
			    	?>
			    </div>
	     	</article>

				<?php
					/* 
					 * Create content-___.php (where ___ is the Post Format name) 
					 * and that will be used instead depending on the post format.
					 */
					//get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			</div>
			<?php wp_pagenavi(); ?>
		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>
	</div>
		</section><!-- section.site-content -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>