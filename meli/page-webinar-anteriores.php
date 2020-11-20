<?php
/*
Template Name: Webinars Anteriores
*/

get_header();

$url = explode("=", add_query_arg( $wp->query_vars, home_url() ));
$url = $url[1];

if(isset($_GET['u'])){
    $url = $_GET['u'];
}
?>
<?php include('inc_hero-webinars.php') ?>
<div id="filters">  
    <div id="categories" class="wp tagsList">
        <a href=".mercado-libre" class="ml bt" data-filter="mercado-libre"><?php _e( 'Mercado Libre', 'meli-centro-vendedores' ); ?></a>
        <a href=".mercado-pago" class="mp bt" data-filter="mercado-pago"><?php _e( 'Mercado Pago', 'meli-centro-vendedores' ); ?></a>
        <a href=".mercado-envios" class="me bt" data-filter="mercado-envios"><?php _e( 'Mercado envíos', 'meli-centro-vendedores' ); ?></a>
        <?php if($blog_id != 5): ?>
        <a href=".mercado-shops" class="ms bt" data-filter="mercado-shops"><?php _e( 'Mercado Shops', 'meli-centro-vendedores' ); ?></a>
        <?php endif; ?>               
    </div>
</div>

<main id="interna">

    <?php 
    setlocale(LC_ALL, 'es_ES');

    $fechaActual = date('d/m/Y H:i');
    $monthActual  = date('m');
    $dateObjActual   = DateTime::createFromFormat('!m', $monthActual);
    $monthNameActual = strftime('%B', $dateObjActual->getTimestamp());


   

    $monthProx  = date("m", strtotime("+ 1 month")); 
    $dateObjProx   = DateTime::createFromFormat('!m', $monthProx);
    $monthNameProx = strftime('%B', $dateObjProx->getTimestamp());

    // echo '<hr>';
    // echo $monthNameActual;
    // echo $monthNameProx;
    // echo $fechaActual;
    ?>
    <!-- Webinars -->
    <div class="block_home novedades webinars anteriores mrg-b-0" style="opacity: 0">
        <div class="wp tagsList">
            Seleccioná el nivel de webinar que querés: 
            <a href=".principiante" class="bt">Principiante</a>
            <a href=".avanzado" class="bt">Avanzado</a>
        </div>
        <h3 class="wp dif"><?php _e( 'Webinars anteriores', 'meli-centro-vendedores' ); ?></h3>
        <div class="gridList content">
            <div class="grid-sizer"></div>
            <?php
            $the_query_webinar = new WP_Query( array(
                'posts_per_page' => -1,
                'post_type' => 'webinars',
                'meta_key'  => 'fecha_webinar',
                'orderby'   => 'meta_value',
                'order'     => 'ASC',
                'meta_query' => array(
                    // 'relation' => 'AND',
                    // array(
                    //     'key'    => 'mes_webinar',
                    //     'value'    => $monthActual,
                    //     'compare' => 'IN',
                    // ),
                    array(
                        'key' => 'fecha_webinar',
                        'value' => date('Y-m-d H:i:s'),
                        'compare' => '<',
                        'type' => 'DATE'

                    )
                )
            ) );

            ?>
            <?php

            while ( $the_query_webinar->have_posts() ) :
                $the_query_webinar->the_post(); ?>
                
                <?php 
                    $gcat = get_object_taxonomies('webinars');
                    $cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
                    $ptag = get_the_tags();
                    $ptg = '';
                    if($ptag){
                    foreach ($ptag as $pt) {
                        $ptg .= $pt->slug.' ';
                    }
                    }
                ?>

                <div class="card grid-item <?=$cat[0]->slug;?> <?=$ptg?>"> 
                    <div class="tags"><span><?= $ptag[0]->name ?> </span></div>      
                    <small>
                        <img src="<?=get_bloginfo('template_url')?>/img/ico-calendar.svg" alt="">
                        <?php $date = get_field('fecha_webinar'); 
                        echo date('d/m', strtotime($date)) .' '. date('H:i', strtotime($date))  ?>Hs
                    </small>
                    <h2><?php the_title(); ?></h2>
                    <p>
                        <?php 
                        $content = get_the_content(); 
                        echo substr(strip_tags($content,'<em> <strong> <i>'), 0, 160);
                        
                        ?>
                    </p>
                    <a href="<?= get_field('link_webinar'); ?>" target="_blank"><?php _e( 'Registrarme', 'meli-centro-vendedores' ); ?></a>
                </div>
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
.gridList .grid-item, .gridList .grid-sizer{width: 25%;margin:10px 0;}
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


$('.tagsList .bt').on('click', function(e){
    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $('.tagsList .bt').removeClass('active')
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