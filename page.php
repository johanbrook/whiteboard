<?php

get_header(); ?>

<div role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<article>
		
			<h1><?php the_title(); ?></h1>
			
			<div class="post-text">
				<?php the_content(); ?>
				<?php edit_post_link('Edit this page.', '<p>', '</p>'); ?>
			</div>
			
		</article>
		
		<?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>