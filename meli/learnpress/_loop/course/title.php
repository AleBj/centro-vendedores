<?php
/**
 * Template for displaying title of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/title.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>
<div class="text">
<h3 class="course-title"><?php the_title(); ?></h3>
<p><?php echo wp_trim_words( get_the_excerpt(), 10, '...' ); ?></p>
</div>
