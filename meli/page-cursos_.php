<?php
/*
Template Name: Cursos
*/

get_header();

?>

<section class="lp-cursos-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-2 list-category">
				<h4><?php _e( 'Cursos', 'learnpress' ); ?></h4>
            <?php
                $category = get_queried_object();
				$args = array(
							'taxonomy' => 'course_category',
							'orderby' => 'name',
							'order'   => 'ASC'
						);

				$cats = get_categories($args);

				foreach($cats as $cat) {
				?>
					<a href="<?php echo get_category_link( $cat->term_id ) ?>"  <?php echo $cat->term_id === $category->term_id ? "class='active'" : ""; ?>>
						<?php echo $cat->name; ?>
					</a>
				<?php
                }
				?>
			</div>
			<div class="col-md-12 col-lg-10 list-posts">
				<?php
	            $the_query = new WP_Query( array(
	            	'posts_per_page' => -1,
	                'post_type' => 'lp_course'
	            ) ); ?>

	            <?php
	            while ( $the_query->have_posts() ) :
	                $the_query->the_post(); ?>
	                <?php var_dump($post) ?>
					<article class="card card-md">
                    <figure class="mb-0">
                    <a class="card-link" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large', array(
                            'class' => 'card-img-top')) ?>
                    </a>
                    </figure>
                    <div class="card-body">
                    <a class="card-link" href="<?php the_permalink(); ?>">
                        <h3 class="card-title mb-2"><?php the_title(); ?></h3>
                        <p class="card-text"><?php echo wp_trim_words( get_the_excerpt(), 10, '...' ); ?></p>
                    </a>
                    <div>
                    	<?php
                        $tags = wp_get_object_terms( $post->ID , 'course_tag' );
                        foreach ( $tags as $tag ) {
                            echo '<span>'.$tag->name.'</span>';
                            }
                        ?>    
                        <br>                   
                    	<?php
                        $cats = wp_get_object_terms( $post->ID , 'course_category' );
                        foreach ( $cats as $cat ) {
                            echo '<span>'.$cat->name.'</span> ('.$cat->slug.')';
                            }
                        ?>
                    </div>
                        <hr> 
                </article>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</section>