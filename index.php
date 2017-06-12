<?php
/**
 * The main template file.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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