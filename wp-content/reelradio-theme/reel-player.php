<?php
/**
 * Document header for the theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package reel_radio
 * @since reel_radio 1.0
  Template Name: Player
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]> 		   <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php wp_title('&laquo;', true, 'right'); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="Paul Morel">
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico"/>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	

	<script src="<?php bloginfo('template_url'); ?>/js/libs/modernizr-2.6.2.min.js"></script>

	<!-- Wordpress Head -->
	<?php wp_head() ?>
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<!-- End Wordpress Head -->
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>

<div id="wrap-player">	
   	<header class="hp-page" role="banner">
	   	<div class="hp-wrapper">
			<div class="hp-logo ir"><a href="<?php echo get_option('home'); ?>" target="_blank" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
		</div>
	</header>
    <section class="main-content clearfix">
     	<div class="p-wrapper">
			<h1><?php the_title(); ?></h1>
		      <div class="player">
				<code> 
					<audio id="wp_mep_1" type="audio/mp3" controls="controls" preload="none" autoplay >
					<source src="http://50.7.242.114:7561/listen" type="audio/mp3" />
					<object width="500" height="30" type="application/x-shockwave-flash" data="http://localhost:8888/rr_wordpress/wp-content/plugins/media-element-html5-video-and-audio-player/mediaelement/flashmediaelement.swf">
					<param name="movie" value="http://localhost:8888/rr_wordpress/wp-content/plugins/media-element-html5-video-and-audio-player/mediaelement/flashmediaelement.swf" />
					<param name="flashvars" value="controls=true&amp;file=http://50.7.242.114:7561/listen" />
					</object>
					</audio>
					<script type="text/javascript">
					jQuery(document).ready(function($) {
					$('#wp_mep_1').mediaelementplayer({
					m:1
					,features: ['playpause','current','progress','duration','volume','tracks','fullscreen']
					,audioWidth:500,audioHeight:30
					});
					});
					</script>
					</code>	
				</div>
		</div>
	</section><!-- section.site-content -->
	<footer>
		<b>Information : </b>
		<br>Si ce lecteur ne marche pas ou que vous ne souhaitez pas l'utiliser, cliquer sur ce lien : b><a href="http://50.7.242.114:7561/listen.m3u">http://50.7.242.114:7561/listen.m3u</a></b></br>
	</footer>
</div>   <!--wrap-player -->
</body>
</html>