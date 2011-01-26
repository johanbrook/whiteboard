<?php
/**
 * @package WordPress
 * @subpackage Dyluni
 */
?>
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
	
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
<link rel="shortcut icon" href="/favicon.png"/>	
<link rel="apple-touch-icon-precomposed" href="/iOS-icon.png"/>

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	 
<!--[if IE]>
<link rel="stylesheet" href="<?php bloginfo("stylesheet_directory"); ?>/style/css/patches/win-ie-all.css" media="all" />
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
			
		</nav>
	</header>
	
	<section role="main">
	