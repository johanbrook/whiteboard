<?php

get_header(); ?>

	<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
	
		<?php get_template_part("partials/post");?>

	<?php endwhile; ?>
	
		<?php if (show_posts_nav()) : ?>
		<nav>
			<ul>
				<li><?php next_posts_link('&laquo; Older Entries') ?></li>
				<li><?php previous_posts_link('Newer Entries &raquo;') ?></li>
			</ul>
		</nav>
		<?php endif; ?>

	<?php else : ?>

			<h1>Not Found</h1>
			<p>Sorry, but you are looking for something that isn't here.</p>
			<?php get_search_form(); ?>

	<?php endif; ?>


<?php get_footer(); ?>