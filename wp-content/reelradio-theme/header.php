<?php
/**
 * Document header for the theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package reel_radio
 * @since reel_radio 1.0
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
   <header class="page" role="banner">
	   		<div class="background"></div>
	   		<div class="wrapper">
			   <div class="site-title logo ir"><a href="<?php echo get_option('home'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
			   <nav class="main-menu">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					<?php 	
							if (stripslashes(get_option("rr_twitter"))) {
								$twitter = "<li class=\"twitter\"><a href=\"http://twitter.com/". stripslashes(get_option("rr_twitter")) ."\" title=\"Twitter\" rel=\"me external\" ><i class=\"icon\">T</i></a></li>\n";
							}
							
							if (stripslashes(get_option("rr_youtube"))) {
								$youtube = "<li class=\"youtube\"><a href=\"http://www.youtube.com/user/". stripslashes(get_option("rr_youtube")) ."\" title=\"Youtube\" rel=\"me external\" ><i class=\"icon\">P</i></a></li>\n";
							}
							
							if (stripslashes(get_option("rr_facebook"))) {
								$facebook = "<li class=\"facebook\"><a href=\"https://www.facebook.com/pages/". stripslashes(get_option("rr_facebook")) ."\" title=\"Facebook\" rel=\"me external\" ><i class=\"icon\">F</i></a></li>\n";
							}
							
							$construct = "<ul class=\"links-social clearfix\">\n
							   			$twitter
										$facebook
										$youtube
										</ul>";
							   echo  $construct;
						?>
			   </nav>
		   </div>
	  </header>
