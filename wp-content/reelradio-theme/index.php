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
		    <?php //_s_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		      	<div class="article-content">
			        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','rr'); the_title(); ?>" rel="bookmark" ><?php the_title(); ?></a></h2>
			        <div class="excerpt">
				        <p><?php the_excerpt(); ?></p>
				        <p><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','rr'); the_title(); ?>" rel="bookmark" >En lire plus...</a></p>
			        </div>
			    </div>
			    <div class="article-image">
			    	<?php if ( has_post_thumbnail() ) :
						the_post_thumbnail();
					endif;
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

			<?php reel_content_nav( 'nav-below' ); ?>
			</div>
		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>
	</div>
		</section><!-- section.site-content -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>