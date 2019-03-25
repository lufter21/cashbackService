// global variables
; var browser, elemIsHidden, ajax, animate;

(function() {
	'use strict';
	
	// Get useragent
	document.documentElement.setAttribute('data-useragent', navigator.userAgent.toLowerCase());
	
	// Browser identify
	browser = (function(userAgent) {
		userAgent = userAgent.toLowerCase();
		
		if (/(msie|rv:11\.0)/.test(userAgent)) {
			return 'ie';
		} else if (/firefox/.test(userAgent)) {
			return 'ff';
		}
	})(navigator.userAgent);
	
	// Add support CustomEvent constructor for IE
	try {
		new CustomEvent("IE has CustomEvent, but doesn't support constructor");
	} catch (e) {
		window.CustomEvent = function(event, params) {
			var evt = document.createEvent("CustomEvent");

			params = params || {
				bubbles: false,
				cancelable: false,
				detail: undefined
			};

			evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
			
			return evt;
		}
		
		CustomEvent.prototype = Object.create(window.Event.prototype);
	}
	
	// Window Resized Event
	const winResizedEvent = new CustomEvent('winResized'),
	winWidthResizedEvent = new CustomEvent('winWidthResized');

	let rsz = true,
	beginWidth = window.innerWidth;
	
	window.addEventListener('resize', function() {
		if (rsz) {
			rsz = false;
			
			setTimeout(function() {
				window.dispatchEvent(winResizedEvent);
				
				if (beginWidth != window.innerWidth) {
					window.dispatchEvent(winWidthResizedEvent);

					beginWidth = window.innerWidth
				}

				rsz = true;
			}, 1021);
		}
	});
	
	// Closest polyfill
	if (!Element.prototype.closest) {
		(function(ElProto) {
			ElProto.matches = ElProto.matches || ElProto.mozMatchesSelector || ElProto.msMatchesSelector || ElProto.oMatchesSelector || ElProto.webkitMatchesSelector;
			
			ElProto.closest = ElProto.closest || function closest(selector) {
				if (!this) {
					return null;
				}
				
				if (this.matches(selector)) {
					return this;
				}
				
				if (!this.parentElement) {
					return null;
				} else {
					return this.parentElement.closest(selector);
				}
			};
		})(Element.prototype);
	}
	
	// Check element for hidden
	elemIsHidden = function(elem) {
		while (elem) {
			if (!elem) break;
			
			const compStyle = getComputedStyle(elem);
			
			if (compStyle.display == 'none' || compStyle.visibility == 'hidden' || compStyle.opacity == '0') return true;
			
			elem = elem.parentElement;
		}
		
		return false;
	}
	
	// Ajax
	ajax = function(options) {
		const xhr = new XMLHttpRequest();
		
		xhr.open('POST', options.url);
		
		if (typeof options.send == 'string') {
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		}
		
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				options.success(xhr.response);
			} else if (xhr.readyState == 4 && xhr.status != 200) {
				options.error(xhr.response);
			}
		}
		
		xhr.send(options.send);
	}
	
	/*
	Animation
	animate(function(takes 0...1) {}, Int duration in ms[, Str easing[, Fun animation complete]]);
	*/
	animate = function(draw, duration, ease, complete) {
		const start = performance.now();
		
		requestAnimationFrame(function anim(time) {
			let timeFraction = (time - start) / duration;
			
			if (timeFraction > 1) {
				timeFraction = 1;
			}
			
			draw((ease) ? easing(timeFraction, ease) : timeFraction);
			
			if (timeFraction < 1) {
				requestAnimationFrame(anim);
			} else {
				if (complete !== undefined) {
					complete();
				}
			}
		});
	}
	
	function easing(timeFraction, ease) {
		switch (ease) {
			case 'easeInQuad':
			return quad(timeFraction);
			
			case 'easeOutQuad':
			return 1 - quad(1 - timeFraction);
			
			case 'easeInOutQuad':
			if (timeFraction <= 0.5) {
				return quad(2 * timeFraction) / 2;
			} else {
				return (2 - quad(2 * (1 - timeFraction))) / 2;
			}
		}
	}
	
	function quad(timeFraction) {
		return Math.pow(timeFraction, 2)
	}
})();
; var MobNav;

(function() {
	'use strict';

	// fix header
	const headerElem = document.getElementById('header');

	function fixHeader() {
		if (window.pageYOffset > 21) {
			headerElem.classList.add('header_fixed');
		} else if (!document.body.classList.contains('popup-is-opened') && !document.body.classList.contains('mob-nav-is-opened')) {
			headerElem.classList.remove('header_fixed');
		}
	}

	fixHeader();

	window.addEventListener('scroll', fixHeader);

	//mob menu
	MobNav = {
		options: null,
		winScrollTop: 0,

		fixBody: function(st) {
			if (st) {
				this.winScrollTop = window.pageYOffset;

				document.body.classList.add('mob-nav-is-opened');
				document.body.style.top = -this.winScrollTop +'px';
			} else {
				document.body.classList.remove('mob-nav-is-opened');

				if (this.winScrollTop > 0) {
					window.scrollTo(0, this.winScrollTop);
				}
			}
		},

		open: function(btnElem) {
			var headerElem = document.getElementById(this.options.headerId);

			if (!headerElem) return;

			if (btnElem.classList.contains('opened')) {
				this.close();
			} else {
				btnElem.classList.add('opened');
				headerElem.classList.add('opened');
				this.fixBody(true);
			}
		},

		close: function() {
			var headerElem = document.getElementById(this.options.headerId);

			if (!headerElem) return;

			headerElem.classList.remove('opened');

			var openBtnElements = document.querySelectorAll(this.options.openBtn);

			for (var i = 0; i < openBtnElements.length; i++) {
				openBtnElements[i].classList.remove('opened');
			}

			this.fixBody(false);
		},

		init: function(options) {
			this.options = options;

			document.addEventListener('click', (e) => {
				var openElem = e.target.closest(options.openBtn),
				closeElem = e.target.closest(options.closeBtn),
				menuLinkElement = e.target.closest(options.menuLinkSelector);

				if (openElem) {
					e.preventDefault();
					this.open(openElem);
				} else if (closeElem) {
					e.preventDefault();
					this.close();
				} else if (menuLinkElement) {
					this.close();
				}
			});
		}
	};
})();
/*
* call Menu.init(Str menu item selector, Str sub menu selector);
*/
var Menu;

(function() {
	'use strict';

	Menu = {
		toggle: function(elem, elementStr, subMenuStr) {
			var subMenuElem = elem.querySelector(subMenuStr);

			if (!subMenuElem) {
				return;
			}

			if (elem.classList.contains('active')) {
				subMenuElem.style.height = 0;

				elem.classList.remove('active');
			} else {
				var mainElem = elem.closest('.menu'),
				itemElements = mainElem.querySelectorAll(elementStr),
				subMenuElements = mainElem.querySelectorAll(subMenuStr);

				for (var i = 0; i < itemElements.length; i++) {
					itemElements[i].classList.remove('accord__button_active');
					subMenuElements[i].style.height = 0;
				}

				subMenuElem.style.height = subMenuElem.scrollHeight +'px';

				elem.classList.add('active');
			}
		},

		init: function(elementStr, subMenuStr) {
			document.addEventListener('click', (e) => {
				var elem = e.target.closest(elementStr);

				if (!elem) {
					return;
				}

				this.toggle(elem, elementStr, subMenuStr);
			});
		}
	};
})();
/*
Toggle.init(Str toggleSelector[, onDocClickToggleOffSelecor[, Str toggledClass (default - 'toggled')]]);

Toggle.onChange = function(toggleElem, state) {
	// code...
}
*/

; var Toggle;

