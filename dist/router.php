<?php
$query = array();

if (!empty($_GET['route'])) {
	$route = trim(htmlspecialchars(strip_tags($_GET['route'])));
	$rt = explode('/', $route);
	$rtn = count($rt);

	switch ($rtn) {
		case 1:
			if ($rt[0] == 'by' || $rt[0] == 'ru' || $rt[0] == 'ua') {
				$query = array(
					'class' => 'MainPage',
					'template' => 'main-page',
					'region' => $rt[0]
				);
			} elseif ($rt[0] == 'shops') {
				$query = array(
					'class' => 'Shops',
					'template' => 'shops',
					'alias' => ''
				);
			} elseif ($rt[0] == 'free-shipping' || $rt[0] == 'discounts' || $rt[0] == 'gifts') {
				$query = array(
					'class' => 'Coupons',
					'template' => 'coupons',
					'alias' => '',
					'type' => $rt[0]
				);
			}
			break;

		case 2:
			if ($rt[0] == 'by' || $rt[0] == 'ru' || $rt[0] == 'ua') {
				$query = array(
					'alias' => $rt[1],
					'region' => $rt[0]
				);
			} elseif ($rt[0] == 'coupon' || $rt[0] == 'shops' || $rt[0] == 'shop') {
				$query = array(
					'class' => ucfirst($rt[0]),
					'template' => $rt[0],
					'alias' => $rt[1]
				);
			} elseif ($rt[0] == 'free-shipping' || $rt[0] == 'discounts' || $rt[0] == 'gifts') {
				$query = array(
					'class' => 'Coupons',
					'template' => 'coupons',
					'alias' => $rt[1],
					'type' => $rt[0]
				);
			} elseif ($rt[0] == 'go') {
				$query = array(
					'class' => 'Go',
					'template' => 'go',
					'alias' => $rt[1]
				);
			}
			break;

		case 3:
			if ($rt[0] == 'by' || $rt[0] == 'ru' || $rt[0] == 'ua') {
				$query = array(
					'alias' => $rt[1] . '/' . $rt[2],
					'region' => $rt[0]
				);
			} elseif (($rt[0] == 'free-shipping' || $rt[0] == 'discounts' || $rt[0] == 'gifts') && $rt[1] == 'page') {
				$query = array(
					'class' => 'Coupons',
					'template' => 'coupons',
					'alias' => '',
					'type' => $rt[0],
					'page' => $rt[2]
				);
			} elseif ($rt[1] == 'page') {
				$query = array(
					'class' => ucfirst($rt[0]),
					'template' => $rt[0],
					'alias' => '',
					'page' => $rt[2]
				);
			}
			break;

		case 4:
			if (($rt[0] == 'free-shipping' || $rt[0] == 'discounts' || $rt[0] == 'gifts') && $rt[2] == 'page') {
				$query = array(
					'class' => 'Coupons',
					'template' => 'coupons',
					'alias' => $rt[1],
					'type' => $rt[0],
					'page' => $rt[3]
				);
			} elseif ($rt[2] == 'page') {
				$query = array(
					'class' => ucfirst($rt[0]),
					'template' => $rt[0],
					'alias' => $rt[1],
					'page' => $rt[3]
				);
			}
			break;
	}
} else {
	$query = array(
		'class' => 'MainPage',
		'template' => 'main-page'
	);
}

$query = array_merge($query, array('route' => $route));
