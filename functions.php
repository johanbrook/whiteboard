<?php
/*
 	THE MAIN FUNCTIONS FILE	
 
	Written by Johan Brook except where noted.
 	
	//-style comments are my explanations and tips.
	#-style comments are for you to take action on (remove/let be)
	
 */



/* SETUP
------------------------------------------------------*/

// Defines a constant containing the absolute path to the theme 
// directory. Using 'bloginfo' all the time queries the database.

define("JB_TEMPLATE_DIR", get_bloginfo("stylesheet_directory"));
define("JB_JS_DIR", JB_TEMPLATE_DIR . "/style/js/");
define("JB_IMG_DIR", JB_TEMPLATE_DIR . "/style/images/");
define("JB_CSS_DIR", JB_TEMPLATE_DIR . "/style/css/");

// Include the helpers:

require_once "library/helpers.inc.php";



// Add theme support for stuff

add_theme_support("post-thumbnails");
add_theme_support("menus");


// RSS for everything:
automatic_feed_links();


// Styles for the post/page editor in wp-admin. You can of course point this to any CSS file.

add_editor_style("style/css/editor-style.css");


// Nav menus

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





/* MISC
------------------------------------------------------*/

// Clean up the <head>
function remove_head_links() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links', 2);
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





/*	jQUERY SETUP
-------------------------------------------------*/

if ( !is_admin() ) {
	$dir = get_bloginfo("stylesheet_directory")."/style/js/";
	wp_deregister_script('jquery');

	// I often use a local copy of jQuery in dev mode, included in the style/js directory.

	wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"), false, "1.5.1", true);
	#wp_register_script('jquery', ($dir . "jquery-1.5.1.min.js"), false, "1.5.1", true);
	wp_enqueue_script('jquery');
}




/* SIDEBARS
----------------------------------------------*/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => "Global sidebar",
		'id' => 'global',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
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
		"rewrite" => array("slug" => "work"),
		"description" => "My portfolio items",
		"supports" => array("title", "editor", "custom-fields", "thumbnail", "excerpt")
	);
	
	#register_post_type("portfolio", $portfolio_args);
}







/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return '<a class="read-more" href="'. get_permalink() . '">' . 'Continue reading &rarr;' . '</a>';
}

add_filter( 'excerpt_more', 'twentyten_continue_reading_link' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

function dyluni_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'dyluni_excerpt_length' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );



/**
*	Adds the current browser as a class to the body tag. Handy as hell for styling.
*/
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
	$is_win = stripos($_SERVER["HTTP_USER_AGENT"], "windows");
	
	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	if($is_win !== false) $classes[] = 'windows';
	return $classes;
}	





/**
 * Conditional Page/Post Navigation Links
 * http://www.ericmmartin.com/conditional-pagepost-navigation-links-in-wordpress-redux/
 * If more than one page exists, return TRUE.
 */
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}



/* GOOGLE ANALYTICS
--------------------------------------*/

# The new, asynchronous way
function add_google_analytics_async(){
	echo "<script type='text/javascript'>".PHP_EOL."
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '". GOOGLE_ANALYTICS_ID ."']);
		_gaq.push(['_trackPageview']);
		(function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>".PHP_EOL;
}
	

