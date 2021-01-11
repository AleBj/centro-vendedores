<?php
/*
Template Name: Tags
*/

get_header(); 

$url = explode("=", add_query_arg( $wp->query_vars, home_url() ));
$url = $url[1];
$course = LP_Global::course();

$url = $_GET['t'];

?>

<main>
    
    <div class="wp" id="search">
        <form action="" method="post" style="display: none;">
        	<label for="s" style="font-size:12px;"><?php _e( 'Etiquetas', 'meli-centro-vendedores' ); ?></label>
            <input type="text" name="s" id="buscar" placeholder="¿Qué estás buscando hoy?" value="<?php echo str_replace("-", " ", $url); ?>" readonly style="text-transform: capitalize;">
        </form>
        
    <?php 
    	$tag = get_term_by('slug', $_GET['t'], 'post_tag');
    	$tag_id =  $tag->term_id; 
    	$tag_ds = $tag->description;
    	//tag_description($tag_id);
	?>
		<div class="tagsTitle">
	        <h2><?php echo $tag->name ?></h2>
	        <!-- 195 -->
	        <?php if($tag_ds): ?>
	        	<p><?php echo substr($tag_ds, 0, 195);?></p>
	        <?php endif; ?>
        </div>

        <div id="filterssearch">  
            <a href="" class="ml bt" data-filter="mercado-libre"><?php _e( 'Mercado Libre', 'meli-centro-vendedores' ); ?></a>
            <a href="" class="mp bt" data-filter="mercado-pago"><?php _e( 'Mercado Pago', 'meli-centro-vendedores' ); ?></a>
            <a href="" class="me bt" data-filter="mercado-envios"><?php _e( 'Mercado envíos', 'meli-centro-vendedores' ); ?></a>
            <?php if($blog_id != 5): ?>
            <a href="" class="ms bt" data-filter="mercado-shops"><?php _e( 'Mercado Shops', 'meli-centro-vendedores' ); ?></a>   
            <?php endif; ?>    
        	<a href="" class="ma bt" data-filter="mercado-ads"><?php _e( 'Mercado Ads', 'meli-centro-vendedores' ); ?></a>            
        </div>
        <div id="results">
            <div class="nav-result">
                <div class="bt active" id="notas"><?php _e( 'Notas', 'meli-centro-vendedores' ); ?></div>
                <div class="bt" id="novedades"><?php _e( 'Novedades', 'meli-centro-vendedores' ); ?></div>
                <div class="bt" id="cursos"><?php _e( 'Cursos', 'meli-centro-vendedores' ); ?></div>
                <i></i>
            </div>
            
            <div class="main-result" id="mainresult">
				<!-- CONTENT NOVEDADES -->
				<div class="block_home novedades"><div class="contentRes">
            	<?php 
				if($url):

					$argus = array(
						'post_type' => array('novedades'),
						'posts_per_page' => -1, 
					   	'tax_query' => array(
					        array (
					            'taxonomy' => 'post_tag',
					            'field' => 'slug',
					            'terms' => $url,
					        ),
					        array(
					            'taxonomy' => 'novedades_categories', 
					            'field'    => 'slug',
				            	'terms'    => 'oculta',
				            	'operator' => 'NOT IN',
					        )
					    ),
					);
				?>

				<?php 
					$the_query_nov = new WP_Query( $argus);
					 if( $the_query_nov->have_posts() ) :
					 	while ($the_query_nov->have_posts()) :
					 		$the_query_nov->the_post(); 
					 	
							$gcat = get_object_taxonomies('novedades');
                    		$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);
				?>
                    <script>
                    	$('.bt#novedades').addClass('hay')
                    </script>
	                <!-- NOVEDADES -->
	                <a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?=$cat[0]->slug;?>">
	                    <small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
	                    <h2><?php the_title();?></h2>
	                </a>

				<?php  endwhile; else:?>
                    <script>
                    	$('.bt#novedades').removeClass('hay')
                    </script>
				<?php
					echo '<div class="noExist">' . __( "Ups, no encontramos nada para", "meli-centro-vendedores" ) .' '. str_replace("-", " ", $url).'</div>';
					endif; 
				wp_reset_postdata();
				endif; 
				?>
				</div></div>

				<!-- CONTENT NOTAS -->
				<div class="block_home notas" style="display: block;"><div class="contentRes">
            	<?php 
				if($url):
				?>

				<?php
				$args = array(
					'post_type' => array('notas'),
					'posts_per_page' => -1, 
				   	'tax_query' => array(
				        array (
				            'taxonomy' => 'post_tag',
				            'field' => 'slug',
				            'terms' => $url,
				        ),
				        array(
				            'taxonomy' => 'notas_categories', 
				            'field'    => 'slug',
			            	'terms'    => 'oculta',
			            	'operator' => 'NOT IN',
				        )			     
				    ),
				);
				 
				$the_query = new WP_Query( $args);

				if( $the_query->have_posts() ) :
				while( $the_query->have_posts() ):

					$the_query->the_post(); 

					$gcat = get_object_taxonomies('notas');
					$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);
					$ptag = get_the_tags();
					$ptg = '';
					foreach ($ptag as $pt) {
						$ptg .= $pt->slug.' ';
					}
					$image = get_field('imagen_principal_nota');	

					?>

                    <script>
                    	$('.bt#notas').addClass('hay')
                    </script>
					<!-- NOTA -->
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?= $ptg; ?> <?=$cat[0]->slug;?>">
					    <div class="img" style="background-image: url(<?= $image['sizes']['large'] ?>)"></div>
					    <div class="copy">
							<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
					        <h2><?php the_title();?></h2>
					        <?php $content = get_the_content(); ?>
							<p><?= $content ?></p>
					        <div class="tags">
					        	<?php $tags = get_the_tags();
					            foreach ($tags as $tg) {?>
					                <span><?= $tg->name ?></span>
					            <?php } ?>
					        </div>
					    </div>
					</a>

				<?php endwhile; else:?>

                    <script>
                    	$('.bt#notas').removeClass('hay')
                    </script>
				<?php
					echo '<div class="noExist">' . __( "Ups, no encontramos nada para", "meli-centro-vendedores" ) .' '. str_replace("-", " ", $url).'</div>';
				endif;
				wp_reset_postdata();
				endif; 
				?>
				</div></div>
				
				<!-- CONTENT CURSOS -->
				<div class="block_home cursos"><div class="contentRes">
            	<?php 
				if($url):

					$argu = array(
						'post_type' => array('lp_course'),
						'posts_per_page' => -1, 
					   	'tax_query' => array(
					        array (
					            'taxonomy' => 'course_tag',
					            'field' => 'slug',
					            'terms' => $url,
					        ),
					        array(
					            'taxonomy' => 'course_categories', 
					            'field'    => 'slug',
				            	'terms'    => 'oculta',
				            	'operator' => 'NOT IN',
					        )
					    ),
					);
				?>

				<?php 
					$the_query_lp = new WP_Query( $argu);
					 if( $the_query_lp->have_posts() ) :
					 	while ($the_query_lp->have_posts()) :
					 		$the_query_lp->the_post(); 
					 	
							$gcat = get_object_taxonomies('lp_course');
							$cat = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[0]);
							$tag = wp_get_post_terms(get_the_ID(), $taxonomy = $gcat[1]);

							$img = get_the_post_thumbnail_url($post->ID, 'thumbnail');
				?>
                    
                    <script>
                    	$('.bt#cursos').addClass('hay')
                    </script>
                        <!-- CURSOS -->
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?=$cat[0]->slug;?>">
                            <div class="img" style="background-image: url(<?= $img ?>"></div>
                            <div class="copy">
								<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
                                <h2><?php the_title();?></h2>
								<div class="tags">
									<?php foreach ($tag as $tg) {
										echo "<span>".$tg->name."</span>";
									} ?>									
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
                
				<?php  endwhile; else: ?>

                    <script>
                    	$('.bt#cursos').removeClass('hay')
                    </script>
				<?php
					echo '<div class="noExist">' . __( "Ups, no encontramos nada para", "meli-centro-vendedores" ) .' '. str_replace("-", " ", $url).'</div>';
					endif; 
				wp_reset_postdata();
				endif; 
				?>
				</div></div>
                
            </div>

        </div>
    </div>
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
</main>


