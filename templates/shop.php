<?php
if(!$meta){
	$meta = array(
		'name'=>$content['name'],
		'title'=>$content['name']
	);
}
include('header.php');
?>
<!--Container/-->
<div class="container wrap">
	<div class="content">
		<h1><?php echo $meta['name'];?></h1>
		<?php echo $content['description'];?>
		<p class="ta-c">
			<a rel="nofollow" href="/go/shop/<?php echo $content['id']; ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="blue-button" title="Перейти в <?php echo $content['name']; ?>">Перейти в магазин</a>
		</p>
		<h2>Категории товаров:</h2>
		<p><?php echo $content['category'];?></p>
		<h2>Кэшбэк <?php echo $content['cashback'];?>:</h2>
		<?php echo $content['cashback_details'];?>
		<p class="ta-c">
			<a rel="nofollow" href="/go/shop/<?php echo $content['id']; ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="blue-button" title="Перейти в <?php echo $content['name']; ?>">Перейти в магазин</a>
		</p>
	</div>
</div>
<!--/Container-->
<?php include('footer.php');?>