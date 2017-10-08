<?php
if(empty($meta)){
	$meta = array(
		'name'=>'Вопрос/Ответ',
		'title'=>'Вопрос/Ответ'
		);
}
include('templates/header.php');
?>
<!--Container/-->
	<div class="container wrap">

	<div class="container__sidebar">
		<aside class="sidebar">
			<?php include '/templates/sidebar-menu.php'; ?>
		</aside>
	</div>

<div class="container__content">
	<article class="content">
		<h1 class="bord-none m-0"><?php echo $meta['name'];?></h1>
		
		<div class="faq accord">

			<div class="accord__item">
				<button class="faq__quest accord__button">Что такое кэшбэк?<span></span></button>
				<div class="faq__answ accord__content">
					<p>Кэшбэк — это бонус в виде денежных средств, который вы получаете после покупки товаров в интернет-магазинах.</p>
				</div>
			</div>
			
			<div class="accord__item">
				<button class="faq__quest accord__button">Сколько денег мне вернут?<span></span></button>
				<div class="faq__answ accord__content">
					<p>Размер кэшбэка зависит от условий интернет-магазина.</p>
				</div>
			</div>

			<div class="accord__item">
				<button class="faq__quest accord__button">Как получить кэшбэк?<span></span></button>
				<div class="faq__answ accord__content">
					<ol>
						<li>
							<a href="#log-reg-window" data-tab="registration" class="js_open-popup">Зарегистрируйтесь</a>.
						</li>
						<li>
							Ознакомьтесь с <a href="/recomendations" title="Рекомендации" target="_blank">рекомендациями по совершению покупок</a>.
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
			</div>

			<div class="accord__item">
				<button class="faq__quest accord__button">Когда мне начислят кэшбэк?<span></span></button>
				<div class="faq__answ accord__content">
					<p>Кэшбэк начисляется в течении от 15 минут до 24 часов. Всю статистику вы можете просмотреть в личном кабинете.</p>
				</div>
			</div>

			<div class="accord__item">
				<button class="faq__quest accord__button">Когда кэшбэк будет доступным для вывода?<span></span></button>
				<div class="faq__answ accord__content">
					<p>Кэшбэк станет доступен для вывода, когда товар будет оплачен и доставлен вам, и если вы не вернете товар в течении разрешенного для возврата срока.</p>
				</div>
			</div>

			<div class="accord__item">
				<button class="faq__quest accord__button">Как вывести деньги?<span></span></button>
				<div class="faq__answ accord__content">
					<p>Зайдите в личный кабинет и закажите вывод средств. Мы можем перечислить деньги на кошельки Яндекс.Деньги, WebMoney или на счет мобильного телефона.</p>
				</div>
			</div>



		</div>

		
	</article>
</div>

	</div>
	<!--/Container-->

<?php 
$js_include = array('accord.js');
include('templates/footer.php');
?>