<script>

// var onlyUrl = window.location.href.replace(window.location.search,'');
// window.history.pushState("object or string", "Title", onlyUrl );
    
$('#results .nav-result .bt').on('click', function(e){
    e.preventDefault();
    $('#results .nav-result .bt').removeClass('active');
    $(this).addClass('active')
    var lft = $(this).position().left;
    var frm = $(this).attr('id');
    var wpx = $(this).width();
    $('#results .nav-result i').css({'left': lft+'px', 'width': wpx+'px'});
    $('#results .block_home').fadeOut(300);
    $('#results .block_home.'+frm).stop(true,true).delay(300).fadeIn(300)
});

(function($) {

var $filters = $('#filterssearch .bt');

  $filters.on('click', function(e) {

    e.preventDefault();
    var $this = $(this);

    var $filterCat = $this.attr('data-filter');
    var     $boxes = $('#mainresult .card');

    if ($this.hasClass('active')) {
        
      $filters.removeClass('active');
 
      $boxes.removeClass('is-animated')
        .fadeOut().finish().promise().done(function() {
          $boxes.each(function(i) {
            $(this).addClass('is-animated').delay((i++) * 200).fadeIn();
          });
        });
    } else {

      $filters.removeClass('active');
      $this.addClass('active');

      $boxes.removeClass('is-animated')
        .fadeOut().finish().promise().done(function() {
          $boxes.filter('.card.' + $filterCat ).each(function(i) {
            $(this).addClass('is-animated').delay((i++) * 200).fadeIn();
          });
        });
    }

  });

})(jQuery);
</script>

<?php

get_footer(); 

?>