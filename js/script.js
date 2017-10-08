$(document).ready(function(){

//window-onload
window.onload = function(){
	
	/*if(winW > 670){
		var curH = 0;
		$('.discount-item').each(function(){
			var itH = $(this).height();
			if(itH > curH){
				curH = itH;
			}
		});
		$('.discount-item .inner').height(curH - 221);
	}
	
	var winH = $(window).height();
	var wrapH = $('#wrapper').height();
	if(winH > (wrapH + 43)){
		//$('#wrapper').height(winH - $('#footer').height() - 35);
		$('#footer').addClass('fixed');
	}
	
*/	
	





	
}
	



//dropdown-menu
$('.header .button').mouseenter(function(){
	var el = this;
	if(!$(this).hasClass('active')){
		$(el).addClass('me');
		setTimeout(function(){
			if($(el).hasClass('me') && !$(el).hasClass('active')){
				var blockId = $(el).attr('data-block');
				$('.drop-block').slideUp(121);
				$('.button').removeClass('active');
				$('#'+blockId).slideDown(121);
				$(el).addClass('active');
			}
		},1221);
	}
});

$('.header .button').mouseleave(function(){
	$(this).removeClass('me');
});

$('.header .button').click(function(){
	var blockId = $(this).attr('data-block');
	if($(this).hasClass('active')){
		$('#'+blockId).slideUp(121);
		$(this).removeClass('active');
	}
	else{
		if(winW > 680){
			$('.drop-block').slideUp(121);
		}
		$('.button').removeClass('active');
		$('#'+blockId).slideDown(121);
		$(this).addClass('active');
	}
});

//modal
$('.modal').click(function(){
	var modalClass = $(this).attr('href');
	$('#modal-window').addClass(modalClass);
	$('#mask,#modal-window').fadeIn(321);
	return false;
});

$('.close,#mask').click(function(){
	$('#mask,#modal-window').fadeOut(321,function(){
		$('#modal-window').removeClass();
	});
});

//searchform
$('#search-form').submit(function(){
	var sQ = $('#sfi').val();
	if(sQ.length < 4){
		alert('Длина поисковой фразы должна быть не менее 4 букв');
		return false;
	}
	$('#load').fadeIn(121);
});



//open-menu
$('#wrapper').on('click','#open-mob-menu',function(){
	if (!$(this).hasClass('active')) {
		$('#mob-nav-block').slideDown(321);
		$(this).addClass('active');
	}
	else{
		$('#mob-nav-block').slideUp(321);
		$(this).removeClass('active');
	}
});


//loader
$('#menu-block a,#menu-region a,.pagination a').click(function(){
	$('#load').fadeIn(121);
});

});



