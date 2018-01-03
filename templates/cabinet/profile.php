<div class="col-9">
	<div class="box">
		<div class="pad content">
			<h1>Настройка профиля <?php echo $user['name']; ?></h1>
		</div>

		<div class="row vw1000-row-col">
			<div class="col-2 vw1000-mb-15">
				<b>Регион:</b>
			</div>
			<div class="col-7 pad-0">
				<form action="/cabinet/profile" method="POST" class="form">
					<div class="row pad-0 vw1000-row-col">
						<div class="col-8">
							<div class="form__field">
								<div class="form__select">
									<button type="button" class="form__select-button"><?php echo $rgn; ?></button>
									<ul class="form__select-options">
										<li><button type="button" class="form__select-val" data-value="ru" data-show-hidden="#change-reg-btn">Россия</button></li>
										<li><button type="button" class="form__select-val" data-value="ua" data-show-hidden="#change-reg-btn">Украина</button></li>
									</ul>
									<input type="hidden" data-required="true" class="form__select-input" name="new_region" value="<?php echo $region; ?>">
								</div>
							</div>
						</div>
						<div class="col-4">
							<div id="change-reg-btn" class="form__field form__field_hidden">
								<button type="submit" class="form__button">Изменить</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>