(function() {
	'use strict';
	
	Toggle = {
		toggledClass: 'toggled',
		onChange: null,
		
		target: function(toggleElem, state) {
			var targetElements = document.querySelectorAll(toggleElem.getAttribute('data-target-elements'));
			
			if (!targetElements.length) return;
			
			if (state) {
				for (var i = 0; i < targetElements.length; i++) {
					targetElements[i].classList.add(this.toggledClass);
				}
				
				//dependence elements
				if (toggleElem.hasAttribute('data-dependence-target-elements')) {
					var dependenceTargetElements = document.querySelectorAll(toggleElem.getAttribute('data-dependence-target-elements'));
					
					for (var i = 0; i < dependenceTargetElements.length; i++) {
						dependenceTargetElements[i].classList.remove(this.toggledClass);
					}
				}
			} else {
				for (var i = 0; i < targetElements.length; i++) {
					targetElements[i].classList.remove(this.toggledClass);
				}
			}
		},
		
		toggle: function(toggleElem, off) {
			var state;
			
			if (toggleElem.classList.contains(this.toggledClass)) {
				toggleElem.classList.remove(this.toggledClass);
				
				state = false;
				
				if (toggleElem.hasAttribute('data-first-text')) {
					toggleElem.innerHTML = toggleElem.getAttribute('data-first-text');
				}
			} else if (!off) {
				toggleElem.classList.add(this.toggledClass);
				
				state = true;
				
				if (toggleElem.hasAttribute('data-second-text')) {
					toggleElem.setAttribute('data-first-text', toggleElem.innerHTML);
					
					toggleElem.innerHTML = toggleElem.getAttribute('data-second-text');
				}
			}
			
			//target
			if (toggleElem.hasAttribute('data-target-elements')) {
				this.target(toggleElem, state);
			}
			
			//call onChange
			if (this.onChange) {
				this.onChange(toggleElem, state);
			}
		},
		
		onDocClickOff: function (e, onDocClickOffSelector) {
			var toggleElements = document.querySelectorAll(onDocClickOffSelector + '.' +this.toggledClass);
			
			for (var i = 0; i < toggleElements.length; i++) {
				var elem = toggleElements[i];
				
				if (elem.hasAttribute('data-target-elements')) {
					var targetSelectors = elem.getAttribute('data-target-elements');
					
					if (!e.target.closest(targetSelectors)) {
						this.toggle(elem, true);
					}
				}
			}
		},
		
		init: function(toggleSelector, onDocClickOffSelector, toggledClass) {
			if (toggledClass) {
				this.toggledClass = toggledClass;
			}
			
			document.addEventListener('click', (e) => {
				var toggleElem = e.target.closest(toggleSelector);
				
				if (toggleElem) {
					e.preventDefault();
					
					this.toggle(toggleElem);
				} else {
					this.onDocClickOff(e, onDocClickOffSelector);
				}
			});
		}
	};
})();
/* 
new LazyLoad({
   selector: @Str,
   event: false
});
*/

; var LazyLoad;

(function() {
   'use strict';
   
   LazyLoad = function(opt) {
      opt = opt || {};
      
      const elements = document.querySelectorAll(opt.selector);
      
      if (!elements.length) return;
      
      function doLoad() {
         for (let i = 0; i < elements.length; i++) {
            const elem = elements[i],
            src = elem.getAttribute('data-src') || null;
            
            if (src) {
               elem.src = src;
            }
         }
      }
      
      // do load
      if (opt.event && opt.event == 'scroll') {} else {
         setTimeout(doLoad, 1000);
      }
   }
})();
var Popup, MediaPopup;

(function() {
	'use strict';

	//popup core
	Popup = {
		winScrollTop: 0,
		onClose: null,
		headerSelector: '.header',

		fixBody: function(st) {
			var headerElem = document.querySelector(this.headerSelector);

			if (st && !document.body.classList.contains('popup-is-opened')) {
				this.winScrollTop = window.pageYOffset;

				var offset = window.innerWidth - document.documentElement.clientWidth;

				document.body.classList.add('popup-is-opened');

				if (headerElem) {
					headerElem.style.right = offset +'px';
				}

				document.body.style.right = offset +'px';

				document.body.style.top = (-this.winScrollTop) +'px';
			} else if (!st) {
				if (headerElem) {
					headerElem.style.right = '';
				}
				
				document.body.classList.remove('popup-is-opened');

				window.scrollTo(0, this.winScrollTop);
			}
		},

		open: function(elementStr, callback) {
			var elem = document.querySelector(elementStr);

			if (!elem || !elem.classList.contains('popup__window')) {
				return;
			}

			this.close();

			var elemParent = elem.parentElement;
			
			elemParent.classList.add('popup_visible');

			elem.classList.add('popup__window_visible');

			if (callback) {
				this.onClose = callback;
			}

			this.fixBody(true);

			return elem;
		},

		message: function(elementStr, msg, callback) {
			var elem = this.open(elementStr, callback);

			elem.querySelector('.popup__inner').innerHTML = '<div class="popup__message">'+ msg +'</div>';
		},

		close: function() {
			var elements = document.querySelectorAll('.popup__window');

			if (!elements.length) {
				return;
			}

			for (var i = 0; i < elements.length; i++) {
				var elem = elements[i];

				if (!elem.classList.contains('popup__window_visible')) {
					continue;
				}

				elem.classList.remove('popup__window_visible');
				elem.parentElement.classList.remove('popup_visible');
			}

			if (this.onClose) {
				this.onClose();
				this.onClose = null;
			}
		},

		init: function(elementStr) {
			document.addEventListener('click', (e) => {
				var element = e.target.closest(elementStr),
				closeElem = e.target.closest('.js-popup-close');

				if (element) {
					e.preventDefault();

					this.open(element.getAttribute('data-popup'));
				} else if (closeElem || (!e.target.closest('.popup__window') && e.target.closest('.popup'))) {
					this.fixBody(false);

					this.close();
				}
			});

			if (window.location.hash) {
				this.open(window.location.hash);
			}
		}
	};

	//popup media
	MediaPopup = {
		image: function(args) {
			var elemPopup = Popup.open(args.popupStr),
			elemImg = elemPopup.querySelector('.popup-media__image');

			Popup.onClose = function() {
				elemImg.src = '#';
				elemImg.classList.remove('popup-media__image_visible'); 
			}

			elemImg.src = args.href;
			elemImg.classList.add('popup-media__image_visible');
			
		},

		video: function(args) {

		},

		next: function(elem) {
			if (!elem.hasAttribute('data-group')) {
				return;
			}

			var group = elem.getAttribute('data-group'),
			index = [].slice.call(document.querySelectorAll('[data-group="'+ group +'"]')).indexOf(elem);
		},

		init: function(elementStr) {
			document.addEventListener('click', (e) => {
				var element = e.target.closest(elementStr);

				if (!element) {
					return;
				}

				e.preventDefault();

				var type = element.getAttribute('data-type'),
				args = {
					href: element.href,
					caption: element.getAttribute('data-caption'),
					group: element.getAttribute('data-group'),
					popupStr: element.getAttribute('data-popup')
				};

				if (type == 'image') {
					this.image(args);
				} else if (type == 'video') {
					this.video(args);
				}

				this.next(element);
			});
		}
	};

})();



