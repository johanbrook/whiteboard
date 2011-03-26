<?php

/* HELPER FUNCTIONS 
	For inclusion in 'functions.php'
----------------------------------------*/



/**
*	Wrapper function for linking to pages.
*
*	@args String $page: The slug of the page you're linking to
*	@args bool $echo: Prints (true) or returns (false) the permalink.
*
*	Usage: <a href="<?php link_to('about');?>">About me</a>
*/
function link_to($page, $echo = true){
	$link = get_permalink(get_ID_by_slug($page));
	if($echo && $link)
		echo $link;
	else
		return $link;
}


/**
*	Builds a HTML link element and prints it.
*
*	@args String $text: The text inside the link
*	@args String $page: The slug of the page you're linking to.
*/
function link($text, $page){
	$format = '<a href="%2$s">%1$s</a>';
		
	printf($format, $text, link_to($page, false));
}




/**
*	Wrapper function for including images with absolute paths in the theme.
*
*	@args String $filename: The name of the image. 
*/

function img($filename){
	echo get_bloginfo("stylesheet_directory")."/style/images/".$filename;
}

/**
*	Returns the ID from a slug
*/
function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page)
        return $page->ID;
	else
        return null;
}


/* Use the actual short URL in shortlinks */
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
add_filter( 'the_permalink', 'root_relative_permalinks' );


/**
* Related posts without plugin
*/
function related_posts() {
	echo '<ul>';
        global $post;
        $tags = wp_get_post_tags($post->ID);
        if($tags) {
        	foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
            	$args = array(
            	'tag' => $tag_arr,
            	'numberposts' => 5,
            	'post__not_in' => array($post->ID)
           		);
           	$related_posts = get_posts($args);
           		if($related_posts) {
           			foreach ($related_posts as $post) : setup_postdata($post); ?>
           		<li class="related_post"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
         <?php endforeach; } else { ?>
                <li class="no_related_post">No Related Posts Yet!</li>
         <?php   }
	}
	wp_reset_query();
	echo '</ul>';
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
*	Simple function to check if there are shortcodes in the post's content:
*/

function has_shortcode($shortcode){
	global $post;
	if(strrpos($post->post_content, $shortcode))
		return $shortcode;
	else if(strrpos($post->post_content, $shortcode) === 0)
		return $shortcode;
	else
		return false;
}



/**
 * Modifies a string to remove all non ASCII characters and spaces.
 */
function slugify($text) {	
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
 
    // trim
    $text = trim($text, '-');
 
    // transliterate
    if (function_exists('iconv'))
    {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
 
    // lowercase
    $text = strtolower($text);
 
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
 
    if (empty($text))
    {
        return 'n-a';
    }
 
    return $text;
}


?>