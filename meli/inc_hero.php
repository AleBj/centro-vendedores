<div id="header">
	
	<ul class="slides">
	<?php
	$bh = 0;
	// check if the repeater field has rows of data
	if( have_rows('banners_hero', 'option') ):

	 	// loop through the rows of data
	    while ( have_rows('banners_hero', 'option') ) : the_row();

	        // display a sub field value
	        $imgDesk = get_sub_field('banner_desktop_hero');
	        $imgMob = get_sub_field('banner_mobile_hero');
	        $link = get_sub_field('link_banner_hero');
	        $target = get_sub_field('target_banner_hero');

	        if($bh < 3):

	        	var_dump($link);
	        	var_dump($target);
	    ?>
	    <li>
	    	<?php if(isset($link) && $link !== ""): ?>
	    		<a href="<?=$link?>" target="<?=$target?>">
	    	<?php endif; ?>
	    	
	    	<img src="<?=$imgDesk["url"]?>" alt="Centro de vendedores Mercado Libre" class="img-desktop">
	    	<img src="<?=$imgMob["url"]?>" alt="Centro de vendedores Mercado Libre" class="img-mobile">
	    	
	    	<?php if(isset($link) && $link !== ""): ?>
	    		</a>
	    	<?php endif; ?>	    	
	    </li>

	    <?php
	    	endif;
	    	$bh++;
	    endwhile;

	endif;

	?>
	</ul>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider-min.js" crossorigin="anonymous"></script>
<script>
	$('#header').flexslider({
		animation:"slide",
	});
</script>
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
<!-- <div class="copy">
		<?php if($title): 
			echo $title;
		else: ?>
			<h1><strong><?php _e( 'Potenciemos juntos tus ventas.', 'meli-centro-vendedores'); ?></strong> <?php _e( 'Descubrí cómo podemos ayudarte a llegar más lejos', 'meli-centro-vendedores' ); ?></h1>
		<?php endif; ?>
		<form action="" id="formSearch" onsubmit="return prevent(event)">
			<input type="text" name="search" id="search" placeholder="Buscar..." onkeyup="fetch()">
			<button><img src="<?php bloginfo('url'); ?>/wp-content/themes/meli/img/lupa.svg" alt=""></button>
			<div class="list-search" id="datafetch">
			</div>
		</form>
	</div> -->
