<!--FOOTER/-->
<footer class="footer">
	<div class="row row_wrp">
		<div class="col-12">
			<ul class="foot-nav">
				<li class="foot-nav__item">
					<a rel="nofollow" href="/coupons" class="foot-nav__a">Промокоды</a>
				</li>
				<li class="foot-nav__item">
					<a rel="nofollow" href="/shops" class="foot-nav__a">Магазины</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="row row_wrp">
		<div class="col col_grow">
			<div class="footer__txt">
				Промокоды и скидки от лучших интернет магазинов.<br> 
				&copy; <?php echo date('Y');?> Dealers Air Bombonus, https://bombonus.dealersair.com
			</div>
		</div>
		<div class="col">
			<a href="http://dealersair.com/" title="«Dealers Air» — интернет-проекты и сервисы" target="_blank" class="footer__logo"><img src="/static/images/icon-dealersair.svg" alt="Dealers Air"></a>
		</div>
	</div>
</footer>
<!--/FOOTER-->
	
<!--POPUP/-->
<div class="popup">

	<!-- <div id="log-reg-window" class="popup__window">
		<button class="popup__close btn-close"></button>

		<div id="js_auth_msg" class="popup__alert"></div>

		<div class="popup__inner">

			<div class="tab">

				<div class="m-x-10">
					<div class="tab__buttons">
						<a href="#login-tab" id="login-tab__btn" class="tab__btn">Вход</a>
						<a href="#registration-tab" id="registration-tab__btn" class="tab__btn">Регистрация</a>
					</div>
					<script src="//ulogin.ru/js/ulogin.js"></script>
					<div id="uLogin1c4c508d" class="ta-c mb-14" data-ulogin="display=panel;fields=first_name,last_name,email,country;providers=vkontakte,facebook,odnoklassniki,twitter,google,yandex,mailru;redirect_uri=;callback=socAuth"></div>
					<div class="popup__title popup__title_s">
						<span>или заполните форму</span>
					</div>
				</div>

				
				<div id="login-tab" class="tab__content">
					<form id="js-login-form" action="/functions/auth.php" method="POST" class="form">
						<div class="form__field">
							<label for="lf-i-txt-1" class="overlabel">E-mail</label>
							<input id="lf-i-txt-1" type="text" data-type="email" name="email" data-required="true" class="form__text-input" value="">
						</div>
						<div class="form__field">
							<label for="lf-i-txt-2" class="overlabel">Пароль</label>
							<input id="lf-i-txt-2" type="password" data-type="pass" name="pass_l" class="form__text-input" value="">
						</div>
						<div class="col">
							<button type="submit" class="form__button">Войти</button>
						</div>
						<input type="hidden" name="form_role" value="log">
					</form>
				</div>
				
				<div id="registration-tab" class="tab__content">
					<form id="js-registration-form" action="/functions/auth.php" method="POST" class="form">
						<div class="form__field">
							<label for="rf-i-txt-1" class="overlabel">E-mail</label>
							<input id="rf-i-txt-1" type="text" data-type="email" name="email" data-required="true" class="form__text-input" value="">
						</div>
						<div class="form__field">
							<label for="rf-i-txt-2" class="overlabel">Имя</label>
							<input id="rf-i-txt-2" type="text" name="name" data-required="true" class="form__text-input" value="">
						</div>
						<div class="form__field">
							<label for="rf-i-txt-3" class="overlabel">Пароль (минимум 7 символов)</label>
							<input id="rf-i-txt-3" type="password" data-type="pass" data-pass-compare="group" data-pass-length="7" name="pass_r" class="form__text-input" value="">
						</div>
						<div class="form__field">
							<label for="rf-i-txt-4" class="overlabel">Повторите пароль</label>
							<input id="rf-i-txt-4" type="password" data-type="pass" data-pass-compare="group" data-pass-length="7" name="pass_r2" class="form__text-input" value="">
						</div>
						<div class="col">
							<button type="submit" class="form__button">Зарегистрироваться</button>
						</div>
						<input type="hidden" name="country" value="<?php echo $region; ?>">
						<input type="hidden" name="form_role" value="reg">
					</form>
				</div>
				
			</div>

		</div>

	</div> -->

	<div id="alert-block" class="popup__window">
		<button class="js-popup-close popup-close-btn"></button>
		<div class="popup__inner">
			<div class="popup__title">Функционал сайта ограничен</div>
			<p>
				В вашем браузере установлено расширение, которое может нарушить работу нашего сайта, блокировать отображение элементов сайта, производить подмену ссылок, блокировать cookie и вызывать другие неполадки. В связи с этим мы не даем гарантии, что вы сможете воспользоваться купоном или получить скидку.
			</p>
			<p>
				Проблема может быть вызвана сторонним расширением AdBlock. В данный момент, фильтры и инструкции для AdBlock могут составлять различные независимые организации, как с целью блокировать рекламу, так и с целью навредить пользователям и владельцам сайтов. На нашем сайте нет рекламы, нашего сайта нет в черных списках, но расширение блокирует даже отображение логотипов магазинов и с большой вероятностью нарушит корректную работу сайтов самих интернет магазинов. Чтобы наш сайт, а также сайты интернет магазинов заработали корректно вам нужно добавить фильтр исключений в AdBlock.
			</p>
			<p>
				<a href="abp:subscribe?location=https%3A%2F%2Fbombonus.dealersair.com%2Fadblock.txt&amp;title=BomBonus" class="orange-btn">Добавить фильтр</a>
			</p>
		</div>
	</div>

	<div id="message-popup" class="popup__window">
		<button class="popup__close btn-close"></button>
		<div class="popup__inner"></div>
	</div>

</div>
<!--/POPUP-->

<script>
var adblock = true;
</script>
<script src="/static/js/advert.js"></script>

<script src="/static/js/jquery-3.1.1.min.js"></script>
<script src="/static/js/slick.min.js"></script>
<script src="/static/js/script.js"></script>
<script src="/static/js/common.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-49744337-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-49744337-3');
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");

   ym(39630900, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/39630900" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>