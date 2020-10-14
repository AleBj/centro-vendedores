<?php get_header(); ?>

<main id="site-content">
	
	<div class="section-inner">

		<?php

		if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				// If the page has WooCommerce shortcodes, make the inner sections wide
				$content = get_the_content();


				?>

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					
					<div class="wp">
					

						<div class="section-inner max-percentage page-header text-center">

							<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

							<?php if ( has_excerpt() ) : ?>

								<p class="sans-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>

							<?php endif; ?>

						</div><!-- .post-header -->

			

					<?php if ( has_post_thumbnail() ) : ?>

						<div class="featured-media section-inner max-percentage medium">

							<?php the_post_thumbnail(); ?>

						</div><!-- .featured-media -->

					<?php endif;?>

					<div class="content_page">

						<?php
						the_content();

						
						?>

					</div><!-- .entry-content -->
					
					<div class="related-page"><?php 
						wp_link_pages(); ?></div>
					
					</div>

				</article>

				<?php

			endwhile;

		endif;

		?>

	</div><!-- .section-inner -->

</main><!-- #site-content -->

<?php get_footer(); ?>
