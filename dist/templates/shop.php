<?php
$meta = array(
	'title' => 'Cкидки и подарки от ' . $content['name'],
	'meta_title' => $content['name'] . ' скидки, подарки, бесплатная доставка',
	'meta_description' => $content['description']
);

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/n2w.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp row_col-middle row_sm-x-nw">
		<div class="col p-y-0">
			<div class="shop-logo">
				<img src="/static/images/logos/<?php echo $content['logo']; ?>" alt="<?php echo $content['name']; ?>" class="resp-img">
			</div>
		</div>
		<div class="col">
			<h1 class="title"><?php echo $meta['title']; ?></h1>
		</div>
	</div>
	<div class="row row_wrp">
		<div class="col-12 shop-cats">
			<?php echo $content['category']; ?>
		</div>
	</div>
	<div class="row row_wrp tile">
		<?php
		if (!empty($content['coupons'])) {
			$view_logo = false;

			foreach ($content['coupons'] as $item) {
				echo '<div class="col-3 md-col-4 sm-col-6">';
				include $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/coupon-item.php';
				echo '</div>';
			}
		} else {
			echo '<div class="message">На данный момент, у этого магазина нет промокодов и скидок</div>';
		}
		?>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/footer.php'; ?>