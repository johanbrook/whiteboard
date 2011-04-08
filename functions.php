<?php
/*
 	THE MAIN FUNCTIONS FILE	
 
	Written by Johan Brook except where noted.
 	
	//-style comments are my explanations and tips.
	#-style comments are for you to take action on (remove/let be)
	
	Here you'll find:
	
	1. SETUP				Setting up constants, menus, editor styles and more.
	2. CONFIGURATION		Where you probably want to poke around a bit. Some values to be set.
	3. MISC					Some Wordpress spring cleaning and utility features.
	4. jQUERY SETUP			Setting up and registrering jQuery the right way.
	5. SIDEBARS				Adding sidebars.
	6. CUSTOM POST TYPES	Adding a post type.
	7. EXCERPTS				Some post excerpt tweaking.
	8. GOOGLE ANALYTICS		Adding Google Analytics code to footer.
	
 */



/* SETUP
------------------------------------------------------*/

/* Defines a constant containing the absolute path to theme
 directories. Using 'bloginfo' all the time is tough on the database.*/

define("JB_THEME_DIR", get_bloginfo("stylesheet_directory") . "/");
define("JB_JS_DIR", JB_THEME_DIR . "static/js/");
define("JB_IMG_DIR", JB_THEME_DIR . "static/images/");
define("JB_CSS_DIR", JB_THEME_DIR . "static/css/");


// Include the helpers:

require_once "library/helpers.inc.php";



/* Add theme support for stuff */

add_theme_support("post-thumbnails");
add_theme_support("menus");
add_theme_support('automatic-feed-links');


/* Styles for the post/page editor in wp-admin. You can of course point this to any CSS file. */

add_editor_style("style/css/editor-style.css");


/* Add custom login styles: */

add_action("login_head", "custom_login_style");

function custom_login_style(){?>
	<link rel="stylesheet" href="<?php echo JB_CSS_DIR; ?>login.css" type="text/css" media="screen" />
<?php }



/* Nav menus */

#register_nav_menu( 'main-nav', 'Main navigation' );




/* CONFIGURATION
------------------------------------------------------*/

/* Google Analytics */

// Fill in your Google Analytics tracking code:
define("GOOGLE_ANALYTICS_ID", "XX-XXXXXXX-X");

// Adds asynchronous Google Analytics to the <head> tag. Uncomment in production!:

#add_action('wp_head', 'add_google_analytics_async');


/* Post thumbnail sizes */

set_post_thumbnail_size(588, 364, true);

// Add more with the function 'add_image_size(String $name, int $width, int $height, bool $hardcrop)'


// The size (in characters) of the post excertps.
define("EXCERPT_LENGTH", 40);

// Set to false to not use root relative links, i.e. the absolute URL instead of URLs relative to
// your root domain. ('/some/page' instead of 'http://domain.com/your/page').

define("USE_ROOT_RELATIVE_LINKS", true);

// Register jQuery.
define("USE_JQUERY", true);




/* MISC
------------------------------------------------------*/


/* Clean up the <head> */

function remove_head_links() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
}
add_action('init', 'remove_head_links');



/* Add custom post types to RSS feed. Normally only regular posts are included. */

function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		
		# Specify your custom post types here, including the standard "post"
	
		$qv['post_type'] = array('post', 'portfolio');
		
	return $qv;
}
add_filter('request', 'myfeed_request');


/**
*	Use the actual short URL in shortlinks.
*
*/
add_filter( 'the_shortlink', 'my_shortlink', 10, 4 );
function my_shortlink( $link, $shortlink, $text, $title ){
	return $shortlink;
}



/**
*	Makes Wordpress URLs root relative (from http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/)
*/

function make_href_root_relative($input) {
    return preg_replace('!http(s)?://' . $_SERVER['SERVER_NAME'] . '/!', '/', $input);
}
function root_relative_permalinks($input) {
    return make_href_root_relative($input);
}
if(USE_ROOT_RELATIVE_LINKS == true){
	add_filter( 'the_permalink', 'root_relative_permalinks' );
}



