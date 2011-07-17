<?php


get_header(); ?>

<div role="main">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php get_template_part("partials/_post");?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

</div>

<?php get_footer(); ?>