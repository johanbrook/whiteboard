<?php

/* HELPER FUNCTIONS 
	For inclusion in 'functions.php'
----------------------------------------*/



/**
*	Wrapper function for linking to pages.
*
*	@args String/int $page: The slug or ID of the page you're linking to
*	@args bool $echo: Prints (true) or returns (false) the permalink.
*
*	Usage: <a href="<?php link_to('about');?>">About me</a>
*/
function link_to($page, $echo = true){
	if(is_string($page))
		$page = get_ID_by_slug($page);
	
	$link = get_permalink($page);

	if($echo && $link)
		echo $link;
	else
		return $link;
}


/**
*	Builds a HTML link element and prints it.
*
*	@args String $text: The text inside the link
*	@args String/int $page: The slug or ID of the page you're linking to.
*/
function build_link($text, $page){
	$format = '<a href="%2$s">%1$s</a>';
		
	printf($format, $text, link_to($page, false));
}




/**
*	Wrapper function for including images with absolute paths in the theme.
*
*	@args String $filename: The name of the image file.
*	@args Bool $echo: Echo (true) the string or return it (false).
*/

function img_src($filename, $echo = true){
	if($echo)
		echo JB_IMG_DIR . $filename;
	else
		return JB_IMG_DIR . $filename;
}


/**
*	Builds an HTML image element and prints it.
*
*	@args String $filename: The name of the image file.
*	@args String $alt: The alt attribute. Defaults to no alt attribute.
*/
function img($filename, $alt = ""){
	$img = '<img src="%1$s" alt="%2$s" />';
	
	printf($img, img_src($filename, false), $alt);
}


/**
*	Returns the ID of a page from the slug.
*
*	@args String $page_slug: The slug.
*/
function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page)
        return $page->ID;
	else
        return null;
}




/**
* 	Related posts without plugin, based on tags and categories.
*
*	@args int $numberposts: How many posts to be shown. Defaults to 5.
*	@return An unordered list of related posts.
*/
function the_related_posts($numberposts = 5) {
	echo '<ul>';
        global $post;
        $tags = wp_get_post_tags($post->ID);

        if($tags) {
        	foreach($tags as $tag) { $tag_string .= $tag->slug . ','; }
            
			$args = array(
            	'tag' => $tag_string,
            	'numberposts' => $numberposts,
            	'post__not_in' => array($post->ID)
           	);

           	$related_posts = get_posts($args);
           		if($related_posts) {
           			foreach ($related_posts as $post) : setup_postdata($post); ?>
           		<li class="related-post"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
         <?php endforeach;
				
				} else { ?>
                
					<li class="no-related-posts">No Related Posts Yet!</li>

         <?php   }
	}
	wp_reset_query();
	echo '</ul>';
}



/**
*	Looks for child pages.
*
*	@return bool: True if the post/page has children.
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
*
*	@return bool: True if the page is a child.
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
 * Conditional Page/Post Navigation Links
 * http://www.ericmmartin.com/conditional-pagepost-navigation-links-in-wordpress-redux/
 * If more than one page exists, return TRUE.
 */
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}



/**
*	Make a string a 'slug', i.e. strip all non-ASCII characters, add hyphens for spaces etc.
*
*	@args String $text: The string to be slugified.
*	@return String: The slug.
*/
function slugify($text) {	
    // Replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
 
    // Transliterate
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
 
    $text = strtolower($text);
 
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
 
    if (empty($text)){
        return false;
    }
 
    return $text;
}


?>