/*var pPopup = {
	closeCallback: function() {},
	play: null,
	ind: 0,
	group: null,
	position: 0,

	show: function(id, fun) {
		var _ = this,
		$popWin = $(id),
		$popup = $popWin.closest('.popup');
		
		if ($popWin.length && $popWin.hasClass('popup__window')) {

			_.position = $(window).scrollTop();
			$popup.fadeIn(321).scrollTop(0);
			$('.popup__window').removeClass('popup__window_visible');
			$popWin.addClass('popup__window_visible');
			$('body').css('top', -_.position).addClass('is-popup-opened');

			setTimeout(function() {
				CoverImg.reInit('#media-popup');
			}, 721);

		}

		_.closeCallback = fun || function() {};
	},

	hide: function() {
		var _ = this;
		$('.popup__window').removeClass('popup__window_visible');
		$('.popup').fadeOut(321);
		$('.popup__message').remove();
		$('body').removeClass('is-popup-opened').removeAttr('style');
		$('html, body').scrollTop(_.position);
		_.closeCallback();
	},

	message: function(id,msg,fun) {
		var _ = this;
		$(id).find('.popup__inner').prepend('<div class="popup__message">'+ msg +'</div>');
		_.show(id);
		_.closeCallback = fun || function() {};
	},

	resize: function($pop, $img) {
		var popH = $pop.innerHeight();
		if (popH > window.innerHeight) {
			$pop.css('max-width', (window.innerHeight * ($pop.innerWidth() / popH)));
		}
	},

	media: function(_$,args,show) {
		var _ = this,
		id = $(_$).attr('data-popup'),
		Pop = $(id),
		$box = Pop.find('.popup-media__box'),
		Img = Pop.find('.popup-media__image'),
		BtnPlay = Pop.find('.popup-media__play'),
		Iframe = Pop.find('.popup-media__iframe');

		if (args.data) {
			Pop.find('.popup-media__bar').css('display', 'block');
			var data = JSON.parse( args.data );
			for (var i = 0; i < data.length; i++) {
				Pop.find('.popup-media__data-'+ i).html(data[i]);
			}
		}

		if (args.imgSize) {
			var imgSize = JSON.parse(args.imgSize);
			Img.attr('width', imgSize[0]).attr('height', imgSize[1]);
		} else {
			Img.attr('width', '').attr('height', '');
		}

		if (args.img) {
			Img.css({visibility: 'visible', marginLeft: '', marginTop: ''}).removeClass('cover-img_w cover-img_h').attr('src', args.img);
		}
		
		//Pop.css('max-width', '');
		Iframe.css('visibility', 'hidden').attr('src', '');
		BtnPlay.css('visibility', 'hidden');
		
		if (args.vid) {
			$box.removeClass('middle').addClass('cover-img-wrap');
			Img.removeClass('middle__img').addClass('cover-img');
			BtnPlay.css('visibility', 'visible').attr('href', args.vid);

			_.play = function() {
				var utm = args.vid.match(/(?:youtu\.be\/|youtube\.com\/watch\?v\=|youtube\.com\/embed\/)+?([\w-]+)/i),
				ifrSrc = 'https://www.youtube.com/embed/'+ utm[1] +'?autoplay=1';
				BtnPlay.css('visibility', 'hidden');
				Img.css('visibility', 'hidden');
				Iframe.css('visibility', 'visible').attr('src', ifrSrc);
			}

			if (!args.img) {
				_.play();
			} else {
				setTimeout(function() {
					CoverImg.init(id);
					Img.attr('src', args.img);
				}, 721);
			}

			

		} else {
			$box.removeClass('cover-img-wrap').addClass('middle');
			Img.removeClass('cover-img').addClass('middle__img');
		}



		if (args.group) {
			Pop.find('.popup-media__arr').css('display', 'block');
			_.group =  $(_$).attr('data-group');
			_.ind = $('[data-group="'+ _.group +'"]').index(_$);
		}

		if (show) {
			_.show(id);
		}

		if (!args.vid) {
			setTimeout(function() {
				_.resize(Pop, Img);
			}, 721);
		}

		_.closeCallback = function() {
			Img.css('visibility', 'hidden').attr('src', '');
			Iframe.css('visibility', 'hidden').attr('src', '');
			BtnPlay.css('visibility', 'hidden');
		}

	},

	next: function(dir) {
		var _ = this,
		$next,
		ind = _.ind;

		if (dir == 'next') {
			ind++;
			if ($('[data-group="'+ _.group +'"]').eq(ind).length) {
				$next = $('[data-group="'+ _.group +'"]').eq(ind);
			}
		} else if (dir == 'prev' && ind > 0) {
			ind--;
			if ($('[data-group="'+ _.group +'"]').eq(ind).length) {
				$next = $('[data-group="'+ _.group +'"]').eq(ind);
			}
		}

		if ($next) {
			var args;

			if ($next.hasClass('js-open-popup-image')) {
				args = {
					img: $next.attr('href'),
					imgSize: $next.attr('data-image-size'),
					group: $next.attr('data-group'),
					data: $next.attr('data-data')
				};
			} else if ($next.hasClass('js-open-popup-video')) {
				args = {
					vid: $next.attr('href'),
					img: $next.attr('data-preview'),
					imgSize: $next.attr('data-preview-size'),
					group: $next.attr('data-group'),
					data: $next.attr('data-data')
				};
			}

			_.media($next, args);
			
		}

	}

};*/


/*$(document).ready(function() {
	$('body').on('click', '.js-open-popup', function () {
		Popup.show($(this).attr('data-popup'));
		return false;
	});

	$('body').on('click', '.js-open-popup-image', function () {
		var args = {
			img: $(this).attr('href'),
			imgSize: $(this).attr('data-image-size'),
			group: $(this).attr('data-group'),
			data: $(this).attr('data-data')
		};
		Popup.media(this, args, true);
		return false;
	});

	$('body').on('click', '.js-open-popup-video', function () {
		var args = {
			vid: $(this).attr('href'),
			img: $(this).attr('data-preview'),
			imgSize: $(this).attr('data-preview-size'),
			group: $(this).attr('data-group'),
			data: $(this).attr('data-data')
		};
		Popup.media(this, args, true);
		return false;
	});

	$('body').on('click', '.popup-media__play', function () {
		Popup.play();
		return false;
	});

	$('body').on('click', '.popup-media__arr', function () {
		Popup.next($(this).attr('data-dir'));
		return false;
	});

	$('body').on('click', '.js-open-msg-popup', function () {
		Popup.message('#message-popup', 'Это всплывашка с сообщением.<br> вызов: <span class="c-red">Popup.message("#id", "Текст или html");</span>', function() { alert('После закрытия'); });
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
		var hash = window.location.hash;
		if($(hash).length && $(hash).hasClass('popup__window')){
			Popup.show(hash);
		}
	}

});*/
; var Select;

