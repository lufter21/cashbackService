/*global vars (window width, window height)*/
var winW = $(window).width(),
winH = $(window).height(),
sel_reg;

(function(w, d) {

	$(d).ready(function(){

		$('.wrapper').css('padding-bottom', $('.footer').innerHeight());

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
			if ($(w).scrollTop() > 7) {
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

}(window, document));