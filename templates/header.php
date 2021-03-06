<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo $meta['title']; ?> | BomBonus.dealersAir — Кэшбэк, скидки/промокоды</title>
<meta name="description" content="<?php echo $meta['description']; ?>">
<link type="text/css" rel="stylesheet" href="/css/style.css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="canonical" href="https://bombonus.dealersair.com/<?php echo $route; ?>">
<script>var adBlock = true, unknownUser = false;</script>
<script src="/js/adframe.js"></script>
</head>
<body>
<!--Wrapper/-->
<div id="wrapper" class="wrapper">
<!--Header/-->
	<header class="header">
		<noscript class="noscript">Для корректной работы сервиса необходимо включить JavaScript</noscript>
		<div id="alert" class="alert"></div>
		<div id="header-top" class="header-top">
			<div class="header-top__wrap wrap row-col-mid vw1000-row-col">
				<div class="col-6">
					<div class="region-block">
						<span>Страна:</span>
						<?php
						if($region == 'ua') {
							$rgn = 'Украина';
						} elseif($region == 'ru') {
							$rgn = 'Россия';
						} else {
							$rgn = 'выбрать';
						}
						?>
						<button id="show-region-button" class="js-show-button show-region-button" data-block="menu-region"><?php echo $rgn; ?></button>
						<ul id="menu-region" class="menu-region">
							<li><a href="/ru">Россия</a></li>
							<li><a href="/ua">Украина</a></li>
						</ul>
					</div>
				</div>
				<div class="col-6 ta-r">
					<div class="header__user">
						<?php if($user){ ?>
						<a href="/cabinet" class="borno"><?php echo $user['name']; ?></a> <span class="gr">|</span> <a href="/logout" class="-gray">Выход</a>
						<?php } else { ?>
						<a href="#log-reg-window" data-tab="login" class="-dash js-open-popup">Вход</a> | <a href="#log-reg-window" data-tab="registration" class="-dash js-open-popup">Регистрация</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="header-bottom__wrap wrap row-col-mid">
				<div class="col-3 vw1000-col-11">
					<a href="/" title="На главную страницу"><img class="header__logo" src="/images/bombonus.svg" onerror="this.onerror=null; this.src='/images/bombonus.png'" alt="«e-discount» — Кэшбэк, скидки/промокоды"/></a>
				</div>
				<div class="col-9 pad-0 vw1000-col-1">
					<div id="header-mob-menu" class="header__menu-wrap row-col-mid vw1000-row-col">
						<div class="col-4">
							<form action="#" class="form form_v1">
								<div class="form__field m-0 form__field_btn">
									<div class="form__select form__select_autocomplete">
										<label for="i-txt-6s" class="overlabel">Поиск магазина</label>
										<input id="i-txt-6s" type="text" class="form__text-input form__text-input_autocomplete" data-opt="search-by-name" value="">
										<span class="form__btn form__btn_search"></span>
										<ul class="form__select-options">
											<?php foreach ($lemon->getShops() as $val) { ?>
											<li>
												<a href="/shop/<?php echo $val['alias']; ?>" class="form__select-val"><?php echo $val['name']; ?></a>
											</li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</form>
						</div>
						<div class="col-8">
							<nav class="top-menu">
								<?php echo $lemon->getMenu(array(
									'shops'=>'Магазины',
									'discounts'=>'Скидки/промокоды',
									'about'=>array('О сервисе', array('recomendations'=>'Рекомендации', 'faq'=>'Вопрос/Ответ'))
								)); ?>
							</nav>
						</div>
					</div>
				</div>

				<button class="js-toggle toggle header__toggle" data-target-id="header-mob-menu" data-target-class="header"><span></span><span></span><span></span><span></span></button>

				<button class="js-toggle header__user-btn-mob" data-target-id="header-top"></button>

			</div>
		</div>
	</header>
	<!--/Header-->