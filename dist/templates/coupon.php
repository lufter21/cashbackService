<?php
$title = (!empty($content['title_translated'])) ? $content['title_translated'] : $content['title'];
$description = (!empty($content['description_translated'])) ? $content['description_translated'] : $content['description'];

$meta = array(
	'meta_title' => $title,
	'meta_description' => $description
);

require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp">
		<main class="col-12">
			<article class="coupon">
				<?php if (!empty($content['discount'])) { ?>
				<div class="row row_col-middle row_nw">
					<div class="col">
						<div class="coupon__discount">
							<?php echo $content['discount']; ?>
						</div>
					</div>
					<div class="col col_right">
						<a href="/shop/<?php echo $content['shop']['alias']; ?>" class="coupon__shop-logo"><img src="<?php echo $content['shop']['logo']; ?>" alt="<?php echo $content['shop']['name']; ?>" title="Скидки от <?php echo $content['shop']['name']; ?>"></a>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<h1 class="title"><?php echo $title; ?></h1>
					</div>
				</div>
				<?php } else { ?>
				<div class="row row_col-middle row_sm-x-nw">
					<div class="col">
						<h1 class="title"><?php echo $title; ?></h1>
					</div>
					<div class="col col_right xs-col-first">
						<a href="/shop/<?php echo $content['shop']['alias']; ?>" class="coupon__shop-logo"><img src="<?php echo $content['shop']['logo']; ?>" alt="<?php echo $content['shop']['name']; ?>" title="Скидки от <?php echo $content['shop']['name']; ?>"></a>
					</div>
				</div>
				<?php } ?>

				<div class="row">
					<div class="article col-12">
						<?php if (!empty($description)) { ?>
						<p>
							<?php echo $description; ?>
						</p>
						<?php } ?>
						<p>
							Категории: <span class="c-gray fs-14"><?php echo $content['category']; ?></span>
						</p>
					</div>
				</div>
				
				<div class="row row_col-middle">
					<div class="col lh-1_5">
						<?php if ($content['promocode'] == 'Не нужен' || empty($content['promocode'])) { ?>
						<span class="c-orange">Вводить промокод не требуется. Скидка засчитывается автоматически.</span>
						<?php } else { ?>
							<span class="c-orange">При оформлении заказа требуется ввести промокод:</span> <span class="coupon__promocode"><?php echo $content['promocode']; ?></span>
						<?php } ?>
					</div>
					<div class="col col_right">
						<a href="/go/<?php echo $content['id']; ?>" target="_blank" class="green-btn">Перейти в магазин</a>
					</div>
				</div>
			</article>
		</main>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>