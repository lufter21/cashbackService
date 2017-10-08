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
<div class="container wrap">

<div id="js-sidebar" class="container__sidebar">
	<aside class="sidebar">
		<div class="title">Категории</div>
		<?php echo $lemon->getCategoryMenu(); ?>
	</aside>
</div>

<div class="container__content">
	<div class="content-head">
		<article class="meta-block">
			<h1><?php echo $meta['name'];?></h1>
			<div class="text-block">
				<?php echo $meta['text'];?>
			</div>
		</article>
	</div>
	<div id="flex-wrap" class="flex-wrap">
	<?php
	if(!empty($content['shops'])){
		foreach($content['shops'] as $item){
	?>	
		<div class="shop-item">
			<div class="inner">
				<div class="logo">
					<a href="/shop/<?php echo $item['alias'];?>" title="Подробнее о <?php echo $item['name']; ?>"><img src="/images/logo/<?php echo $item['alias']; ?>.png" alt="<?php echo $item['name']; ?>"></a>
				</div>
				<!-- div class="title"><?php echo $item['name']; ?></div -->
				<?php
					/*cashback*/
					if(!empty($item['cashback'])){
						echo '<div class="cashback"><span>'.$item['cashback'].'</span></div>';
					}
				?>
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