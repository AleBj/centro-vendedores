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