(function () {
	'use strict';
	
	// custom select
	Select = {
		field: null,
		hideCssClass: 'hidden',
		onSelect: null,
		
		reset: function (parentElem) {
			var parElem = parentElem || document, 
			fieldElements = parElem.querySelectorAll('.custom-select'),
			buttonElements = parElem.querySelectorAll('.custom-select__button'),
			inputElements = parElem.querySelectorAll('.custom-select__input'),
			valueElements = parElem.querySelectorAll('.custom-select__val');
			
			for (var i = 0; i < fieldElements.length; i++) {
				fieldElements[i].classList.remove('custom-select_changed');
			}
			
			for (var i = 0; i < buttonElements.length; i++) {
				buttonElements[i].innerHTML = buttonElements[i].getAttribute('data-placeholder');
			}
			
			for (var i = 0; i < inputElements.length; i++) {
				inputElements[i].value = '';
				inputElements[i].blur();
			}
			
			for (var i = 0; i < valueElements.length; i++) {
				valueElements[i].classList.remove('custom-select__val_checked');
			}
		},
		
		close: function () {
			var fieldElements = document.querySelectorAll('.custom-select'),
			optionsElements = document.querySelectorAll('.custom-select__options');
			
			for (var i = 0; i < fieldElements.length; i++) {
				fieldElements[i].classList.remove('custom-select_opened');
				optionsElements[i].classList.remove('ovfauto');
				optionsElements[i].style.height = 0;
			}
			
			var listItemElements = document.querySelectorAll('.custom-select__options li');
			
			for (var i = 0; i < listItemElements.length; i++) {
				listItemElements[i].classList.remove('hover');
			}
		},
		
		open: function () {
			this.field.classList.add('custom-select_opened');
			
			var opionsElem = this.field.querySelector('.custom-select__options');
			
			opionsElem.style.height = (opionsElem.scrollHeight + 2) +'px';
			
			opionsElem.scrollTop = 0;
			
			setTimeout(function () {
				opionsElem.classList.add('ovfauto');
			}, 550);
		},
		
		selectMultipleVal: function (elem, button, input) {
			var toButtonValue = [],
			toInputValue = [],
			inputsBlock = this.field.querySelector('.custom-select__multiple-inputs');
			
			elem.classList.toggle('custom-select__val_checked');
			
			var checkedElements = this.field.querySelectorAll('.custom-select__val_checked');
			
			for (var i = 0; i < checkedElements.length; i++) {
				var elem = checkedElements[i];
				
				toButtonValue[i] = elem.innerHTML;
				toInputValue[i] = (elem.hasAttribute('data-value')) ? elem.getAttribute('data-value') : elem.innerHTML;
			}
			
			if (toButtonValue.length) {
				button.innerHTML = toButtonValue.join(', ');
				
				input.value = toInputValue[0];
				
				inputsBlock.innerHTML = '';
				
				if (toInputValue.length > 1) {
					for (var i = 1; i < toInputValue.length; i++) {
						var yetInput = document.createElement('input');
						
						yetInput.type = 'hidden';
						yetInput.name = input.name;
						yetInput.value = toInputValue[i];
						
						inputsBlock.appendChild(yetInput);
					}
				}
			} else {
				button.innerHTML = button.getAttribute('data-placeholder');
				input.value = '';
				this.close();
			}
		},
		
		targetAction: function () {
			var elements = this.field.querySelectorAll('.custom-select__val');
			
			for (var i = 0; i < elements.length; i++) {
				var elem = elements[i];
				
				if (!elem.hasAttribute('data-target-elements')) continue;
				
				var targetElem = document.querySelector(elem.getAttribute('data-target-elements'));
				
				if (elem.classList.contains('custom-select__val_checked')) {
					targetElem.style.display = 'block';
					targetElem.classList.remove(this.hideCssClass);
					
					var textInputElement = targetElem.querySelector('input[type="text"]');
					
					if (textInputElement) {
						textInputElement.focus();
					}
				} else {
					targetElem.style.display = 'none';
					targetElem.classList.add(this.hideCssClass);
				}
			}
		},
		
		selectVal: function (elem) {
			var button = this.field.querySelector('.custom-select__button'),
			input = this.field.querySelector('.custom-select__input');
			
			if (this.field.classList.contains('custom-select_multiple')) {
				
				this.selectMultipleVal(elem, button, input);
				
			} else {
				var toButtonValue = elem.innerHTML,
				toInputValue = (elem.hasAttribute('data-value')) ? elem.getAttribute('data-value') : elem.innerHTML;
				
				var valueElements = this.field.querySelectorAll('.custom-select__val');
				
				for (var i = 0; i < valueElements.length; i++) {
					valueElements[i].classList.remove('custom-select__val_checked');
					valueElements[i].disabled = false;
				}
				
				elem.classList.add('custom-select__val_checked');
				elem.disabled = true;
				
				if (button) {
					button.innerHTML = toButtonValue;
				}
				
				input.value = toInputValue;
				
				this.close();
				
				if (window.Placeholder) {
					Placeholder.hide(input, true);
				}
				
				if (input.getAttribute('data-submit-form-onchange')) {
					Form.submitForm(input.closest('form'));
				}
				
				if (this.onSelect) {
					this.onSelect(input, toInputValue, elem.getAttribute('data-second-value'));
				}
			}
			
			this.targetAction();
			
			if (input.classList.contains('var-height-textarea__textarea')) {
				varHeightTextarea.setHeight(input);
			}
			
			this.field.classList.add('custom-select_changed');
			
			ValidateForm.select(input);
		},
		
		autocomplete: function(elem) {
			var match = false,
			reg = new RegExp(elem.value, 'gi'),
			valueElements = this.field.querySelectorAll('.custom-select__val');
			
			if (elem.value.length) {
				for (var i = 0; i < valueElements.length; i++) {
					var valueElem = valueElements[i];
					
					valueElem.classList.remove('custom-select__val_checked');
					
					if (valueElem.innerHTML.match(reg)) {
						valueElem.parentElement.classList.remove('hidden');
						
						match = true;
					} else {
						valueElem.parentElement.classList.add('hidden');
					}
				}
			}
			
			if (!match) {
				for (var i = 0; i < valueElements.length; i++) {
					valueElements[i].parentElement.classList.remove('hidden');
				}
			}
		},
		
		setOptions: function (fieldSelector, optObj, nameKey, valKey, secValKey) {
			var fieldElements = document.querySelectorAll(fieldSelector);
			
			for (var i = 0; i < fieldElements.length; i++) {
				var optionsElem = fieldElements[i].querySelector('.custom-select__options');
				
				optionsElem.innerHTML = '';
				
				for (var i = 0; i < optObj.length; i++) {
					var li = document.createElement('li'),
					secValAttr = (secValKey != undefined) ? ' data-second-value="'+ optObj[i][secValKey] +'"' : '';
					
					li.innerHTML = '<button type="button" class="custom-select__val" data-value="'+ optObj[i][valKey] +'"'+ secValAttr +'>'+ optObj[i][nameKey] +'</button>';
					
					optionsElem.appendChild(li);
				}
			}
		},
		
		keyboard: function (key) {
			var options = this.field.querySelector('.custom-select__options'),
			hoverItem = options.querySelector('li.hover');
			
			switch (key) {
				case 40:
				if (hoverItem) {
					var nextItem = function (item) {
						var elem = item.nextElementSibling;
						
						while (elem) {
							if (!elem) break;
							
							if (!elemIsHidden(elem)) {
								return elem;
							} else {
								elem = elem.nextElementSibling;
							}
						}
					}(hoverItem);
					
					if (nextItem) {
						hoverItem.classList.remove('hover');
						nextItem.classList.add('hover');
						
						options.scrollTop = options.scrollTop + (nextItem.getBoundingClientRect().top - options.getBoundingClientRect().top);
					}
				} else {
					var elem = options.firstElementChild;
					
					while (elem) {
						if (!elem) break;
						
						if (!elemIsHidden(elem)) {
							elem.classList.add('hover');
							break;
						} else {
							elem = elem.nextElementSibling;
						}
					}
				}
				break;
				
				case 38:
				if (hoverItem) {
					var nextItem = function (item) {
						var elem = item.previousElementSibling;
						
						while (elem) {
							if (!elem) break;
							
							if (!elemIsHidden(elem)) {
								return elem;
							} else {
								elem = elem.previousElementSibling;
							}
						}
					}(hoverItem);
					
					if (nextItem) {
						hoverItem.classList.remove('hover');
						nextItem.classList.add('hover');
						
						options.scrollTop = options.scrollTop + (nextItem.getBoundingClientRect().top - options.getBoundingClientRect().top);
					}
				} else {
					var elem = options.lastElementChild;
					
					while (elem) {
						if (!elem) break;
						
						if (!elemIsHidden(elem)) {
							elem.classList.add('hover');
							options.scrollTop = 9999;
							break;
						} else {
							elem = elem.previousElementSibling;
						}
					}
				}
				break;
				
				case 13:
				this.selectVal(hoverItem.querySelector('.custom-select__val'));
			}
		},
		
		build: function (elementStr) {
			var elements = document.querySelectorAll(elementStr);
			
			if (!elements.length) return;
			
			for (let i = 0; i < elements.length; i++) {
				var elem = elements[i],
				options = elem.querySelectorAll('option'),
				parent = elem.parentElement,
				optionsList = '',
				selectedOption = null;
				
				// option list
				for (let i = 0; i < options.length; i++) {
					var opt = options[i];
					
					if (opt.hasAttribute('selected')) {
						selectedOption = opt;
					}
					((opt.hasAttribute('data-second-value')) ? ' data-second-value="'+ opt.getAttribute('data-second-value') +'"' : '')
					
					optionsList += '<li><button type="button" class="custom-select__val'+ ((opt.hasAttribute('selected')) ? ' custom-select__val_checked' : '') +'"'+ ( (opt.hasAttribute('value')) ? ' data-value="'+ opt.value +'"' : '') + ((opt.hasAttribute('data-second-value')) ? ' data-second-value="'+ opt.getAttribute('data-second-value') +'"' : '') + ( (opt.hasAttribute('data-target-elements')) ? ' data-target-elements="'+ opt.getAttribute('data-target-elements') +'"' : '') + ((opt.hasAttribute('selected')) ? ' disabled' : '') +'>'+ opt.innerHTML +'</button></li>';
				}
				
				var require = (elem.hasAttribute('data-required')) ? ' data-required="'+ elem.getAttribute('data-required') +'" ' : '',
				placeholder = elem.getAttribute('data-placeholder'),
				submitOnChange = (elem.hasAttribute('data-submit-form-onchange')) ? ' data-submit-form-onchange="'+ elem.getAttribute('data-submit-form-onchange') +'" ' : '',
				head;
				
				if (elem.getAttribute('data-type') == 'autocomplete') {
					head = '<button type="button" class="custom-select__arr"></button><input type="text" name="'+ elem.name +'"'+ require + ((placeholder) ? ' placeholder="'+ placeholder +'" ' : '') +'class="custom-select__input custom-select__autocomplete form__text-input" value="'+ ((selectedOption) ? selectedOption.innerHTML : '') +'">';
				} else {
					head = '<button type="button"'+ ((placeholder) ? ' data-placeholder="'+ placeholder +'"' : '') +' class="custom-select__button">'+ ((selectedOption) ? selectedOption.innerHTML : (placeholder) ? placeholder : '') +'</button>';
				}
				
				var multiple = {
					class: (elem.multiple) ? ' custom-select_multiple' : '',
					inpDiv: (elem.multiple) ? '<div class="custom-select__multiple-inputs"></div>' : ''
				},
				hiddenInp = (elem.getAttribute('data-type') != 'autocomplete') ? '<input type="hidden" name="'+ elem.name +'"'+ require + submitOnChange +'class="custom-select__input" value="'+ ((selectedOption) ? selectedOption.value : '') +'">' : '';
				
				// output select
				var customElem = document.createElement('div');
				customElem.className = 'custom-select'+ multiple.class + ((selectedOption) ? ' custom-select_changed' : '');
				customElem.innerHTML = head +'<ul class="custom-select__options">'+ optionsList +'</ul>'+ hiddenInp + multiple.inpDiv;
				parent.insertBefore(customElem, parent.firstChild);
				parent.removeChild(parent.children[1]);
			}
		},
		
		init: function (elementStr) {
			this.build(elementStr);
			
			// click on select or value or arrow button
			document.addEventListener('click', (e) => {
				var btnElem = e.target.closest('.custom-select__button'),
				valElem = e.target.closest('.custom-select__val'),
				arrElem = e.target.closest('.custom-select__arr');
				
				if (btnElem) {
					this.field = btnElem.closest('.custom-select');
					
					if (this.field.classList.contains('custom-select_opened')) {
						this.close();
					} else {
						this.close();
						
						this.open();
					}
				} else if (valElem) {
					this.field = valElem.closest('.custom-select');
					
					this.selectVal(valElem);
				} else if (arrElem) {
					if (!arrElem.closest('.custom-select_opened')) {
						arrElem.closest('.custom-select').querySelector('.custom-select__autocomplete').focus();
					} else {
						this.close();
					}
				}
			});
			
			//focus autocomplete
			document.addEventListener('focus', (e) => {
				var elem = e.target.closest('.custom-select__autocomplete');
				
				if (!elem) return;
				
				this.field = elem.closest('.custom-select');
				
				this.close();
				
				this.open();
			}, true);
			
			//input autocomplete
			document.addEventListener('input', (e) => {
				var elem = e.target.closest('.custom-select__autocomplete');
				
				if (!elem) return;
				
				this.field = elem.closest('.custom-select');
				
				this.autocomplete(elem);
				
				if (!this.field.classList.contains('custom-select_opened')) {
					this.open();
				}
			});
			
			// keyboard events
			document.addEventListener('keydown', (e) => {
				var elem = e.target.closest('.custom-select_opened');
				
				if (!elem) return;
				
				this.field = elem.closest('.custom-select');
				
				var key = e.which || e.keyCode || 0;
				
				if (key == 40 || key == 38 || key == 13) {
					e.preventDefault();
					
					this.keyboard(key);
				}
			});
			
			// close all
			document.addEventListener('click', (e) => {
				if (!e.target.closest('.custom-select_opened')) {
					this.close();
				}
			});
		}
	};
	
	// init scripts
	document.addEventListener('DOMContentLoaded', function () {
		Select.init('select');
	});
})();
; var AutoComplete;

