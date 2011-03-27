# Whiteboard for Wordpress

Whiteboard is "another naked, barebone, Wordpress theme", but still not quite. It serves as my starting point for every Wordpress project I'm starting working on, and includes an extensive library of nifty Wordpress helper functions.

I encourage you to poke around in the files and remove stuff you don't need. I've made the theme highly configurable and minimal, so you shouldn't have to remove too much.

## Constants

A few constants are set in Whiteboard's functions file:

- `JB_THEME_DIR`. The absolute path to the theme 

## Helpers

Helper functions. Included in `functions.php`. Put all your custom theme functions in here in order to keep things tidy. 

Some handy, time-saving functions:

### `link_to($page, [$echo = true])`

Link to a Wordpress page by providing the slug name (Note: a pretty permalink structure must have been setup).
	
	// In template:
	<a href="<?php link_to("about");?>">About me</a>
	
	// Produces:
	<a href="http://domain.com/about/">About me</a>

### `build_link($text, $page)`

Builds a complete <a> element with text and HREF attribute.

	// In template:
	<?php build_link("About me", "about");
	
	// Produces:
	<a href="http://domain.com/about/">About me</a>

After some use, it's incredibly nice to having to write HTML links all the time. You're also able to use IDs instead of page slugs, if you would want that (Ex: `link_to(2)`).

### `img_src($filename, [$echo = true])`

Remember how tedious it is to link to static images in some directory in your theme? Writing `bloginfo` and all that? Fear not, these image helpers will help you.

	// In template:
	<img src="<?php img_src("duck.png");?>" alt="Duck" />
	
	// Produces:
	<img src="http://domain.com/wordpress/wp-content/themes/<your-theme>/static/images/duck.png" alt="Duck" />

The path varies, of course. The path constant to the images directory is set at the top of `functions.php`.

### `img($filename, [$alt = ""])`

Builds the `<img>` element with just the filename and an optional `alt` attribute.

	// In template:
	<?php img("duck.png");?>
	
	// Produces:
	<img src="http://domain.com/wordpress/wp-content/themes/<your-theme>/static/images/duck.png" alt="" />


### `has_children()`

Used within a loop. Returns true if the current page has child pages.

	// In template:
	if(has_children()){
		// Do stuff
	}

### `is_child()`

Used withing a loop. Returns true if the current page is a child page.

	// In template:
	if(is_child()){
		// Do stuff
	}

### `show_posts_nav()`

Returns true if there's need to show a page navigation ("< Previous page, Next page >"). Hence there's no annoying navigation links if there are only a couple of posts listed. You set the post limit from wp-admin.

	// In template:
	if(show_posts_nav()){
		// Show some sort of navigation.
	}
	
### `slugify($text)`

"Slugifies" a text string, i.e. the function replaces spaces for hyphens, and non-ASCII characters for their equivalents.

	// In template:
	$text = "This is a text string"
	$slug = slugify($text);
	
	// Produces => 'this-is-a-text-string'.

