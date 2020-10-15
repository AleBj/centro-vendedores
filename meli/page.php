<?php get_header(); 


?>

<main id="site-content">

		

		<?php

		if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				//$content = get_the_content();


				?>

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					

					<?php if ( has_post_thumbnail() ) : ?>

						<div class="featured-media">

							<?php the_post_thumbnail(); ?>

						</div><!-- .featured-media -->

					<?php endif;?>
					</div>

							<div class="featured-content">

								<?php
								the_content();

								wp_link_pages(); ?>
							</div>
						</div>
			
					

				</article>

				<?php

			endwhile;

		endif;

		?>

</main><!-- #site-content -->
<?php get_footer(); ?>
