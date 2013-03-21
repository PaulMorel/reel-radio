<?php
/**
 * The main template file. Loop separated in several files. Article content found in content.php
 *
 * @package reel_radio
 * @since reel_radio 1.1
 */

get_header(); ?>

     <section class="main-content clearfix">
     	<div class="wrapper">

	     <h1>
		     <?php
				if ( is_category() ) {
					printf( __( 'Archives pour la catégorie: %s', '_s' ), '<span>' . single_cat_title( '', false ) . '</span>' );

				} elseif ( is_tag() ) {
					printf( __( 'Archives du mot-clé: %s', '_s' ), '<span>' . single_tag_title( '', false ) . '</span>' );

				} elseif ( is_author() ) {
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					*/
					the_post();
					printf( __( 'Archives de l\'auteur: %s', '_s' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();

				} elseif ( is_day() ) {
					printf( __( 'Archives quotidiennes: %s', '_s' ), '<span>' . get_the_date() . '</span>' );

				} elseif ( is_month() ) {
					printf( __( 'Archives mensuelles: %s', '_s' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

				} elseif ( is_year() ) {
					printf( __( 'Archives anuelles : %s', '_s' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

				} else {
					_e( 'Archives', '_s' );

				}
			?>
		</h1>

		<?php if ( have_posts() ) : ?>
		    <?php //_s_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','rr'); the_title(); ?>" rel="bookmark" ><?php the_title(); ?></a></h2>
		      	<div class="entry-content">
				<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						the_post_thumbnail();
					} ?>				
					<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rr' ), 'after' => '</div>' ) ); ?>
				</div>
                <div lass="entry-meta">
					<p class="meta-date">Écrit le <time datetime="<?php the_time('c'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time></p>
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