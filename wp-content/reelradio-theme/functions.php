<?php
// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'reel-radio', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );
	
$themename = "RÉÉL-Radio 2013";
$shortname = "rr";
$author = "http://paulmorel.com/";

// Set content_width. Hopefully it works
if ( ! isset( $content_width ) ) {
	$content_width = 620;
} 
// ----------------------------------------------
// Theme Tweaks
// ----------------------------------------------
// New Actions


// Remove WP head garbage
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3 );

// Secure WP a bit more
add_filter('get_comments_number', 'comment_count', 0);
add_filter('the_generator', 'remove_generator');
add_filter('login_errors', 'login_error_mess');

function remove_generator() {
	//People don't need to know which version of Wordpress we're running
	return '';	
}

function login_error_mess() {
	// Remove login error messages for security
	return 'ERROR: Invalid username or password.';	
}

// Extra Theme Support
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
  set_post_thumbnail_size( 700, 0, true );
  add_image_size( 'long', 660, 0, true );
  add_image_size( 'short', 340, 0, true );
  add_image_size( 'very-large', 940, 100, true );
  add_image_size( 'very-large-full', 940, 0, false );

  add_theme_support( 'nav-menus' );
}

// Filter trackbacks from comments
function comment_count($count) {
	if (!is_admin()) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));


		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}


// Replay jQuery
function replace_jquery() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',array(),'1.8.3',true);
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'init', 'replace_jquery' ); // Add Custom Menus

// ----------------------------------------------
// Wordpress 3.0 Navigation Menus
// ----------------------------------------------

// Modify WP3 Menu Makrup
function my_wp_nav_menu_args( $args = '' )
{
	$args['container'] = NULL;
	//$args['menu_class'] = NULL;
	return $args;
} // function

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' ); // Filter out garbage default menu markup

//Register Wordpress 3 dynamic menus for the theme
function custom_menus() {
	register_nav_menus(
		array(
		'primary' => __( 'Main Menu' )
		/*'secondary' => __( 'Extra Menu' ),
		'tertiary' => __( 'Extra Menu 2' )*/
		)
	);
}
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

add_action( 'init', 'custom_menus' ); // Add Custom Menus

