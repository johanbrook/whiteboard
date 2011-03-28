# Whiteboard for Wordpress

Whiteboard is "another naked, barebone, Wordpress theme", but still not quite. It serves as the starting point for every Wordpress project I start working on, and includes an extensive library of nifty Wordpress helper functions.

I encourage you to poke around in the files and remove stuff you don't need.

## Constants

URL constants:

- `JB_THEME_DIR`. The absolute URL to the theme directory. Could for example be: `http://domain.com/wordpress/wp-content/themes/<your-theme>/`. This constant is preferrable over calling the `bloginfo("stylesheet_directory")` all the time.
- `JB_JS_DIR`. The absolute URL to the Javascript directory. Defaults to `JB_THEME_DIR . static/js/`.
- `JB_IMG_DIR`. The absolute URL to the images directory. Defaults to `JB_THEME_DIR . static/images/`.
- `JB_CSS_DIR`. The absolute URL to the stylesheet directory. Defaults to `JB_THEME_DIR . static/css/`.

Some more configurable constants you should have a look at:

- `GOOGLE_ANALYTICS_ID`. Your Google Analytics id. Fill it in and uncomment the `add_action(..)` row just below to add Analytics to the footer.
- `EXCERPT_LENGTH`. The global length in characters of post excerpts. Defaults to 40 characters.
- `USE_ROOT_RELATIVE_LINKS`. Set to false if you don't want to use relative permalink ("/some/page/" instead of "http://domain.com/some/page/").
- `USE_JQUERY`. Set to false to deactivate registration of the jQuery library in the theme.


## Helpers

Helper functions. Included in `library/helpers.inc.php`. Put all your custom theme functions in here in order to keep things tidy. 

Some handy, time-saving functions:

### `link_to($page, [$echo = true])`

Link to a Wordpress page by providing the slug name (Note: a pretty permalink structure must have been setup).
	
	// In template:
	<a href="<?php link_to("about");?>">About me</a>
	
	// Produces:
	<a href="http://domain.com/about/">About me</a>

### `build_link($text, $page)`

Builds a complete `<a>` element with text and href attribute.

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

"Slugifies" a text string, i.e. the function replaces spaces for hyphens, and non-ASCII characters for their equivalents, and makes it all lowercase.

	// In template:
	$text = "This is a text string"
	$slug = slugify($text);
	
	// $slug => 'this-is-a-text-string'.
	
## HTML

The theme's HTML is valid HTML5, complete with ARIA roles for accessibility. The theme's HTML structure (for a regular page, for example) is as follows:

	body
	|__ header[role="banner"]
		|__ hgroup
			|__ h1 "Site title"
			|__ h2 "Subtitle/Description"
		|__ nav[role="navigation"]
		
	|__ section[role="main"]
	    |__ article.page
			|__ h1 "Page title"
		
	|__ footer[role="contentinfo"]
	
Not too hard to grasp. These selectors are invaluable to have when targeting elements from the CSS as well (instead of having IDs and class attributes set). As you see, it's in `section[role="main"]` the main content goes (duh). I also advise you to use the `body` element as the main container for the site, and use the `html` element for background image/color.


## Javascripts

There's no crazy use of Javascript built in – that's up to you to write – but some Javascript files are included. In the `style/js` directory you'll find:

- `whiteboard.js`. The main script file. Automatically loaded. Put your custom code and setup functions here.
- `html5.js`. Self-hosted HTML5 Shim for IE 8 and below. Automatically included in the `<head>`. Rather than using Google's I prefer using a local copy. Why? Imagine if Google Code would go down – every IE user with or below 8.0 would see a broken site.
	
I've tossed a few handy libraries along with Whiteboard (lives in the `static/js/library` directory):

