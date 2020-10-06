<div id="header">
	<div class="copy">
		<?php if($title): 
			echo $title;
		else: ?>
			<h1><strong>Te ayudamos a crecer</strong> con todas las herramientas de Mercado Libre</h1>
		<?php endif; ?>
		<form action="" id="formSearch" onsubmit="return prevent(event)">
			<input type="text" name="search" id="search" placeholder="¿Qué estás buscando hoy?" onkeyup="fetch()">
			<button><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/lupa.svg" alt=""></button>
			<div class="list-search" id="datafetch">
				<!-- <div class="item">
					<h4>Novedades <a href="">Ver más</a></h4>
					<a href="#">
						Nuevas retenciones de IVA y Ganancias sobre los cobros con medios de pago electrónicos
					</a>
				</div>
				<div class="item">
					<h4>Notas <a href="">Ver más</a></h4>
					<a href="#">
						Nuevas retenciones de IVA y Ganancias sobre los cobros con medios de pago electrónicos					
						<div class="img" style="background-image: url(<?php bloginfo('url'); ?>/wp-content/themes/meli/img/retorno_head-768x512.jpg)"></div>
					</a>
				</div>
				<div class="item">
					<h4>Cursos <a href="">Ver más</a></h4>
					<a href="#">
						Nuevas retenciones de IVA y Ganancias sobre los cobros con medios de pago electrónicos		
					</a>
				</div>
				<div class="tags">
					<strong>tags:</strong>
					<a href="">Impuestos</a>
					<a href="">Cobro online</a>
					<a href="">Cobro presencial</a>
				</div> -->
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
var texto;
function fetch(){

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'data_fetch', keyword: jQuery('#search').val() },
        success: function(data) {
        	// console.log(data);
        	texto = jQuery('#search').val();
            jQuery('#datafetch').html( data );
            $('#formSearch .list-search').delay(300).slideDown(500)
        }
    });

}
function prevent(e){
	e.preventDefault()
}

// Get the input field
var input = document.getElementById("search");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();

	window.location = '<?php bloginfo('url'); ?>/buscar/#'+input.value

  }
});
function clickGoSearch(){
	window.location.href = '<?php bloginfo('url'); ?>/buscar/#'+texto
	console.log('<?php bloginfo('url'); ?>/buscar/#'+texto)
}

</script>
