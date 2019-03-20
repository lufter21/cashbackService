<?php
$ins_act = $db->prepare('INSERT INTO coupons (id,category,type,title,description,promocode,discount,date_start,date_end,gotolink,shop_id,region) VALUES (:id,:category,:type,:title,:description,:promocode,:discount,:date_start,:date_end,:gotolink,:shop_id,:region)');


$get_shops = $db->prepare('SELECT * FROM shops');
$get_shops->execute();
$shops_result = $get_shops->fetchAll(PDO::FETCH_ASSOC);

$shops_resultArr = array();

foreach ($shops_result as $value) {
	$shops_resultArr[$value['id']] = $value;
}

//get XML
$coupons_xml = simplexml_load_file('admitad_coupons.xml');

$couponsArr = array(
	'coupons_cats' => array(),
	'coupons_type' => array()
);

//categories
foreach ($coupons_xml -> categories -> children() as $value) {
	$couponsArr['coupons_cats'][(int) $value -> attributes()['id']] = (string) $value;
}

function get_coupon_categories($coupon, $cats) {
	$categories = '';
	$k = 0;
	
	foreach ($coupon -> categories -> children() as $value) {
		$categories .= (($k) ? ', ' : ''). $cats[(int) $value];
		$k++;
	}
	
	return $categories;
}

//type
foreach ($coupons_xml -> types -> children() as $value) {
	$couponsArr['coupons_type'][(int) $value -> attributes()['id']] = (string) $value;
}

function get_coupon_type($coupon, $types) {
	$type = '';
	$k = 0;
	
	foreach ($coupon -> types -> children() as $value) {
		$type .= (($k) ? ', ' : ''). $types[(int) $value];
		$k++;
	}
	
	return $type;
}

// execute
foreach ($coupons_xml -> coupons -> children() as $value) {
	$ins_act->execute(array(
		'id' => (int) $value -> attributes()['id'],
		'category' => get_coupon_categories($value, $couponsArr['coupons_cats']),
		'type' => get_coupon_type($value, $couponsArr['coupons_type']),
		'title' => (string) $value -> name,
		'description' => (string) $value -> description,
		'promocode' => (string) $value -> promocode,
		'discount' => (string) $value -> discount,
		'date_start' => (string) $value -> date_start,
		'date_end' => (string) $value -> date_end,
		'gotolink' => (string) $value -> gotolink,
		'shop_id' => (int) $value -> advcampaign_id,
		'region' => $shops_resultArr[(int) $value -> advcampaign_id]['region']
	));
}

$tit = 'Import coupons';
include('header.php');
?>
<div class="clr"></div>

<div class="wrap">

<p class="message">Купоны импортированы.</p>

<div class="clr"></div>
</div>