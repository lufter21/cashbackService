//label
function initOverLabels () {
	if (!document.getElementById) return; 
	var labels, id, field;
	labels = document.getElementsByTagName('label');
	for (var i = 0; i < labels.length; i++) {
		if (labels[i].className == 'overlabel') {
			id = labels[i].htmlFor || labels[i].getAttribute('for');
			if (!id || !(field = document.getElementById(id))) {
				continue;
			} 
			labels[i].className = 'overlabel-apply';
			if (field.value !== '') {
				hideLabel(field.getAttribute('id'), true);
			}
			field.onfocus = function () {
				hideLabel(this.getAttribute('id'), true);
			};
			field.onblur = function () {
				if (this.value === '') {
					hideLabel(this.getAttribute('id'), false);
				}
			};
			labels[i].onclick = function () {
				var id, field;
				id = this.getAttribute('for');
				if (id && (field = document.getElementById(id))) {
					field.focus();
				}
			};
		}
	}
}

function hideLabel (field_id, hide) {
	var field_for;
	var labels = document.getElementsByTagName('label');
	for (var i = 0; i < labels.length; i++) {
		field_for = labels[i].htmlFor || labels[i].getAttribute('for');
		if (field_for == field_id) {
			labels[i].style.textIndent = (hide) ? '-4000px' : '0px';
			labels[i].style.border = (hide) ? 'none' : '';
			return true;
		}
	}
}


/*FormHandler*/
$(document).ready(function() {

initOverLabels();

//sortingForm
$('#sorting-form select').change(function(){
	$('#sorting-form').submit();
	$('#load').fadeIn(121);
});


//Form Select
var Select = {
	_el: null,
	_field: null,
	_options: null,
	init: function(el) {
		var _ = this;
		_._el = $(el);
		_._field = _._el.closest('.form__select');
		_._options = _._field.find('.form__select-options');
	},
	change: function(state) {
		var _ = this;
		if (state) {
			if (!_._field.hasClass('form__select_search')) {
				$('.form__select').removeClass('form__select_opened');
				$('.form__select-options').slideUp(221);
			}
			_._field.addClass('form__select_opened');
			_._options.slideDown(221);
		} else {
			_._field.removeClass('form__select_opened');
			_._options.slideUp(221);
		}
	},
	open: function(el) {
		var _ = this;
		_.init(el);
		if (!_._field.hasClass('form__select_opened')) {
			_.change(1);
		} else {
			_.change(0);
		}
		return false;
	},
	select: function(el) {
		var _ = this;
		_.init(el);
		var _f = _._field,
		_button = _f.find('.form__select-button'),
		_srcInput = _f.find('.form__text-input_search'),
		_input = _f.find('.form__select-input');
		

		if (_f.hasClass('form__select_multiple')) {
			if (!_._el.hasClass('form__select-val_checked')) {
				_._el.addClass('form__select-val_checked');
			} else {
				_._el.removeClass('form__select-val_checked');
			}

			var toButtonValue = [],
			toInputValue = [];

			_._options.find('.form__select-val_checked').each(function(i) {
				var el = $(this);
				toButtonValue[i] = el.html();
				toInputValue[i] = el.attr('data-value');
			});

			if (toButtonValue.length) {
				_button.html(toButtonValue.join(', '));
				_input.val(toInputValue.join('+'));
			} else {
				_.change(0);
				_button.html('Множественный выбор');
				_input.val('');
			}

		} else {
			var toButtonValue = _._el.html(),
			toInputValue = _._el.attr('data-value');

			_.change(0);

			_button.html(toButtonValue);
			_srcInput.val(toButtonValue);
			_input.val(toInputValue);
		}

		if (_._el.attr('data-show-hidden')) {
			var opt = _._el.attr('data-show-hidden').split(','),
			_hidden = $(opt[0].trim());

			_hidden.removeClass('form__field_hidden');
			_hidden.find('label').html(opt[1].trim());
			_hidden.find('.form__text-input').attr('data-type', opt[2].trim());
		}

		Form.select(_input);

		return false;
	},
	search: function(el) {
		var _ = this;
		_.init(el);
		var inputValue = _._el.val();

		if(inputValue.length > 0){

			var reg = function(str) {
				var str = str.trim(),
				reg = str.replace(/\s/g,'|%');
				return '%'+reg;
			}(inputValue);

			var wordsCount = reg.split('|').length,
			_reg = new RegExp(reg, 'gi'),
			match = false;

			_._options.find('.form__select-val').each(function() {

				var srcVal = $(this).attr('data-search');

				if(srcVal.match(_reg) && srcVal.match(_reg).length >= wordsCount){
					$(this).parent().removeClass('hidden');
					match = true;
				} else {
					$(this).parent().addClass('hidden');
				}

			});

			if (match) {
				_.change(1);
			} else {
				_.change(0);
			}

		} else {
			_.change(0);
		}
	},
};

$('body').on('click', '.form__select-button', function() { 
	Select.open(this); 
});

$('body').on('keyup', '.form__text-input_search', function() { 
	Select.search(this); 
});

$('body').on('click', '.form__select-val', function() { 
	Select.select(this); 
});

$(document).on('click', 'body', function(e) {
	if (!$(e.target).closest('.form__select_opened').length) {
		$('.form__select').removeClass('form__select_opened');
		$('.form__select-options').slideUp(221);
	}
});


});


