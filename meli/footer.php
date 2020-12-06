
<footer>
	<div class="wp navlink">
		<ul>
			<li><a href="<?php bloginfo('url') ?>/novedades"><?php _e( 'Novedades', 'meli-centro-vendedores' ); ?></a></li>
			<li><a href="<?php bloginfo('url') ?>/notas"><?php _e( 'Notas', 'meli-centro-vendedores' ); ?></a></li>
			<li><a href="<?php bloginfo('url') ?>/cursos"><?php _e( 'Cursos', 'meli-centro-vendedores' ); ?></a></li>
		</ul>
		
		<div class="copyright"><?php _e( 'COPYRIGHT © 1999-2020 MERCADOLIBRE S.R.L.', 'meli-centro-vendedores' ); ?></div>
	</div>
	<div class="links">
		<div class="bt"> <?php _e( 'Más información', 'meli-centro-vendedores' ); ?> <i class="fa fa-angle-up"></i></div>
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

<?php if( have_rows('disclaimer_cookies', 'option') ): ?>
    <?php while( have_rows('disclaimer_cookies', 'option') ): the_row(); 

	 $disc_txt = get_sub_field('texto_disclaimer');
	 $disc_btn = get_sub_field('boton_disclaimer');
    ?>    
	<div id="disclaimer">
		<?php echo $disc_txt ?>
		<div class="btn"><?php echo $disc_btn ?></div>
	</div>		
    <?php endwhile; ?>
<?php endif; ?>


<script src="<?php bloginfo('url'); ?>/wp-content/themes/meli/js/jquery.flexslider-min.js?v=1"></script>
<script src="<?php bloginfo('url'); ?>/wp-content/themes/meli/js/owl.carousel.min.js?v=1"></script>
<script src="<?php bloginfo('url'); ?>/wp-content/themes/meli/js/funciones.js?v=1"></script>
<script>
	var x = getCookie('ppkcookie');
	if (x) {
		//console.log(x);
		$('#disclaimer').hide()
	}

	$('.links .bt').on('click', function(){
		$(this).toggleClass('open');
		$('.links .contentLinks').slideToggle(400);
		$("html, body").animate({ scrollTop: $(document).height() }, 1000);
	});
	$('#disclaimer .btn').on('click', function(){
		$('#disclaimer').fadeOut(300);
		setCookie('ppkcookie','melicookie',7);
	})

	$('.owl-carousel').owlCarousel({
	    loop:false,
	    margin:16,
	    autoWidth:true,
	    nav:true,
	    responsive:{
	        0:{
	            items:3,	            
	        },
	        600:{
	            items:4
	        },
	        1000:{
	            items:6
	        }
	    }
	})


</script>
</body>
</html>