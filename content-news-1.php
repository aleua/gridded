<?php
/**
 * The default template for displaying content.
 */
?>

	<article <?php post_class( array('class' => 'wow fadeInUp')); ?>>
		<header>
			<a href="<?php the_permalink();?>">
				<?php
					// Must be inside a loop.

					if ( has_post_thumbnail() ) {
						the_post_thumbnail('news', array('class' => 'img-responsive'));
					}
					else {
						echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
							. '/img/no-image.png" class="img-responsive" />';
					}
				?>
			</a>
			<div class="meta">
				<small><i class="fa fa-clock-o"></i> Publisert: <?php the_time('F jS, Y'); ?></small>
			</div>
			<a href="<?php the_permalink();?>">
				<h1><?php the_title(); ?></h1>
			</a>

		</header>

		<div>
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink();?>" class="more-link" title="Les <?php the_title(); ?>">Les mer &raquo;</a>
		</div>



	</article>