- `jquery-1.5.1.min.js`. Local copy of jQuery 1.5.1.
- `jquery.hashgrid.js`. Superb grid tool. Sets up a customizable (through CSS) grid overlay which can be shown with the 'G' key. More info on [http://hashgrid.com](http://hashgrid.com/). 
- `jquery.retina.js`. If you're targeting the iPhone 4, this handy script will replace all regular images on your site with (by you created) high-res images named after Apple's "@2x" convention.
- `jquery.smoothscroll.js`. Smoothscroll on anchor links. Automatically loaded.
- `modernizr-1.7.min.js`. See [Modernizr.com](http://www.modernizr.com/). Detects HTML5, CSS3 and other modern browser features.

For more JS polyfills, please see [https://github.com/Modernizr/Modernizr/wiki/HTML5-Cross-browser-Polyfills](https://github.com/Modernizr/Modernizr/wiki/HTML5-Cross-browser-Polyfills).


### Global theme path variable

A thing I've used recently is the global Javascript variable `THEME_DIR`. In the footer, this variable is set to the path to the Wordpress theme directory, so you're able to reach theme files from within Javascript files, for example when writing Ajax functions which are talking to a PHP script in your theme:

	// In whiteboard.js:
	$.get(THEME_DIR + "server-script.php", {name: "John"}, function(data){
		// Do stuff with data
		
		// Very handy when inserting external images as well:
		$(this).after("<img src='"+ THEME_DIR +"static/images/loader.gif' />");
	});

This means you don't have to hard code the theme directory into the Javascript code (which is very, very bad when you want to migrate or deploy your site). The `THEME_DIR` Javascript variable is the same as the `JB_THEME_DIR` PHP constant.

## CSS

Whiteboard is a Wordpress theme template only – there's no boilerplate CSS included. For that I recommend you to have a look at my [Sass framework](https://github.com/johanbrook/dyluni "Dyluni Framework"). However, in the `style/css` directory, there are styles for the visual editor in wp-admin, styles for the login screen, and several patch files for IE.


## Other features

### Partials

Instead of writing the same template code over and over again, you should use partials. There's one partial included in Whiteboard – `post.php` – which is the main post template. It's included with the `get_template_part("partials/_post")` construct. I advise you to use partials (put them in the partials directory) whenever you find yourself writing the same code twice or more.

### Body classes
Whiteboard's functions file automatically adds browser names to the theme's `body` class. This means you're able to target specific browsers in your CSS and Javascripts. Ex. if a user running Firefox visits the site, the body class looks like `<body class="firefox">`. Also supports the iPhone body class.
	
	
### Real shortlinks

Whiteboard uses **real** shortlinks when using the Wordpress template tag `the_shortlink()`, i.e. it outputs the raw URL rather than a pre-built link element.


### Custom backend styles

Automatically adds references to `editor-style.css`, where CSS styles for the visual editor in wp-admin goes, as well as `login.css` which lets you style the login screen (`wp-login.php`).


## General security tips

### Place Wordpress in its own directory.

Don't keep Wordpress directly in the web root. The web root is usually `public_html` or some other name if you're using a subdomain. It's a security concern – any naughty individual could guess your whole Wordpress installation structure with ease (which isn't optimal). Personally, I find it cluttering with all Wordpress core files in my web root as well.

The solution is to put the whole Wordpress core in a separate directory (`core`, for instance) and put an `index.php` in the web root which "starts up" Wordpress:

	public_html/
		index.php
		-- core/
			-- wp-admin/
			-- wp-content/
			-- etc, etc.

In `index.php` it should say:

	<?php
	/**
	 * Front to the WordPress application. This file doesn't do anything, but loads
	 * wp-blog-header.php which does and tells WordPress to load the theme.
	 *
	 * @package WordPress
	 */

	/**
	 * Tells WordPress to load the WordPress theme and output it.
	 *
	 * @var bool
	 */
	define('WP_USE_THEMES', true);

	/** Loads the WordPress Environment and Template */
	require('./core/wp-blog-header.php');
	?>
	
Change `core` in the `require('./wordpress/wp-blog-header.php');` line to the name of the sub-directory you keep Wordpress in. More info may be found in the [Wordpress Codex page about this topic](http://codex.wordpress.org/Giving_WordPress_Its_Own_Directory). 

### Protecting wp-config.php

wp-config.php is an important file, since it contains sensitive stuff about the database, and more. To prevent anyone to view the contents of wp-config, put this in your `.htaccess` file:

	<files wp-config.php>
		order allow,deny
		deny from all
	</files>
	
Double-check the path to your installation's wp-config.php. More info at [http://www.devlounge.net/code/protect-your-wordpress-wp-config-so-you-dont-get-hacked](http://www.devlounge.net/code/protect-your-wordpress-wp-config-so-you-dont-get-hacked). I've included a `.htaccess` file in this theme with the code above.
