<div class="col-9">
	<div class="box payment">

		<div class="pad content">
			<h1>Вывод средств <?php echo $user['name']; ?></h1>
			<div class="balance mb-35">
				<div class="balance__item c-l-green">
					<span>Доступно для вывода:</span><span class="balance__sum"><?php echo ($content['sum_approved']) ?: '0'; ?></span>
				</div>
				<div class="balance__item">
					<!--<a href="#" class="balance__button">Вывести</a>-->
				</div>
			</div>
			<h2>Доступные способы вывода:</h2>
			<ul>
				<li>Яндекс.Деньги (Российский рубль)</li>
				<li>WebMoney (Доллар США, российский рубль, украинская гривна, соответственно на Z, R и U -кошельки)</li>
				<li>Пополнение мобильного телефона (Российские и украинские операторы. Иностранная валюта по курсу, например: вывод долларов или рублей на номер украинского оператора)</li>
			</ul>

			<?php if ($content['sum_approved']) { ?>
			<h2>Закажите вывод средств</h2>
		</div>

		<form id="payment-form" action="/functions/payment.php" method="POST" class="form">
			<?php foreach ($content['sum_approved_arr'] as $key => $val) { ?>

			<?php if ($key == 'usd' && $val > 0) { ?>
			<div class="row">
				<div class="payment__val col-1">
					$
				</div>
				<div class="col-2">
					<div class="form__field">
						<label for="fp-usd-txt-1" class="overlabel">Сумма</label>
						<input id="fp-usd-txt-1" type="text" data-required="true" data-type="num" data-max-num="<?php echo $val; ?>" class="form__text-input" name="payment_usd" value="">
						<div class="form__error-tip" data-second-error-text="Некорректная сумма">Введите сумму</div>
					</div>
				</div>
				<div class="col-4-5">
					<div class="form__field">
						<div class="form__select">
							<button type="button" class="form__select-button">Способ вывода</button>
							<ul class="form__select-options">
								<li><button type="button" class="form__select-val" data-show-hidden="#requisites-usd-wm" data-value="WebMoney Z-кошелек">WebMoney Z-кошелек</button></li>
								<li><button type="button" class="form__select-val" data-show-hidden="#requisites-usd-tel" data-value="Мобильный телефон">Мобильный телефон (по курсу)</button></li>
							</ul>
							<input type="hidden" data-required="true" class="form__select-input" name="method_usd" value="">
						</div>
						<div class="form__error-tip">Выборите способ вывода</div>
					</div>
				</div>
				<div class="col-4-5 form__field-wrap">
					<div id="requisites-usd-wm" class="form__field form__field_hidden">
						<label for="fp-usd-txt-2-1" class="overlabel">WebMoney Z-кошелек</label>
						<input id="fp-usd-txt-2-1" type="text" data-type="wmz" data-required="true" class="form__text-input" name="requisites_usd[]" value="Z">
						<div class="form__error-tip" data-second-error-text="Некорректный Z-кошелек, формат: Z999999999999">Введите Z-кошелек</div>
					</div>
					<div id="requisites-usd-tel" class="form__field form__field_hidden">
						<label for="fp-usd-txt-2-2" class="overlabel">Номер телефона</label>
						<input id="fp-usd-txt-2-2" type="text" data-type="tel" data-required="true" class="form__text-input" name="requisites_usd[]" value="+">
						<div class="form__error-tip" data-second-error-text="Некорректный номер, формат: +кодНомер">Введите номер телефона</div>
					</div>
				</div>
			</div>
			<?php } ?>

			<?php if ($key == 'rub' && $val > 0) { ?>
			<div class="row">
				<div class="payment__val col-1">
					руб
				</div>
				<div class="col-2">
					<div class="form__field">
						<label for="fp-rub-txt-1" class="overlabel">Сумма</label>
						<input id="fp-rub-txt-1" type="text" data-required="true" data-type="num" data-max-num="<?php echo $val; ?>" class="form__text-input" name="payment_rub" value="">
					</div>
				</div>
				<div class="col-4-5">
					<div class="form__field">
						<div class="form__select">
							<button type="button" class="form__select-button">Способ вывода</button>
							<ul class="form__select-options">
								<li><button type="button" class="form__select-val" data-show-hidden="#requisites-rub, R-кошелек (R.....), wmr" data-value="WebMoney R-кошелек">WebMoney R-кошелек</button></li>
								<li><button type="button" class="form__select-val" data-show-hidden="#requisites-rub, Кошелек Яндекс.Деньги, yam" data-value="Яндекс.Деньги">Яндекс.Деньги</button></li>
								<li><button type="button" class="form__select-val" data-show-hidden="#requisites-rub, Номер телефона (+.....), tel" data-value="Мобильный телефон">Мобильный телефон</button></li>
							</ul>
							<input type="hidden" data-required="true" class="form__select-input" name="method_rub" value="">
						</div>
					</div>
				</div>
				<div class="col-4-5">
					<div id="requisites-rub" class="form__field form__field_hidden">
						<label for="fp-rub-txt-2" class="overlabel"></label>
						<input id="fp-rub-txt-2" type="text" data-required="true" class="form__text-input" name="requisites_rub" value="">
					</div>
				</div>
			</div>
			<input type="hidden" name="currensy[]" value="rub">
			<?php } ?>

			<?php if ($key == 'uah' && $val > 0) { ?>
			<div class="row">
				<div class="payment__val col-1">
					грн
				</div>
				<div class="col-2">
					<div class="form__field">
						<label for="fp-uah-txt-1" class="overlabel">Сумма</label>
						<input id="fp-uah-txt-1" type="text" data-required="true" data-type="num" data-max-num="<?php echo $val; ?>" class="form__text-input" name="payment_uah" value="">
					</div>
				</div>
				<div class="col-4-5">
					<div class="form__field">
						<div class="form__select">
							<button type="button" class="form__select-button">Способ вывода</button>
							<ul class="form__select-options">
								<li><button type="button" class="form__select-val" data-show-hidden="#requisites-uah, U-кошелек (U.....), wmu" data-value="WebMoney U-кошелек">WebMoney U-кошелек</button></li>
								<li><button type="button" class="form__select-val" data-show-hidden="#requisites-uah, Номер телефона (+.....), tel" data-value="Мобильный телефон">Мобильный телефон</button></li>
							</ul>
							<input type="hidden" data-required="true" class="form__select-input" name="method_uah" value="">
						</div>
					</div>
				</div>
				<div class="col-4-5">
					<div id="requisites-uah" class="form__field form__field_hidden">
						<label for="fp-uah-txt-2" class="overlabel"></label>
						<input id="fp-uah-txt-2" type="text" data-required="true" class="form__text-input" name="requisites_uah" value="">
					</div>
				</div>
			</div>
			<input type="hidden" name="currensy[]" value="uah">
			<?php } ?>

			<?php } ?>

			<div class="row">
				<div class="col-4-5 col-offset-3 mt-14">
					<button type="submit" class="form__button">Вывести</button>
				</div>
			</div>
		</form>
		<?php } ?>

	</div>
</div>