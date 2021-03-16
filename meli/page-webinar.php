<?php
/*
Template Name: Webinars
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
        <a href=".mercado-ads" class="ma bt" data-filter="mercado-ads"><?php _e( 'Mercado Ads', 'meli-centro-vendedores' ); ?></a>        
    </div>
</div>

<main id="interna">
    <?php 
    setlocale(LC_ALL, 'es_ES');

    $fechaActual = date('d/m/Y H:i', strtotime("- 3 hours"));
    $monthActual  = date('m');
    $dateObjActual   = DateTime::createFromFormat('!m', $monthActual);
    $monthNameActual = strftime('%B', $dateObjActual->getTimestamp());

    if($monthActual == '01'){
        $monthProx  = date("m", strtotime("+ 28 days")); 
    }else{
        $monthProx  = date("m", strtotime("+ 1 month")); 
    }
    $dateObjProx   = DateTime::createFromFormat('!m', $monthProx);
    $monthNameProx = strftime('%B', $dateObjProx->getTimestamp());
    
    echo '<!--';
    echo '<hr>';
    echo $monthNameActual;
    echo '<hr>';
    echo $monthNameProx;
    echo '<hr>';
    echo $monthActual;
    echo '<hr>';
    echo date('Y-m-d H:i:s');
    echo '-->';
    ?>
    <!-- Webinars -->
    <div class="block_home novedades webinars mrg-b-0" style="opacity: 0">
        <div class="wp tagsList">
            <?php _e( 'Seleccioná el nivel de webinar que querés hacer:', 'meli-centro-vendedores'); ?>
            <a href=".principiante" class="bt">Principiante</a>
            <a href=".avanzado" class="bt"><?php _e( 'Avanzado', 'meli-centro-vendedores'); ?></a>
        </div>
        <?php
            $the_query_webinar = new WP_Query( array(
                'posts_per_page' => -1,
                'post_type' => 'webinars',
                'meta_key'  => 'fecha_webinar',
                'orderby'   => 'meta_value',
                'order'     => 'ASC',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key'    => 'mes_webinar',
                        'value'    => $monthActual,
                        'compare' => 'IN',
                    ),
                    array(
                        'key' => 'fecha_webinar',
                        'value' => date('Y-m-d'),
                        'compare' => '>=',
                        'type' => 'DATE'

                    )
                )
            ) );

            if ($the_query_webinar->have_posts()) :
        ?>
        <h3 class="wp dif"><?php _e( $monthNameActual, 'meli-centro-vendedores'); ?></h3>
        <?php endif; ?>
        <div class="gridList content mrg-b-web">
            <div class="grid-sizer"></div>
            
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

                    $date = get_field('fecha_webinar');

                    if($blog_id == 1 || $blog_id == 10 || $blog_id == 2 || $blog_id == 5 || $blog_id == 6){
                        $hourNow = strtotime(date('Y-m-d H:i:s', strtotime("- 3 hours")));
                    }else if($blog_id == 3){
                        $hourNow = strtotime(date('Y-m-d H:i:s', strtotime("- 5 hours")));
                    }else if($blog_id == 9){
                        $hourNow = strtotime(date('Y-m-d H:i:s', strtotime("- 6 hours")));
                    }                


                    $hourWeb = strtotime(date('Y-m-d H:i:s', strtotime($date)));
                   
                    if($hourNow < $hourWeb):
                      
                ?>

                <div class="card grid-item <?=$cat[0]->slug;?> <?=$ptg?>"> 
                    <?php if($ptag[0] != ''): ?>
                    <div class="tags"><span><?= $ptag[0]->name ?> </span></div>      
                    <?php endif; ?>
                    <small>
                        <img src="<?=get_bloginfo('template_url')?>/img/ico-calendar.svg" alt="">
                        <?php ; 
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
            <?php endif; endwhile; ?>
        </div>

        <?php
        $the_query_webinar_nx = new WP_Query( array(
            'posts_per_page' => -1,
            'post_type' => 'webinars',
            'meta_key'  => 'fecha_webinar',
            'orderby'   => 'meta_value',
            'order'     => 'ASC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'    => 'mes_webinar',
                    'value'    => $monthProx,
                    'compare' => 'IN',
                )
            )
        ) );

        if ($the_query_webinar_nx->have_posts()) :
        
        ?>

        <h3 class="wp dif"><?php _e( $monthNameProx, 'meli-centro-vendedores'); ?></h3>
        <?php endif ?>
        <div class="gridList content">
            <div class="grid-sizer"></div>
            
            <?php
            while ( $the_query_webinar_nx->have_posts() ) :
                $the_query_webinar_nx->the_post(); ?>
                
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

        <?php if(!$the_query_webinar_nx->have_posts() && !$the_query_webinar->have_posts()): ?>
        <div class="content">
            <p class="noExit"><?php _e( 'Estamos creando nuevos webinars para que puedas seguir aprendiendo. <br>Te recordamos que podés seguir aprendiendo con los webinars anteriores acá abajo.', 'meli-centro-vendedores' ); ?></p>
        </div>
        <?php endif; ?>

    </div>
    <div id="related" class="block_home novedades webinars anteriores">
        <div class="wp" style="padding: 0">
            <h3 class="wp"><?php _e( 'Webinars anteriores', 'meli-centro-vendedores' ); ?> <a href="<?=get_bloginfo('url');?>/webinars-anteriores">Ver todos</a></h3>
            <div class="content" style="padding: 0">
                <?php
                $the_query_webinar_ant = new WP_Query( array(
                    'posts_per_page' => 4,
                    'post_type' => 'webinars',
                    'meta_key'  => 'fecha_webinar',
                    'orderby'   => 'meta_value',
                    'order'     => 'DESC',
                    'meta_query' => array(
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

                while ( $the_query_webinar_ant->have_posts() ) :
                    $the_query_webinar_ant->the_post(); ?>
                    
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
                        <?php if($ptag[0] != ''): ?>
                        <div class="tags"><span><?= $ptag[0]->name ?> </span></div>      
                        <?php endif; ?>      
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
                        <a href="<?= get_field('link_webinar'); ?>" target="_blank"><?php _e( 'Ver webinar', 'meli-centro-vendedores' ); ?></a>
                    </div>
                <?php endwhile; ?>
            </div>


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
.gridList .grid-item, .gridList .grid-sizer{width: 25%;margin:16px 0;}
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


// $('.tagsList .bt').on('click', function(e){
//     if($(this).hasClass('active')){
//         $(this).removeClass('active');
//     }else{
//         $('.tagsList .bt').removeClass('active')
//         $(this).addClass('active');
//     }   
// })

$('.tagsList .bt').on('click', function(){
    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $('.tagsList .bt').removeClass('active')
        $(this).addClass('active');
    }   
})
</script>


<?php

get_footer(); 

?>