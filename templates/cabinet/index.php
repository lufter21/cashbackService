<?php require_once('functions/mod-date.php'); ?>

<div class="col-9">
	<div class="box">
		<div class="pad content">
			<h1><?php echo $user['name']; ?></h1>

			<div class="balance mb-35">
				<div class="balance__item">
					<span>Ожидает&nbsp;подтверждения:</span><span class="balance__sum"><?php echo ($content['sum_open']) ?: '0'; ?></span>
				</div>

				<div class="balance__item c-l-green">
					<span>Доступно для вывода:</span><span class="balance__sum"><?php echo (!empty($content['sum_approved'])) ? $content['sum_approved'] : '0'; ?></span>
				</div>
				<div class="balance__item">
					<!--<a href="#" class="balance__button">Вывести</a>-->
				</div>
			</div>

			<?php
			if(!empty($content['stat'])){ ?>
			<h2>Ваши заказы:</h2>
			<div class="orders">
				<div class="orders__head row">
					<div class="col-6">
						Заказ
					</div>
					<div class="col-3 ta-c">
						Магазин
					</div>
					<div class="col-3 ta-r">
						Кэшбэк
					</div>
				</div>

				<?php foreach ($content['stat'] as $value) { ?>

				<div class="orders__date">
					<?php echo mod_date($value['date']); ?>
				</div>

				<?php foreach (json_decode($value['data']) as $val) { ?>

				<div class="orders__item row-col-mid">
					<div class="col-6 row-col-mid row-col-pad-0">
						<div class="col-4">
							<img src="<?php echo $val->product_image; ?>" alt="order">
						</div>
						<div class="col-8">
							<div class="orders__tit">
								<?php echo $val->product_name; ?>
							</div>
							<div class="orders__price">
								<?php echo $val->price; ?>
							</div>
						</div>
					</div>
					<div class="orders__shop col-3">
						<?php echo $val->shop_name; ?>
					</div>
					<div class="orders__cashback <?php echo 'orders__cashback_'.$val->status; ?> col-3">
						<?php echo $val->cashback; ?>
					</div>
				</div>

				<?php } } ?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>