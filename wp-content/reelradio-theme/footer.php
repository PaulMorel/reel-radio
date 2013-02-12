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
	<aside class="page clearfix">
		<div class="wrapper">
			<div class="widget widget-links">
				<h3>Partenaires</h3>
				<ul>
					<li><img src="http://placehold.it/150x150&amp;text=STO" alt="STO"></li>
					<li><img src="http://placehold.it/150x150&amp;text=Petit Chicago" alt="STO"></li>
					<li><img src="http://placehold.it/150x150&amp;text=UQO" alt="STO"></li>
				</ul>
			</div>
		</div>
	</aside>

	   <footer class="page clearfix">
	   	<div class="wrapper">
		 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 2') ) : ?>
		<?php endif; ?>
			<div class="widget widget-contact">
				<h3>Contactez-nous</h3>
				<div class="vcard">
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
		</div>
		</footer>
<?php wp_footer(); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKvZQrhBQSUCsctvSphe_2yIRzwvzI2l4&amp;sensor=false"></script>
<script src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/script.js"></script>
</body>
</html>