(function () {
	'use strict';
	
	AutoComplete = {
		fieldElem: null,
		inputElem: null,
		optionsElem: null,
		valuesData: null,
		setValuesData: null,
		
		open: function () {
			this.fieldElem.classList.add('autocomplete_opened');
			
			var optionsElem = this.optionsElem;
			
			optionsElem.style.height = optionsElem.scrollHeight +'px';
			
			optionsElem.scrollTop = 0;
			
			setTimeout(function () {
				if (optionsElem.scrollHeight > optionsElem.offsetHeight) {
					optionsElem.classList.add('ovfauto');
				}
			}, 550);
		},
		
		close: function () {
			this.fieldElem.classList.remove('autocomplete_opened');
			
			var optionsElem = this.optionsElem;
			
			optionsElem.classList.remove('ovfauto');
			
			optionsElem.style.height = 0;
		},
		
		getValues: function () {
			var optionsElem = this.optionsElem;
			
			if (this.inputElem.value.length) {
				var preReg = new RegExp(this.inputElem.value, 'i'),
				values = '';
				
				if (this.setValuesData) {
					this.setValuesData(this.inputElem.value, (valuesData) => {
						for (var i = 0; i < valuesData.length; i++) {
							var dataVal = valuesData[i];
							
							if (dataVal.value.match(preReg)) {
								values += '<li><button type="button" class="autocomplete__val">'+ dataVal.value +'</button></li>';
							}
						}
						
						if (values == '') {
							values = '<li>Nothing found!</li>';
						}
						
						optionsElem.innerHTML = values;
						
						this.open();
					});
				}
			} else {
				optionsElem.innerHTML = '';
				
				this.close();
			}
		},
		
		selectVal: function (itemElem) {
			var valueElem = itemElem.querySelector('.autocomplete__val');
			
			if (valueElem) {
				this.inputElem.value = valueElem.innerHTML;
			}
		},
		
		keybinding: function (e) {
			var key = e.which || e.keyCode || 0;
			
			if (key != 40 && key != 38 && key != 13) return;
			
			e.preventDefault();
			
			var optionsElem = this.optionsElem,
			hoverItem = optionsElem.querySelector('li.hover');
			
			switch (key) {
				case 40:
				if (hoverItem) {
					var nextItem = hoverItem.nextElementSibling;
					
					if (nextItem) {
						hoverItem.classList.remove('hover');
						nextItem.classList.add('hover');
						
						optionsElem.scrollTop = optionsElem.scrollTop + (nextItem.getBoundingClientRect().top - optionsElem.getBoundingClientRect().top);
						
						this.selectVal(nextItem);
					}
				} else {
					var nextItem = optionsElem.firstElementChild;
					
					if (nextItem) {
						nextItem.classList.add('hover');
						
						this.selectVal(nextItem);
					}
				}
				break;
				
				case 38:
				if (hoverItem) {
					var nextItem = hoverItem.previousElementSibling;
					
					if (nextItem) {
						hoverItem.classList.remove('hover');
						nextItem.classList.add('hover');
						
						optionsElem.scrollTop = optionsElem.scrollTop + (nextItem.getBoundingClientRect().top - optionsElem.getBoundingClientRect().top);
						
						this.selectVal(nextItem);
					}
				} else {
					var nextItem = optionsElem.lastElementChild;
					
					if (nextItem) {
						nextItem.classList.add('hover');
						
						optionsElem.scrollTop = 9999;
						
						this.selectVal(nextItem);
					}
				}
				break;
				
				case 13:
				if (hoverItem) {
					this.selectVal(hoverItem);
					
					this.inputElem.blur();
				}
			}
		},
		
		init: function () {
			// focus event
			document.addEventListener('focus', (e) => {
				var elem = e.target.closest('.autocomplete__input');
				
				if (!elem) return;
				
				this.fieldElem = elem.closest('.autocomplete');
				this.inputElem = elem;
				this.optionsElem = this.fieldElem.querySelector('.autocomplete__options');
				
				this.getValues();
			}, true);
			
			// blur event
			document.addEventListener('blur', (e) => {
				if (e.target.closest('.autocomplete__input')) {
					setTimeout(() => {
						this.close();
					}, 21);
				}
			}, true);
			
			// input event
			document.addEventListener('input', (e) => {
				if (e.target.closest('.autocomplete__input')) {
					this.getValues();
				}
			});
			
			// click event
			document.addEventListener('click', (e) => {
				var elem = e.target.closest('.autocomplete__val');
				
				if (elem) {
					this.selectVal(elem.parentElement);
				}
			});
			
			// keyboard events
			document.addEventListener('keydown', (e) => {
				if (e.target.closest('.autocomplete_opened')) {
					this.keybinding(e);
				}
			});
		}
	};
	
	// init scripts
	document.addEventListener('DOMContentLoaded', function () {
		AutoComplete.init();
	});
})();
var ValidateForm, Form;

