	<!--Footer/-->
	<footer id="footer" class="footer">
		<div class="wrap">
			<div class="left">&copy; <?php echo date('Y');?> <span>BomBonus.dealersAir — Кэшбэк, скидки/промокоды</span></div>
			<div class="right">
				<a class="dealersair" href="http://dealersair.com/" title="«dealersAir» — интернет-проекты и сервисы" target="_blank"><img src="/images/icon-dealersair.svg" onerror="this.onerror=null; this.src='/images/icon-dealersair.png'" alt="DealersAir"></a>
			</div>
		</div>
	</footer>
	<!--/Footer-->

</div> 
<!--/Wrapper-->
	
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

	<div id="message-popup" class="popup__window">
		<button class="popup__close btn-close"></button>
		<div class="popup__inner"></div>
	</div>

</div>

<!--/POPUP-->

<div id="load" class="load"><img src="/images/loader.gif" alt="loader"></div>

<!-- <script src="/js/script.js"></script>
<script src="/js/common.js"></script> -->

<script>
// script loading
document.addEventListener('DOMContentLoaded', function() {
	var scriptsSrcArr = ['/js/script.js', '/js/common.js'],
	count = 0;

	function loaded() {
		count++;
		
		if (count == scriptsSrcArr.length) {
			console.log('loaded');
			scriptLoaded();
		}
	}

	for (var i = 0; i < scriptsSrcArr.length; i++) {
		var src = scriptsSrcArr[i],
		scriptElem = document.createElement('script');
		
		scriptElem.async = true;
		scriptElem.src = src;

		scriptElem.addEventListener('load', loaded);

		document.body.appendChild(scriptElem);
	}
});

var selRegion = false;

<?php
if (empty($region)) {
	echo 'selRegion = true;';
}
?>
</script>



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
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter39630900 = new Ya.Metrika({
                    id:39630900,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/39630900" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>