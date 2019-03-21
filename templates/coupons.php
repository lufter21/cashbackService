<?php
if(empty($meta)){
	$meta = array(
		'title'=>'Скидки и промокоды от лучших интернет магазинов',
		'name'=>'Скидки/промокоды',
		'description'=>'Совместно с кэшбэком вы также можете получить дополнительную скидку'
	);
}
include $_SERVER['DOCUMENT_ROOT'] .'/templates/header.php';
?>
<!--Container/-->
<div class="container wrap row vw1000-row-col">

	<div class="col-3">
		<aside id="js-sidebar" class="sidebar box">
			<div class="pad">
				<div class="title">Категории</div>
				<?php echo $lemon->getCategoryMenu(); ?>
			</div>
		</aside>
	</div>

	<div class="col-9 pad-0">

		<div class="pad mb-28">
			<div class="box">
				<div class="row-col-mid">
					<div class="col-9">
						<h1><?php echo $meta['name'];?></h1>
					</div>

					<?php
					if(!empty($content['coupons'])){
						?>
						<div class="sorting-block col-3">
							<form id="sorting-form" action="/coupons<?php echo (!empty($alias)) ? '/'.$alias : '';?>" method="POST">
								<select name="sorting">
									<option value=" ORDER BY discount_abs DESC" <?php if($content['sorting'] == ' ORDER BY discount_abs DESC'){echo 'selected';}?>>Наибольшие скидки</option>
									<option value=" ORDER BY date_start DESC" <?php if($content['sorting'] == ' ORDER BY date_start DESC'){echo 'selected';}?>>Самые новые</option>
									<option value=" ORDER BY date_end ASC" <?php if($content['sorting'] == ' ORDER BY date_end ASC'){echo 'selected';}?>>Скоро заканчиваются</option>
								</select>
							</form>
						</div>
						<?php
					}
					?>

				</div>
			</div>
		</div>
		
		<div id="flex-wrap" class="flex-wrap">
			<?php
			if (!empty($content['coupons'])) {
				foreach ($content['coupons'] as $item) {
					include $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/coupon-item.php';
				}
			} else {
				echo '<div class="message">На данный момент, в этом разделе нет акций и скидок</div>';
			}
			?>
		</div>
		
		<div class="pagination">
			<?php echo $lemon -> getPagenav(); ?>
		</div>
		
	</div>

</div>
<!--/Container-->

<?php include $_SERVER['DOCUMENT_ROOT'] .'/templates/footer.php'; ?>