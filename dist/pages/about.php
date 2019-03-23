<?php
if(empty($meta)){
	$meta = array(
		'name'=>'О сервисе BomBonus.dealersAir',
		'title'=>'О сервисе',
		'description'=>'Что такое кэшбэк и как его получить'
		);
}
include('templates/header.php');
?>
<!--Container/-->
<div class="container wrap row vw1000-row-col">

	<div class="col-3">
		<aside class="sidebar box">
			<div class="pad">
				<?php include 'templates/sidebar-menu.php'; ?>
			</div>
		</aside>
	</div>

	<div class="col-9">
		<article class="box">
			<div class="pad content">
				<h1><?php echo $meta['name'];?></h1>

				<p>
					<strong>BomBonus.dealersAir</strong> — это кэшбэк сервис. Мы возвращаем часть потраченных вами средств на покупки в интернет-магазинах.
				</p>

				<h2>Что такое кэшбэк?</h2>
				<p>
					<strong>Кэшбэк</strong> <sub>(от англ. cashback или амер. cash back — возврат наличных денег)</sub> — это бонус в виде денежных средств, который вы получаете после покупки товаров в интернет-магазинах.
				</p>

				<h2>Почему мы платим деньги:</h2>
				<ol>
					<li>
						Мы приводим в магазин покупателей.
					</li>
					<li>
						Магазины платят нам вознаграждение.
					</li>
					<li>
						Большей частью вознаграждения мы делимся с вами.
					</li>
				</ol>

				<h2>Получить кэшбэк очень просто:</h2>

				<ol>
					<?php if(!$user){ ?>
					<li>
						<a href="#log-reg-window" data-tab="registration" class="js-open-popup">Зарегистрируйтесь</a>.
					</li>
					<?php } ?>
					<li>
						Ознакомьтесь с <a href="/recomendations" title="Правила" target="_blank">рекомендациями по совершению покупок</a>.
					</li>
					<li>
						Выберите любой <a href="/shops" title="Магазины" target="_blank">магазин</a> или <a href="/discounts" title="Скидки и промокоды" target="_blank">скидку</a>, перейдите по кнопке "В МАГАЗИН".
					</li>
					<li>
						Покупайте нужные товары обычным способом.
					</li>
					<li>
						Зайдите в личный кабинет и выведите средства удобным для вас способом.
					</li>
				</ol>
			</div>
		</article>
	</div>

</div>
<!--/Container-->
<?php include('templates/footer.php');?>