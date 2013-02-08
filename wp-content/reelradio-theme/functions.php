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
$GLOBALS['content_width'] = 620;

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
  set_post_thumbnail_size( 700, 300, true );
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
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    	//'name' => 'Footer Widgets',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
	
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
// ----------------------------------------------
// New Short Codes
// ----------------------------------------------

/*function layout_one_third( $atts, $content = null ) {
	   extract( shortcode_atts( array(
      'last' => false,
      ), $atts ) );
	 
	  if ($last) {
	 	$class = ' col-last';
	  } else {
		$class = '';
  	  }

   return '<div class="col-one-third' . $class  . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'layout_one_third');

function layout_two_third( $atts, $content = null ) {
		   extract( shortcode_atts( array(
      'last' => false,
      ), $atts ) );
	 
	  if ($last) {
	 	$class = ' col-last';
	  } else {
		$class = '';
  	  }
   return '<div class="col-two-third' . $class  . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'layout_two_third');
function layout_one_half( $atts, $content = null ) {
		   extract( shortcode_atts( array(
      'last' => false,
      ), $atts ) );
	 
	  if ($last) {
	 	$class = ' col-last';
	  } else {
		$class = '';
  	  }
   return '<div class="col-one-half' . $class  . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'layout_one_half');

function shortcode_button( $atts, $content = null ) {
   return '<span class="red-button">' . do_shortcode($content) . '</span>';
}
add_shortcode('button', 'shortcode_button');

function shortcode_button2( $atts, $content = null ) {
   return '<span class="grey-button">' . do_shortcode($content) . '</span>';
}
add_shortcode('button2', 'shortcode_button2');

function shortcode_elegant( $atts, $content = null ) {
   return '<span class="elegant">' . do_shortcode($content) . '</span>';
}
add_shortcode('elegant', 'shortcode_elegant');

function shortcode_social( $atts, $content = null ) {
	
	if (stripslashes(get_option("gat_twitter"))) {
		$twitter = "<li class=\"twitter\"><a href=\"http://twitter.com/". stripslashes(get_option("gat_twitter")) ."\" title=\"Twitter\" rel=\"me external\" >Twitter</a></li>\n";
	}
	
	if (stripslashes(get_option("gat_zerply"))) {
		$zerply = "<li class=\"zerply\"><a href=\"http://zerp.ly/". stripslashes(get_option("gat_zerply")) ."\" title=\"Zerply\" rel=\"me external\" >Zerply</a></li>\n";
	}
	
	if (stripslashes(get_option("gat_dribbble"))) {
		$dribbble = "<li class=\"dribbble\"><a href=\"http://dribbble.com/". stripslashes(get_option("gat_dribbble")) ."\" title=\"Dribbble\" rel=\"me external\" >Dribbble</a></li>\n";
	}
	
	if (stripslashes(get_option("gat_da"))) {
		$da = "<li class=\"da\"><a href=\"http://". stripslashes(get_option("gat_da")) .".deviantart.com\" title=\"DeviantART\" rel=\"me external\" >DeviantART</a></li>\n";
	}
	
	if (stripslashes(get_option("gat_flickr"))) {
		$flickr = "<li class=\"flickr\"><a href=\"http://www.flickr.com/photos/". stripslashes(get_option("gat_flickr")) ."\" title=\"Flickr\" rel=\"me external\">Flickr</a></li>\n";
	}

	if (stripslashes(get_option("gat_flickr"))) {
		$flickr = "<li class=\"flickr\"><a href=\"http://www.flickr.com/photos/". stripslashes(get_option("gat_flickr")) ."\" title=\"Flickr\" rel=\"me external\">Flickr</a></li>\n";
	}
	
	if (stripslashes(get_option("gat_facebook"))) {
		$facebook = "<li class=\"facebook\"><a href=\"". stripslashes(get_option("gat_facebook")) ."\" title=\"Facebook\">Facebook</a></li>\n";
	}

	if (stripslashes(get_option("gat_lastfm"))) {
		$lastfm = "<li class=\"lastfm\"><a href=\"http://last.fm/user/". stripslashes(get_option("gat_lastfm")) ."\" title=\"Last.fm\" rel=\"me external\">Last.fm</a></li>\n";
	}
	
	$construct = "<ul class=\"links-social clearfix\">\n
	   			$zerply
	   			$twitter
				$dribbble
				$da
				$flickr
				$facebook
				$lastfm
				</ul>";
	   return  $construct;
}
add_shortcode('social', 'shortcode_social');

function shortcode_slider( $atts, $content = null ) {
   return '<div class="slider">
	<div class="slides_container">' . do_shortcode($content) . '</div></div>';
}
add_shortcode('slider', 'shortcode_slider');

function shortcode_slide( $atts, $content = null ) {
		   extract( shortcode_atts( array(
		  'caption' => '',
		  'date' => ''
		  ), $atts ) );
		 
		  if ($caption && $date) {
			$figcaption = "<figcaption>$caption<span>$date</span></figcaption>";
		  } elseif ($caption && !$date) {
			$figcaption = "<figcaption>$caption</figcaption>";
		  }

		  
		  return '<figure>' . do_shortcode($content) . $figcaption .'</figure>';
}
add_shortcode('slide', 'shortcode_slide');

/*function shortcode_timthumb( $atts, $content = null ) {
		   extract( shortcode_atts( array(
		  'width' => '',
		  'height' => ''
		  ), $atts ) );
		  $template = bloginfo('template_directory');
		  return  $template . "/inc/thumb.php?src='". do_shortcode($content) ."&w=$width&h=$height&zc=1&q=100";
}
add_shortcode('timthumb', 'shortcode_timthumb');*/

