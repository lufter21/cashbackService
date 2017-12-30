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
<div class="container wrap row">

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
							<p>Кэшбэк начисляется в течении от 15 минут до нескольких дней и зависит от скорости предоставления информации магазином. Всю статистику вы можете просмотреть в личном кабинете.</p>
						</div>
					</div>

					<div class="accord__item">
						<button class="faq__quest accord__button">Когда кэшбэк будет доступным для вывода?<span></span></button>
						<div class="faq__answ accord__content">
							<p>Кэшбэк станет доступным для вывода, когда магазин подтвердит его. Среднее время подтверждения 30 дней. Это время необходимо магазину, чтоб убедиться, что заказ был доставлен вам, и вы его не вернете.</p>
						</div>
					</div>

					<div class="accord__item">
						<button class="faq__quest accord__button">Как вывести деньги?<span></span></button>
						<div class="faq__answ accord__content">
							<p>Зайдите в личный кабинет и закажите вывод средств. Мы можем перечислить деньги на кошельки Яндекс.Деньги, WebMoney, или на счет мобильного телефона.</p>
						</div>
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