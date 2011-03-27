<?php
/**
*	The main blog post template.
*	In here you can customize what's shown with Conditionals tags (like 'if(is_single())').
*/

?>

<article class="post">
	<header>
		<h1>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</h1>
		
		<p class="meta">
			<time datetime="<?php the_time('c') ?>" pubdate><?php the_time('F j, Y') ?></time>
		</p>
	</header>
	
	
	<div class="post-text">	
		<?php the_content('Read the rest of this entry &raquo;'); ?>
	</div>
	
	<?php if(is_single()):?>
		<footer>
			<p><?php previous_post_link('&laquo; %link') ?> <?php next_post_link('%link &raquo;') ?></p>
			<p>Tagged <?php the_tags("", ", ", ""); ?></p>
		</footer>
	<?php endif;?>

</article>