<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

	<section class="sider sider-single">
		<div class="container">


				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; ?>


		</div>
	</section>

<?php get_footer(); ?>