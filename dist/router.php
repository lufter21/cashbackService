<?php
$query = array();

if(!empty($_GET['route'])){
	$route = trim(htmlspecialchars(strip_tags($_GET['route'])));
	$rt = explode('/', $route);
	$rtn = count($rt);
	
	switch($rtn){
		case 1:
		if ($rt[0] == 'ua' || $rt[0] == 'ru') {
			$query = array(
				'class' => 'MainPage',
				'template' => 'main-page',
				'region' => $rt[0]
			);
		} else if ($rt[0] == 'coupons' || $rt[0] == 'shops') {
			$query = array(
				'class' => ucfirst($rt[0]),
				'template' => $rt[0],
				'alias' => ''
			);
		}
		break;
		
		case 2:
		if ($rt[0] == 'ua' || $rt[0] == 'ru') {
			$query = array(
				'alias' => $rt[1],
				'region' => $rt[0]
			);
		} elseif ($rt[0] == 'coupons' || $rt[0] == 'coupon' || $rt[0] == 'shops' || $rt[0] == 'shop'){
			$query = array(
				'class' => ucfirst($rt[0]),
				'template' => $rt[0],
				'alias' => $rt[1]
			);
		} elseif ($rt[0] == 'go'){
			$query = array(
				'class' => 'Go',
				'template' => 'go',
				'alias' => $rt[1]
			);
		}
		break;
		
		case 3:
		if ($rt[0] == 'ua' || $rt[0] == 'ru') {
			$query = array(
				'alias' => $rt[1] .'/'. $rt[2],
				'region' => $rt[0]
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
		if ($rt[2] == 'page') {
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