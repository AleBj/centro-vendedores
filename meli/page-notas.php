<?php
/*
Template Name: Notas
*/

get_header();

$url = explode("=", add_query_arg( $wp->query_vars, home_url() ));
$url = $url[1];

$url = $_GET['u'];

?>
<?php
$the_query_novedades = new WP_Query( array(
    'posts_per_page' => -1,
    'post_type' => 'notas',
    'tax_query' => array(
        array(
            'taxonomy' => 'notas_categories',
            'field'    => 'term_id',
            'terms'    => array( 69 ),
            'operator' => 'NOT IN',
        ),
    )
) ); 

$title = '<h1><strong>Notas</strong><br> Estas son las Notas</h1>'; 
?>
<?php include('inc_hero.php') ?>
<div id="filters">  
    <div id="categories" class="wp tagsList">
        <a href=".mercado-libre" class="ml bt" data-filter="mercado-libre">mercado libre</a>
        <a href=".mercado-pago" class="mp bt" data-filter="mercado-pago">mercado pago</a>
        <a href=".mercado-envios" class="me bt" data-filter="mercado-envios">mercado envíos</a>
        <a href=".mercado-shops" class="ms bt" data-filter="mercado-shops">mercado shops</a>
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
<div id="tags">
    <div class="show-tags">Filtrar (<?=count($tagsName)?>) <i class="fa fa-angle-down"></i></div>
    
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

    <!-- NOVEDADES -->
    <div class="block_home notas mrg-b-0" style="opacity: 0">
        <h3 class="wp">Notas</h3>
        <div class="gridList content">
            <div class="grid-sizer"></div>

            <?php $y =0; 
            while ( $the_query_novedades->have_posts() ) :
                $y++;
                $the_query_novedades->the_post(); ?>
                
                <?php 
                    $gcat = get_object_taxonomies('notas');
                    $cat = wp_get_post_terms($post->ID, $taxonomy = $gcat[1]);
                    $ptag = get_the_tags();
                    $ptg = '';
                    if($ptag){
                    foreach ($ptag as $pt) {
                        $ptg .= $pt->slug.' ';
                    }
                    }
                    $image = get_field('imagen_principal_nota'); 
                ?>

                <div class="card grid-item <?= ($y == 1) ? 'important' : '';?> <?= $ptg ?> <?=$cat[0]->slug;?>">
                    <a href="<?php the_permalink()?>" class="img" style="background-image: url(<?= $image['sizes']['medium'] ?>"></a>
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
                            <?php }
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <!-- <p class="noExist" style="display: none;">No existen resultados para Notas.</p> -->

       
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
    $('.block_home.notas').delay(400).animate({'opacity':1}, 300)

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