<?php
if(!$meta){
	$meta = array(
		'name'=>$content['name'],
		'title'=>$content['name'],
		'description'=>$content['category']
	);
}
include('header.php');
?>
<!--Container/-->
<div class="container wrap row vw1000-row-col">
	<div class="col-3">
		<div class="shop-item shop-item_sng">
			<div class="inner">
				<div class="logo mid-image-wrap">
					<img src="/images/logo/<?php echo $content['alias']; ?>.png" alt="<?php echo $content['name']; ?>" class="mid-image">
				</div>
				<div class="cashback"><span><?php echo $content['cashback'];?></span></div>
				<a rel="nofollow" href="/go/shop/<?php echo $content['id']; ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="shop-item__button" title="Перейти в <?php echo $content['name']; ?>">В магазин</a>
			</div>
		</div>
	</div>
	<div class="col-9">
		<div class="box min-h-272">
			<div class="content pad">
				<h1><?php echo $meta['name'];?></h1>
				<?php echo $content['cashback_details'];?>
				<p>
					<span class="c-d-gray">Категории товаров:</span> <?php echo $content['category'];?>
				</p>
			</div>
		</div>
	</div>
</div>
<!--/Container-->
<?php include('footer.php');?>