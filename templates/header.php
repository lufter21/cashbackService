<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo $meta['title']; ?> | BomBonus.dealersAir — Кэшбэк, скидки/промокоды</title>
<meta name="description" content="<?php echo $meta['description']; ?>">
<link rel="canonical" href="https://bombonus.dealersair.com/<?php echo $alias; ?>">
<link type="text/css" rel="stylesheet" href="/css/style.css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<!--[if lt IE 9]><script type="text/javascript" src="/js/html5.min.js"></script><![endif]-->
<script>var adBlock = true;</script>
<script type="text/javascript" src="/js/adframe.js"></script>
</head>
<body>
<!--Wrapper/-->
<div id="wrapper" class="wrapper">
<!--Header/-->
	<header class="header">
		<noscript class="noscript">Для корректной работы сервиса необходимо включить JavaScript</noscript>
		<div id="alert" class="alert"></div>
		<div class="header-top">
			<div class="header-top__wrap wrap row-col-mid">
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
				<div class="col-3">
					<a href="/" title="На главную страницу"><img class="header__logo" src="/images/bombonus.svg" onerror="this.onerror=null; this.src='/images/bombonus.png'" alt="«e-discount» — Кэшбэк, скидки/промокоды"/></a>
				</div>
				<div class="col-9">
					<nav class="top-menu">
						<?php 
						echo $lemon->getMenu(array(
							'shops'=>'Магазины',
							'discounts'=>'Скидки/промокоды',
							'about'=>array('О сервисе', array('recomendations'=>'Рекомендации', 'faq'=>'Вопрос/Ответ'))
							));
							?>
					</nav>
				</div>
			</div>
		</div>
		
		<!--<div id="mob-nav-block" class="nav-block">
			
			<button data-block="menu-block" class="button show-menu-button">Все скидки</button>
			<nav id="menu-block" class="drop-block menu-block clear">
				<?php echo $lemon->getCategoryMenu(); ?>
			</nav>
			<div class="search-form">
				<form id="search-form" action="/search" method="POST">
					<div><input id="sfi" type="text" name="search" value="<?php echo $content['search']; ?>" placeholder="Поиск..." required /></div>
					<input type="submit" value="Найти" />
				</form>
			</div>
			<div class="subscribe-button-wrap">
				<button class="modal show-subscribe-button" data-window="subscribe-modal">Подписаться</button>
			</div>
		</div>-->
		<button id="open-mob-menu" class="mob-menu-button"></button>
	</header>
	<!--/Header-->