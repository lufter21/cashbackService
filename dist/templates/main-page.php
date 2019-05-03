<?php
$meta = array(
	'meta_title' => 'Скидки и промокоды от популярных интернет магазинов',
	'meta_description' => 'Используйте промокоды и покупайте со скидками в лучших интернет магазинах'
);

$header_class = 'header_bg';

require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="main__full-page">
		<div id="main-slider" class="slider">
			<?php
			foreach ($content['coupons'] as $k => $item) {
				$title = $item['title_translated'] ?: $item['title'];
				$description = $item['description_translated'] ?: $item['description'];
				
				if (mb_strlen($description) > 175) {
					$description = mb_substr($description, 0, 175) . '...';
				}
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
									<img src="/static/images/logos/<?php echo $item['logo']; ?>" alt="shop logo">
								</div>
							</div>
						</div>
						<div class="slider__title">
							<?php echo $title; ?>
						</div>
						
						<?php if ($description) { ?>
						<div class="slider__desc">
							<?php echo $description; ?>
						</div>
						<?php } ?>

						<div class="mt-45">
							<a href="/coupon/<?php echo $item['id']; ?>" class="orange-btn">Получить промокод</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>