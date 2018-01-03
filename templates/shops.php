<?php
if(!$meta){
	$meta = array(
		'name'=>'Все магазины',
		'title'=>'Каталог магазинов'
	);
}
include('header.php');
?>
<!--Container/-->
<div class="container wrap row vw1000-row-col">

	<div class="col-3">
		<aside class="sidebar box">
			<div class="pad">
				<div class="title">Категории</div>
				<?php echo $lemon->getCategoryMenu(); ?>
			</div>
		</aside>
	</div>

	<div class="col-9 pad-0">

		<div class="pad mb-28">
			<div class="box">
				<article class="pad">
					<h1><?php echo $meta['name'];?></h1>
					<div class="article-block pad">
						<?php echo $meta['text'];?>
					</div>
				</article>
			</div>
		</div>

		<div id="flex-wrap" class="flex-wrap">
			<?php
			if(!empty($content['shops'])){
				foreach($content['shops'] as $item){
					?>	
					<div class="shop-item">
						<div class="inner">
							<div class="logo mid-image-wrap">
								<a href="/shop/<?php echo $item['alias'];?>" title="Подробнее о <?php echo $item['name']; ?>"><img src="/images/logo/<?php echo $item['alias']; ?>.png" alt="<?php echo $item['name']; ?>" class="mid-image"></a>
							</div>
							<div class="cashback"><span><?php echo $item['cashback']; ?></span></div>
							<a rel="nofollow" href="/go/shop/<?php echo $item['id']; ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="button" title="Перейти в <?php echo $item['name']; ?>">В магазин</a>

							<a href="/shop/<?php echo $item['alias'];?>" class="more" title="Подробнее о <?php echo $item['name']; ?>">Подробнее</a>
						</div>
					</div>
					<?php	
				}
			}
			?>
		</div>
		<div class="pagination">
			<?php echo $lemon->getPagenav(); ?>
		</div>
	</div>

</div>
<!--/Container-->
<?php include('footer.php');?>