# Whiteboard for Wordpress

Whiteboard is "another naked, barebone, Wordpress theme", but still not quite. It serves as my starting point for every Wordpress project I'm starting working on, and includes an extensive library of nifty Wordpress helper functions.

I encourage you to poke around in the files and remove stuff you don't need. I've made the theme highly configurable and minimal, so you shouldn't have to remove too much.

## Interesting files and directories

### `functions.php`

The heart of every Wordpress theme. In Whiteboard, `functions.php` serves as a config file where you register menus, widgets, sidebars and more. Constans are set and theme supports are added. In the "Configuration" section you're able to customize some values, and add your own.

### `library/helpers.inc.php`

Helper functions. Included in `functions.php`. Put all your custom theme functions in here in order to keep things tidy. 

Some handy, time-saving functions:

#### `link_to($page, [$echo = true])`

Link to a Wordpress page by providing the slug name (Note: pretty permalinks must be setup).

Usage:
	
	// In template:
	<a href="<?php link_to("about");?>">About me</a>
	
	// Produces:
	<a href="http://domain.com/about/">About me</a>

#### `build_link($text, $page)`

Builds a complete <a> element with text and HREF attribute.
	
Usage:

	// In template:
	<?php build_link("About me", "about");
	
	// Produces:
	<a href="http://domain.com/about/">About me</a>

After some use, it's incredibly nice to having to write HTML links all the time.
