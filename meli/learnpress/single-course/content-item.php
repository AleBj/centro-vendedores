<?php
/**
 * Template for displaying item content in single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/content-item.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.9
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user          = LP_Global::user();
$course_item   = LP_Global::course_item();
$course        = LP_Global::course();
$can_view_item = $user->can_view_item( $course_item->get_id(), $course->get_id() );
?>

<div id="learn-press-content-item">

	<?php do_action( 'learn-press/course-item-content-header' ); ?>

    <div class="content-item-scrollable">

	<?php if( get_field('video_clase', $course_item->get_id()) ): ?>
		<div style="background-color: black;">
			<div class="container" style="max-width: 900px;padding-left:0px;padding-right: 0px;">
				<div class="embed-container">
					<?php the_field('video_clase', $course_item->get_id()); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	

	<style>
		.embed-container { 
			position: relative; 
			padding-bottom: 56.25%;
			overflow: hidden;
			max-width: 100%;
			height: auto;
		} 

		.embed-container iframe,
		.embed-container object,
		.embed-container embed { 
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;			
		}
		
		/* @media (min-width: 768px) { 
			.embed-container iframe,
			.embed-container object,
			.embed-container embed { 			
				padding: 15px 20px;
			} 
		 }

		@media (min-width: 1200px) { 
			.embed-container iframe,
			.embed-container object,
			.embed-container embed { 			
				padding: 035px 80px;
			}
		 }
		 @media (min-width: 1500px) { 
			.embed-container iframe,
			.embed-container object,
			.embed-container embed { 			
				padding: 35px 150px;
			}
		 } */
	</style>

        <div class="content-item-wrap">

			<?php
			/**
			 * @deprecated
			 */
			do_action( 'learn_press_before_content_item' );

			/**
			 * @since 3.0.0
			 *
			 */
			do_action( 'learn-press/before-course-item-content' );

			if ( $can_view_item ) {
				/**
				 * @deprecated
				 */
				do_action( 'learn_press_course_item_content' );

				/**
				 * @since 3.0.0
				 */
				do_action( 'learn-press/course-item-content' );

			} else {
				learn_press_get_template( 'single-course/content-protected.php', array( 'can_view_item' => $can_view_item ) );
			}

			/**
			 * @since 3.0.0
			 */
			do_action( 'learn-press/after-course-item-content' );

			/**
			 * @deprecated
			 */
			do_action( 'learn_press_after_content_item' );
			?>

        </div>

    </div>

	<?php do_action( 'learn-press/course-item-content-footer' ); ?>

</div>