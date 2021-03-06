<?php
/*
Template Name: Cursos
*/

get_header();


$course = LP_Global::course();

$url = explode("=", add_query_arg( $wp->query_vars, home_url() ));
$url = $url[1];

if(isset($_GET['u'])){
    $url = $_GET['u'];
}

$the_query_cursos = new WP_Query( array(
    'posts_per_page' => -1,
    'post_type' => 'lp_course'
) ); 

$title = '<h1><strong>'. __( 'Capacitá a tu equipo', 'meli-centro-vendedores' ).'</strong> '. __( 'y llevá tu negocio al siguiente nivel', 'meli-centro-vendedores' ).'</h1>'; 
?>
<?php include('inc_hero_interna.php') ?>
<div id="filters">  
    <div id="categories" class="wp tagsList">
        <a href=".mercado-libre" class="ml bt" data-filter="mercado-libre"><?php _e( 'Mercado Libre', 'meli-centro-vendedores' ); ?></a>
        <a href=".mercado-pago" class="mp bt" data-filter="mercado-pago"><?php _e( 'Mercado Pago', 'meli-centro-vendedores' ); ?></a>
        <a href=".mercado-envios" class="me bt" data-filter="mercado-envios"><?php _e( 'Mercado envíos', 'meli-centro-vendedores' ); ?></a>
        <?php if($blog_id != 5): ?>
        <a href=".mercado-shops" class="ms bt" data-filter="mercado-shops"><?php _e( 'Mercado Shops', 'meli-centro-vendedores' ); ?></a>
        <?php endif; ?>    
        <a href=".mercado-ads" class="ma bt" data-filter="mercado-ads"><?php _e( 'Mercado Ads', 'meli-centro-vendedores' ); ?></a>              
    </div>
</div>
<?php 

$tagsName = [];
$arrayControl = [];

while ( $the_query_cursos->have_posts() ) :

    $the_query_cursos->the_post();
    $gcat = get_object_taxonomies('lp_course');
    $tag = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
    foreach ($tag as $t) {
        $obj = new stdClass();
        $obj->name = $t->name;
        $obj->slug = $t->slug;

        if (!in_array($obj->name, $arrayControl)) {
            array_push($tagsName, $obj);
        }
        array_push($arrayControl, $obj->name);

    }
    
endwhile;
?>
<div id="tags">
    <div class="show-tags"><?php _e( 'Filtrar', 'meli-centro-vendedores' ); ?> (<?=count($tagsName)?>) <i class="fa fa-angle-down"></i></div>
    
    <div class="content tagsList">
        <?php 
            foreach ($tagsName as $tg) {
                echo '<a href=".'.$tg->slug.'" class="bt">'.$tg->name.'</a>';
                //print_r($tg->name);
            }

        ?>
    </div>
</div>
<script>    
    $('#tags .show-tags').on('click', function(){
        $(this).toggleClass('open')
        $('#tags .content').slideToggle(500);   
    })
</script>

<main id="interna">
	
	<!-- CURSOS -->
	<div class="block_home cursos mrg-b-0" style="opacity: 0">
		<h3 class="wp">Cursos</h3>
    <div class="gridList content">
        <div class="grid-sizer"></div>
		<?php
		while ( $the_query_cursos->have_posts() ) :
		    $the_query_cursos->the_post(); ?>
			<?php 
				$gcat = get_object_taxonomies('lp_course');
				$cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[0]);
				$tag = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
				$ptg = '';
                foreach ($tag as $pt) {
                    $ptg .= $pt->slug.' ';
                }

				$img = get_the_post_thumbnail_url($post->ID, 'thumbnail');

				//get_the_post_thumbnail( $post_id, 'thumbnail' );      // Thumbnail (Note: different to Post Thumbnail)
				//get_the_post_thumbnail( $post_id, 'medium' );         // Medium resolution
				//get_the_post_thumbnail( $post_id, 'large' );          // Large resolution
				//get_the_post_thumbnail( $post_id, 'full' );           // Original resolution		 
				//get_the_post_thumbnail( $post_id, array( 100, 100) ); // Other resolutions
			?>

		    <a href="<?php the_permalink()?>" class="card grid-item <?=$cat[0]->slug;?> <?=$ptg?>">
				<div class="img" style="background-image: url(<?= $img ?>)"></div>
				<div class="copy">
					<small class="<?=$cat[0]->slug;?>"><?=$cat[0]->name;?></small>
					<h2><?php the_title(); ?></h2>
					<div class="tags">
						<?php foreach ($tag as $tg) {
							echo "<span>".$tg->name."</span>";
						} ?>
						
					</div>
					<div class="items">
						<div class="time"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-reloj.svg" alt="Reloj"> <?= conversorSegundosHoras($course->get_duration()) ?></div>
						<div class="file"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-page.svg" alt="Page"><?php _e( 'Sin evaluación', 'meli-centro-vendedores' ); ?></div>
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
<style>
.gridList{padding: 0 !important;}
.gridList:after {
  content: '';
  display: block;
  clear: both;
}
.gridList .grid-item, .gridList .grid-sizer{width: 50%;margin:10px 0;}
.gridList .grid-item{float: left;}
main .block_home.notas .card{transition: 0s;}
</style>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script>

$(window).on('load', function(){
    $('#filters .bt[data-filter="<?=$url?>"]').trigger('click');
    $('.block_home.cursos').delay(400).animate({'opacity':1}, 300)

    var onlyUrl = window.location.href.replace(window.location.search,'');
    window.history.pushState("object or string", "Title", onlyUrl );

})


</script>
<script>
// init Isotope
var $grid = $('.gridList').isotope({
  itemSelector: '.grid-item',
  percentPosition: true,
  masonry: {
    columnWidth: '.grid-sizer'
  }
});



// store filter for each group
var filters = [];

$('.tagsList').on( 'click', '.bt', function( event ) {
  event.preventDefault();

  // if($(this).hasClass('active')){
  //   $(this).removeClass('active');
  // }else{
  //   $(this).addClass('active');
  // }   

  $('.tagsList .bt.active').each(function(){
    filters += $(this).attr('href');
  })
 
  // combine filters

  // set filter for Isotope
  $grid.isotope({ filter: filters });
  filters = '';

});


$('#tags .tagsList .bt').on('click', function(e){
    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $(this).addClass('active');
    }   
})

$('#categories.tagsList .bt').on('click', function(){
    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $('#categories.tagsList .bt').removeClass('active')
        $(this).addClass('active');
    }   
})
</script>

<?php

get_footer(); 

?>