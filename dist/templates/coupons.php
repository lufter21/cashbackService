<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/header.php'; ?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp">
		<div class="col-3">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/sidebar.php'; ?>
		</div>
		<div class="col-9 p-0">
			<div class="row row_col-middle row_sm-x-nw">
				<div class="col">
					<h1 class="title"><?php echo $meta['title']; ?></h1>
				</div>

				<?php if ($type == 'discounts' && $content['coupons']) { ?>
					<div class="col col_right">
						<form id="sorting-form" action="/discounts<?php echo $alias ? '/' . $alias : ''; ?>" method="POST" class="form sorting-form">
							<div class="form__field">
								<select name="sorting" data-placeholder="Сортировать" data-submit-form-onchange="true">
									<option value="rating" <?php echo ($content['sorting'] == 'rating') ? 'selected' : ''; ?>>Самые популярные</option>
									<option value="biggest_discounts" <?php echo ($content['sorting'] == 'biggest_discounts') ? 'selected' : ''; ?>>Наибольшие скидки</option>
									<option value="newest" <?php echo ($content['sorting'] == 'newest') ? 'selected' : ''; ?>>Самые новые</option>
									<option value="expire_soon" <?php echo ($content['sorting'] == 'expire_soon') ? 'selected' : ''; ?>>Скоро заканчиваются</option>
								</select>
								<div class="field-error-tip">Select an animal</div>
							</div>
						</form>
					</div>
				<?php } ?>
			</div>

			<div class="row tile">
				<?php
				if ($content['coupons']) {
					foreach ($content['coupons'] as $item) {
						echo '<div class="col-4 md-col-6">';
						include $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/coupon-item.php';
						echo '</div>';
					}
				} else {
					echo '<div class="message col-12">На данный момент, в этом разделе нет купонов.</div>';
				}
				?>
			</div>
			<div class="row">
				<div class="col-12 p-x-0">
					<ul class="paginate">
						<?php echo $lemon->getPagenav(); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/footer.php'; ?>