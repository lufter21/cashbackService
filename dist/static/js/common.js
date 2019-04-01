document.addEventListener('DOMContentLoaded', function() {
	const fsElem = document.getElementById('js-first-screen');
	
	(function initFun() {
		if (fsElem) {
			let padTop = 100;

			if (window.innerWidth < 1200) {
				padTop = 60;
			}

			fsElem.style.height = (window.innerHeight - padTop) +'px';
		}
		
		// resize events
		window.removeEventListener('winResized', initFun);
		window.removeEventListener('winWidthResized', initFun);

		if (window.innerWidth > 1200) {
			window.addEventListener('winResized', initFun);
		} else {
			window.addEventListener('winWidthResized', initFun);
		}
	})();
	
	// toggle button
	Toggle.init('.js-toggle', '.js-document-toggle-off');
	
	Toggle.onChange = function(tgl, state) {
		
	}
	
	// popup
	Popup.init('.js-open-popup');
	MediaPopup.init('.js-open-media-popup');

	// menu
	if (window.innerWidth < 1000) {
		Menu.init('.menu__item_has-children', '.menu__sub-menu');
	}
	
	// mobile nav
	MobNav.init({
		openBtn: '.js-open-menu',
		closeBtn: '.js-close-menu',
		headerId: 'header',
		menuLinkSelector: '.menu a'
	});
	
	// // alert
	// new Alert({
	// 	content: '<div class="row alert__row row_col-middle row_sm-x-nw"><div class="col">На нашем веб-сайте используются файлы cookies, которые позволяют улучшить Ваше взаимодействие с сайтом. Когда вы посещаете данный веб-сайт, Вы даете согласие на использование файлов cookies.</div><div class="col"><button class="js-alert-close btn btn_be">Хорошо</button></div></div>',
	// 	showOnce: true
	// });
	
	// autocomplete data
	AutoComplete.setValuesData = function (val, fun) {
		fun([
			{val:"mc", value:"Mercury"},
			{val:"vn", value:"Venus"},
			{val:"eth", value:"Earth"},
			{val:"ms", value:"Mars"},
			{val:"mn", value:"Mandarin"},
			{val:"mk", value:"Marakuja"},
			{val:"mlk", value:"Milk"}
		]);
	}
	
	// submit form
	Form.init('.form');
	
	Form.onSubmit = function(form, callback) {
		switch (form.id) {
			case 'sorting-form':
			return true;
			
			case 'custom-form-2':
			case 'custom-form-3':
			case 'custom-form-4':
			var files = CustomFile.getFiles(form);
			
			console.log(files);
			return false;
			
			default:
			ajax({
				url: form.action,
				send: new FormData(form),
				success: function(response) {
					var response = JSON.parse(response);
					
					if (response.status == 'sent') {
						Popup.message('#message-popup', 'Форма отправлена');
						
						callback({clearForm: true, unlockSubmitButton: true});
					} else {
						console.log(response);
					}
				},
				error: function(response) {
					console.log(response);
				}
			});
			return false;
		}
	}
});

// jQuery plugins
$(document).ready(function(){
	// slick slider
	$('#slider').on('init', function() {
		CoverImg.reInit('#slider');
	});
	
	$('#main-slider').slick({
		// autoplay: true,
		fade: true,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1
	});
});

