<!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php language_attributes(); ?> class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
	
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="Paul Morel">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	
	<script src="<?php bloginfo('template_url'); ?>/js/libs/modernizr-1.6.min.js"></script>
	<!-- Wordpress Head -->
	<?php wp_head() ?>
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<!-- End Wordpress Head -->
	
</head>

<body <?php body_class() ?>>
<?php $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	if ($lang == 'fr') { ?>
		<div class="lang-warning"><p>Veuillez noter que la version française du site web est encore en dévelopment. <a href="http://paulmorel.com/2011/04/version-francaise/">Informations supplémentaires &raquo;</a></p></div>
<?php } ?>
<div class="wrapper">
	<header>
		<div class="logo ir"><a href="<?php echo get_option('home'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
		<?php wp_nav_menu(array('container_class' => 'main-nav','theme_location' => 'primary')); ?>
		<?php wp_nav_menu(array('container_class' => 'extra-nav-1','theme_location' => 'secondary','fallback_cb' => NULL)); ?>
		<?php wp_nav_menu(array('container_class' => 'extra-nav-2','theme_location' => 'tertiary','fallback_cb' => NULL)); ?>
		<ol class="drdre">
				<li class="snoop"></li>
				<li class="icecube"><a href=""><span></span></a></li>
			</ol>	
	</header>

