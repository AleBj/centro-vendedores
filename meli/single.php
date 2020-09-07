<?php get_header(); ?>

<main>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
	<div class="wp" id="single" class="anteriores">
		<h1 class="content-small"><?php the_title(); ?></h1>
	
		<div class="texto content-small content-novedad">

	        <?php the_content(); ?>
		</div>
	</div>
	<style>
		img{display: block;width: 100%;margin: 30px auto;}
	</style>
<?php 
    endwhile;

endif;
?>
</main>
<?php get_footer(); ?>