//validateForm
var Form = {
	input: null,
	state: function(state,msg) {
		var _f = this.input.closest('.form__field'),
		_tip = _f.find('.form__error-tip');
		if (state) {
			_f.removeClass('form__field_error').find('.form__error-tip').remove();
		} else {
			_f.addClass('form__field_error');
			if (_f.find('.form__error-tip').length) {
				_f.find('.form__error-tip').html(msg);
			} else {
				_f.append('<div class="form__error-tip">'+ msg +'</div>');
			}
		}
	},
	date: function() {
		var _ = this,
		err = false,
		validDate = function(val) {
			var _reg = new RegExp("^([0-9]{2}).([0-9]{2}).([0-9]{4})$"),
			matches = _reg.exec(val);
			if (!matches) {
				return false;
			}
			var now = new Date(),
			cDate = new Date(matches[3], (matches[2] - 1), matches[1]);
			return ((cDate.getMonth() == (matches[2] - 1)) && (cDate.getDate() == matches[1]) && (cDate.getFullYear() == matches[3]) && (cDate.valueOf() < now.valueOf()));
		};

		if (!validDate(_.input.val())) {
			_.state(false,'Введите корректную дату');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	email: function() {
		var _ = this,
		err = false;
		if (!/^[a-z0-9]+[a-z0-9-\.]*@[a-z0-9-]{2,}\.[a-z]{2,6}$/i.test(_.input.val())) {
			_.state(false,'Введите корректный email');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	tel: function() {
		var _ = this,
		err = false;
		if (!/^(\+7|\+38)[0-9]{10}$/.test(_.input.val())) {
			_.state(false,'Не корректный телефон');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	num: function() {
		var _ = this,
		err = false,
		maxNum = +_.input.attr('data-max-num'),
		val = _.input.val().replace(',','.');

		if (!/^[0-9]+((\.|,)[0-9]{1,2})?$/.test(_.input.val())) {
			_.state(false,'Не корректная сумма');
			err = true;
		} else if(val > maxNum) {
			_.state(false,'Не достаточно средств');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	wmz: function() {
		var _ = this,
		err = false;
		if (!/^z[0-9]{12}$/i.test(_.input.val())) {
			_.state(false,'Не корректный Z-кошелек');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	wmr: function() {
		var _ = this,
		err = false;
		if (!/^r[0-9]{12}$/i.test(_.input.val())) {
			_.state(false,'Не корректный R-кошелек');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	wmu: function() {
		var _ = this,
		err = false;
		if (!/^u[0-9]{12}$/i.test(_.input.val())) {
			_.state(false,'Не корректный U-кошелек');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	yam: function() {
		var _ = this,
		err = false;
		if (!/^[0-9]{15}$/i.test(_.input.val())) {
			_.state(false,'Не корректный кошелек Яндекс.Деньги');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	pass: function() {
		var _ = this,
		err = false,
		lng = _.input.attr('data-pass-length');

		if (_.input.val().length < 1) {
			_.state(false,'Введите пароль');
			err = true;
		} else if(lng && _.input.val().length < lng) {
			_.state(false,'Пароль не менее '+ lng +' символов');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	select: function(inp) {
		var _ = this,
		err = false;
		_.input = inp;
		if (_.input.attr('data-required') && _.input.val().length < 1) {
			_.state(false,'Сделайте выбор');
			err = true;
		} else {
			_.state(true);
		}
		return err;
	},
	keyup: function(inp) {
		var _ = this;
		_.input = $(inp);
		var type = _.input.attr('data-type');

		if (_.input.hasClass('tested')) {
			_[type]();
		}
		
	},
	validate: function(form) {
		var _ = this,
		err = 0,
		_form = $(form);

		_form.find('.form__text-input, .form__textarea').each(function() {
			_.input = $(this);
			var type = _.input.attr('data-type');
			_.input.addClass('tested');

			if (_.input.attr('data-required') && _.input.val().length < 1) {
				_.state(false,'Заполните поле');
				err++;
			} else {
				_.state(true);

				if (type && _[type]()) {
					err++;
				}

			}
			if (type == 'pass' && _.pass()) {
				err++;
			}
		});

		_form.find('.form__select-input').each(function() {
			if (_.select($(this))) {
				err++;
			}
		});

		_form.find('.form__chbox-input').each(function() {
			var _inp = $(this),
			_chbox = _inp.closest('.form__chbox');
			if(_inp.attr('data-required') && !_inp.prop('checked')){
				_chbox.addClass('form__chbox_error');
				err++;
			} else {
				_chbox.removeClass('form__chbox_error');
			}
		});

		_form.find('.form__chbox-group').each(function() {
			var i = 0,
			_g = $(this);

			_g.find('.form__chbox-input').each(function() {
				if ($(this).prop('checked')) {
					i++;
				}
			});
			
			if (i < _g.attr('data-min')) {
				_g.addClass('form__chbox-group_error');
				err++;
			} else {
				_g.removeClass('form__chbox-group_error');
			}
		});

		if (_form.find('.form__text-input[data-pass-compare]').length) {
			_form.find('.form__text-input[data-pass-compare]').each(function() {
				var gr = $(this).attr('data-pass-compare');
				_.input = _form.find('.form__text-input[data-pass-compare="'+ gr +'"]');
				if (!_.pass()) {
					if (_.input.eq(0).val() != _.input.eq(1).val()) {
						_.state(false,'Пароли не совпадают');
					} else {
						_.state(true);
					}
				}
			});
		}

		if (!err) {
			_form.find('.form__alert').remove();
		} else {
			if (_form.find('.form__alert').length) {
				_form.find('.form__alert').html('Ошибка заполнения полей формы');
			} else {
				_form.append('<div class="form__alert">Ошибка заполнения полей формы</div>');
			}
		}

		return !err;
	},
	submit: function(el, fun) {
		var _ = this;
		$('body').on('keyup', '.form__text-input', function() {
			_.keyup(this);
		});
		$('body').on('submit', el, function() {
			if (_.validate(this)) {
				fun(this);
			}
			return false;
		});
	},
};


//payment form
$(document).ready(function(){
	Form.submit('#payment-form', function(form) {
		var _f = $(form);
		$.ajax({
			url: _f.attr('action'),
			type:"POST",
			dataType:"json",
			data: _f.serialize(),
			success: function(response){
				if (response.status == 'ok') {
					Popup.message('#message-popup', '<span class="c-green">Заявка на вывод средств успешно составлена.<br> Наш менеджер обработает ее в течении 2-х рабочих дней.</span>', function() { window.location.reload(); });
				}
			},
			error: function() {
				alert('Send Error');
			}
		});
	});
});



/*GetCountriesAndCitiesList
function dAirGetInit() {
	dAirGet.countries(function(c) {
		var contryObj = $.parseJSON(c),
		countryOpt = $('.form__select-options_countries');
		
		for (var i = 0; i < contryObj.length; i++) {
			countryOpt.append('<li><button type="button" class="form__select-val" data-value="'+ contryObj[i].id +'">'+ contryObj[i].name +'</button></li>');
		}
	});
}*/