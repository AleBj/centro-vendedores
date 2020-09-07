<?php
/**
 * Template for displaying archive course content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-archive-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post, $wp_query, $lp_tax_query, $wp_query;


/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

/**
 * @deprecated
 */
do_action( 'learn_press_archive_description' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/archive-description' );

if ( LP()->wp_query->have_posts() ) :

	/**
	 * @deprecated
	 */
	do_action( 'learn_press_before_courses_loop' );

	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/before-courses-loop' );

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
					learn_press_begin_courses_loop();

					while ( LP()->wp_query->have_posts() ) : LP()->wp_query->the_post();

						learn_press_get_template_part( 'content', 'course' );

					endwhile;

					learn_press_end_courses_loop();

					?>
				</div>
			</div>
		</div>
	</section>
	<?php
	/**
	 * @since 3.0.0
	 */
	do_action( 'learn_press_after_courses_loop' );

	/**
	 * @deprecated
	 */
	do_action( 'learn-press/after-courses-loop' );

	wp_reset_postdata();

else:
	learn_press_display_message( __( 'No course found.', 'learnpress' ), 'error' );
endif;

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

/**
 * @deprecated
 */
do_action( 'learn_press_after_main_content' );
