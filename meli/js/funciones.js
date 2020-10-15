$('#formSearch input').on('keyup', function(){
	$('#formSearch').addClass('open');
	// $('#formSearch .list-search').delay(300).slideDown(500)
})	
$('#formSearch input').on('focusout', function(){
	$('#formSearch input').val('');
	setTimeout(function(){
	
		$('#formSearch .list-search').slideUp(300, function(){
			$('#formSearch').removeClass('open');
		})

	}, 300)
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

//COOKIES
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
