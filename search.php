<?php

get_header(); ?>

	<?php if (have_posts()) : ?>

		<h1>Search Results – found <?php echo $wp_query->found_posts;?> posts</h1>

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

		<h2>No posts found. Try a different search?</h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

<?php get_footer(); ?>