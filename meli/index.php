<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 *
 * @package WordPress
 * @subpackage Liebre
 * @since 1.0.0
 */

get_header();
$course = LP_Global::course();
?>
<?php include('inc_hero.php') ?>
<div id="filters">	
	<div id="categories" class="wp">
		<a href="mercado-libre" class="ml">Mercado libre</a>
		<a href="mercado-pago" class="mp">Mercado pago</a>
		<a href="mercado-envios" class="me">Mercado envíos</a>
        <?php if($blog_id != 5): ?>
		<a href="mercado-shops" class="ms">Mercado shops</a>
        <?php endif; ?>               
	</div>
</div>
<script>
$('#categories a').on('click', function(e){
	e.preventDefault();
	var h = $(this).attr('href');
	if ($(this).hasClass('active')) {
		$('#categories a').removeClass('active');
	    h = 'all'
	}else{
		$('#categories a').removeClass('active');
		$(this).addClass('active');
	}
	//console.log(h);
	novedades(h);
	notas(h)
	cursos(h)
	alertas(h)
	
})
function alertas(x){
	$('.block_home.alertas .wp').html('<div class="loading"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/spinner.svg" width="30"></div>')
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'act_alerts', keyword: x },
        success: function(data) {
        	// console.log(data);
            $('.block_home.alertas .wp').html( data );
            setTimeout(function(){           	
	            $('.block_home.alertas .alert').each(function(i) {
		           $(this).removeClass('hiddenbx');
		        });
	        }, 200)
        }
    });

}
function novedades(x){
	$('.block_home.novedades .content').html('<div class="loading"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/spinner.svg" width="30"></div>')
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'act_novedades', keyword: x },
        success: function(data) {
        	// console.log(data);
            $('.block_home.novedades .content').html( data );
            setTimeout(function(){           	
	            $('.block_home.novedades .card').each(function(i) {
		           $(this).removeClass('hiddenbx');
		        });
	        }, 200)
        }
    });

}
function notas(x){	
	$('.block_home.notas .content').html('<div class="loading"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/spinner.svg" width="30"></div>')

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'act_notas', keyword: x },
        success: function(data) {
        	// console.log(data);
            $('.block_home.notas .content').html( data );
            setTimeout(function(){
	            $('.block_home.notas .card').each(function(i) {
		           $(this).removeClass('hiddenbx');
		        });
	        }, 200)
        }
    });

}
function cursos(x){
	$('.block_home.cursos .content').html('<div class="loading"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/spinner.svg" width="30"></div>')

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'act_cursos', keyword: x },
        success: function(data) {
        	// console.log(data);
            $('.block_home.cursos .content').html( data );
            setTimeout(function(){
	            $('.block_home.cursos .card').each(function(i) {
		           $(this).removeClass('hiddenbx');
		        });
	        }, 200)
        }
    });

}
</script>
<main>
	
	<div class="block_home alertas">
		<?php 
			$the_queryAlert = new WP_Query( 
		    	array( 
		    	'post_type' => array('alertas'),
		    	'posts_per_page' => 1,
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'alertas_categories',
			            'field'    => 'slug',
			            'terms'    => 'general',
			            'operator' => 'IN',
			        ),
			    ) 
		    ) );
			while( $the_queryAlert->have_posts() ):
                $the_queryAlert->the_post(); 

				$gcat = get_object_taxonomies('alertas');
				$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);

				$content = strip_tags(get_the_content(), '<i> <em> <strong>');
				$icon = get_field('icono_alert');
				$btn = get_field('botones_alert');

				(!$btn && !$icon) ? $elem = 'center' : $elem = 'no-center';
			?>
			<div class="wp">
			<div class="alert <?php foreach ($cat as  $value) { echo $value->slug .' ';	} ?><?=$elem?>">
				<?= ($icon) ? '<img src="'.$icon['url'].'" alt="'.get_the_title().'" class="icon" />' : '';  ?>
				<p><?= $content  ?></p>
				<?php if( have_rows('botones_alert') ):?>
					<div class="btnsAlert">
					<?php
				    while ( have_rows('botones_alert') ) : the_row();

				        ?>
				        <a href="<?= the_sub_field('url_btn_alert') ?>" target="<?= the_sub_field('target_btn_alert') ?>"> <?= the_sub_field('cta_btn_alert') ?></a>
				        <?php
				        

				    endwhile;?>
					</div>
				    <?php
				endif; ?>
			</div>
			</div>
	    <?php endwhile; ?>
	</div>

	<!-- NOVEDADES -->
	<div class="block_home novedades">
		<h3 class="wp">Novedades <a href="<?php bloginfo('url')?>/novedades">Ver más</a></h3>
		
		<div class="content">
			<?php
			$the_query_novedades = new WP_Query( array(
				'posts_per_page' => 3,
			    'post_type' => 'novedades',
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'novedades_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 68 ),
			            'operator' => 'NOT IN',
			        ),
			    ),
			) ); ?>
			<?php
			$y =1; 
			while ( $the_query_novedades->have_posts() ) :
				$y++;
			    $the_query_novedades->the_post(); ?>
				
				<?php 
					$gcat = get_object_taxonomies('novedades');
					$cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
				?>

				<a href="<?php the_permalink()?>" class="card <?=$cat[0]->slug;?>">
					<?= ($y == 1) ? '<div class="ribbon"><span>New</span><div class="triangle"></div></div>' : '';?>				

					<small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
					<h2><?php the_title(); ?></h2>
				</a>
			<?php endwhile; ?>
			
		</div>
		
	</div>

	<!-- NOTAS -->
	<div class="block_home notas">
		<h3 class="wp">Notas <a href="<?php bloginfo('url')?>/notas">Ver más</a></h3>
		<div class="content">
			<?php
			$the_query_notas = new WP_Query( array(
				'posts_per_page' => 5,
			    'post_type' => 'notas',
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'notas_categories',
			            'field'    => 'term_id',
			            'terms'    => array( 69 ),
			            'operator' => 'NOT IN',
			        ),
			    ),
			) );
			$i =0; 
			while ( $the_query_notas->have_posts() ) :
				$i++;
			    $the_query_notas->the_post(); 
			    $image = get_field('imagen_principal_nota');
			    //var_dump($image);
			    ?>

			    <div class="card  <?= ($i == 1) ? 'important' : '';?>">
					<a href="<?php the_permalink()?>" class="img" style="background-image: url(<?= $image["sizes"]["large"] ?>);"></a>
					<div class="copy">
						<?php 
							$gcat = get_object_taxonomies('notas');
							$cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
						?>
						<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
						<h2><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h2>

						<?php $content = get_the_content(); ?>
						<p><a href="<?php the_permalink()?>"><?= $content ?></a></p>

						<div class="tags">
							<?php $tags = get_the_tags();
							if($tags){
							foreach ($tags as $tg) {?>
								<a href="<?=get_bloginfo('url')?>/tags/?t=<?= $tg->slug?>"><?= $tg->name ?></a>
							<?php } }
							?>
							
						</div>
					</div>
				</div>

			<?php endwhile; ?>
			
		</div>

	</div>

	<!-- CURSOS -->
	<div class="block_home cursos">
		<h3 class="wp">Cursos <a href="<?php bloginfo('url')?>/cursos">Ver más</a></h3>
		
		<div class="content">
			<?php
			$the_query_cursos = new WP_Query( array(
				'posts_per_page' => 2,
			    'post_type' => 'lp_course'
			) ); ?>
			<?php
			while ( $the_query_cursos->have_posts() ) :
			    $the_query_cursos->the_post(); ?>
				<?php 
					$gcat = get_object_taxonomies('lp_course');
					$cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[0]);
					$tag = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);

					$img = get_the_post_thumbnail_url($post->ID, 'thumbnail');

					//get_the_post_thumbnail( $post_id, 'thumbnail' );      // Thumbnail (Note: different to Post Thumbnail)
					//get_the_post_thumbnail( $post_id, 'medium' );         // Medium resolution
					//get_the_post_thumbnail( $post_id, 'large' );          // Large resolution
					//get_the_post_thumbnail( $post_id, 'full' );           // Original resolution		 
					//get_the_post_thumbnail( $post_id, array( 100, 100) ); // Other resolutions
				?>

			    <a href="<?php the_permalink()?>" class="card">
					<div class="img" style="background-image: url(<?= $img ?>)"></div>
					<div class="copy">
						<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
						<h2><?php the_title(); ?></h2>
						<div class="tags">
							<?php 
							if($tag){
							foreach ($tag as $tg) {
								echo "<span>".$tg->name."</span>";
							} }?>
							
						</div>
						<div class="items">
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
						</div>
					</div>
				</a>
			<?php endwhile; ?>
			

		</div>

	</div>

	<!-- BANNER -->
	<div id="banners">
		<div class="wp">
		<?php include('inc_banner.php'); ?>
		</div>
	</div>

</main>
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
<?php include('footer.php') ?>
