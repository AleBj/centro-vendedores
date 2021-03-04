<div id="inputSearch">
	<form action="" id="formSearch" onsubmit="return prevent(event)">
		<input type="text" name="search" id="search" placeholder="Buscar..." onkeyup="fetch()">
		<button><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/lupa.svg" alt=""></button>
		<div class="list-search" id="datafetch">
		</div>
	</form>	
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
