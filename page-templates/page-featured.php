<?php
/**
 * Template Name: Featured
 *
 * Page Template for featured posts with a slider, based on index.
 */

get_header(); ?>

	<section class="sider sider-featured">
		<div class="container">
			<div class="hero" id="hero-featured">

				<?php
					query_posts(array(
						'post_type' => 'post',
						'posts_per_page' => 14,
						'orderby' => 'asc'
					) );
				?>

				<?php while (have_posts()) : the_post(); ?>

					<article <?php post_class(); ?>>
						<header>
							<a href="<?php the_permalink();?>">
								<?php
									// Must be inside a loop.

									if ( has_post_thumbnail() ) {
										the_post_thumbnail('post-thumbnails', array('class' => 'img-responsive'));
									}
									else {
										echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
											. '/img/no-image.png" class="img-responsive" />';
									}
								?>
							</a>


						</header>

						<div class="hero-inner">
							<div class="meta">
								<small><i class="fa fa-clock-o"></i> Publisert: <?php the_time('F jS, Y'); ?></small>
							</div>
							<a href="<?php the_permalink();?>">
								<h1><?php the_title(); ?></h1>
							</a>
							<?php the_excerpt(); ?>
						</div>



					</article>

				<?php endwhile;?>

			</div>
		</div>
	</section>


<?php get_footer(); ?>