//Modify Sidebar Markup
if ( function_exists('register_sidebars') )
    register_sidebars(2, array(
    	'name' => 'Sidebar %d',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

if ( ! function_exists( 'reel_content_nav' ) ) :

function reel_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class . ' clearfix' ?>">
	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', '_s' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', '_s' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Articles plus anciens', '_s' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="next"><?php previous_posts_link( __( 'Articles plus récents <span class="meta-nav">&rarr;</span>', '_s' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // _s_content_nav

/*function my_filter($posttypes)
{
    // to remove posttypes of a particular name
    foreach($posttypes as $key => $val)
    {
        if($val=='super_duper')
        {
            unset($posttypes[$key]);
        }
    }
 
    // to add posttypes e.g. page
    $posttypes[] = 'page';
 
    return $posttypes;
}*/
 
//add_filter('guar_sitemap_posttype_filter','my_filter',10,1);	


// WP Filters

// Provided by Webtreats
function content_formatter($content) {
	$new_content = '';

	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';

	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach ($pieces as $piece) {
		/* Look for presence of the shortcode */
		if (preg_match($pattern_contents, $piece, $matches)) {

			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {

			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'content_formatter', 99);
add_filter('widget_text', 'content_formatter', 99);

// ----------------------------------------------
// Updated HTML 5 Stuffs
// ----------------------------------------------

add_shortcode('wp_caption', 'gat_img_caption_shortcode');
add_shortcode('caption', 'gat_img_caption_shortcode');

function gat_img_caption_shortcode($attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;


if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';
$align = 'class="' . esc_attr($align) . '" ';

  return '<figure ' . $idtag . $align . 'aria-describedby="figcaption_' . $id . '" style="width: ' . (/*10 + (int)*/ $width) . 'px">' 
  . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';
}

// ----------------------------------------------
// Comment Structure
// ----------------------------------------------

function rr_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  <div id="comment-<?php comment_ID(); ?>">
    <h3 class="comment-author vcard"><?php printf(__('%s'), get_comment_author()) ?> </h3>
    <?php if ($comment->comment_approved == '0') : ?>
    <em>
    <?php _e('Your comment is awaiting moderation.') ?>
    </em> <br />
    <?php endif; ?>
    <div class="comment-meta commentmetadata"><?php printf(__('%1$s at %2$s'), get_comment_date('j F Y'),  get_comment_time()) ?>
      <?php edit_comment_link(__('(Edit)'),'  ','') ?>
    </div>
    <?php comment_text() ?>
  </div>
  <?php // Missing </li> is on intentional, as Wordpress adds it autoatically. Why or how? I'm not sure.
        }

// ----------------------------------------------
// Add Emissions
// ----------------------------------------------

add_action( 'init', 'add_emissions_post_type');
add_action( 'init', 'add_episodes_post_type');



function add_emissions_post_type() {

	// Custom Post Type Labels
	$labels = array('name' => _x('Émissions', 'post type general name'),
					'singular_name' => _x('Émission', 'post type singular name'),
					'add_new' => _x('Ajouter', 'portfolio item'),
					'add_new_item' => __('Ajouter une nouvelle émission'),
					'edit_item' => __('Modifier une émission'),
					'new_item' => __('Nouvelle émission'),
					'all_items' => __( 'Tous les émissions' ),
					'view_item' => __('Afficher émission'),
					'search_items' => __('Rechercher émissions'),
					'not_found' =>  __('Aucune émission trouvée'),
					'not_found_in_trash' => __('Aucune émission trouvée dans la corbeille'), 
					'parent_item_colon' => '',
					'menu_name' => 'Émissions');

	$args = array(	'labels'        => $labels,
					'description'   => 'Contient les émissions RÉÉL-Radio',
					'public'        => true,
					'menu_position' => 5,
					'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
					'has_archive'   => true,
	);

	register_post_type('emissions',$args );
			
	flush_rewrite_rules();
	
	/*// Adding the Custom Taxonomy for Credits
    register_taxonomy( 'tasks', 'portfolio', array(
			 'hierarchical' => false,
			 'label' =>  __('Tasks'), 
			 "singular_label" => __('Task'),
			 'rewrite' => array('slug' => 'tasks' )
		)
	);

	// Adding the Custom Taxonomy for Skills related to the portfolio item. Here we can add tags specific for this post type.
    register_taxonomy( 'skills', 'portfolio', array(
			 'hierarchical' => true,
			 "label" =>  __('Skills'), 
			 "singular_label" => __('Skill'),
			 'rewrite' => array('slug' => 'skills' )
		)
	);*/

}

function add_episodes_post_type() {

	// Custom Post Type Labels
	$labels = array('name' => _x('Épisodes', 'post type general name'),
					'singular_name' => _x('Épisode', 'post type singular name'),
					'add_new' => _x('Ajouter', 'portfolio item'),
					'add_new_item' => __('Ajouter un nouvel épisode'),
					'edit_item' => __('Modifier un épisode'),
					'new_item' => __('Nouvel épisode'),
					'all_items' => __( 'Tous les épisodes' ),
					'view_item' => __('Afficher épisode'),
					'search_items' => __('Rechercher épisodes'),
					'not_found' =>  __('Aucune épisode trouvée'),
					'not_found_in_trash' => __('Aucun épisode trouvée dans la corbeille'), 
					'parent_item_colon' => '',
					'menu_name' => 'Épisodes');

	$args = array(	'labels'        => $labels,
					'description'   => 'Contient les épisodes RÉÉL-Radio',
					'public'        => true,
					'menu_position' => 5,
					'supports'      => array( 'title', 'editor', 'custom-fields'),
					'has_archive'   => true
	);

	register_post_type('episodes',$args );
			
	flush_rewrite_rules();
	
	/*// Adding the Custom Taxonomy for Credits
    register_taxonomy( 'tasks', 'portfolio', array(
			 'hierarchical' => false,
			 'label' =>  __('Tasks'), 
			 "singular_label" => __('Task'),
			 'rewrite' => array('slug' => 'tasks' )
		)
	);

	// Adding the Custom Taxonomy for Skills related to the portfolio item. Here we can add tags specific for this post type.
    register_taxonomy( 'skills', 'portfolio', array(
			 'hierarchical' => true,
			 "label" =>  __('Skills'), 
			 "singular_label" => __('Skill'),
			 'rewrite' => array('slug' => 'skills' )
		)
	);*/

}
// Load Meta-Box Plugin

// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/include/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( STYLESHEETPATH . '/include/meta-box' ) );
// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

//
$prefix = 'rr_';

global $meta_boxes;

$meta_boxes = array();

$meta_boxes[] = array(
	'id'       => 'excerpt-size',
	'title'    => __('Dimensions', 'rr'),
	'pages'    => array('post'),
	'context'  => 'normal',
	'priority' => 'high',

	'fields'   => array(
		array(
			'name' => __('Dimensions de la boite de l\'article', 'rr'),
			'id'   => $prefix . 'dimensions',
			'type' => 'radio',
			'options' => array(
				'is-normal' => 'Normale',
				'is-long' => 'Large',
			),
			'std'  => ''
		)
	)
);


function rr_get_some_posts( $post_type )
{
	// set the criteria 
	$args = array(
		'post_type' => $post_type,
		'numberposts' => -1
	);
	// return the object array of the posts.
	return get_posts( $args );
}
$emissions_returned = rr_get_some_posts( 'emissions' );
foreach ( $emissions_returned as $emission_returned ) {
	$emissions_array[$emission_returned->post_name] = $emission_returned->post_title;
}
//var_dump ($emissions_array);

$meta_boxes[] = array(
	'id'       => 'join-emission',
	'title'    => __('Émission', 'rr'),
	'pages'    => array('episodes'),
	'context'  => 'normal',
	'priority' => 'high',

	'fields'   => array(
		array(
			'name' => __('Émission associée', 'rr'),
			'id'   => $prefix . 'emission',
			'type' => 'select',
			'options' => $emissions_array,
			'std'  => ''
		)
	)
);

/**
 * Register meta boxes
 *
 * @return void
 */
function register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded
//  before (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'register_meta_boxes' );


function customformatTinyMCE($init) {
	// Add block format elements you want to show in dropdown
	$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,h6';

	// Add elements not included in standard tinyMCE doropdown p,h1,h2,h3,h4,h5,h6
	//$init['extended_valid_elements'] = 'code[*]';
	return $init;
}

// Modify Tiny_MCE init
add_filter('tiny_mce_before_init', 'customformatTinyMCE' );

?>