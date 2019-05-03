<?php
if(empty($meta)){
	$meta = array(
		'meta_title' => 'Промокоды и скидки от лучших интернет магазинов',
		'title' => 'Промокоды и скидки',
		'meta_description' => 'Получите промокоды, акции и скидки от лучших интернет магазинов'
	);
}

require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp">
		<div class="col-3">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/sidebar.php'; ?>
		</div>
		<div class="col-9 p-0">
			<div class="row row_col-middle row_sm-x-nw">
				<div class="col">
					<h1 class="title"><?php echo $meta['title'];?></h1>
				</div>

				<?php if (!empty($content['coupons'])) { ?>
				<div class="col col_right">
					<form id="sorting-form" action="/coupons<?php echo (!empty($alias)) ? '/'.$alias : '';?>" method="POST" class="form sorting-form">
						<div class="form__field">
							<select name="sorting" data-placeholder="Сортировать" data-submit-form-onchange="true">
								<option value="rating" <?php if($content['sorting'] == 'rating'){echo 'selected';}?>>Самые популярные</option>
								<option value="biggest_discounts" <?php if($content['sorting'] == 'biggest_discounts'){echo 'selected';}?>>Наибольшие скидки</option>
								<option value="newest" <?php if($content['sorting'] == 'newest'){echo 'selected';}?>>Самые новые</option>
								<option value="expire_soon" <?php if($content['sorting'] == 'expire_soon'){echo 'selected';}?>>Скоро заканчиваются</option>
							</select>
							<div class="field-error-tip">Select an animal</div>
						</div>
					</form>
				</div>
				<?php } ?>
			</div>

			<div class="row tile">
			<?php
			if (!empty($content['coupons'])) {
				foreach ($content['coupons'] as $item) {
					echo '<div class="col-4 md-col-6">';
					include $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/coupon-item.php';
					echo '</div>';
				}
			} else {
				echo '<div class="message">На данный момент, в этом разделе нет акций и скидок</div>';
			}
			?>
			</div>
			<div class="row">
				<div class="col-12 p-x-0">
					<ul class="paginate">
					<?php echo $lemon -> getPagenav(); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>