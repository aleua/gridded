<?php
/**
 * Template Name: Featured
 *
 * Page Template for featured posts with a slider, based on index.
 */

get_header(); ?>

	<section class="sider sider-featured">

		<div class="owl-carousel owl-theme hero" id="hero-featured">

			<?php
				query_posts(array(
					'post_type' => 'post',
					'posts_per_page' => 14,
					'orderby' => 'asc'
				) );
			?>

			<?php while (have_posts()) : the_post(); ?>

				<article <?php post_class(); ?>>

					<?php
						// Must be inside a loop.

						if ( has_post_thumbnail() ) {
							the_post_thumbnail('news-big');
						}
					?>

					<div class="hero-inner">
						<h1><?php the_title(); ?></h1>
						<div class="meta">
							<small><i class="fa fa-clock-o"></i> Publisert: <?php the_time('F jS, Y'); ?></small>
						</div>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink();?>" class="more-link" title="Les <?php the_title(); ?>">Les mer &raquo;</a>
					</div>

				</article>

			<?php endwhile;?>

		</div>
	</section>


<?php get_footer(); ?>