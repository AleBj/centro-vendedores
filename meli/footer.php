
<footer>
	<div class="wp navlink">
		<ul>
			<li><a href="<?php bloginfo('url') ?>/novedades">Novedades</a></li>
			<li><a href="<?php bloginfo('url') ?>/notas">Notas</a></li>
			<li><a href="<?php bloginfo('url') ?>/cursos">Cursos</a></li>
		</ul>
		
		<div class="copyright">COPYRIGHT © 1999-2020 MERCADOLIBRE S.R.L.</div>
	</div>
	<div class="links">
		<div class="bt"> Mas información <i class="fa fa-angle-up"></i></div>
		<div class="contentLinks">
		<div class="wp">
			<?php
    		if( have_rows('columnas_footer', 'option') ):
			 	// loop through the rows of data
			    while ( have_rows('columnas_footer', 'option') ) : the_row(); 
			    	$headerCol = get_sub_field('titulo_col_footer');
			    ?>
				<ul>
					<li><h5><?= $headerCol ?></h5></li>
					<?php
		    		if( have_rows('links_interes_footer') ):
					 	// loop through the rows of data
					    while ( have_rows('links_interes_footer') ) : the_row(); 
					    	$cta = get_sub_field('cta_link_footer');
					    	$url = get_sub_field('url_link_footer');
					    	$target = get_sub_field('target_link_footer');
					    ?>
						<li><a href="<?= $url; ?>" target="<?= $target; ?>"><?= $cta; ?></a></li>
						
					<?php    
						endwhile;

					endif; ?>
				</ul>

			<?php    
				endwhile;

			endif; ?>
		</div>
		</div>
	</div>
</footer>
<script src="<?php bloginfo('url'); ?>/wp-content/themes/meli/js/jquery.flexslider-min.js?v=1"></script>
<script src="<?php bloginfo('url'); ?>/wp-content/themes/meli/js/owl.carousel.min.js?v=1"></script>
<script src="<?php bloginfo('url'); ?>/wp-content/themes/meli/js/funciones.js?v=1"></script>
<script>
	$('.links .bt').on('click', function(){
		$(this).toggleClass('open');
		$('.links .contentLinks').slideToggle(400);
		$("html, body").animate({ scrollTop: $(document).height() }, 1000);
	})
</script>
</body>
</html>