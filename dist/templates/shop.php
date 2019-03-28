<?php
$meta = array(
	'meta_title' => $content['name'] .' промокоды и скидки',
	'meta_description' => $content['description']
);

require_once $_SERVER['DOCUMENT_ROOT'] .'/functions/n2w.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp row_col-middle row_nw">
		<div class="col p-y-0">
			<div class="shop-logo">
				<img src="<?php echo $content['logo']; ?>" alt="<?php echo $content['name']; ?>" class="resp-img">
			</div>
		</div>
		<div class="col">
			<h1 class="title">Промокоды и скидки от магазина <?php echo $content['name'];?></h1>
		</div>
	</div>
	<div class="row row_wrp tile">
	<?php
	if (!empty($content['coupons'])) {
		$view_logo = false;
		foreach ($content['coupons'] as $item) {
			echo '<div class="col-3">';
			include $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/coupon-item.php';
			echo '</div>';
		}
	} else {
		echo '<div class="message">На данный момент, у этого магазина нет промокодов и скидок</div>';
	}
	?>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>