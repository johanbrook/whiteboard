<form role="search" action="<?php echo get_option("home");?>" method="GET">
	<input type="search" name="s" placeholder="Search and you will find" size="30"
		results="0"
		<?php if(is_search()):?> value="<?php the_search_query();?>" <?php endif;?>
	 />
</form>