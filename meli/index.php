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

if(isset($_GET['u'])){
	$url = strip_tags($_GET['u']);
}else{
	$url = 'nada';
}
?>
<?php include('inc_hero.php') ?>
<div id="filters">	
	<div id="categories" class="wp">
		<a href="mercado-libre" class="ml mercado-libre" data-rel="mercado-libre"><?php _e( 'Mercado Libre', 'meli-centro-vendedores' ); ?></a>
		<a href="mercado-pago" class="mp mercado-pago" data-rel="mercado-pago"><?php _e( 'Mercado Pago', 'meli-centro-vendedores' ); ?></a>
		<a href="mercado-envios" class="me mercado-envios" data-rel="mercado-envios"><?php _e( 'Mercado envíos', 'meli-centro-vendedores' ); ?></a>
        <?php if($blog_id != 5): ?>
		<a href="mercado-shops" class="ms mercado-shops" data-rel="mercado-shops"><?php _e( 'Mercado Shops', 'meli-centro-vendedores' ); ?></a>
        <?php endif; ?>         
		<a href="mercado-ads" class="ma mercado-ads" data-rel="mercado-ads"><?php _e( 'Mercado Ads', 'meli-centro-vendedores' ); ?></a>      
	</div>
</div>
<div id="submenu">
	<?php
	if( have_rows('submenu_sb', 'option') ):
	 	// loop through the rows of data
	    while ( have_rows('submenu_sb', 'option') ) : the_row(); 
	    	$headerCol = get_sub_field('categoria_sb');
	    ?>
		<div class="wp <?= $headerCol->slug ?>">
			<p class="tax-detail">
				<?php $tax = $headerCol->slug;

					$text = get_term_by('slug', $tax,'notas_categories');

					echo $text->description;
				?>
				
			</p>
			<div class="owl-carousel">
			<?php
    		if( have_rows('link_sb') ):
			 	// loop through the rows of data
			    while ( have_rows('link_sb') ) : the_row(); 
			    	$tag = get_sub_field('tag_sb');
			    	$icono = get_sub_field('icono_sb');
			    ?>
			    <div class="item">
					<a href="<?= get_bloginfo('url').'/tags/?t='?><?= $tag->slug ?>">
						<div class="image">
					    	<img src="<?= $icono['url'] ?>" alt="<?= $tag->name ?>">
					    </div>
					    <?= $tag->name ?>
					</a>
				</div>
				
			<?php    
				endwhile;

			endif; ?>


			</div>
		</div>

	<?php    
		endwhile;

	endif; ?>

</div>
<script>
$('#categories a').on('click', function(e){
	e.preventDefault();
	
	$('#submenu .wp').slideUp(100);

	var h = $(this).attr('href');
	if ($(this).hasClass('active')) {
		$('#categories a').removeClass('active');
	    h = 'all';

		var onlyUrl = window.location.href.replace(window.location.search,'');
    	window.history.pushState("object or string", "Title", onlyUrl );

    	var link = '<?= get_bloginfo('url'); ?>'; 

    	$('.block_home.novedades h3 a').attr('href',link+'/novedades')
    	$('.block_home.notas h3 a').attr('href',link+'/notas')
    	$('.block_home.cursos h3 a').attr('href',link+'/cursos')

		// Submenú
	}else{
		var cls = $(this).data('rel');
		var param = '?u='+cls;
		var onlyUrl = window.location.href.replace(window.location.search,'');
    	window.history.pushState("object or string", "Title", onlyUrl+param );

    	var linkNov = $('.block_home.novedades h3 a').attr('href');
    	var linkNot = $('.block_home.notas h3 a').attr('href');
    	var linkCur = $('.block_home.cursos h3 a').attr('href');
    	
    	$('.block_home.novedades h3 a').attr('href',linkNov+param)
    	$('.block_home.notas h3 a').attr('href',linkNot+param)
    	$('.block_home.cursos h3 a').attr('href',linkCur+param)

		$('#categories a').removeClass('active');
		$(this).addClass('active');

		// Submenú
		$('#submenu .wp.'+h).slideDown(300);
	}
	//console.log(h);
	//novedades(h);
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
        	 console.log(data);
            $('.block_home.alertas .wp').html( data );
            setTimeout(function(){           	
	            $('.block_home.alertas .alert').each(function(i) {
		           $(this).removeClass('hiddenbx');
		        });
	        }, 200)
        }
    });

}
// function novedades(x){
// 	$('.block_home.novedades .content').html('<div class="loading"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/spinner.svg" width="30"></div>')
//     jQuery.ajax({
//         url: '<?php echo admin_url('admin-ajax.php'); ?>',
//         type: 'post',
//         data: { action: 'act_novedades', keyword: x },
//         success: function(data) {
//         	// console.log(data);
//             $('.block_home.novedades .content').html( data );
//             setTimeout(function(){           	
// 	            $('.block_home.novedades .card').each(function(i) {
// 		           $(this).removeClass('hiddenbx');
// 		        });
// 	        }, 200)
//         }
//     });

