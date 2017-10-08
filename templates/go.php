<?php
$shop = (!empty($content['alias'])) ? $content['alias'] : $content['shop'];
if(empty($meta)){
	$meta = array(
		'name'=>'Вы переходите в магазин',
		'title'=>' Переход в магазин '.$shop,
		);
}
include('header.php');
?>

<!--Container/-->
<div class="container wrap">

	<div class="go content">

		<div id="go-block">
			<h2 class="ta-c"><?php echo $meta['name']; ?></h2>
			<div class="ta-c mb-35">
				<img src="/images/logo/<?php echo $shop; ?>.png" alt="<?php echo $shop; ?>">
			</div>
			<div class="timer">
				<div id="timer-num" class="timer__num"></div>
				<div class="timer__icon"></div>
			</div>
		</div>
		
		<div id="go-warning" class="go__warning">
			<div class="go__warning-tit">Внимание! Кэшбэк может быть не начислен</div>
			<p>
				В вашем браузере установленны сторонние плагины и расширения, которые могут помешать работе сервиса. Некоторые плагины могут подменить или обрезать ссылки&nbsp;и ваш заказ не будет засчитан.
			</p>
			
			<div class="grid mb-35">
				<div class="grid__col-2 ta-c">
					<img src="/images/extensions.jpg" alt="extensions" class="image">
				</div>
				<div class="grid__col-2">
					<p class="ta-l fs-15">
						Для гарантированного начисления кэшбэка отключите все плагины и расширения, а&nbsp;также следуйте <a href="/recomendations" target="_blank">рекомендациям&nbsp;по&nbsp;совершению&nbsp;покупок</a>.
					</p>
				</div>
			</div>
			<a rel="nofollow" href="<?php echo $content['red_url']; ?>" class="go__warning-btn">Перейти в магазин</a>
		</div>

	</div>

</div>
<!--/Container-->
<script> var redUrl = '<?php echo $content['red_url']; ?>'; </script>
<?php
$js_include = array('go.js');
include('templates/footer.php');
?>