var Popup = {
	show: function(id,fun) {
		var _popup = $(id);
		if (_popup.length && _popup.hasClass('popup__window')) {
			var pos = $(window).scrollTop();
			$('.popup').fadeIn(321).scrollTop(0);
			$('.popup__window').removeClass('popup__window_visible');
			_popup.addClass('popup__window_visible');
			$('body').css('top', -pos).attr('data-position', pos).addClass('is-popup-opened');
		}
		this.closeCallback = fun || function() {};
		return _popup;
	},
	hide: function() {
		$('.popup__window').removeClass('popup__window_visible');
		$('.popup').fadeOut(321);
		$('.popup__message').remove();
		$('body').removeClass('is-popup-opened').removeAttr('style');
		$('html,body').scrollTop($('body').attr('data-position'));
		this.closeCallback();
	},
	message: function(id,msg,fun) {
		$(id).find('.popup__inner').prepend('<div class="popup__message">'+ msg +'</div>');
		this.show(id);
		this.closeCallback = fun || function() {};
	}
};


$(document).ready(function() {
	$('body').on('click', '.js-open-popup', function () {
		var _popup = Popup.show($(this).attr('href')),
		tabId = $(this).attr('data-tab');

		if(tabId){
			_popup.find('.tab__btn').removeClass('tab__btn_active');
			_popup.find('.tab__content').removeClass('tab__content_vis').removeAttr('style');
			$('#'+ tabId +'-tab__btn').addClass('tab__btn_active');
			$('#'+ tabId +'-tab').addClass('tab__content_vis');
		}
		return false;
	});

	$('body').on('click', '.popup__close', function () {
		Popup.hide();
		return false;
	});

	$('body').on('click', '.popup', function(e) {
		if (!$(e.target).closest('.popup__window').length) {
			Popup.hide();
		}
	});

	if (window.location.hash) {
		Popup.show(window.location.hash);
	}

});