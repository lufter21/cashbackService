<?php
$ins_act = $db -> prepare('INSERT INTO coupons (id,category,category_ids,type,title,description,promocode,discount,discount_abs,date_start,date_end,gotolink,shop_id,region) VALUES (:id,:category,:category_ids,:type,:title,:description,:promocode,:discount,:discount_abs,:date_start,:date_end,:gotolink,:shop_id,:region)');


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
	$categories = array('txt' => '', 'ids' => '');
	$k = 0;
	
	foreach ($coupon -> categories -> children() as $value) {
		$categories['txt'] .= (($k) ? ', ' : ''). $cats[(int) $value];
		$categories['ids'] .= (($k) ? ',' : ''). (int) $value;
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

// erase table
$erase_coupons = $db -> prepare('TRUNCATE TABLE coupons');
$erase_coupons -> execute();

// execute
foreach ($coupons_xml -> coupons -> children() as $value) {
	$cats = get_coupon_categories($value, $couponsArr['coupons_cats']);

	$ins_act -> execute(array(
		'id' => (int) $value -> attributes()['id'],
		'category' => $cats['txt'],
		'category_ids' => $cats['ids'],
		'type' => get_coupon_type($value, $couponsArr['coupons_type']),
		'title' => (string) $value -> name,
		'description' => (string) $value -> description,
		'promocode' => (string) $value -> promocode,
		'discount' => (string) $value -> discount,
		'discount_abs' => (int) $value -> discount,
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