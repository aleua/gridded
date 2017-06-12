<?php
/**
 * Template Name: Featured
 *
 * Page Template for featured posts with a slider, based on index.
 */

get_header(); ?>

	<section class="sider sider-blog">
		<div class="container">


				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'news-1' ); ?>

				<?php endwhile; ?>


		</div>
	</section>


<?php get_footer(); ?>