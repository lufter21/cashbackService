<?php
$meta = array(
	'meta_title' => $content['title'],
	'meta_description' => $content['description']
);

require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp">
		<main class="col-12">
			<article class="coupon">
				<div class="row row_nw">
					<div class="col">
						<h1 class="title"><?php echo $content['title'];?></h1>
					</div>
					<div class="col col_right p-y-0">
						<a href="/shop/<?php echo $content['shop']['alias']; ?>" class="coupon__shop-logo"><img src="<?php echo $content['shop']['logo']; ?>" alt="<?php echo $content['shop']['name']; ?>" title="Скидки от <?php echo $content['shop']['name']; ?>"></a>
					</div>
				</div>

				<div class="row">
					<div class="article col-12">
						<?php if ($content['description']) { ?>
						<p>
							<?php echo $content['description']; ?>
						</p>
						<?php } ?>
						<p>
							Категории: <span class="c-gray"><?php echo $content['category']; ?></span>
						</p>
					</div>
				</div>
				
				<div class="row row_nw row_col-middle">
					<div class="col">
						<?php if ($content['promocode'] == 'Не нужен' || empty($content['promocode'])) { ?>
						<span class="c-orange">Вводить промокод не требуется. Скидка засчитывается автоматически.</span>
						<?php } else { ?>
							<span class="c-orange">При оформлении заказа требуется ввести промокод:</span> <span class="coupon__promocode"><?php echo $content['promocode']; ?></span>
						<?php } ?>
					</div>
					<div class="col col_right">
						<a href="<?php echo $content['gotolink']; ?>" target="_blank" class="green-btn">Перейти в магазин</a>
					</div>
				</div>
			</article>
		</main>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>