<?php

get_header(); ?>

	<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
	
		<article class="post">
		
			<h1>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h1>
			
			<time datetime="<?php the_time('c') ?>" pubdate><?php the_time('F jS, Y') ?></time>
			
			<div class="post-text">	
				<?php the_content('Read the rest of this entry &raquo;'); ?>
			</div>
			
		
		</article>

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