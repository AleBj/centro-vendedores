<?php
/*
Template Name: Novedades
*/

get_header();

$url = explode("=", add_query_arg( $wp->query_vars, home_url() ));
$url = $url[1];

if(isset($_GET['u'])){
    $url = $_GET['u'];
}
?>
<?php
$the_query_novedades = new WP_Query( array(
    'posts_per_page' => -1,
    'post_type' => 'novedades',
    'tax_query' => array(
        array(
            'taxonomy' => 'novedades_categories',
            'field'    => 'slug',
            'terms'    => 'oculta',
            'operator' => 'NOT IN',
        ),
    )
) );

$title = '<h1><strong>'. __( 'No te pierdas los lanzamientos', 'meli-centro-vendedores' ).'</strong> '. __( ' y avances de nuestro ecosistema', 'meli-centro-vendedores' ).'</h1>'; 
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

while ( $the_query_novedades->have_posts() ) :

    $the_query_novedades->the_post();
    $tag = get_the_tags();
    if($tag){
    foreach ($tag as $t) {
        $obj = new stdClass();
        $obj->name = $t->name;
        $obj->slug = $t->slug;

        if (!in_array($obj->name, $arrayControl)) {
            array_push($tagsName, $obj);
        }
        array_push($arrayControl, $obj->name);

    }
    }
endwhile;
    
?>

<div id="submenu">
    <?php
    if( have_rows('submenu_sb', 'option') ):
        // loop through the rows of data
        while ( have_rows('submenu_sb', 'option') ) : the_row(); 
            $headerCol = get_sub_field('categoria_sb');
        ?>
        <div class="wp <?= $headerCol->slug ?>">
            <div class="owl-carousel tagsList">
            <?php
            if( have_rows('link_sb') ):
                // loop through the rows of data
                while ( have_rows('link_sb') ) : the_row(); 
                    $tag = get_sub_field('tag_sb');
                    $icono = get_sub_field('icono_sb');
                ?>
                <div class="item">
                    <a href=".<?= $tag->slug ?>" class="bt">
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
<div id="tags">
    
    <div class="content tagsList">
        <?php 
            foreach ($tagsName as $tg) {
                echo '<a href=".'.$tg->slug.'" class="bt">'.$tg->name.'</a>';
                //print_r($tg->name);
            }

        ?>
    </div>
    <div class="show-tags"><span><?php _e( 'Más Filtros', 'meli-centro-vendedores' ); ?></span> <!-- (<?=count($tagsName)?>) --> <i class="fa fa-angle-down"></i></div>
</div>
<script>    
    $('#tags .show-tags').on('click', function(){
        $('#submenu .wp').toggleClass('open');
        $(this).toggleClass('open')
        $('#tags .content').slideToggle(500);   
    })
</script>
<main id="interna">
    <?php if($blog_id == 100): ?>
    <div class="block_home alertas">
        <div class="wp">                                    
            <div class="alert small white">

                <div class="left" style="align-items: center;">
                    <img src="<?php bloginfo('template_url')?>/img/alert-megafono.svg" alt="Alertas" class="icon"><p><strong>Conocé la nueva sección de Novedades</strong> <br>Ahora podés mantenerte al día desde tu cuenta. Revisá la información que tenés que ver según las características de tu negocio.</p>
                </div>
                <div class="btnsAlert">
                    <a href="https://www.mercadolibre.com.ar/novedades?utm_source=vendedores&utm_medium=referral&utm_campaign=encendidoCDN&utm_content=alerta_novedades" target="_blank"> Ver mis novedades</a>
                </div>

            </div>

        </div>
    </div>
    <?php endif; ?>  
    <!-- NOVEDADES -->
    <div class="block_home novedades mrg-b-0" style="opacity: 0">
        <h3 class="wp"><?php _e( 'Novedades', 'meli-centro-vendedores' ); ?></h3>
        <div class="gridList content">
            <div class="grid-sizer"></div>
            <?php $y =1; 
            while ( $the_query_novedades->have_posts() ) :
                $y++;
                $the_query_novedades->the_post(); ?>
                
                <?php 
                    $gcat = get_object_taxonomies('novedades');
                    $cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
                    $ptag = get_the_tags();
                    $ptg = '';
                    if($ptag){
                    foreach ($ptag as $pt) {
                        $ptg .= $pt->slug.' ';
                    }
                    }
                ?>

                <a href="<?php the_permalink()?>" class="card grid-item <?=$cat[0]->slug;?> <?=$ptg?>">
                    <?= ($y == 0) ? '<div class="ribbon"><span>New</span><div class="triangle"></div></div>' : '';?>                

                    <small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
                    <h2><?php the_title(); ?></h2>
                </a>
            <?php endwhile; ?>
        </div>

    </div>

</main>
<style>
.gridList{padding: 0 !important;}
.gridList:after {
  content: '';
  display: block;
  clear: both;
}
.gridList .grid-item, .gridList .grid-sizer{width: 33%;margin:10px 0;}
.gridList .grid-item{float: left;}
main .block_home.notas .card{transition: 0s;}
</style>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script>

$(window).on('load', function(){
    $('#filters .bt[data-filter="<?=$url?>"]').trigger('click');
    $('.block_home.novedades').delay(400).animate({'opacity':1}, 300)

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
$('#submenu .tagsList .bt').on('click', function(e){

    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $('#submenu .tagsList .bt').removeClass('active');
        $(this).addClass('active');
    }
     
})

$('#categories.tagsList .bt').on('click', function(){
    
    $('#submenu .wp').slideUp(300);

    $('#tags').slideUp(300); 
    var h = $(this).attr('href');

    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $('#categories.tagsList .bt').removeClass('active')
        $(this).addClass('active');
        // Submenú
        $('#submenu .wp'+h).slideDown(400);
        $('#tags').slideDown(300); 
    }     
})
</script>


<?php

get_footer(); 

?>