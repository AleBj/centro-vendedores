<?php
/*
Template Name: Buscador
*/

get_header();

?>
<main>
    
    <div class="wp" id="search">
        <form action="" method="post" id="formEnviar">
            <input type="text" name="s" id="buscar" onkeyup="fetch()" placeholder="<?php _e( '¿Qué estás buscando hoy?', 'meli-centro-vendedores' ); ?>">
        </form>
        <div id="filterssearch">  
            <a href="" class="ml bt" data-filter="mercado-libre"><?php _e( 'Mercado Libre', 'meli-centro-vendedores' ); ?></a>
            <a href="" class="mp bt" data-filter="mercado-pago"><?php _e( 'Mercado pago', 'meli-centro-vendedores' ); ?> </a>
            <a href="" class="me bt" data-filter="mercado-envios"><?php _e( 'Mercado envíos', 'meli-centro-vendedores' ); ?> </a>
            <?php if($blog_id != 5): ?>
            <a href="" class="ms bt" data-filter="mercado-shops"><?php _e( 'Mercado shops', 'meli-centro-vendedores' ); ?> </a>    
            <?php endif; ?>       
            <a href="" class="ma bt" data-filter="mercado-ads"><?php _e( 'Mercado Ads', 'meli-centro-vendedores' ); ?></a>   
        </div>
        <div id="results">
            <div class="nav-result">
                <div class="bt active" id="notas"><?php _e( 'Notas', 'meli-centro-vendedores' ); ?></div>
                <!-- <div class="bt" id="novedades"><?php _e( 'Novedades', 'meli-centro-vendedores' ); ?></div> -->
                <div class="bt" id="cursos"><?php _e( 'Cursos', 'meli-centro-vendedores' ); ?></div>
                <div class="bt" id="etiquetas"><?php _e( 'Etiquetas', 'meli-centro-vendedores' ); ?></div>
                <i></i>
            </div>
            
            <div class="main-result" id="mainresult">
                
            </div>

        </div>
    </div>
    
</main>
<script>
$('#buscar').focus()
$('#results .nav-result .bt').on('click', function(e){
    e.preventDefault();
    $('#results .nav-result .bt').removeClass('active');
    $(this).addClass('active')
    var lft = $(this).position().left;
    var frm = $(this).attr('id');
    var wpx = $(this).width();
    console.log(frm)
    $('#results .nav-result i').css({'left': lft+'px', 'width': wpx+'px'});
    $('#results .block_home').fadeOut(300);
    $('#results .block_home.'+frm).stop(true,true).delay(300).fadeIn(300)
});
// Get the input field
var input = document.getElementById("buscar");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
  }
});
$('#formEnviar').on('submit', function(e){e.preventDefault();})
$('#formSearch input').on('keydown', function(){
    var val = $(this).val()
    $('#formEnviar input').val(val)
})
function fetch(){
    
    $('#notas.bt').trigger('click');
    $('#filterssearch .bt').removeClass('active')

    $('#mainresult').html('<div class="loading"><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/spinner.svg" width="30"></div>')
    
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'data_search', keyword: jQuery('#buscar').val() },
        success: function(data) {
            jQuery('#mainresult').html( data );

            var nove = $('.block_home.novedades .card').length
            var nota = $('.block_home.notas .card').length
            var curso = $('.block_home.cursos .card').length

            if(nove > 0){
                $('.bt#novedades').addClass('hay')
            }else{
                $('.bt#novedades').removeClass('hay')                
            }
            if(nota > 0){
                $('.bt#notas').addClass('hay')
            }else{
                $('.bt#notas').removeClass('hay')                
            }
            if(curso > 0){
                $('.bt#cursos').addClass('hay')
            }else{
                $('.bt#cursos').removeClass('hay')                
            }
        }
    });

}
function fetch2(xxx){

    $('#notas.bt').trigger('click');
    $('#filterssearch .bt').removeClass('active')
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'data_search', keyword: xxx },
        success: function(data) {
            // console.log(data);
            jQuery('#mainresult').html( data );

            var nove = $('.block_home.novedades .card').length
            var nota = $('.block_home.notas .card').length
            var curso = $('.block_home.cursos .card').length

            if(nove > 0){
                $('.bt#novedades').addClass('hay')
            }else{
                $('.bt#novedades').removeClass('hay')                
            }
            if(nota > 0){
                $('.bt#notas').addClass('hay')
            }else{
                $('.bt#notas').removeClass('hay')                
            }
            if(curso > 0){
                $('.bt#cursos').addClass('hay')
            }else{
                $('.bt#cursos').removeClass('hay')                
            }
        }
    });

}
//CAPTURA HASH
    var hash = window.location.hash.substring(1);
    hash = hash.replace('%C3%A1', 'á')
    hash = hash.replace('%C3%A9', 'é')
    hash = hash.replace('%C3%AD', 'í')
    hash = hash.replace('%C3%B3', 'ó')
    hash = hash.replace('%C3%BA', 'ú')
    hash = hash.replace('%20', ' ')
    hash = hash.replace('%20', ' ')
    hash = hash.replace('%20', ' ')
    
    console.log(hash)
    if(hash){
        $('#buscar').val(hash)
        fetch2(hash)
    }
</script>
<script>
(function($) {

var $filters = $('#filterssearch .bt');

  $filters.on('click', function(e) {

    e.preventDefault();
    var $this = $(this);

    var $filterCat = $this.attr('data-filter');
    var     $boxes = $('#mainresult .card');

    if ($this.hasClass('active')) {
        
      $filters.removeClass('active');
 
      $boxes.removeClass('is-animated')
        .fadeOut().finish().promise().done(function() {
          $boxes.each(function(i) {
            $(this).addClass('is-animated').delay((i++) * 200).fadeIn();
          });
        });
    } else {

      $filters.removeClass('active');
      $this.addClass('active');

      $boxes.removeClass('is-animated')
        .fadeOut().finish().promise().done(function() {
          $boxes.filter('.card.' + $filterCat ).each(function(i) {
            $(this).addClass('is-animated').delay((i++) * 200).fadeIn();
          });
        });
    }

  });

})(jQuery);
</script>

<?php

get_footer(); 

?>