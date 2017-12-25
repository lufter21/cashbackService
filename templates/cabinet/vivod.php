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
		</div>

		<?php if ($content['sum_approved']) { ?>
		<div class="pad content">
			<h2>Закажите вывод средств</h2>
		</div>

		<form id="payment-form" action="/functions/payment.php" method="POST" class="form">

			<div class="row">
				<div class="col-4-5 col-offset-3">
					<div class="form__field">
						<div class="form__select">
							<button type="button" class="form__select-button">Выберите валюту</button>
							<ul class="form__select-options">
								<?php foreach ($content['sum_approved_arr'] as $key => $val) { ?>

								<?php if ($key == 'usd' && $val > 0) { ?>
								<li><button type="button" class="form__select-val" data-show-hidden="#cur-usd-fieldset" data-value="usd">Американский доллар</button></li>
								<?php } ?>

								<?php if ($key == 'rub' && $val > 0) { ?>
								<li><button type="button" class="form__select-val" data-show-hidden="#cur-rub-fieldset" data-value="rub">Российский рубль</button></li>
								<?php } ?>

								<?php if ($key == 'uah' && $val > 0) { ?>
								<li><button type="button" class="form__select-val" data-show-hidden="#cur-uah-fieldset" data-value="uah">Украинская гривна</button></li>
								<?php } ?>

								<?php } ?>
							</ul>
							<input type="hidden" data-required="true" class="form__select-input" name="currency" value="">
						</div>
						<div class="form__error-tip">Выберите валюту</div>
					</div>
				</div>
			</div>

			<div class="form__fieldset-wrap">

				<?php foreach ($content['sum_approved_arr'] as $key => $val) { ?>

				<?php if ($key == 'usd' && $val > 0) { ?>
				<div id="cur-usd-fieldset" class="form__fieldset form__fieldset_hidden">
					<div class="row">
						<div class="payment__val col-1">
							$
						</div>
						<div class="col-2">
							<div class="form__field">
								<label for="fp-usd-txt-1" class="overlabel">Сумма</label>
								<input id="fp-usd-txt-1" type="text" data-required="true" data-type="num" data-max-num="<?php echo $val; ?>" class="form__text-input" name="payment_usd" value="">
								<div class="form__error-tip" data-second-error-text="Некорректная сумма" data-third-error-text="Недостаточно средств">Введите сумму</div>
							</div>
						</div>
						<div class="col-4-5">
							<div class="form__field">
								<div class="form__select">
									<button type="button" class="form__select-button">Способ вывода</button>
									<ul class="form__select-options">
										<li><button type="button" class="form__select-val" data-show-hidden="#requisites-usd-wm" data-value="wmz">WebMoney Z-кошелек</button></li>
										<li><button type="button" class="form__select-val" data-show-hidden="#requisites-usd-tel" data-value="tel">Мобильный телефон (по курсу)</button></li>
									</ul>
									<input type="hidden" data-required="true" class="form__select-input" name="method_usd" value="">
								</div>
								<div class="form__error-tip">Выберите способ вывода</div>
							</div>
						</div>
						<div class="col-4-5 form__field-wrap">
							<div id="requisites-usd-wm" class="form__field form__field_hidden">
								<label for="fp-usd-txt-2-1" class="overlabel">WebMoney Z-кошелек</label>
								<input id="fp-usd-txt-2-1" type="text" data-type="wmz" data-required="true" class="form__text-input" name="requisites_usd_wmz" value="Z">
								<div class="form__error-tip" data-second-error-text="Некорректный Z-кошелек, формат: Z999999999999">Введите Z-кошелек</div>
							</div>
							<div id="requisites-usd-tel" class="form__field form__field_hidden">
								<label for="fp-usd-txt-2-2" class="overlabel">Номер телефона</label>
								<input id="fp-usd-txt-2-2" type="text" data-type="tel" data-required="true" class="form__text-input" name="requisites_usd_tel" value="+">
								<div class="form__error-tip" data-second-error-text="Некорректный номер, формат: +кодНомер">Введите номер телефона</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if ($key == 'rub' && $val > 0) { ?>
				<div id="cur-rub-fieldset" class="form__fieldset form__fieldset_hidden">
					<div class="row">
						<div class="payment__val col-1">
							руб
						</div>
						<div class="col-2">
							<div class="form__field">
								<label for="fp-rub-txt-1" class="overlabel">Сумма</label>
								<input id="fp-rub-txt-1" type="text" data-required="true" data-type="num" data-max-num="<?php echo $val; ?>" class="form__text-input" name="payment_rub" value="">
								<div class="form__error-tip" data-second-error-text="Некорректная сумма" data-third-error-text="Недостаточно средств">Введите сумму</div>
							</div>
						</div>
						<div class="col-4-5">
							<div class="form__field">
								<div class="form__select">
									<button type="button" class="form__select-button">Способ вывода</button>
									<ul class="form__select-options">
										<li><button type="button" class="form__select-val" data-show-hidden="#requisites-rub-wm" data-value="wmr">WebMoney R-кошелек</button></li>
										<li><button type="button" class="form__select-val" data-show-hidden="#requisites-rub-yam" data-value="yam">Яндекс.Деньги</button></li>
										<li><button type="button" class="form__select-val" data-show-hidden="#requisites-rub-tel" data-value="tel">Мобильный телефон</button></li>
									</ul>
									<input type="hidden" data-required="true" class="form__select-input" name="method_rub" value="">
								</div>
								<div class="form__error-tip">Выберите способ вывода</div>
							</div>
						</div>
						<div class="col-4-5 form__field-wrap">
							<div id="requisites-rub-wm" class="form__field form__field_hidden">
								<label for="fp-rub-txt-2-1" class="overlabel">WebMoney R-кошелек</label>
								<input id="fp-rub-txt-2-1" type="text" data-type="wmr" data-required="true" class="form__text-input" name="requisites_rub_wmr" value="R">
								<div class="form__error-tip" data-second-error-text="Некорректный R-кошелек, формат: R999999999999">Введите R-кошелек</div>
							</div>
							<div id="requisites-rub-yam" class="form__field form__field_hidden">
								<label for="fp-rub-txt-2-2" class="overlabel">Кошелек Яндекс.Деньги</label>
								<input id="fp-rub-txt-2-2" type="text" data-type="yam" data-required="true" class="form__text-input" name="requisites_rub_yam" value="">
								<div class="form__error-tip" data-second-error-text="Некорректный кошелек, формат: 999999999999999">Введите кошелек Яндекс.Деньги</div>
							</div>
							<div id="requisites-rub-tel" class="form__field form__field_hidden">
								<label for="fp-rub-txt-2-3" class="overlabel">Номер телефона</label>
								<input id="fp-rub-txt-2-3" type="text" data-type="tel" data-required="true" class="form__text-input" name="requisites_rub_tel" value="+">
								<div class="form__error-tip" data-second-error-text="Некорректный номер, формат: +кодНомер">Введите номер телефона</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if ($key == 'uah' && $val > 0) { ?>
				<div id="cur-uah-fieldset" class="form__fieldset form__fieldset_hidden">
					<div class="row">
						<div class="payment__val col-1">
							грн
						</div>
						<div class="col-2">
							<div class="form__field">
								<label for="fp-uah-txt-1" class="overlabel">Сумма</label>
								<input id="fp-uah-txt-1" type="text" data-required="true" data-type="num" data-max-num="<?php echo $val; ?>" class="form__text-input" name="payment_uah" value="">
								<div class="form__error-tip" data-second-error-text="Некорректная сумма" data-third-error-text="Недостаточно средств">Введите сумму</div>
							</div>
						</div>
						<div class="col-4-5">
							<div class="form__field">
								<div class="form__select">
									<button type="button" class="form__select-button">Способ вывода</button>
									<ul class="form__select-options">
										<li><button type="button" class="form__select-val" data-show-hidden="#requisites-uah-wm" data-value="wmu">WebMoney U-кошелек</button></li>
										<li><button type="button" class="form__select-val" data-show-hidden="#requisites-uah-tel" data-value="tel">Мобильный телефон</button></li>
									</ul>
									<input type="hidden" data-required="true" class="form__select-input" name="method_uah" value="">
								</div>
								<div class="form__error-tip">Выберите способ вывода</div>
							</div>
						</div>
						<div class="col-4-5 form__field-wrap">
							<div id="requisites-uah-wm" class="form__field form__field_hidden">
								<label for="fp-uah-txt-2-1" class="overlabel">WebMoney U-кошелек</label>
								<input id="fp-uah-txt-2-1" type="text" data-type="wmu" data-required="true" class="form__text-input" name="requisites_uah_wmu" value="U">
								<div class="form__error-tip" data-second-error-text="Некорректный U-кошелек, формат: U999999999999">Введите U-кошелек</div>
							</div>
							<div id="requisites-uah-tel" class="form__field form__field_hidden">
								<label for="fp-uah-txt-2-2" class="overlabel">Номер телефона</label>
								<input id="fp-uah-txt-2-2" type="text" data-type="tel" data-required="true" class="form__text-input" name="requisites_uah_tel" value="+">
								<div class="form__error-tip" data-second-error-text="Некорректный номер, формат: +кодНомер">Введите номер телефона</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php } ?>

			</div>

			<div class="row">
				<div class="col-4-5 col-offset-3 mt-14">
					<button type="submit" class="form__button">Вывести</button>
				</div>
			</div>
		</form>
		<?php } ?>

	</div>
</div>