<?php get_header(); 

//$course = LP_Global::course();
?>

<main id="site-content">

		<?php 
		$gcat = get_object_taxonomies('lp_course');
		$cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[0]);
		$tag = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
		$ptg = '';
        foreach ($tag as $pt) {
            $ptg .= $pt->slug.' ';
        }
		foreach($cat as $term) {
		  $category = $term->name;
		  $categorySlug = $term->slug;
		}
 		?>		

		<?php

		if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				// If the page has WooCommerce shortcodes, make the inner sections wide
				$content = get_the_content();


				?>

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					
					<div class="breadcrumbs"><a href="<?php bloginfo('url')?>/cursos">Cursos</a> <i class="fa fa-angle-right"></i> <a href="<?php bloginfo('url')?>/cursos/?u=<?=$categorySlug?>"><?= $category;  ?> </a> <i class="fa fa-angle-right"></i> <?php the_title(); ?></div>

						
					<div class="wp-small">
						<div class="featured-course">
						<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>


						<!-- <div class="items">
							<div class="time"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-reloj.svg" alt="Reloj"> <?= conversorSegundosHoras($course->get_duration()) ?></div>
							<div class="file"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-page.svg" alt="Page"> Sin evaluación</div>
							<div class="lessons"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-book.svg" alt="Book"> 
	                        <?php
	                        $curriculum = $course->get_curriculum();
	                        $clases = 0;
	                        foreach ( $curriculum as $section ) {
	                            $clases += count($section->get_items());
	                        };
	                        echo $clases;
	                        ?>
	                         Lecciones</div>
						</div> -->
						<div class="courseCategory">
							<div class="categories"><small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small></div>
					
							<div class="tags">
								<?php foreach ($tag as $tg) {
									echo "<a href='".get_bloginfo('url')."/tags/?t=".$tg->slug."' class='tags'>".$tg->name."</a>";
								} ?>
								
							</div>
							<a href="" class="share"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/share.svg" alt="share"></a>
						</div>

						<?php if ( has_excerpt() ) : ?>

							<p class="sans-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>

						<?php endif; ?>

				
						</div>

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
<?php 
function conversorSegundosHoras($tiempo_en_segundos) {
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

    $hora_texto = "";
    if ($horas > 0 ) {
        $hora_texto .= $horas . " hs. ";
    }

    if ($minutos > 0 ) {
        $hora_texto .= $minutos . " min.";
    }

    if ($segundos > 0 ) {
        $hora_texto .= $segundos . " seg.";
    }

    return $hora_texto;
}
?>
<?php get_footer(); ?>