/**
*	Adds the current browser as a class to the body tag. Handy for styling.
*
*/
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_safari, $is_chrome, $is_iphone;

	$is_win = stripos($_SERVER["HTTP_USER_AGENT"], "windows");
	
	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	
	// Adds 'windows' to the body class
	if($is_win !== false) $classes[] = 'windows';
	
	return $classes;
}	




/*	jQUERY SETUP
-------------------------------------------------*/

if ( !is_admin() && USE_JQUERY == true) {
	wp_deregister_script('jquery');

	// I often use a local copy of jQuery in dev mode, included in the style/js directory.

	wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"), false, "1.5.1", true);
	#wp_register_script('jquery', (JB_JS_DIR . "library/jquery-1.5.1.min.js"), false, "1.5.1", true);
	wp_enqueue_script('jquery');
}




/* SIDEBARS
----------------------------------------------*/

if ( function_exists('register_sidebar') ) {
	/*register_sidebar(array(
		'name' => "Global sidebar",
		'id' => 'global',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));*/
}






/* CUSTOM POST TYPES
-------------------------------------------------*/

add_action("init", "register_my_posttypes");

function register_my_posttypes(){
	
	// Labels in wp-admin for your post type
	$portfolio_labels = array(
		"name" => "Portfolio items",
		"singular_name" => "Portfolio item",
		"add_new_item" => "Add portfolio item",
		"edit_item" => "Edit portfolio item",
		"new_item" => "New portfolio item",
		"view_item" => "View the item",
		"not_found" => "No portfolio items"
	);
	
	// The parameters. Please see the Codex for all options: http://codex.wordpress.org/Function_Reference/register_post_type
	$portfolio_args = array(
		"labels" => $portfolio_labels,
		"public" => true,
		"show_ui" => true,
		"cabability_type" => "post",
		"rewrite" => array("slug" => "portfolio"),
		"description" => "My portfolio items",
		"supports" => array("title", "editor", "custom-fields", "thumbnail", "excerpt")
	);
	
	#register_post_type("portfolio", $portfolio_args);
}





/* EXCERPTS
-------------------------------------------------*/


/**
*	Sets the excerpt length. Stored in the EXCERPT_LENGTH constant.
*/
function jb_excerpt_length( $length ) {
	return EXCERPT_LENGTH;
}
add_filter( 'excerpt_length', 'jb_excerpt_length' );


/**
 * Adds the "Read More" link to custom post excerpts.
 *
 * @return string Excerpt with "Read More" link in the end.
 */
function custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= read_more_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'custom_excerpt' );


/**
* 	Returns a "Read more" link in excerpts
*
*	@args String $text: The text inside the link. Defaults to 'Read more'.
*	@args String $class: The class attribute. Defaults to 'read-more'.
*
*	@return String: The formatted link with an ellipsis in the front.
*/
function read_more_link($text = "Read more", $class = "read-more") {
	$link = '… <a class="%3$s" href="%2$s">%1$s</a>';
	
	return sprintf($link, $text, get_permalink(), $class);
}

add_filter( 'excerpt_more', 'read_more_link' );





/* GOOGLE ANALYTICS
--------------------------------------------------------*/

// The new, asynchronous way
function add_google_analytics_async(){?>
	
	<script>
	 var _gaq = [['_setAccount', '<?php echo GOOGLE_ANALYTICS_ID; ?>'], ['_trackPageview']];
	 (function(d, t) {
	  var g = d.createElement(t),
	      s = d.getElementsByTagName(t)[0];
	  g.async = 1;
	  g.src = '//www.google-analytics.com/ga.js';
	  s.parentNode.insertBefore(g, s);
	 }(document, 'script'));
	</script>

<?php
}
	

