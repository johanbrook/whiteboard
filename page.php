<?php

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<article class="page">
		
			<h1><?php the_title(); ?></h1>
			
			<div class="post-text">
				<?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
				<?php edit_post_link('Edit this page.', '<p>', '</p>'); ?>
			</div>
			
		</article>
		
		<?php endwhile; endif; ?>

<?php get_footer(); ?>