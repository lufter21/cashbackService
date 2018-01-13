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
		Популярные магазины
	</h2>
	<div id="flex-wrap" class="flex-wrap">
		<?php
		if(!empty($content['shops'])){
			foreach($content['shops'] as $item){
				?>	
				<div class="shop-item shop-item_w">
					<div class="inner">
						<div class="logo mid-image-wrap">
							<a href="/shop/<?php echo $item['alias'];?>" title="Подробнее о <?php echo $item['name']; ?>"><img src="/images/logo/<?php echo $item['alias']; ?>.png" alt="<?php echo $item['name']; ?>" class="mid-image"></a>
						</div>
						<div class="cashback"><span><?php echo $item['cashback']; ?></span></div>
						<a rel="nofollow" href="/go/shop/<?php echo $item['id']; ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="shop-item__button" title="Перейти в <?php echo $item['name']; ?>">В магазин</a>

						<a href="/shop/<?php echo $item['alias'];?>" class="more" title="Подробнее о <?php echo $item['name']; ?>">Подробнее</a>
					</div>
				</div>
				<?php	
			}
		}
		?>
	</div>

	<div class="ta-c pt-20 pad">
		<a href="/shops" class="button">Все магазины</a>
	</div>
	
</div>
<!--/Container-->

<?php include('footer.php');?>