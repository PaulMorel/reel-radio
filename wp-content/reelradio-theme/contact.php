<?php
/**
 * Contact template page
 *
 * @package reel_radio
 * @since reel_radio 1.0
 *
 * Template Name: Page Contact
 *
 * Selectable from a dropdown menu on the edit page screen.
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
				<div id="mapcanvas"></div>
		      	<div class="entry-content clearfix">
		      		<div class="contact-form">
					<?php the_content(); ?>
					</div>
					<div class="vcard">
						<h2>Venez nous voir</h2>
					    <p>
					      	<span class="fn url ir logo"><a href="#">RÉÉL-Radio</a></span>
					      	<span class="org">Université du Québec en Outaouais</span>
					      	<span class="adr">
					      		<span class="street-address">283, boul. Alexandre-Taché</span>
					      		<span class="locality">Gatineau</span>, 
					      		<span class="region" title="Québec">QC</span>
					      		<span class="postal-code">J8X 3X7</span>
					      	</span>
					    </p>
					    <p>
					      	<span class="tel">
						        Tél : <span class="value">819 773-1750</span><br>
						        <span class="type">Fax</span> : <span class="value">819 595-2218</span>
					        </span>
					        Courriel : <a class="email" href="mailto:info@reel-radio.fm">info@reel-radio.fm</a>
					    </p>
					</div>
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