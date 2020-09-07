<?php
/**
 * Template for displaying price of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/price.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();
?>

<div class="course-price">

	<!-- <?php if ( $price_html = $course->get_price_html() ) { ?>

		<?php if ( $course->get_origin_price() != $course->get_price() ) { ?>

			<?php $origin_price_html = $course->get_origin_price_html(); ?>

            <span class="origin-price"><?php echo $origin_price_html; ?></span>

		<?php } ?>

        <span class="price"><?php echo $price_html; ?></span>

	<?php } ?> -->

</div>

<!-- Course info botoom -->
<div class="course-info-bottom">

		<div class="course-categories-taxonomy">
			<?php
			$tags = wp_get_object_terms( $course->get_id() , 'course_tag' );
			foreach ( $tags as $tag ) {
				echo '<span>'.$tag->name.'</span>';
				}
			?>
		</div>

		<div class="coruse-clases">				
			<img src="<?= App\asset_path('images/lessons-gray.svg') ?>">
			<?php
			$curriculum = $course->get_curriculum();
			$clases = 0;
			foreach ( $curriculum as $section ) {
				$clases += count($section->get_items());
			};
			echo $clases;
			?>
		</div>

</div>

</div> <!-- END OF WRAP SHADOW -->