(function () {
	'use strict';
	
	// validate form
	ValidateForm = {
		input: null,
		
		errorTip: function (err, errInd, errorTxt) {
			const field = this.input.closest('.form__field') || this.input.parentElement,
			errTip = field.querySelector('.field-error-tip');
			
			if (err) {
				field.classList.remove('field-success');
				field.classList.add('field-error');
				
				if (!errTip) return;
				
				if (errInd) {
					if (!errTip.hasAttribute('data-error-text')) {
						errTip.setAttribute('data-error-text', errTip.innerHTML);
					}
					errTip.innerHTML = (errInd != 'custom') ? errTip.getAttribute('data-error-text-'+ errInd) : errorTxt;
				} else if (errTip.hasAttribute('data-error-text')) {
					errTip.innerHTML = errTip.getAttribute('data-error-text');
				}
			} else {
				field.classList.remove('field-error');
				field.classList.add('field-success');
			}
		},
		
		customErrorTip: function (input, errorTxt) {
			if (!input) return;
			
			this.input = input;
			
			this.errorTip(true, 'custom', errorTxt);
		},
		
		txt: function () {
			var err = false;
			
			if (!/^[0-9a-zа-яё_,.:;@-\s]*$/i.test(this.input.value)) {
				this.errorTip(true, 2);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		num: function () {
			var err = false;
			
			if (!/^[0-9.,-]*$/.test(this.input.value)) {
				this.errorTip(true, 2);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		name: function () {
			var err = false;
			
			if (!/^[a-zа-яё'-]{3,21}(\s[a-zа-яё'-]{3,21})?(\s[a-zа-яё'-]{3,21})?$/i.test(this.input.value)) {
				this.errorTip(true, 2);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		date: function () {
			var err = false, 
			errDate = false, 
			matches = this.input.value.match(/^(\d{2}).(\d{2}).(\d{4})$/);
			
			if (!matches) {
				errDate = 1;
			} else {
				var compDate = new Date(matches[3], (matches[2] - 1), matches[1]),
				curDate = new Date();
				
				if (this.input.hasAttribute('data-min-years-passed')) {
					var interval = curDate.valueOf() - new Date(curDate.getFullYear() - (+this.input.getAttribute('data-min-years-passed')), curDate.getMonth(), curDate.getDate()).valueOf();
					
					if (curDate.valueOf() < compDate.valueOf() || (curDate.getFullYear() - matches[3]) > 100) {
						errDate = 1;
					} else if ((curDate.valueOf() - compDate.valueOf()) < interval) {
						errDate = 2;
					}
				}
				
				if (compDate.getFullYear() != matches[3] || compDate.getMonth() != (matches[2] - 1) || compDate.getDate() != matches[1]) {
					errDate = 1;
				}
			}
			
			if (errDate == 1) {
				this.errorTip(true, 2);
				err = true;
			} else if (errDate == 2) {
				this.errorTip(true, 3);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		email: function () {
			var err = false;
			
			if (!/^[a-z0-9]+[\w\-\.]*@[\w\-]{2,}\.[a-z]{2,6}$/i.test(this.input.value)) {
				this.errorTip(true, 2);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		url: function () {
			var err = false;
			
			if (!/^(https?\:\/\/)?[a-zа-я0-9\-\.]+\.[a-zа-я]{2,11}$/i.test(this.input.value)) {
				this.errorTip(true, 2);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		tel: function () {
			var err = false;
			
			if (!/^\+7\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}$/.test(this.input.value)) {
				this.errorTip(true, 2);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		pass: function () {
			var err = false,
			minLng = this.input.getAttribute('data-min-length');
			
			if (minLng && this.input.value.length < minLng) {
				this.errorTip(true, 2);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		checkbox: function (elem) {
			this.input = elem;
			
			var group = elem.closest('.form__chbox-group');
			
			if (group && group.getAttribute('data-tested')) {
				var checkedElements = 0,
				elements = group.querySelectorAll('input[type="checkbox"]');
				
				for (var i = 0; i < elements.length; i++) {
					if (elements[i].checked) {
						checkedElements++;
					}
				}
				
				if (checkedElements < group.getAttribute('data-min')) {
					group.classList.add('form__chbox-group_error');
				} else {
					group.classList.remove('form__chbox-group_error');
				}
				
			} else if (elem.getAttribute('data-tested')) {
				if (elem.getAttribute('data-required') && !elem.checked) {
					this.errorTip(true);
				} else {
					this.errorTip(false);
				}
			}
		},
		
		radio: function (elem) {
			this.input = elem;
			
			var checkedElement = false,
			group = elem.closest('.form__radio-group'),
			elements = group.querySelectorAll('input[type="radio"]');
			
			for (var i = 0; i < elements.length; i++) {
				if (elements[i].checked) {
					checkedElement = true;
				}
			}
			
			if (!checkedElement) {
				group.classList.add('form__radio-group_error');
			} else {
				group.classList.remove('form__radio-group_error');
			}
		},
		
		select: function (elem) {
			var err = false;
			
			this.input = elem;
			
			if (elem.getAttribute('data-required') && !elem.value.length) {
				this.errorTip(true);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		file: function (elem, filesArr) {
			this.input = elem;
			
			var err = false,
			errCount = {ext: 0, size: 0},
			maxFiles = +this.input.getAttribute('data-max-files'),
			extRegExp = new RegExp('(?:\\.'+ this.input.getAttribute('data-ext').replace(/,/g, '|\\.') +')$', 'i'),
			maxSize = +this.input.getAttribute('data-max-size'),
			fileItemElements = this.input.closest('.custom-file').querySelectorAll('.custom-file__item');;
			
			for (var i = 0; i < filesArr.length; i++) {
				var file = filesArr[i];
				
				if (!file.name.match(extRegExp)) {
					errCount.ext++;
					
					if (fileItemElements[i]) {
						fileItemElements[i].classList.add('file-error');
					}
					
					continue;
				}
				
				if (file.size > maxSize) {
					errCount.size++;
					
					if (fileItemElements[i]) {
						fileItemElements[i].classList.add('file-error');
					}
				}
			}
			
			if (maxFiles && filesArr.length > maxFiles) {
				this.errorTip(true, 4);
				err = true;
			} else if (errCount.ext) {
				this.errorTip(true, 2);
				err = true;
			} else if (errCount.size) {
				this.errorTip(true, 3);
				err = true;
			} else {
				this.errorTip(false);
			}
			
			return err;
		},
		
		validateOnInput: function (elem) {
			this.input = elem;
			
			var dataType = elem.getAttribute('data-type');
			
			if (elem.getAttribute('data-required') && !elem.value.length) {
				this.errorTip(true);
			} else if (elem.value.length) {
				if (dataType) {
					this[dataType]();
				} else {
					this.errorTip(false);
				}
			} else {
				this.errorTip(false);
			}
		},
		
		validate: function (formElem) {
			var err = 0;
			
			// text, password, textarea
			var elements = formElem.querySelectorAll('input[type="text"], input[type="password"], textarea');
			
			for (var i = 0; i < elements.length; i++) {
				var elem = elements[i];
				
				if (elemIsHidden(elem)) {
					continue;
				}
				
				this.input = elem;
				
				elem.setAttribute('data-tested', 'true');
				
				var dataType = elem.getAttribute('data-type');
				
				if (elem.getAttribute('data-required') && !elem.value.length) {
					this.errorTip(true);
					err++;
				} else if (elem.value.length) {
					if (dataType) {
						if (this[dataType]()) {
							err++;
						}
					} else {
						this.errorTip(false);
					}
				} else {
					this.errorTip(false);
				}
			}
			
			// select
			var elements = formElem.querySelectorAll('.custom-select__input');
			
			for (var i = 0; i < elements.length; i++) {
				var elem = elements[i];
				
				if (elemIsHidden(elem.parentElement)) {
					continue;
				}
				
				if (this.select(elem)) {
					err++;
				}
			}
			
			// checkboxes
			var elements = formElem.querySelectorAll('input[type="checkbox"]');
			
			for (var i = 0; i < elements.length; i++) {
				var elem = elements[i];
				
				if (elemIsHidden(elem)) {
					continue;
				}
				
				this.input = elem;
				
				elem.setAttribute('data-tested', 'true');
				
				if (elem.getAttribute('data-required') && !elem.checked) {
					this.errorTip(true);
					err++;
				} else {
					this.errorTip(false);
				}
			}
			
			// checkbox group
			var groups = formElem.querySelectorAll('.form__chbox-group');
			
			for (let i = 0; i < groups.length; i++) {
				var group = groups[i],
				checkedElements = 0;
				
				if (elemIsHidden(group)) {
					continue;
				}
				
				group.setAttribute('data-tested', 'true');
				
				var elements = group.querySelectorAll('input[type="checkbox"]');
				
				for (let i = 0; i < elements.length; i++) {
					if (elements[i].checked) {
						checkedElements++;
					}
				}
				
				if (checkedElements < group.getAttribute('data-min')) {
					group.classList.add('form__chbox-group_error');
					err++;
				} else {
					group.classList.remove('form__chbox-group_error');
				}
			}
			
			// radio group
			var groups = formElem.querySelectorAll('.form__radio-group');
			
			for (let i = 0; i < groups.length; i++) {
				var group = groups[i],
				checkedElement = false;
				
				if (elemIsHidden(group)) {
					continue;
				}
				
				group.setAttribute('data-tested', 'true');
				
				var elements = group.querySelectorAll('input[type="radio"]');
				
				for (let i = 0; i < elements.length; i++) {
					if (elements[i].checked) {
						checkedElement = true;
					}
				}
				
				if (!checkedElement) {
					group.classList.add('form__radio-group_error');
					err++;
				} else {
					group.classList.remove('form__radio-group_error');
				}
			}
			
			// file
			var elements = formElem.querySelectorAll('input[type="file"]');
			
			for (var i = 0; i < elements.length; i++) {
				var elem = elements[i];
				
				if (elemIsHidden(elem)) {
					continue;
				}
				
				this.input = elem;
				
				if (CustomFile.inputFiles(elem).length) {
					if (this.file(elem, CustomFile.inputFiles(elem))) {
						err++;
					}
				} else if (elem.getAttribute('data-required')) {
					this.errorTip(true);
					err++;
				} else {
					this.errorTip(false);
				}
			}
			
			// passwords compare
			var elements = formElem.querySelectorAll('input[data-pass-compare-input]');
			
			for (var i = 0; i < elements.length; i++) {
				var elem = elements[i];
				
				if (elemIsHidden(elem)) {
					continue;
				}
				
				this.input = elem;
				
				var val = elem.value;
				
				if (val.length) {
					var compElemVal = formElem.querySelector(elem.getAttribute('data-pass-compare-input')).value;
					
					if (val !== compElemVal) {
						this.errorTip(true, 2);
						err++;
					} else {
						this.errorTip(false);
					}
				}
			}
			
			if (err) {
				formElem.classList.add('form-error');
			} else {
				formElem.classList.remove('form-error');
			}
			
			return (err) ? false : true;
		},
		
		init: function (formSelector) {
			document.addEventListener('input', (e) => {
				var elem = e.target.closest(formSelector +' input[type="text"],'+ formSelector +' input[type="password"],'+ formSelector +' textarea');
				
				if (elem && elem.hasAttribute('data-tested')) {
					this.validateOnInput(elem);
				}
			});
			
			document.addEventListener('change', (e) => {
				var elem = e.target.closest(formSelector +' input[type="radio"],'+ formSelector +' input[type="checkbox"]');
				
				if (elem) {
					this[elem.type](elem);
				}
			});
		}
	};
	
	// variable height textarea
	var varHeightTextarea = {
		setHeight: function (elem) {
			var mirror = elem.parentElement.querySelector('.var-height-textarea__mirror'),
			mirrorOutput = elem.value.replace(/\n/g, '<br>');
			
			mirror.innerHTML = mirrorOutput +'&nbsp;';
		},
		
		init: function () {
			document.addEventListener('input', (e) => {
				var elem = e.target.closest('.var-height-textarea__textarea');
				
				if (!elem) {
					return;
				}
				
				this.setHeight(elem);
			});
		}
	};
	
	// next fieldset
	var NextFieldset = {
		next: function (btnElem, fwd) {
			var nextFieldset = (btnElem.hasAttribute('data-go-to-fieldset')) ? document.querySelector(btnElem.getAttribute('data-go-to-fieldset')) : null;
			
			if (!nextFieldset) return;
			
			var currentFieldset = btnElem.closest('.fieldset__item'),
			goTo = (fwd) ? ValidateForm.validate(currentFieldset) : true;
			
			if (goTo) {
				currentFieldset.classList.add('fieldset__item_hidden');
				nextFieldset.classList.remove('fieldset__item_hidden');
			}
		},
		
		init: function (nextBtnSelector, prevBtnSelector) {
			document.addEventListener('click', (e) => {
				var nextBtnElem = e.target.closest(nextBtnSelector),
				prevBtnElem = e.target.closest(prevBtnSelector);
				
				if (nextBtnElem) {
					this.next(nextBtnElem, true);
				} else if (prevBtnElem) {
					this.next(prevBtnElem, false);
				}
			});
		}
	};
	
	// form
	Form = {
		onSubmit: null,
		
		submitForm: function (formElem, e) {
			if (!ValidateForm.validate(formElem)) {
				if (e) {
					e.preventDefault();
				}

				return;
			}
			
			formElem.classList.add('form_sending');
			
			if (!this.onSubmit) {
				formElem.submit();
				
				return;
			}
			
			// clear form
			function clear() {
				var elements = formElem.querySelectorAll('input[type="text"], input[type="password"], textarea');
				
				for (var i = 0; i < elements.length; i++) {
					var elem = elements[i];
					
					elem.value = '';
					
					if (window.Placeholder) {
						Placeholder.hide(elem, false);
					}
				}
				
				if (window.Select) {
					Select.reset();
				}
				
				var textareaMirrors = formElem.querySelectorAll('.form__textarea-mirror');
				
				for (var i = 0; i < textareaMirrors.length; i++) {
					textareaMirrors[i].innerHTML = '';
				}
			}
			
			// submit button
			function actSubmitBtn(st) {
				var elements = formElem.querySelectorAll('button[type="submit"], input[type="submit"]');
				
				for (var i = 0; i < elements.length; i++) {
					var elem = elements[i];
					
					if (!elemIsHidden(elem)) {
						if (st) {
							elem.removeAttribute('disabled');
						} else {
							elem.setAttribute('disabled', 'disable');
						}
					}
				}
			}
			
			// call onSubmit
			const ret = this.onSubmit(formElem, function (obj) {
				obj = obj || {};
				
				actSubmitBtn(obj.unlockSubmitButton);
				
				formElem.classList.remove('form_sending');
				
				if (obj.clearForm == true) {
					clear();
				}
			});
			
			if (ret === false) {
				if (e) {
					e.preventDefault();
				}

				actSubmitBtn(false);
			} else {
				formElem.submit();
			}
		},
		
		init: function (formSelector) {
			if (!document.querySelector(formSelector)) return;
			
			ValidateForm.init(formSelector);
			
			// submit event
			document.addEventListener('submit', (e) => {
				var formElem = e.target.closest(formSelector);
				
				if (formElem) {
					this.submitForm(formElem, e);
				}
			});
			
			// keyboard event
			document.addEventListener('keydown', (e) => {
				var formElem = e.target.closest(formSelector);
				
				if (!formElem) return;
				
				var key = e.which || e.keyCode || 0;
				
				if (e.ctrlKey && key == 13) {
					e.preventDefault();

					this.submitForm(formElem, e);
				}
			});
		}
	};
	
	// bind labels
	function BindLabels(elementsStr) {
		var elements = document.querySelectorAll(elementsStr);
		
		for (var i = 0; i < elements.length; i++) {
			var elem = elements[i],
			label = elem.parentElement.querySelector('label'),
			forID = (elem.hasAttribute('id')) ? elem.id : 'keylabel-'+ i;
			
			if (label && !label.hasAttribute('for')) {
				label.htmlFor = forID;
				elem.id = forID;
			}
		}
	}
	
	// duplicate form
	var DuplicateForm = {
		add: function (btnElem) {
			var modelElem = (btnElem.hasAttribute('data-form-model')) ? document.querySelector(btnElem.getAttribute('data-form-model')) : null,
			destElem = (btnElem.hasAttribute('data-duplicated-dest')) ? document.querySelector(btnElem.getAttribute('data-duplicated-dest')) : null;
			
			if (!modelElem || !destElem) return;
			
			var duplicatedDiv = document.createElement('div');
			
			duplicatedDiv.className = 'duplicated';
			
			duplicatedDiv.innerHTML = modelElem.innerHTML;
			
			destElem.appendChild(duplicatedDiv);
			
			var dupicatedElements = destElem.querySelectorAll('.duplicated');
			
			for (var i = 0; i < dupicatedElements.length; i++) {
				var dupicatedElem = dupicatedElements[i],
				labelElements = dupicatedElem.querySelectorAll('label'),
				inputElements = dupicatedElem.querySelectorAll('input');
				
				for (var j = 0; j < labelElements.length; j++) {
					var elem = labelElements[j];
					
					if (elem.htmlFor != '') {
						elem.htmlFor += '-'+ i +'-'+ j;
					}
				}
				
				for (var j = 0; j < inputElements.length; j++) {
					var elem = inputElements[j];
					
					if (elem.id != '') {
						elem.id += '-'+ i +'-'+ j;
					}
				}
			}
		},
		
		remove: function (btnElem) {
			var duplElem =  btnElem.closest('.duplicated');
			
			if (duplElem) {
				duplElem.innerHTML = '';
			}
		},
		
		init: function (addBtnSelector, removeBtnSelector) {
			document.addEventListener('click', (e) => {
				var addBtnElem = e.target.closest(addBtnSelector),
				removeBtnElem = e.target.closest(removeBtnSelector);
				
				if (addBtnElem) {
					this.add(addBtnElem);
				} else if (removeBtnElem) {
					this.remove(removeBtnElem);
				}
			});
		}
	};
	
	// set tabindex
	/*function SetTabindex(elementsStr) {
		var elements = document.querySelectorAll(elementsStr);
		
		for (let i = 0; i < elements.length; i++) {
			var elem = elements[i];
			
			if (!elemIsHidden(elem)) {
				elem.setAttribute('tabindex', i + 1);
			}
		}
	}*/
	
	// init scripts
	document.addEventListener('DOMContentLoaded', function () {
		BindLabels('input[type="text"], input[type="checkbox"], input[type="radio"]');
		// SetTabindex('input[type="text"], input[type="password"], textarea');
		varHeightTextarea.init();
		NextFieldset.init('.js-next-fieldset-btn', '.js-prev-fieldset-btn');
		DuplicateForm.init('.js-dupicate-form-btn', '.js-remove-dupicated-form-btn');
	});
})();
(function() {
   'use strict';
   
   // animate when is visible
   const animationOnVisible = {
      animElements: null,
      
      scroll: function() {
         const winBotEdge = window.pageYOffset + window.innerHeight;
         
         for (let i = 0; i < this.animElements.length; i++) {
            const animElem = this.animElements[i],
            animElemOffsetTop = animElem.getBoundingClientRect().top + window.pageYOffset,
            animElemOffsetBot = animElemOffsetTop + animElem.offsetHeight;
            
            if (winBotEdge > animElemOffsetBot && window.pageYOffset < animElemOffsetTop) {
               animElem.classList.add('animated');
            } else {
               animElem.classList.remove('animated');
            }
         }
      },
      
      init: function() {
         const animElements = document.querySelectorAll('.animate');
         
         if (animElements.length) {
            this.animElements = animElements;
            this.scroll();
         }
      }
   };
   
   // document ready
   document.addEventListener('DOMContentLoaded', function() {
      animationOnVisible.init();
      
      if (animationOnVisible.animElements) {
         window.addEventListener('scroll', animationOnVisible.scroll);
      }
   });
})();
//# sourceMappingURL=script.js.map
