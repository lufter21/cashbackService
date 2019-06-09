<?php
$until = '';
$d_sec = 0;
$end = true;
$expired = false;

if ($content['date_end'] != 0) {
	$d_sec = strtotime($content['date_end']) - time();
} else {
	$end = false;
}

if ($end) {
	if ($d_sec > 0) {
		$days = floor($d_sec / 86400);
		$d_sec = $d_sec - ($days * 86400);
		$hours = floor($d_sec / 3600);
		$d_sec = $d_sec - ($hours * 3600);
		$minutes = floor($d_sec / 60);

		if ($days > 0) {
			$until .= $days . 'д. ';
		}

		if ($hours > 0) {
			if ($hours < 10) {
				$until .= '0' . $hours . 'ч. ';
			} else {
				$until .= $hours . 'ч. ';
			}
		}

		if ($minutes < 10) {
			$until .= '0' . $minutes . 'мин.';
		} else {
			$until .= $minutes . 'мин.';
		}
	} else {
		$until .= 'Купон просрочен';
		$expired = true;
	}
} else {
	$until .= 'Не установлен';
}

$title = (!empty($content['title_translated'])) ? $content['title_translated'] : $content['title'];
$description = (!empty($content['description_translated'])) ? $content['description_translated'] : $content['description'];

$meta = array(
	'meta_title' => $title,
	'meta_description' => $description
);

require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp">
		<main class="col-12">
			<article class="coupon">
				<?php if ($content['discount']) { ?>
					<div class="row row_col-middle row_nw">
						<div class="col">
							<div class="coupon__discount">
								<?php echo $content['discount']; ?>
							</div>
						</div>
						<div class="col col_right">
							<a href="/shop/<?php echo $content['shop']['alias']; ?>" class="coupon__shop-logo"><img src="/static/images/logos/<?php echo $content['shop']['logo']; ?>" alt="<?php echo $content['shop']['name']; ?>" title="Скидки от <?php echo $content['shop']['name']; ?>"></a>
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
							<a href="/shop/<?php echo $content['shop']['alias']; ?>" class="coupon__shop-logo"><img src="/static/images/logos/<?php echo $content['shop']['logo']; ?>" alt="<?php echo $content['shop']['name']; ?>" title="Скидки от <?php echo $content['shop']['name']; ?>"></a>
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
							Категории: <span class="c-gray"><?php echo $content['category']; ?></span>
						</p>

						<?php if ($expired) { ?>
							<p class="until-icon bold">
								<?php echo $until; ?>
							</p>
						<?php } elseif ($end) { ?>
							<p class="until-icon">
								Срок действия купона истекает через: <span class="c-gray"><?php echo $until; ?></span>
							</p>
						<?php } else { ?>
							<p class="until-icon fs-14">
								Срок действия купона не установлен. <span class="c-gray">Это означает, что купон может быть удален в любой момент, когда закончится акционный товар или изменится политика магазина.</span>
							</p>
						<?php } ?>

					</div>
				</div>

				<?php if (!$expired) { ?>
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
				<?php } ?>
			</article>
		</main>
	</div>
	<?php if ($content['similar']) { ?>
		<div class="row row_wrp mt-45">
			<div class="col-12">
				<div class="title title_h2">
					Смотрите также:
				</div>
			</div>
		</div>
		<div class="row row_wrp tile">
			<?php
			foreach ($content['similar'] as $item) {
				echo '<div class="col-3 md-col-4">';
				include $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/coupon-item.php';
				echo '</div>';
			}
			?>
		</div>
	<?php } ?>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/footer.php'; ?>