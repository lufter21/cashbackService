<!--FOOTER/-->
<footer class="footer">
	<div class="row row_wrp">
		<div class="col-12">
			<ul class="foot-nav">
				<li class="foot-nav__item">
					<a rel="nofollow" href="/discounts" class="foot-nav__a">Скидки на заказ</a>
				</li>
				<li class="foot-nav__item">
					<a rel="nofollow" href="/gifts" class="foot-nav__a">Подарки к заказу</a>
				</li>
				<li class="foot-nav__item">
					<a rel="nofollow" href="/free-shipping" class="foot-nav__a">Бесплатная доставка</a>
				</li>
				<li class="foot-nav__item">
					<a rel="nofollow" href="/shops" class="foot-nav__a">Каталог магазинов</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="row row_wrp">
		<div class="col col_grow">
			<div class="footer__txt">
				Скидки, подарки, бесплатная доставка от лучших интернет магазинов.<br>
				&copy; <?php echo date('Y'); ?> BomBonus, https://bombonus.dealersair.com
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

	<div id="message-popup" class="popup__window">
		<button class="popup__close btn-close"></button>
		<div class="popup__inner"></div>
	</div>

</div>
<!--/POPUP-->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
	(function(m, e, t, r, i, k, a) {
		m[i] = m[i] || function() {
			(m[i].a = m[i].a || []).push(arguments)
		};
		m[i].l = 1 * new Date();
		k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
	})
	(window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");

	ym(39630900, "init", {
		clickmap: true,
		trackLinks: true,
		accurateTrackBounce: true
	});
</script>
<noscript>
	<div><img src="https://mc.yandex.ru/watch/39630900" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-49744337-3"></script>
<script>
	window.dataLayer = window.dataLayer || [];

	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());

	gtag('config', 'UA-49744337-3');
</script>

<?php
if (isset($goUrl)) {
	?>
	<script>
		window.location.href = '<?php echo $goUrl; ?>';
	</script>
<?php
}
?>

<script src="/static/js/jquery-3.1.1.min.js"></script>
<script src="/static/js/slick.min.js"></script>
<script src="/static/js/script.js"></script>
<script src="/static/js/common.js"></script>
</body>

</html>