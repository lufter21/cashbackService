<?php
$rgn = 'Выберите страну';

if ($region == 'ua') {
	$rgn = 'Украина';
} elseif ($region == 'ru') {
	$rgn = 'Россия';
} elseif ($region == 'by') {
	$rgn = 'Беларусь';
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link type="text/css" rel="stylesheet" href="/static/css/style.css">
	<title><?php echo $meta['meta_title']; ?> — BomBonus</title>
	<meta name="description" content="<?php echo $meta['meta_description']; ?>">
	<link rel="canonical" href="https://bombonus.dealersair.com/<?php echo $route; ?>">
	<!-- favicons/ -->
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#2b5797">
	<meta name="theme-color" content="#ffffff">
	<!-- /favicons -->
</head>

<body>

	<!--HEADER/-->
	<header id="header" class="header<?php echo (!empty($header_class)) ? ' ' . $header_class : ''; ?>">
		<div class="header__row row row_wrp row_col-middle sm-row-col-12">
			<div class="col-3 p-y-0">
				<a href="/" class="header__logo"><img src="/static/images/bombonus.svg" alt="Dealers Air Bombonus"></a>
			</div>
			<div class="col-9 p-y-0">
				<div class="row row_col-middle sm-row-col-12">
					<nav class="col p-0">
						<!--Menu/-->
						<?php
						echo $lemon->getMenu(array(
							'discounts' => 'Скидки',
							'gifts' => 'Подарки',
							'free-shipping' => 'Бесплатная доставка',
							'shops' => 'Магазины',
							// 'about'=>array('О сервисе', array('recomendations'=>'Рекомендации', 'faq'=>'Вопрос/Ответ'))
						));
						?>
						<!-- <li class="menu__item menu__item_current">
							<a href="home.html" class="menu__a">Home</a>
						</li> -->

						<!--/Menu-->
					</nav>
					<div class="col col_right p-0">
						<!--User/-->
						<div class="user">
							<span class="user__name"><?php echo $rgn; ?></span>
							<span class="user__thumb"><img src="/static/images/<?php echo (empty($region)) ? 'worldwide.svg' : 'flag-' . $region . '.svg'; ?>" alt="flag"></span>

							<button data-target-elements="#user-menu" class="js-toggle js-document-toggle-off user__button<?php echo (empty($region)) ? ' toggled' : ''; ?>"></button>

							<div id="user-menu" class="user__bubble<?php echo (empty($region)) ? ' toggled' : ''; ?>">
								<ul>
									<li class="user__menu-item"><a href="/by">Беларусь</a></li>
									<li class="user__menu-item"><a href="/ru">Россия</a></li>
									<li class="user__menu-item"><a href="/ua">Украина</a></li>
								</ul>
							</div>
						</div>
						<!--/User-->
					</div>
				</div>
			</div>

			<button class="js-close-menu menu-close-btn"></button>
		</div>
		<button class="js-open-menu open-menu-btn"><span></span><span></span><span></span><span></span></button>
	</header>
	<!--/HEADER-->