<?php


get_header(); 

$url = explode("=", add_query_arg( $wp->query_vars, home_url() ));
$url = $url[1];

//$url = $_GET['t'];

$title = '<h1><strong>Tags:</strong><br> '.$url.'</h1>'; 
include('inc_hero.php');
?>

<main>
<?php 
if($url):
?>

<?php
$args = array(
	'post_type' => array('notas'),
	'posts_per_page' => 5, 
   	'tax_query' => array(
        array (
            'taxonomy' => 'post_tag',
            'field' => 'slug',
            'terms' => $url,
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

	<!-- NOTA -->
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="card <?= $ptg; ?> <?=$cat[0]->slug;?> <?= $r ?> hiddenbx">
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

<?php endwhile; else:
echo 'No HAY';
endif;
// wp_reset_postdata();
endif; 
?>

</main>

<?php 
	get_footer();
?>