// Add Shortcodes to Tiny MCE
/*add_action('init', 'add_newshortcodes'); 
 
function add_newshortcodes() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin');
     add_filter('mce_buttons', 'register_newshortcodes');
   }
}

function register_newshortcodes($buttons) {
   array_push($buttons, "quote");
   return $buttons;
}*/

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
// Add Releases Post Type and Taxonomies
// ----------------------------------------------
/*
add_action( 'init', 'portfolio_post_type');
add_action( 'init', 'portfolio_builtin_taxonimies');

add_action( "admin_init", "portfolio_meta_boxes");
add_action('save_post', 'portfolio_save');
/*add_action("manage_posts_custom_column",  "portfolio_custom_columns");
add_filter("manage_edit-releases_columns", "portfolio_edit_columns");*/

/*
function portfolio_builtin_taxonimies() {
	register_taxonomy_for_object_type('category', 'portfolio'); 
	register_taxonomy_for_object_type('post_tag', 'portfolio'); 	
}



function portfolio_post_type() {
	
	// Add Releases Post Type
	register_post_type('portfolio', array(
			'labels' =>  $labels = array(
					'name' => _x('Portfolio', 'post type general name'),
					'singular_name' => _x('Portfolio Item', 'post type singular name'),
					'add_new' => _x('Add New', 'portfolio item'),
					'add_new_item' => __('Add New Portfolio Item'),
					'edit_item' => __('Edit Portfolio Item'),
					'new_item' => __('New Portfolio Item'),
					'view_item' => __('View Portfolio Item'),
					'search_items' => __('Search Portfolio Items'),
					'not_found' =>  __('No Portfolio Items found'),
					'not_found_in_trash' => __('No Portfolio Items found in Trash'), 
					'parent_item_colon' => ''),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => 'work'),
			'query_var' => true,
			'menu_position' => 20,
			'show_in_nav_menus' => false,
			/*'taxonomies' => array('category', 'post_tag'),*//*
			'supports' => array(
					'title',
					'editor',
					'custom-fields',
					'revisions',
					'thumbnail',)
			) );	
			
	flush_rewrite_rules();
	
	// Adding the Custom Taxonomy for Credits
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
	);


}


// Releases Meta Boxes


function portfolio_meta_boxes(){
  add_meta_box("addinfo_meta", "Additional Information", "addinfo_meta", "portfolio", "side", "high");
  add_meta_box("credits_meta", "Credits", "credits_meta", "portfolio", "normal", "low");
  add_meta_box("media_meta", "Previews &amp; Media", "media_meta", "portfolio", "normal", "low");

}
 

function addinfo_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $completion_date = $custom["completion_date"][0];
  $visit_link = $custom["visit_link"][0];
  ?>

<p>
  <label>Completion Date</label><br />
  <input name="completion_date" value="<?php echo $completion_date; ?>" />
</p>
<p>
  <label>Link</label><br />
  <input name="visit_link" value="<?php echo $visit_link; ?>" />
</p>
<?php
}

function credits_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $designers = $custom["designers"][0];
  $developers = $custom["developers"][0];
  $integrators = $custom["integrators"][0];
  $other_credits = $custom["other_credits"][0];
  ?>
  <p><label>Design Credits</label><br />
  <textarea cols="80" rows="6" name="designers"><?php echo $designers; ?></textarea></p>
  <p><label>Developer Credits</label><br />
  <textarea cols="80" rows="6" name="developers"><?php echo $developers; ?></textarea></p>
  <p><label>Integration Credits</label><br />
  <textarea cols="80" rows="6" name="integrators"><?php echo $integrators; ?></textarea></p>
  <p><label>Misc Credits</label><br />
  <textarea cols="80" rows="6" name="other_credits"><?php echo $other_credits; ?></textarea></p>

<?php

}
function media_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $flickr_set = $custom["flickr_set"][0];
  $preview = $custom["preview"][0];
  $preview_full1 = $custom["preview_full1"][0];
  $preview_full2 = $custom["preview_full2"][0];
  $preview_full3 = $custom["preview_full3"][0];
  ?>
  <p>
  <label>Flickr Set (Optional):</label>
  <input name="flickr_set" value="<?php echo $flickr_set; ?>"/>
</p>
<p>
  <label>Small Preview:</label>
  <input name="preview" value="<?php echo $preview; ?>"/>
</p>
<p>
  <label>Full Preview 1:</label>
  <input name="preview_full1" value="<?php echo $preview_full1; ?>" />
</p>
<p>
  <label>Full Preview 2:</label>
  <input name="preview_full2" value="<?php echo $preview_full2; ?>" />
</p>
<p>
  <label>Full Preview 3:</label>
  <input name="preview_full3" value="<?php echo $preview_full3; ?>" />
</p>
<?php

}
function portfolio_save(){
  global $post;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	    return $post->ID;
	}
	
  update_post_meta($post->ID, "completion_date", $_POST["completion_date"]);
  update_post_meta($post->ID, "visit_link", $_POST["visit_link"]);
  
  update_post_meta($post->ID, "designers", $_POST["designers"]);
  update_post_meta($post->ID, "developers", $_POST["developers"]);
  update_post_meta($post->ID, "integrators", $_POST["integrators"]);
  update_post_meta($post->ID, "other_credits", $_POST["other_credits"]);
  
  update_post_meta($post->ID, "flickr_set", $_POST["flickr_set"]);
  update_post_meta($post->ID, "preview", $_POST["preview"]);
  update_post_meta($post->ID, "preview_full1", $_POST["preview_full1"]);
  update_post_meta($post->ID, "preview_full2", $_POST["preview_full2"]);
  update_post_meta($post->ID, "preview_full3", $_POST["preview_full3"]);

}
 
/*function portfolio_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Release Title",
	"artist" => "Artist",
    "description" => "Description",
    "release_date" => "Release Date",
    "catalogue_number" => "Catalogue Number",
  );
 
  return $columns;
}
function releases_custom_columns($column){
  global $post;
 
  switch ($column) {
	case "artist":
      echo get_the_term_list($post->ID, 'artist', '', ', ','');
      break;
    case "description":
      the_excerpt();
      break;
    case "release_date":
      $custom = get_post_custom();
      echo $custom["release_date"][0];
      break;
	case "catalogue_number":
      $custom = get_post_custom();
      echo $custom["catalogue_number"][0];
      break;

  }
}*/
/*
// Custom Fields
function get_custom_field_value($szKey, $bPrint = false) {
	global $post;
	$szValue = get_post_meta($post->ID, $szKey, true);
	if ( $bPrint == false ) return $szValue; else echo $szValue;
}

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