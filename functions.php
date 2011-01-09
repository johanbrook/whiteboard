<?php
/**
 * @package WordPress
 * @subpackage Dyluni
 * Written by Johan Brook except where noted.
 */

automatic_feed_links();
add_editor_style("style/css/editor-style.css");
add_theme_support( 'post-thumbnails' );

# Replace with your own dimensions

set_post_thumbnail_size(588, 364, true);



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


# Custom header image
#
# Replace with your own values/dimensions!

define('HEADER_IMAGE', '%s/style/images/hero.png');
define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 980 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 365 ) );
define('NO_HEADER_TEXT', true);

add_custom_image_header( '', 'admin_header_style' );


// Add custom post types to RSS feed. Normally only regular posts are included.

function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		
		# Specify your custom post types here, including the standard "post"
	
		$qv['post_type'] = array('post', 'portfolio');
		
	return $qv;
}
add_filter('request', 'myfeed_request');


/*	JAVASCRIPT registrations. Hate this bulky shit.
-------------------------------------------------*/

if ( !is_admin() ) {
	$style_dir = get_bloginfo("stylesheet_directory")."/style/js/";
   wp_deregister_script('jquery');
	
	# I use a local copy of jQuery in dev mode. To fetch from Google, uncomment next line and remove the local line
	
   #wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"), false, "1.4.2", true);
   wp_register_script('jquery', ($style_dir . "jquery-1.4.2.min.js"), false, "1.4.2", true);
   wp_enqueue_script('jquery');
   
	# Handy jQuery library for all sorts of things. See more at http://flowplayer.org/tools/index.html
	# The included file is only a build of the Tab feature, I don't need the whole package sometimes.
	# Visit the site to build your own

   #wp_register_script('jquery-tools', ($style_dir . "jquery.tools.min.js"), array("jquery"), "1.2.5", true);
   #wp_enqueue_script('jquery-tools');

	# For smooth scrolling on local anchors
	
   wp_register_script('jquery-smoothscroll', ($style_dir . "jquery.smoothscroll.min.js"), array("jquery"), "1.3", true);
   wp_enqueue_script('jquery-smoothscroll');
   

	# And finally the local functions Javascript file
	
   wp_register_script('dyluni', $style_dir ."dyluni.js", array("jquery"), "1.0", true);
   wp_enqueue_script('dyluni');

}


/* WIDGETS
----------------------------------------------*/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => "Global sidebar",
		'id' => 'global'
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
}

/* CUSTOM POST TYPES */
/*-----------------------------------------*/

add_action("init", "register_my_posttypes");
function register_my_posttypes(){
	$portfolio_labels = array(
		"name" => "Portfolio items",
		"singular_name" => "Portfolio item",
		"add_new_item" => "Add portfolio item",
		"edit_item" => "Edit portfolio item",
		"new_item" => "New portfolio item",
		"view_item" => "View the item",
		"not_found" => "No portfolio items"
	);

	$portfolio_args = array(
		"labels" => $portfolio_labels,
		"public" => true,
		"show_ui" => true,
		"cabability_type" => "post",
		"rewrite" => array("slug" => "work"),
		"description" => "My portfolio items",
		"supports" => array("title", "editor", "custom-fields", "thumbnail", "excerpt")
	);
	
	register_post_type("portfolio", $portfolio_args);
}

/* TAXONOMIES */
/*-----------------------------------------*/

$labels = array(
	"singular_name" => "Type",
	"search_items" => "Search types",
	"popular_items" => "Most used types",
	"all_items" => "All types",
	"edit_item" => "Edit portfolio type",
	"update_item" => "Update type",
	"add_new_item" => "Add new portfolio type",
	"new_item_name" => "New type name",
	"separate_items_with_commas" => "Separate with commas",
	"add_or_remove_items" => "Add or remove types"
);

register_taxonomy("portfolio-type", "portfolio",
	array(
		"label" => "Portfolio types",
		"labels" => $labels,
		"public" => true,
		"query_var" => true,
		"rewrite" => array("slug" => "type"),
		"capabilities" => array("manage_terms", "edit_terms", "delete_terms")
	));


/* MENUS
----------------------------------------*/

register_nav_menu( 'subnav', 'Sub navigation on pages' );


/* ADD META BOX FOR CUSTOM FIELDS */
/*-----------------------------------------*/

$prefix = 'jb_';

$meta_box = array(
    'id' => 'year-box',
    'title' => 'År',
    'page' => 'portfolio',
    'context' => 'side',
    'priority' => 'low',
    'fields' => array(
        array(
            'name' => 'År',
            'desc' => 'När arbetet utfördes',
            'id' => $prefix . 'text',
            'type' => 'text',
            'std' => date("Y")
        )
    )
);

add_action('admin_menu', 'dyluni_add_box');

