var winW = $(window).width(),
winH = $(window).height();

$(document).ready(function(){

	$('.wrapper').css('padding-bottom', $('.footer').innerHeight());

	//showBlock
	$('body').on('click', '.js-show-button', function() {
		var _ = $(this),
		_block = $('#'+ _.attr('data-block'));
		if (!_.hasClass('active')) {
			_block.slideDown(321);
			_.addClass('active');
		} else {
			_block.slideUp(321);
			_.removeClass('active');
		}
		return false;
	});

	//header
	$(window).scroll(function() {
		if ($(window).scrollTop() > 7) {
			$('.header').addClass('header_fixed');
		} else {
			$('.header').removeClass('header_fixed');
		}
	});

	if (adBlock) {
		$('#alert').fadeIn(321).html('В вашем браузере установленно расширение Adblock, оно может помешать работе сервиса и вам не насчитают кэшбэк.');
		$('.wrapper').css('padding-top', $('.header').innerHeight());
	}

});

function sel_reg(){
	setTimeout(function(){
		$('#menu-region').addClass('bg-red').slideDown(321);
		$('#show-region-button').addClass('active');
		if(winW < 1000){
			$('.header__user-btn-mob').click();
		}
	},1021);
}