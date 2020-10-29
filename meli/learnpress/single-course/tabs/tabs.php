<?php
/**
 * Template for displaying tab nav of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/tabs.php.
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

    //echo $course->get_course_result();

	$curriculum = $course->get_curriculum();
    $clases = 0;
    $quiz = 0;
	foreach ( $curriculum as $section ) {
		$items = $section->get_items();

		foreach ($items as $item) {
            //echo '<pre>' . var_dump($item, true) . '</pre>';
            //echo $item['_item_type'];

            //var_dump($item->get_template());

            if ($item->get_template() == 'item-lesson') {
                $clases++;
            } else {
                $quiz++;
            }
		}
		// echo $section->count_items();
		// echo '<br/>';
	};

	//echo '<pre>' . var_export($section->get_items(), true) . '</pre>';

?>

<?php $tabs = learn_press_get_course_tabs(); ?>

<?php if ( empty( $tabs ) ) {
	return;
} ?>


<section class="single-course">
        <div class="bx_description">
            <div class="descripcion">
                <h3><?php _e( 'Descripción', 'meli-centro-vendedores' ) ?></h3>
                <div class="the-content">
                    <?php echo wp_trim_words( get_the_content(), 60, '...' ); ?>
                </div>
            </div>
        </div>
        <div class="bx_lessons">
            <div class="modulos">
                <h3><?php _e( 'Lecciones', 'meli-centro-vendedores' ) ?></h3>
                <div class="curriculum-scrollable">
                    <?php if ( $curriculum = $course->get_curriculum() ) { ?>
                    <ul class="curriculum-sections">
                        <?php foreach ( $curriculum as $section ) {
							learn_press_get_template( 'single-course/loop-section.php', array( 'section' => $section ) );
						} ?>
                    </ul>
                    <?php } else { ?>
                    <?php echo apply_filters( 'learn_press_course_curriculum_empty', __( 'Curriculum is empty', 'meli-centro-vendedores' ) ); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-12 col-lg-4 mb-4">
            <div class="resumen">
                <h3><?php _e( 'Resumen', 'meli-centro-vendedores' ) ?></h3>
                <ul>
                    <li>
                        <div class="left-side"> <img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-book.svg" alt="Book">  <?php _e( 'Lecciones', 'meli-centro-vendedores' ) ?>:</div>
                        <div class="right-side"><?php echo $clases; ?></div>
                    </li>
                    <li> 
                        <div class="left-side"> <img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-reloj.svg" alt="Reloj"><?php _e( 'Duración', 'meli-centro-vendedores' ) ?>:</div>
                        <div class="right-side"> <?= conversorSegundosHoras($course->get_duration()) ?></div>
                    </li>
                    <li> 
                        <div class="left-side"> <img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/ico-page.svg" alt="Page"><?php _e( 'Evaluación', 'meli-centro-vendedores' ) ?>:</div>
                        <div class="right-side">Sin evaluación</div>
                    </li>
                </ul>
            </div>
        </div>
        -->
</section>
<?php 
/*function conversorSegundosHoras($tiempo_en_segundos) {
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

    $hora_texto = "";
    if ($horas > 0 ) {
        $hora_texto .= $horas . " hs. ";
    }

    if ($minutos > 0 ) {
        $hora_texto .= $minutos . " min.";
    }

    if ($segundos > 0 ) {
        $hora_texto .= $segundos . " seg.";
    }

    return $hora_texto;
}*/
?>
