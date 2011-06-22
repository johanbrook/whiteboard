<?php
/**
*	Included in 'functions.php'.
*
*	Sets up setting fields for use with the Options class.
*/


if(is_admin()){
	
	/*- THEME OPTIONS SETUP
	-------------------------------------------------*/
	
	/* First parameter is the name – prefix – of your options row in the database. 
		Second parameter is an array (handle, title) with the different sections in the options page.
	*/
	$options = new Theme_Options("whiteboard", array(
		array("handle" => "general", "title" => __("General settings"))
	));
	
	
	$general_text_standard = array(
		"type" => "text",
		"section" => "general",	// Corresponds to the 'general' section above
		"desc" => ""
	);
	
	/*
		Add settings with the 'add_setting' method. First parameter is the identifier of the
		setting – the string you call from your theme files. Second parameter is an array
		with all options:
		
		'id'      => 'default_field',
		'title'   => 'Default Field',
		'desc'    => 'This is a default description.',
		'std'     => '',
		'type'    => 'text', (textarea || checkbox || radio || select)
		'section' => 'general',	// Which section does the setting belong to?
		'choices' => array(),	// Array. If 'type' is 'radio' or 'select'.
		'class'   => ''
	
	
	*/
	$options->add_setting("frontpage-title", array(
		"type" => "text",
		"title" => __("Main heading on front page"),
		"std" => "Default heading"
	) + $general_text_standard);
	
	
	
	/*- META BOXES
	-------------------------------------------------*/
	
	$prefix = "wb_";

	$metaboxes = array();


	$metaboxes[] = array(
		"id" => "link",
		"title" => "Links",
		"context" => "side",
		"priority" => "low",
		"fields" => array(
			array(
				"name" => "Link",
				"id" => $prefix."test",
				"type" => "text"
			)
		)

	);


	foreach($metaboxes as $metabox){
		$mybox = new RW_Meta_Box($metabox);
	}
	
	
	
	/* SIDEBARS
	----------------------------------------------*/

	$zones = array(
		array(
			"name" => __("Frontpage, right column"),
			"id" => "front-main",
			"description" => __("Right column on front page"),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></section>',
			'before_title' => '<header><h1>',
			'after_title' => '</h1></header>'
		)
	);


	foreach($zones as $zone){
		register_sidebar($zone);
	}
	
	
	
}


?>