// Add meta box
function dyluni_add_box() {
    global $meta_box;
    
    add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function mytheme_show_box() {
    global $meta_box, $post;
    
    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    foreach ($meta_box['fields'] as $field) :?>

		<?php $meta = get_post_meta($post->ID, $field['id'], true);?>
		
		<input type="text" name="<?php echo $field["id"];?>" id="<?php echo $field["id"];?>" value="<?php if($meta) echo $meta; else echo $field['std'];?>" size="30" />
		
		<p class="howto"><?php echo $field["desc"]; ?></p>
		
	<?php endforeach; ?>
		
<?php }

add_action('save_post', 'mytheme_save_data');

// Save data from meta box
function mytheme_save_data($post_id) {
    global $meta_box;
    
    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}


/* HELPER FUNCTIONS
----------------------------------------*/

/**
*	Wrapper function for linking to pages.
*/
function link_to($page){
	echo get_bloginfo("url")."/$page";
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
add_filter( 'the_permalink', 'root_relative_permalinks' );


/**
* Formats the pubdate of the post to remove the current year
*/
function the_time_spec(){
	global $post;
	$time = get_the_time("Y", $post->ID);
	if($time == date("Y"))
		echo get_the_time("F j", $post->ID);
	else
		echo get_the_time("F j, Y", $post->ID);
}


/**
* Custom wrapper function to retrieve stuff from database quickly. Suitable for "Latest post" etc. in sidebars. 
* @args $args - The arguments, as query string or array.
*/
function list_archives($args, $error_msg = "There are no posts yet."){
	$items = get_posts($args);
	if($items){
		foreach($items as $item):?>
			
			<li><a href="<?php echo get_permalink($item->ID);?>"><?php echo $item->post_title;?></a></li>
			
		<?php endforeach;
	}else{
		echo '<li>'.$error_msg.'</li>';
	}
}


/**
*	Look for child pages
*/

function has_children(){
	global $post;
	$children = get_pages("child_of=".$post->ID);
	
	if($children || count($children) != 0)
		return true;
	else
		return false;
}

/**
*	Check if the page is a child page
*/

function is_child(){
	global $post;
	
	if($post->post_parent){
		$pages = get_pages("child_of=".$post->post_parent);
		if($pages)	
			return true;
		else		
			return false;
	}
}


/**
*	Experimental function. I honestly use WP 3.0's menus more nowadays.
*/

function list_page_tree(){
	global $post;
	global $wp_query;
	
	if(empty($wp_query->post->post_parent))
		$parent = $wp_query->post->ID;
	else
		$parent = $wp_query->post->post_parent;
	
	$pages = get_pages("child_of=".$parent);
	if($pages){
		
		if(is_page($parent))
			$current = 'class="current"';
		
	echo '<li '. $current .'><a href="'. get_permalink($parent) .'">'. get_the_title($parent) .'</a></li>';
		
	foreach($pages as $item):?>
		
		<li <?php if(is_page($item->ID)) echo 'class="current"'; ?>><a href="<?php echo get_permalink($item->ID); ?>"><?php echo get_the_title($item->ID);?></a></li>
	<?php endforeach;
	}
}



/**
*	Returns (or echoes) the number of posts per category.
*/

function posts_per_category($id, $echo = true) {
	global $wpdb;
	$query = "SELECT count FROM ".$wpdb->term_taxonomy." WHERE term_id = ".$id;
	$num = $wpdb->get_col($query);
	
	if($echo)
		echo $num[0]; 
	else
		return $num[0];
}

/**
* Extracts the images or only the text in a post
* @args $type - "image" or "text". 
*/

function jb_the_content($type = "text", $echo=true){
	global $post;
	$content = $post->post_content;
	$content = apply_filters("the_content", $content);
	
	if($type == "image"){
		preg_match_all('/<img[^>]+>/', $content, $matches);
		$ret = multi_implode("", $matches);
		#$ret = $matches;		
	}else if($type == "text"){
		$ret = preg_replace('/<p><img[^>]+><\/p>/', "", $content);
	}
	
	if($echo)
		echo $ret;
	else
		return $ret;
}

/**
*	Acts as the PHP function implode(), but with improved support for multi-dimensional arrays.
*/
function multi_implode($glue, $pieces){
    $string='';
    
    if(is_array($pieces)){
        reset($pieces);
        while(list($key,$value)=each($pieces)){
            $string .= $glue.multi_implode($glue, $value);
        }
    }
    else{
        return $pieces."\n";
    }
    
    return trim($string, $glue);
}



/**
*	Make the main heading in users' RSS reader lead to the attached link (custom field: Link).
*	Be sure to change the custom field to the name of what you're using.
*/

function jb_permalink_rss($content) {
	global $wp_query;
	$postid = $wp_query->post->ID;
	$link = get_post_meta($postid, 'Link', true);
	
	if(is_feed()) {
		if($link !== '') {
			$content = $link;
		}
		else {
			$content = get_permalink($postid);
		}
	}
	
	return $content;
}

/**
*	If a custom field Link is attached, show a permalink at the bottom
*/
function jb_add_permalink_to_content($content){
	global $wp_query;
	$postid = $wp_query->post->ID;
	$link = get_post_meta($postid, 'Link', true);
	
	if(is_feed()){
		if($link !== ''){
			$content = $content . "<p><a href='". get_permalink($postid) ."' title='permalink'>Permalink ›</a></p>\n";
		}else{
			$content = $content;
		}
	}
	
	return $content;
}
add_filter('the_permalink_rss', 'jb_permalink_rss');
add_filter('the_content', 'jb_add_permalink_to_content');
add_filter('the_excerpt_rss', 'jb_add_permalink_to_content');



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


/* Use the actual short URL in shortlinks */
add_filter( 'the_shortlink', 'my_shortlink', 10, 4 );
function my_shortlink( $link, $shortlink, $text, $title ){
	return $shortlink;
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

# The old way
function add_google_analytics() {
	echo '<script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'var pageTracker = _gat._getTracker("UA-4471592-8");'.PHP_EOL;
	echo 'pageTracker._trackPageview();'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}

# The new, asynchronous way
function add_google_analytics_async(){
	echo "<script type='text/javascript'>".PHP_EOL."
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-4471592-8']);
		_gaq.push(['_trackPageview']);
		(function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>".PHP_EOL;
}
# Uncomment in production!
#add_action('wp_head', 'add_google_analytics_async');	

