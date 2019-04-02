<?php
$meta = array(
	'meta_title' => 'Скидки и промокоды от популярных интернет магазинов',
	'meta_description' => 'Используйте промокоды и покупайте со скидками в лучших интернет магазинах'
);

require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="main__full-page">
		<div id="main-slider" class="slider">
			<?php
			foreach ($content['coupons'] as $k => $item) {
				$title = (!empty($item['title_translated'])) ? $item['title_translated'] : $item['title'];
			?>
			<div class="slider__item slider__item_i<?php echo ++$k; ?>">
				<div class="row row_wrp">
					<div class="col-12">
						<div class="row row_col-middle row_nw">
							<?php if (!empty($item['discount'])) { ?>
							<div class="col pl-0">
								<div class="slider__discount">
									<?php echo $item['discount']; ?>
								</div>
							</div>
							<?php } ?>
							<div class="col">
								<div class="slider__logo">
									<img src="<?php echo $item['logo']; ?>" alt="shop logo">
								</div>
							</div>
						</div>
						<div class="slider__title">
							<?php echo $title; ?>
						</div>
						<a href="/coupon/<?php echo $item['id']; ?>" class="orange-btn">Получить промокод</a>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>