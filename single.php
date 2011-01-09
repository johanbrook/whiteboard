<?php


get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


		<article class="post">
			<header>
				<h1><?php the_title(); ?></h1>
				<p class="meta"><time datetime="<?php the_time("c");?>" pubdate><?php the_time("F j, Y");?></time></p>
			</header>
			<div class="post-text">
				<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
				<?php edit_post_link('Edit this post.', '', ''); ?>
			</div>
			
			<footer>
				<?php previous_post_link('&laquo; %link') ?> <?php next_post_link('%link &raquo;') ?>
			</footer>
			
		</article>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

<?php get_footer(); ?>