// }
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
			<div class="wp">
		<?php 
			$the_queryAlert = new WP_Query( 
		    	array( 
		    	'post_type' => array('alertas'),
		    	'posts_per_page' => 1,
			    'tax_query' => array(
			    	'relation' => 'AND',
			        array(
			            'taxonomy' => 'alertas_categories',
			            'field'    => 'slug',
			            'terms'    => 'general',
			            'operator' => 'IN',
			        ),
			        // array(
			        //     'taxonomy' => 'alertas_categories',
			        //     'field'    => 'slug',
			        //     'terms'    => 'interna',
			        //     'operator' => 'NOT IN',
			        // )
			    ),
	            'meta_query' => array(
                    array(
                        'key' => 'fecha_alert',
                        'value' => date('Y-m-d'),
                        'compare' => '>=',
                        'type' => 'DATE'

                    )
                )
		    ) );
			while( $the_queryAlert->have_posts() ):
                $the_queryAlert->the_post(); 

				$gcat = get_object_taxonomies('alertas');
				$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);

				$content = strip_tags(get_the_content(), '<i> <em> <strong>');
				$icon = get_field('icono_alert');
				$btn = get_field('botones_alert');

				if( have_rows('apariencia_alert') ): ?>
			    <?php while( have_rows('apariencia_alert') ): the_row(); 
			        // Get sub field values.
			        $size = get_sub_field('tamano_alert');
			        $color = get_sub_field('color_alert');
			    endwhile;
        		
			endif; ?>
				<div class="alert <?php foreach ($cat as  $value) { echo $value->slug .' ';	} ?><?=$size?> <?=$color?>">
					<?php if($size == 'small'): ?>
					<div class="left">
						<?= ($icon) ? 
							'<img src="'.$icon['url'].'" alt="'.get_the_title().'" class="icon" />' : 
							'<img src="'. get_bloginfo('url').'/wp-content/themes/meli/img/alerta-desktop.svg" alt="Alertas" class="icon" />';  
						?>
						<p><?= substr($content, 0, 200) ?></p>
					</div>
					<div class="btnsAlert">
					<?php if( have_rows('botones_alert') ):

					    while ( have_rows('botones_alert') ) : the_row();

					        ?>
					        <a href="<?= the_sub_field('url_btn_alert') ?>" target="<?= the_sub_field('target_btn_alert') ?>"> <?= the_sub_field('cta_btn_alert') ?></a>
					        <?php				        

					    endwhile;
					endif; ?>
					</div>
					<?php else: ?>
						<div class="left">
							<?= ($icon) ? 
								'<img src="'.$icon['url'].'" alt="'.get_the_title().'" class="icon" />' : 
								'<img src="'. get_bloginfo('url').'/wp-content/themes/meli/img/alerta-desktop.svg" alt="Alertas" class="icon" />';  
							?>
							<div class="texto">
								<p><?= $content; ?></p>
								<div class="btnsAlert">
								<?php if( have_rows('botones_alert') ):

								    while ( have_rows('botones_alert') ) : the_row();

								        ?>
								        <a href="<?= the_sub_field('url_btn_alert') ?>" target="<?= the_sub_field('target_btn_alert') ?>"> <?= the_sub_field('cta_btn_alert') ?></a>
								        <?php				        

								    endwhile;
								endif; ?>
								</div>
							</div>
						</div>
						<div class="vermas" id="AlertVerMas">ver más <i class="fa fa-angle-down"></i></div>
						<script>
							$('#AlertVerMas').on('click', function(){
								$('.alert .texto, #AlertVerMas').toggleClass('open')
							})
						</script>
					<?php endif; ?>					

				</div>
	    <?php endwhile; ?>
			</div>
	</div>

	<!-- NOVEDADES 
	<div class="block_home novedades">
		<h3 class="wp"><?php _e( 'Novedades', 'meli-centro-vendedores' ); ?> <a href="<?php bloginfo('url')?>/novedades"><?php _e( 'Ver más', 'meli-centro-vendedores' ); ?></a></h3>
		
		<div class="content">
			<?php
			$the_query_novedades = new WP_Query( array(
				'posts_per_page' => 3,
			    'post_type' => 'novedades',
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'novedades_categories',
			            'field'    => 'slug',
			            'terms'    => 'oculta',
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
					<?= ($y == 0) ? '<div class="ribbon"><span>New</span><div class="triangle"></div></div>' : '';?>				

					<small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
					<h2><?php the_title(); ?></h2>
				</a>
			<?php endwhile; ?>
			
		</div>
		
	</div>-->

	<!-- NOTAS -->
	<div class="block_home notas">
		<h3 class="wp"><?php _e( 'Notas', 'meli-centro-vendedores' ); ?> <a href="<?php bloginfo('url')?>/notas"><?php _e( 'Ver más', 'meli-centro-vendedores' ); ?></a></h3>
		<div class="content">
			<?php
			$the_query_notas = new WP_Query( array(
				'posts_per_page' => 5,
			    'post_type' => 'notas',
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'notas_categories',
			            'field'    => 'slug',
			            'terms'    => 'oculta',
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
						<p><a href="<?php the_permalink()?>"><?= strip_tags($content) ?></a></p>

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
		<h3 class="wp"><?php _e( 'Cursos', 'meli-centro-vendedores' ); ?> <a href="<?php bloginfo('url')?>/cursos"><?php _e( 'Ver más', 'meli-centro-vendedores' ); ?></a></h3>
		
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
							<div class="file"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-page.svg" alt="Page"> <?php _e( 'Sin evaluación', 'meli-centro-vendedores' ); ?></div>
							<div class="lessons"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-book.svg" alt="Book"> 
	                        <?php
	                        $curriculum = $course->get_curriculum();
	                        $clases = 0;
	                        foreach ( $curriculum as $section ) {
	                            $clases += count($section->get_items());
	                        };
	                        echo $clases;
	                        ?>
	                         <?php _e( 'Lecciones', 'meli-centro-vendedores' ); ?></div>
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
<script>
$(window).on('load', function(){
    $('#categories a.<?=$url?>').trigger('click')
})
</script>
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
