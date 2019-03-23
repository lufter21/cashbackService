<?php
if(!$meta){
	$meta = array(
		'name'=>'Все магазины',
		'title'=>'Каталог магазинов',
		'description'=>'Каталог магазинов для покупок с кэшбэком'
	);
}
include('header.php');
?>
<!--Container/-->
<div class="container wrap row vw1000-row-col">

	<div class="col-3">
		<aside class="sidebar">
			<div class="box vw1000-hide">
				<div class="pad">
					<div class="title js-add-button-to-accord" data-group="cat" data-index="0">Категории</div>
					<div class="js-add-content-to-accord" data-group="cat" data-index="0">
						<?php echo $lemon->getCategoryMenu(); ?>
					</div>
				</div>
			</div>
			<div class="js-create-accord" data-viewport-width="1000" data-group="cat"></div>
		</aside>
	</div>

	<div class="col-9 pad-0">

		<div class="pad mb-28">
			<div class="box">
				<div class="pad">
					<h1><?php echo $meta['name'];?></h1>
				</div>
			</div>
		</div>

		<div id="flex-wrap" class="flex-wrap">
			<?php
			if (!empty($content['shops'])) {
				foreach ($content['shops'] as $item) {
			?>	
					<div class="shop-item">
						<a href="/shop/<?php echo $item['alias']; ?>" title="Скидки от <?php echo $item['name']; ?>" class="inner">
							<span class="logo mid-image-wrap"><img src="<?php echo $item['logo']; ?>" alt="<?php echo $item['name']; ?>" class="mid-image"></span>
							<span class="shop-item__qnt"><?php echo $item['quantity']; ?> купонов</span>
						</a>
					</div>
			<?php	
				}
			}
			?>
		</div>

		<?php $pnav = $lemon->getPagenav();
		if (!empty($pnav)) { ?>
		<div class="pagination">
			<?php echo $pnav; ?>
		</div>
		<?php } ?>

	</div>

</div>
<!--/Container-->
<?php
$js_include = array('accord.js'); 
include('footer.php');
?>