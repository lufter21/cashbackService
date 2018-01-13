$(document).ready(function() {

	$('body').on('click', '.accord__button', function() {
		var _ = $(this),
		_thisContent = _.closest('.accord__item').find('.accord__content'),
		_button = _.closest('.accord').find('.accord__button'),
		_content = _.closest('.accord').find('.accord__content');
		if (!_.hasClass('accord__button_active')) {
			_content.slideUp(321);
			_button.removeClass('accord__button_active');
			_thisContent.slideDown(321);
			_.addClass('accord__button_active');
		} else {
			_thisContent.slideUp(321);
			_.removeClass('accord__button_active');
		}
		return false;
	});

	$('.js-create-accord').each(function() {
		var _$ = $(this),
		group = _$.attr('data-group'),
		viewportWidth = _$.attr('data-viewport-width'),
		cont = '';

		if (winW < viewportWidth) {

			$('.js-add-button-to-accord[data-group="'+ group +'"]').each(function() {
				var ind = $(this).attr('data-index'),
				Cont = $('.js-add-content-to-accord[data-group="'+ group +'"][data-index="'+ ind +'"]');

				cont += '<div class="accord__item"><button class="accord__button">'+ $(this).html() +'<span></span></button><div class="accord__content">'+ Cont.html() +'</div></div>';

				$(this).remove();
				Cont.remove();

			});

			_$.addClass('accord').html(cont);
		}
		
	});

});