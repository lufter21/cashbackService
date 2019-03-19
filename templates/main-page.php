<?php
$meta = array(
	'title' => 'Cамый большой процент кэшбэка у нас!', 
	'description' => 'Возвращаем деньги за совершенные вами покупки в интернет-магазинах. У нас самый большой процент кэшбэка.'
	);
include('header.php');
?>

<div class="promo">
	<div class="wrap">
		<div class="pad">
			<h1 class="promo__tit">
				У нас<br> cамый большой<br> процент кэшбэка!
			</h1>
			<div class="promo__shops row vw1000-row-col">

				<div class="promo__shops-item col-3 row-col-mid">
					<div class="promo__shops-logo col-6">
						<div class="mid-image-wrap">
							<img src="images/logo/aliexpress.png" alt="aliexpress" class="mid-image">
						</div>
					</div>
					<div class="promo__shops-desc col-6">
						<p class="another">до 3%</p>
						<p class="we">до 4,5%</p>
					</div>
				</div>

				<div class="promo__shops-item col-3 row-col-mid">
					<div class="promo__shops-logo col-6">
						<div class="mid-image-wrap">
							<img src="images/logo/gearbest.png" alt="gearbest" class="mid-image">
						</div>
					</div>
					<div class="promo__shops-desc col-6">
						<p class="another">5%</p>
						<p class="we">до 48,5%</p>
					</div>
				</div>

				<div class="promo__shops-item col-3 row-col-mid">
					<div class="promo__shops-logo col-6">
						<div class="mid-image-wrap">
							<img src="images/logo/geekbuying.png" alt="geekbuying" class="mid-image">
						</div>
					</div>
					<div class="promo__shops-desc col-6">
						<p class="another">до 4%</p>
						<p class="we">до 6,5%</p>
					</div>
				</div>

				<div class="promo__shops-item col-3 row-col-mid">
					<div class="promo__shops-logo col-6">
						<div class="mid-image-wrap">
							<img src="images/logo/banggood.png" alt="banggood" class="mid-image">
						</div>
					</div>
					<div class="promo__shops-desc col-6">
						<p class="another">3%</p>
						<p class="we">4,5%</p>
					</div>
				</div>

				<div class="promo__note">
					<p>
						<span class="square red"></span><span> - прочие кэшбэк сервисы</span>
					</p>
					<p>
						<span class="square grn"></span><span> - BomBonus.dealersAir</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Container/-->
<div class="container-p4 wrap">
	<h2 class="title-t2 pad">
		Новые купоны и скидки
	</h2>
	<div id="flex-wrap" class="flex-wrap">
		<?php
		if(!empty($content['shops'])){
			foreach($content['shops'] as $item){
		?>	
		
		<?php	
			}
		}
		?>
	</div>

	<div class="ta-c pt-20 pad">
		<a href="/coupons" class="button">Все купоны и скидки</a>
	</div>
	
</div>
<!--/Container-->

<?php include('footer.php');?>