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

/*function gat_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  <div id="comment-<?php comment_ID(); ?>">
    <div class="comment-author vcard"> <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?> <?php printf(__('%s'), get_comment_author()) ?> </div>
    <?php if ($comment->comment_approved == '0') : ?>
    <em>
    <?php _e('Your comment is awaiting moderation.') ?>
    </em> <br />
    <?php endif; ?>
    <div class="comment-meta commentmetadata"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
      <?php edit_comment_link(__('(Edit)'),'  ','') ?>
    </div>
    <?php comment_text() ?>
    <div class="reply">
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
  </div>
  <?php // Missing </li> is on intentional, as Wordpress adds it autoatically. Why or how? I'm not sure.
        }*/

// ----------------------------------------------
// Add Emissions
// ----------------------------------------------

add_action( 'init', 'add_emissions_post_type');



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




// ----------------------------------------------
// Option Page
// ----------------------------------------------
/*$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift($wp_cats, "Choose a category");


$options = array (

array( "name" => $themename." Options",
	"type" => "title"),
	
array( "name" => "Social Media Bar",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Twitter",
	"desc" => "Enter your Twitter username",
	"id" => $shortname."_twitter",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Facebook",
	"desc" => "Enter your Facebook URL",
	"id" => $shortname."_facebook",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Dribbble",
	"desc" => "Enter your Dribbble username",
	"id" => $shortname."_dribbble",
	"type" => "text",
	"std" => ""),

array( "name" => "Zerply",
	"desc" => "Enter your Zerply username",
	"id" => $shortname."_zerply",
	"type" => "text",
	"std" => ""),
	
array( "name" => "DeviantART",
	"desc" => "Enter your DeviantART username",
	"id" => $shortname."_da",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Flickr",
	"desc" => "Enter your Flickr username",
	"id" => $shortname."_flickr",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Last.fm",
	"desc" => "Enter your Last.fm username",
	"id" => $shortname."_lastfm",
	"type" => "text",
	"std" => ""),

array( "name" => "Behance",
	"desc" => "Enter your Behance username",
	"id" => $shortname."_behance",
	"type" => "text",
	"std" => ""),

array( "type" => "close"),

);

function mytheme_add_admin() {

global $themename, $shortname, $options;

if ( $_GET['page'] == basename(__FILE__) ) {

	if ( 'save' == $_REQUEST['action'] ) {

		foreach ($options as $value) {
		update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

foreach ($options as $value) {
	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

	header("Location: admin.php?page=functions.php&saved=true");
die;

}
else if( 'reset' == $_REQUEST['action'] ) {

	foreach ($options as $value) {
		delete_option( $value['id'] ); }

	header("Location: admin.php?page=functions.php&reset=true");
die;

}
}

add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');
}

function mytheme_add_init() {
$file_dir=get_bloginfo('template_directory');
wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
}

/* Option Page Markup */
/*
function mytheme_admin() {


global $themename, $shortname, $options;
$i=0;

if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';

?>
<div class="wrap rm_wrap">
<h2><?php echo $themename; ?> Settings</h2>
<div class="rm_opts">
<form method="post">
  <?php foreach ($options as $value) {
switch ( $value['type'] ) {

case "open":
?>
  <?php break;

case "close":
?>
  </div>
  </div>
  <br />
  <?php break;

case "title":
?>
  <p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>
  <?php break;

case 'text':
?>
  <div class="rm_input rm_text">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php
break;

case 'textarea':
?>
  <div class="rm_input rm_textarea">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?>
</textarea>
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php
break;

case 'select':
?>
  <div class="rm_input rm_select">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
      <?php foreach ($value['options'] as $option) { ?>
      <option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
      <?php } ?>
    </select>
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php
break;

case "checkbox":
?>
  <div class="rm_input rm_checkbox">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php break; case "section":

$i++;

?>
  <div class="rm_section">
  <div class="rm_title">
    <h3><?php echo $value['name']; ?></h3>
    <span class="submit">
    <input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
    </span>
    <div class="clearfix"></div>
  </div>
  <div class="rm_options">
  <?php break;

}
}
?>
  <input type="hidden" name="action" value="save" />
</form>
<form method="post">
  <p class="submit">
    <input name="reset" type="submit" value="Reset" />
    <input type="hidden" name="action" value="reset" />
  </p>
</form>
<?php
}


add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');

function invictus_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  <div id="comment-<?php comment_ID(); ?>">
    <div class="comment-author vcard"> <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?> <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author()) ?> </div>
    <?php if ($comment->comment_approved == '0') : ?>
    <em>
    <?php _e('Your comment is awaiting moderation.') ?>
    </em> <br />
    <?php endif; ?>
    <div class="comment-meta commentmetadata"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
      <?php edit_comment_link(__('(Edit)'),'  ','') ?>
    </div>
    <?php comment_text() ?>
    <div class="reply">
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
  </div>
  <?php
        }*/