// admitad adblock checker
!function(e,o){var t={retries:10,cookiesEnabled:!1,adblockEnabled:!1,checkLocalDone:!1,checkRemoteDone:!1,options:{showPopup:!0,allowClose:!1,lang:"ru"},langText:{ru:{title:"Функционал сайта ограничен",description:"Настройки вашего браузера или одно из его расширений не дают нашему сайту установить cookie. Без cookie будет невозможно воспользоваться купоном на скидку или услугой возврата части денег за вашу покупку, вероятны и другие ошибки.",listTitle:"Проблема может быть вызвана:",button:"Настроить Adblock",browserSettings:"<strong>Настройками вашего браузера.</strong> Зайдите в настройки браузера и разрешите использование файлов cookie. ",adblockSettings:'<strong>Сторонним расширением AdBlock.</strong> Чтобы наш сайт заработал корректно вам нужно добавить его в <a href="___adblockLink___">белый список</a> в настройках AdBlock. '},en:{title:"Site has a limited functionality",description:"Your browser settings or one of your browser extensions prevent our site from installing a cookie. WIthout the cookie, you will be unable to use coupons to receive discounts or to make use of cashback services, and other errors are likely.",listTitle:"This error may be caused by the following:",button:"Set up Adblock",browserSettings:"<strong>Your browser settings.</strong> Go to your browser settings and allow cookies.",adblockSettings:'A third-party extension called <strong>AdBlock</strong>. To ensure correct operation of our web site, please <a href="___adblockLink___">add it to your white list</a> in AdBlock settings.'},tr:{title:"SİTE FONKSİYONELLİĞİ SINIRLIDIR",description:"Web tarayıcınızın ayarları veya uzantılarından biri çerezlerimizin düzgün çalışmasına engel olmaktadır. Sitemizin bazı bölümleri çerezlerin kullanım dışı bırakılması halinde problemler çıkarabilir. Örneğin: kupon kodunun kullanılamaması ya da para iadesinin cashback alınamaması vb.",listTitle:"Sorunlar aşağıdaki nedenlerden kaynaklanabilir:",button:"Adblock ayarlarına bakın",browserSettings:"<strong>Web tarayıcınızın ayarları.</strong> Web tarayıcınızın ayarlarına girin ve çerez kullanımına izin verin.",adblockSettings:'Üçüncü taraf eklentileri (Adblock). Sitemizin düzgün çalışması için lütfen Adblock ayarlarına <a href="___adblockLink___">girip sitemizi beyaz listeye alın</a>.'}},_:function(e){return t.langText[t.options.lang][e]},init:function(){o.write('<script src="https://ad.admitad.com/3rd-party/advert.js"></script>'),WebFontConfig={google:{families:["PT+Serif::latin,cyrillic"]}},function(){var e=o.createElement("script");e.src=("https:"==o.location.protocol?"https":"http")+"://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js",e.type="text/javascript",e.async="true";var t=o.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)}()},setOptions:function(e){for(var o in e)e.hasOwnProperty(o)&&t.options.hasOwnProperty(o)&&(t.options[o]=e[o])},resetOptions:function(){t.retries=10,t.cookiesEnabled=!1,t.checkLocalDone=!1,t.checkRemoteDone=!1},setLang:function(e){("ru"==e||"en"==e)&&(t.lang=e)},setCallback:function(e){"function"==typeof e&&(t.callback=e)},callback:function(e,o){},checkAdblock:function(){void 0==o.getElementById("tester")&&(t.adblockEnabled=!0)},addScript:function(e){var t=o.createElement("script"),a=o.getElementsByTagName("head")[0];t.setAttribute("src",e),a.appendChild(t)},checkRemoteCookiesEnabled:function(){var e="https://ad.admitad.com/3rd-party/set/cookie/?f=CookieChecker.remoteTestStep1Loaded&r="+Math.floor(1e3*Math.random()+1);t.addScript(e)},remoteTestStep1Loaded:function(){var e="https://ad.admitad.com/3rd-party/check/cookie/?f=CookieChecker.remoteTestStep2Loaded&r="+Math.floor(1e3*Math.random()+1);t.addScript(e)},remoteTestStep2Loaded:function(e){t.cookiesEnabled=!!e,t.checkRemoteDone=!0},checkResults:function(){return!t.checkRemoteDone&&t.retries>0?void t.retries--:(clearInterval(t.timer),t.checkRemoteDone||t.retries||(t.cookiesEnabled=!1,t.checkRemoteDone=!0),t.callback(t.cookiesEnabled,t.adblockEnabled),void(t.options.showPopup&&(t.adblockEnabled||!t.cookiesEnabled)&&t.showResults()))},showResults:function(){var e=o.createElement("style");e.type="text/css",e.innerHTML='.text-left{text-align:left}.text-right{text-align:right}.text-center{text-align:center}.align-left{float:left}.align-right{float:right}.clearfix{overflow:hidden}.no-padding{padding:0!important}.img-responsive{max-width:100%;height:auto;display:block}.img-border{border:30px solid #fff}.general-margin{margin-bottom:54.4px}.unstyled-list{list-style-type:none;margin:0;padding:0}.inline-list li{display:inline-block}.relative{position:relative}.absolute{position:absolute}.absolute-center-left{display:inline-block;position:absolute;left:50%;-ms-transform:translate(-50%,0);-webkit-transform:translate(-50%,0);transform:translate(-50%,0)}.admitad-checker-popup-wrap{display:none;position:absolute;left:0;top:0;width:100%;height:100%;-webkit-font-smoothing:auto;font-family:"PT Serif",serif;font-size:17px;line-height:normal;line-height:1.6;font-weight:400;color:#333}.admitad-checker-popup-wrap *{box-sizing:border-box}.admitad-checker-popup-wrap p{margin-bottom:27.2px}.admitad-checker-popup-wrap p a{text-decoration:underline}.admitad-checker-popup-wrap p a:hover{text-decoration:none}.admitad-checker-popup-wrap h1,.admitad-checker-popup-wrap h2,.admitad-checker-popup-wrap h3,.admitad-checker-popup-wrap h4,.admitad-checker-popup-wrap h5,.admitad-checker-popup-wrap h6{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif}.admitad-checker-popup-wrap button::-moz-focus-inner{border:0}.admitad-checker-popup-wrap .admitad-checker-popup-bg{width:100%;height:100%;background-color:rgba(0,0,0,.5);position:absolute;min-height:100%;z-index:15000}.admitad-checker-popup-wrap .admitad-checker-popup-cont{position:fixed;left:50%;top:50%;box-sizing:border-box;border-radius:5px;z-index:16000;width:780px;margin-left:-390px;background-color:#fff}.admitad-checker-popup-wrap .admitad-checker-popup-header{border-bottom:none;padding:40px 40px 15px}.admitad-checker-popup-wrap .admitad-checker-popup-header .admitad-checker-popup-close{display:inline-block;width:18px;height:18px;position:absolute;right:-30px;top:1px;background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASAgMAAAAroGbEAAAACVBMVEUAAAD///////9zeKVjAAAAA3RSTlMAs1knKdD1AAAARUlEQVQI1y2NywkAMQhEH94sRNiGVnK0FJtIOkifgUwuIvN5wwfWLPBiNlHEfXxYgqUPYO4C4m/AE10pcl9SLRFEE1krB+d5EoVlzt2UAAAAAElFTkSuQmCC) no-repeat;border:none;text-indent:-9999px;cursor:pointer}.admitad-checker-popup-wrap .admitad-checker-popup-header .admitad-checker-popup-close:hover{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASAgMAAAAroGbEAAAADFBMVEUAAAD///////////84wDuoAAAAA3RSTlMAgH8BTzA4AAAAWklEQVQI1w3MIRXAIABF0TcMAjuPnaMCTZZkBxqtwahABEIgMMC+ufJygcl84BopEyq+USJ2mAnHch1Ib5V+R2mnwC1B2FmWuymZdoDrxwIlqpSoesBWTlXxBzhqHQKA2YKzAAAAAElFTkSuQmCC)}.admitad-checker-popup-wrap .admitad-checker-popup-header .admitad-checker-popup-close:active{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASAgMAAAAroGbEAAAADFBMVEUAAAAeHh4eHh4eHh5hB4ydAAAAA3RSTlMAgH8BTzA4AAAAWklEQVQI1w3MIRXAIABF0TcMAjuPnaMCTZZkBxqtwahABEIgMMC+ufJygcl84BopEyq+USJ2mAnHch1Ib5V+R2mnwC1B2FmWuymZdoDrxwIlqpSoesBWTlXxBzhqHQKA2YKzAAAAAElFTkSuQmCC)}.admitad-checker-popup-wrap .admitad-checker-popup-header .admitad-checker-popup-close:focus{outline:0}.admitad-checker-popup-wrap .admitad-checker-popup-header .admitad-checker-popup-title{text-transform:uppercase;color:#545454;font-size:1.76471em;margin:0}.admitad-checker-popup-wrap .admitad-checker-popup-header .admitad-checker-popup-title.danger{color:#a83737}.admitad-checker-popup-wrap .admitad-checker-popup-body{color:#7c7c7c;padding:15px 40px;margin-bottom:20px}.admitad-checker-popup-wrap .admitad-checker-popup-body .admitad-checker-popup-reason{border-left:5px solid #bb6b6b;padding-left:15px}.admitad-checker-popup-wrap .admitad-checker-popup-body .admitad-checker-popup-reason a{text-decoration:none;color:#9ebdff}.admitad-checker-popup-wrap .admitad-checker-popup-body .admitad-checker-popup-reason a:hover{text-decoration:underline}.admitad-checker-popup-wrap .admitad-checker-popup-footer{background-color:#f1f1f1;border-top:none;padding:40px;border-radius:0 0 6px 6px}.admitad-checker-popup-wrap .admitad-checker-popup-footer .admitad-checker-popup-button{border:none;color:#fff;border-radius:5px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:.82353em;line-height:1;font-weight:400;display:inline-block;width:180px;height:41px;outline:0;cursor:pointer;text-decoration:none;padding-top:13px;transition:all .2s ease-in}.admitad-checker-popup-wrap .admitad-checker-popup-footer .admitad-checker-popup-button.copy{background-color:#80b66b}.admitad-checker-popup-wrap .admitad-checker-popup-footer .admitad-checker-popup-button.copy:hover{background-color:#8bc972;color:#ebffe3}.admitad-checker-popup-wrap .admitad-checker-popup-footer .admitad-checker-popup-button.copy:active{background-color:#8ece75}',o.getElementsByTagName("head")[0].appendChild(e);var a=o.createElement("div");a.innerHTML=t.getPopup(),o.body.appendChild(a),t.showPopup()},showPopup:function(){o.getElementById("admitad-cookie-check-popup").style.display="block";var t=o.getElementById("admitad-checker-popup-cont"),a=o.body.scrollHeight,i=t.clientHeight,r=e.innerHeight;o.getElementById("admitad-checker-popup-cont").style.top=r/2-i/2+"px",a>r?o.getElementById("admitad-cookie-check-popup").style.height=a+"px":o.getElementById("admitad-cookie-check-popup").style.height=r+"px"},closePopup:function(){o.getElementById("admitad-cookie-check-popup").style.display="none"},getPopup:function(){var e="abp:subscribe?location="+encodeURI("https://www.admitad.com/3rd-party/adblock.txt")+"&title=Admitad";return'<div class="admitad-checker-popup admitad-checker-popup-wrap" id="admitad-cookie-check-popup"><div class=admitad-checker-popup-bg'+(t.options.allowClose?' onClick="CookieChecker.closePopup(); return false;"':"")+'></div><div class=admitad-checker-popup-cont id="admitad-checker-popup-cont"><div class=admitad-checker-popup-header>'+(t.options.allowClose?'<button type="button" class="admitad-checker-popup-close" onClick="CookieChecker.closePopup(); return false;">Закрыть</button>':"")+'<h4 class="admitad-checker-popup-title danger">'+t._("title")+'</h4></div><div class="admitad-checker-popup-body"><p>'+t._("description")+"</p><p>"+t._("listTitle")+'</p><p class="admitad-checker-popup-reason">'+t._("browserSettings")+"</p>"+(t.adblockEnabled?'<p class="admitad-checker-popup-reason">'+t._("adblockSettings").replace("___adblockLink___",e)+"</p>":"")+"</div>"+(t.adblockEnabled?'<div class="admitad-checker-popup-footer"><div class="row"><div class="col-xs-12 col-sm-4 col-sm-offset-4 text-center"><a href="'+e+'" class="admitad-checker-popup-button copy">'+t._("button")+"</a></div></div></div>":"")+"</div></div>"},run:function(e){t.resetOptions(),t.setOptions(e),t.checkRemoteCookiesEnabled(),t.checkAdblock(),t.timer=setInterval(t.checkResults,200)}};e.CookieChecker=t,t.init()}(window,document);

CookieChecker.run({allowClose: true});