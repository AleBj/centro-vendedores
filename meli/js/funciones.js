$('#formSearch input').on('keyup', function(){
	$('#formSearch').addClass('open');
	// $('#formSearch .list-search').delay(300).slideDown(500)
})	
$('#formSearch input').on('focusout', function(){
	$('#formSearch input').val('');
	$('#formSearch .list-search').slideUp(300, function(){
		$('#formSearch').removeClass('open');
	})
});
$('#burger').on('click', function(){
	$('#burger').toggleClass('open');
	if($(this).hasClass('open')){
		$('nav').slideDown(300);
	}else{
		$('nav').slideUp(300, function(){
			$('nav').delay(400).removeAttr('style')
		});		
	}
});
var vw = $(window).width();
if(vw < 1000){
	$('nav ul li:last-child').on('click', function(){
		$('.submenu').toggle(0)
	})
}