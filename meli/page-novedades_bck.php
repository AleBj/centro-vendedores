<?php
/*
Template Name: Notas
*/

get_header();

?>
<h1>notas</h1>
<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
<hr>
<!-- <?php echo do_shortcode('[my_ajax_filter_search]'); ?> -->
<h3>Buscar</h3>

<form action="">
	<input type="text" name="keyword" id="keyword" onkeyup="fetch()"></input>
	<div id="datafetch">Search results will appear here</div>
</form>
<script type="text/javascript">
function fetch(){

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
        success: function(data) {
        	//console.log(data);
            jQuery('#datafetch').html( data );
        }
    });

}
</script>
<hr>
<?php
$the_query = new WP_Query( array(
    'post_type' => 'notas'
) ); ?>
<?php
while ( $the_query->have_posts() ) :
    $the_query->the_post(); ?>

    <a href="<?php the_permalink()?>"><?php the_title(); ?></a>
	<hr>
<?php endwhile; ?>

<?php
$the_query1 = new WP_Query( array(
    'post_type' => 'novedades'
) ); ?>
<?php
while ( $the_query1->have_posts() ) :
    $the_query1->the_post(); ?>

    <a href="<?php the_permalink()?>"><?php the_title(); ?></a>
	<hr>
<?php endwhile; ?>

<?php
$the_query1 = new WP_Query( array(
    'post_type' => 'post'
) ); ?>
<?php
while ( $the_query1->have_posts() ) :
    $the_query1->the_post(); ?>

    <a href="<?php the_permalink()?>"><?php the_title(); ?></a>
	<hr>
<?php endwhile; ?>


<?php
$the_query1 = new WP_Query( array(
    'post_type' => 'lp_course'
) ); ?>
<?php
while ( $the_query1->have_posts() ) :
    $the_query1->the_post(); ?>

    <a href="<?php the_permalink()?>"><?php the_title(); ?></a>
    <hr>
<?php endwhile; ?>

<?php

get_footer(); 

?>