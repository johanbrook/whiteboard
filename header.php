<!doctype html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<meta name="author" content="Johan Brook" />
<meta name="Copyright" content="Copyright Johan Brook <?php echo date("Y");?>. All Rights Reserved." />

<meta name="DC.title" content="<?php bloginfo("name"); ?>" />
<meta name="DC.subject" content="<?php bloginfo("description");?>" />
<meta name="DC.creator" content="Johan Brook" />
<link type="text/plain" rel="author" href="<?php echo JB_THEME_DIR;?>humans.txt" />
	
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
<link rel="shortcut icon" href="<?php echo JB_IMG_DIR;?>favicon.png"/>	
<link rel="apple-touch-icon-precomposed" href="<?php echo JB_IMG_DIR;?>iOS-icon.png"/>

<!--[if lt IE 9]>
<script src="<?php echo JB_JS_DIR;?>html5.js"></script>
<![endif]-->
	 
<!--[if IE]>
<link rel="stylesheet" href="<?php echo JB_CSS_DIR;?>patches/win-ie-all.css" media="all" />
<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> id="www-website-com">
	
	<header role="banner">
		<hgroup>
			<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			<h2><?php bloginfo('description'); ?></h2>
		</hgroup>
		
		<nav role="navigation">
			<?php
				wp_nav_menu(array(
					"theme_location" => "main-nav",
					"container" => false
				));
			?>
		</nav>
	</header>
	
	<section role="main">
	