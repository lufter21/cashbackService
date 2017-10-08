/*global vars (window width, window height)*/
var winW = $(window).width(),
winH = $(window).height(),
sel_reg;

(function(w, d) {

	$(d).ready(function(){

		//setRegion
		sel_reg = function(){
			setTimeout(function(){
				$('#menu-region').slideDown(321);
				$('#show-region-button').addClass('active');
				if(winW < 670){
					$('#mob-nav-block').slideDown(321);
					$('#open-mob-menu').addClass('active');
				}
			},1021);
		}

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
		$(w).scroll(function() {
			if ($(w).scrollTop() > 28) {
				$('.header').addClass('box-shadow');
			} else {
				$('.header').removeClass('box-shadow');
			}
		});


		//sidebar
		if ($('#js-sidebar').length) {

			var sidbH = $('#js-sidebar').height(),
			sidbOfs = $("#js-sidebar").offset().top,
			wrapH = $('#wrapper').height(),
			flexH = $('#flex-wrap').height();

			if(sidbH < winH){
				$(w).scroll(function(){
					if($(w).scrollTop() > (wrapH - winH) && sidbH < flexH){
						$("#js-sidebar").stop().animate({top: flexH - sidbH + 49},521);
					}
					else if ($(w).scrollTop() > sidbOfs && sidbH < flexH){
						$("#js-sidebar").stop().animate({top: $(w).scrollTop() - sidbOfs + 21},521);
					} else {
						$("#js-sidebar").stop().animate({top: 0});
					}
				});
			} else {
				var delt = sidbOfs + (sidbH - winH);
				var scrD = 0;
				$(w).scroll(function(){
					if($(w).scrollTop() > (wrapH-winH) && sidbH < flexH){
						$("#sidebar").stop().animate({top: flexH - sidbH + 49},521);
					}
					else if ($(w).scrollTop() > delt && sidbH < flexH ){
						if($(w).scrollTop() < scrD){
							$("#js-sidebar").stop().animate({top: $(w).scrollTop() - sidbOfs + 21},521);
						} 
						else if($(w).scrollTop() > scrD){
							$("#js-sidebar").stop().animate({top: $(w).scrollTop() - delt - 21},521);
						}
						scrD = $(w).scrollTop();
					} 
					else {
						$("#js-sidebar").stop().animate({top: 0});
					}
				});
			}

		}

		if (adBlock) {
			$('#alert').fadeIn(321).html('В вашем браузере установленно расширение Adblock, оно может помешать работе сервиса и вам не насчитают кэшбэк.');
			$('.wrapper').css('padding-top', 112+$('#alert').innerHeight());
		}

	});

}(window, document));