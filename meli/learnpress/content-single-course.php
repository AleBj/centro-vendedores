<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-single-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

/**
 * @deprecated
 */
do_action( 'learn_press_before_main_content' );
do_action( 'learn_press_before_single_course' );
do_action( 'learn_press_before_single_course_summary' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

do_action( 'learn-press/before-single-course' );

?>
<div id="learn-press-course" class="course-summary">
	<?php
	/**
	 * @since 3.0.0
	 *
	 * @see learn_press_single_course_summary()
	 */
	do_action( 'learn-press/single-course-summary' );
	?>
</div>

<section class="acced-course">
    <div class="col-12 text-center">
        <div class="lp-course-buttons">
            <?php
            $link = $course->get_item_links();
            if ( $course->is_free() && !$course->is_required_enroll() ) { ?>
            <form action="<?php echo reset($link); ?>" ?>
                <button type="submit" href=""><?php _e( 'Comenzar', 'sage' ) ?></button>
            </form>
            <?php } ?>
        </div>
    </div>
</section>

<?php $tags = wp_get_object_terms( $course->get_id() , 'course_category' ); ?>
<?php if (!empty($tags)): ?>
    <section class="related-course">
        <div class="container">
        <h4><?php _e( 'Te puede interesar', 'sage' ) ?></h4>
        <?php
            $the_query = new WP_Query( array(
                'post_type' => 'lp_course',
                'post__not_in' => [$course->get_id()],
                'posts_per_page' => 2,
                'tax_query' => array(
                    array (
                        'taxonomy' => 'course_category',
                        'field' => 'slug',
                        'terms' => $tags[0]->slug,
                    )
                ),
            ) ); ?>
            <div class="related-slider">
            <?php
            while ( $the_query->have_posts() ) :
                $the_query->the_post(); ?>

                <a href="<?php the_permalink()?>" class="card">
                    <div class="img" style="background-image: url(<?= get_the_post_thumbnail_url() ?>)"></div>
                    <div class="copy">
                        <small class="<?= $tags[0]->slug;?>"><?= $tags[0]->name;?></small>
                        <h2><?php the_title(); ?></h2>
                        <div class="tags">
                            <?php
                                $tagas = wp_get_object_terms( $course->get_id() , 'course_tag' );
                                foreach ( $tagas as $tag ) {
                                    echo '<span>'.$tag->name.'</span>';
                                    }
                                ?>
                            
                        </div>
                        <div class="items">
                            <div class="time"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-reloj.svg" alt="Reloj"><?= conversorSegundosHoras($course->get_duration()) ?></div>
                            <div class="file"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-page.svg" alt="Page"> Sin evaluación</div>
                            <div class="lessons"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-book.svg" alt="Book"><?php
                            $curriculum = $course->get_curriculum();
                            $clases = 0;
                            foreach ( $curriculum as $section ) {
                                $clases += count($section->get_items());
                            };
                            echo $clases;
                            ?>
                             Lecciones</div>
                        </div>
                    </div>
                </a>


            <?php
            endwhile;
            wp_reset_postdata();
            ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

do_action( 'learn-press/after-single-course' );

/**
 * @deprecated
 */
do_action( 'learn_press_after_single_course_summary' );
do_action( 'learn_press_after_single_course' );
do_action( 'learn_press_after_main_content' );


