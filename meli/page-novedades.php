<?php
/*
Template Name: Novedades
*/

get_header();

?>
<?php
$the_query_novedades = new WP_Query( array(
    'posts_per_page' => -1,
    'post_type' => 'novedades',
    'tax_query' => array(
        array(
            'taxonomy' => 'novedades_categories',
            'field'    => 'term_id',
            'terms'    => array( 68 ),
            'operator' => 'NOT IN',
        ),
    )
) );

$title = '<h1><strong>Novedades</strong><br> Estas son las novedades</h1>'; 
?>
<?php include('inc_hero.php') ?>
<div id="filters">  
    <div id="categories" class="wp">
        <a href="" class="ml bt" data-filter="mercado-libre">mercado libre</a>
        <a href="" class="mp bt" data-filter="mercado-pago">mercado pago</a>
        <a href="" class="me bt" data-filter="mercado-envios">mercado envíos</a>
        <a href="" class="ms bt" data-filter="mercado-shops">mercado shops</a>
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
    
    <div class="content">
        <?php 
            foreach ($tagsName as $tg) {
                echo '<a href="'.$tg->slug.'" class="bt">'.$tg->name.'</a>';
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
    <div class="block_home novedades mrg-b-0">
        <h3 class="wp">Novedades</h3>
        <div class="content">
            <?php $y =0; 
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

                <a href="<?php the_permalink()?>" class="card <?=$cat[0]->slug;?> <?=$ptg?>">
                    <?= ($y == 1) ? '<div class="ribbon"><span>New</span><div class="triangle"></div></div>' : '';?>                

                    <small><?php $post_date = get_the_date( 'd M Y' ); echo $post_date; ?></small>
                    <h2><?php the_title(); ?></h2>
                </a>
            <?php endwhile; ?>
            <p class="noExist" style="display: none;">No existen resultados para Novedades.</p>
        </div>

    </div>

</main>
<script>
(function($) {

var $filters = $('#filters .bt'),
    $boxes = $('.card');

  $filters.on('click', function(e) {
    $('.noExist').fadeOut(100);
    e.preventDefault();
    var $this = $(this);
    $('#tags .bt').removeClass('active');

    var $filterCat = $this.attr('data-filter');

    if ($this.hasClass('active')) {
        console.log('entra')
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
          if(!$('.card').hasClass($filterCat)){
            $('.noExist').fadeIn(300);
          }
          $boxes.filter('.card.' + $filterCat ).each(function(i) {
            $(this).addClass('is-animated').delay((i++) * 200).fadeIn();
          });
        });
    }

  });

})(jQuery);

//TAGS
(function($) {

var $tag = $('#tags .bt'),
    $boxes = $('.card');

  $tag.on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    $('#filters .bt').removeClass('active');

    var $filterCat = $this.attr('href');

    if ($this.hasClass('active')) {
        console.log('entra')
      $tag.removeClass('active');
 
      $boxes.removeClass('is-animated')
        .fadeOut().finish().promise().done(function() {
          $boxes.each(function(i) {
            $(this).addClass('is-animated').delay((i++) * 200).fadeIn();
          });
        });
    } else {


      $tag.removeClass('active');
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