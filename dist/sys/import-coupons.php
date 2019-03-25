<?php
//get XML
$coupons_xml = simplexml_load_file('admitad_coupons.xml');

$couponsArr = array(
	'shop_cats' => array(),
	'coupons_cats' => array(),
	'coupons_type' => array()
);

// parse xml
foreach ($coupons_xml -> advcampaign_categories -> children() as $value) {
   $couponsArr['shop_cats'][(int) $value -> attributes()['id']] = (string) $value;
}

foreach ($coupons_xml -> categories -> children() as $value) {
	$couponsArr['coupons_cats'][(int) $value -> attributes()['id']] = (string) $value;
}

foreach ($coupons_xml -> types -> children() as $value) {
	$couponsArr['coupons_type'][(int) $value -> attributes()['id']] = (string) $value;
}

// sql prepare
$erase_coupons = $db -> prepare('TRUNCATE TABLE coupons');

$ins_coupons = $db -> prepare('INSERT INTO coupons (id,category,category_ids,type,title,description,promocode,discount,discount_abs,date_start,date_end,gotolink,logo,shop_id) VALUES (:id,:category,:category_ids,:type,:title,:description,:promocode,:discount,:discount_abs,:date_start,:date_end,:gotolink,:logo,:shop_id)');

$coupon_sql = $db -> prepare('SELECT * FROM coupons WHERE shop_id=?');

$update_shops = $db -> prepare('INSERT INTO shops (id,name,category,category_ids,logo,quantity) VALUES (:id,:name,:category,:category_ids,:logo,:quantity) ON DUPLICATE KEY UPDATE category=:u_category,category_ids=:u_category_ids,logo=:u_logo,quantity=:u_quantity');

$get_shops = $db -> prepare('SELECT * FROM shops');

$upd_coupon_region = $db -> prepare('UPDATE coupons SET region=? WHERE shop_id=?');

$ins_categories = $db -> prepare('INSERT INTO categories (id,name,relation) VALUES (:id,:name,:relation)');

// fun get coupon cats
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

// fun get coupon type
function get_coupon_type($coupon, $types) {
	$type = '';
	$k = 0;
	
	foreach ($coupon -> types -> children() as $value) {
		$type .= (($k) ? ', ' : ''). $types[(int) $value];
		$k++;
	}
	
	return $type;
}

// fun get shop cats
function get_shop_categories($shop, $cats) {
	$categories = array('txt' => '', 'ids' => '');
	$k = 0;
	
	foreach ($shop -> categories -> children() as $value) {
		if ((int) $value != 62) {
			$categories['txt'] .= (($k) ? ', ' : ''). $cats[(int) $value];
			$categories['ids'] .= (($k) ? ',' : ''). (int) $value;
			$k++;
		}
	}

	return $categories;
}

//fun get logo
function get_logo($id, $coupon_sql) {
	$coupon_sql -> execute(array($id));
	$coupon_result = $coupon_sql -> fetch(PDO::FETCH_ASSOC);

	return $coupon_result['logo'];
}

// fun category title
function get_title($str) {
	return trim(str_replace('&', 'и', $str)) .' промокоды и скидки';
}

// fun category meta title
function get_meta_title($str) {
	return 'Скидки на '. mb_strtolower(trim(str_replace('&', 'и', $str)), 'UTF-8')  .', промокоды';
}

// insert coupons
$erase_coupons -> execute();

foreach ($coupons_xml -> coupons -> children() as $value) {
	$cats = get_coupon_categories($value, $couponsArr['coupons_cats']);

	$ins_coupons -> execute(array(
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
		'logo' => (string) $value -> logo,
		'shop_id' => (int) $value -> advcampaign_id
	));
}

// update shops
foreach ($coupons_xml -> advcampaigns -> children() as $value) {
	$cats = get_shop_categories($value, $couponsArr['shop_cats']);
	$id = (int) $value -> attributes()['id'];
	$logo = get_logo($id, $coupon_sql);
	$upd_qnt = $db -> prepare('UPDATE shops SET quantity=? WHERE id=?');

	$coupon_sql->execute(array($id));
	$quant = $coupon_sql->rowCount();
	
	$update_shops -> execute(array(
		'id' => $id,
		'name' => (string) $value -> name,
		'category' => $cats['txt'],
		'category_ids' => $cats['ids'],
		'logo' => $logo,
		'quantity' => $quant,
		'u_category' => $cats['txt'],
		'u_category_ids' => $cats['ids'],
		'u_logo' => $logo,
		'u_quantity' => $quant
	));
}

// update coupons region
$get_shops -> execute();
$shops_result = $get_shops -> fetchAll(PDO::FETCH_ASSOC);

foreach ($shops_result as $value) {
	$upd_coupon_region -> execute(array($value['region'], $value['id']));
}

// insert categories
foreach ($couponsArr['shop_cats'] as $key => $value) {
	$ins_categories -> execute(array(
		'id' => $key,
		'name' => $value,
		'relation' => 'shops'
	));
}

foreach ($couponsArr['coupons_cats'] as $key => $value) {
	$ins_categories -> execute(array(
		'id' => $key,
		'name' => $value,
		'relation' => 'coupons'
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