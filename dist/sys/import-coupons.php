<?php
//get XML
$coupons_xml = simplexml_load_file(XML_FEED);

$couponsArr = array(
	'shop_cats' => array(),
	'coupons_cats' => array(),
	'coupons_type' => array()
);

// parse xml
foreach ($coupons_xml -> advcampaign_categories -> children() as $value) {
	$id = (int) $value -> attributes()['id'];
	
	if ($id != 62) {
		$couponsArr['shop_cats'][$id] = (string) $value;
	}
}

foreach ($coupons_xml -> categories -> children() as $value) {
	$couponsArr['coupons_cats'][(int) $value -> attributes()['id']] = (string) $value;
}

foreach ($coupons_xml -> types -> children() as $value) {
	$couponsArr['coupons_type'][(int) $value -> attributes()['id']] = (string) $value;
}

// sql prepare
// $erase_coupons = $db -> prepare('TRUNCATE TABLE coupons');
$erase_coupons = $db -> prepare('DELETE FROM coupons WHERE date_end > 0 AND date_end < NOW()');

$erase_deleted_coupons = $db -> prepare('DELETE FROM coupons WHERE category_ids = ?');

$ins_coupons = $db -> prepare('INSERT INTO coupons (id,category,category_ids,type,title,description,promocode,discount,discount_abs,date_start,date_end,gotolink,logo,shop_id,rating) VALUES (:id,:category,:category_ids,:type,:title,:description,:promocode,:discount,:discount_abs,:date_start,:date_end,:gotolink,:logo,:shop_id,:rating) ON DUPLICATE KEY UPDATE category=:u_category,category_ids=:u_category_ids,type=:u_type,title=:u_title,description=:u_description,promocode=:u_promocode,discount=:u_discount,discount_abs=:u_discount_abs,date_start=:u_date_start,date_end=:u_date_end,gotolink=:u_gotolink,logo=:u_logo,shop_id=:u_shop_id,rating=:u_rating');

$coupon_sql = $db -> prepare('SELECT * FROM coupons WHERE shop_id=?');

$upd_shop_qnt = $db -> prepare('UPDATE shops SET quantity=? WHERE id=?');

$update_shops = $db -> prepare('INSERT INTO shops (id,name,category,category_ids,logo,quantity) VALUES (:id,:name,:category,:category_ids,:logo,:quantity) ON DUPLICATE KEY UPDATE category=:u_category,category_ids=:u_category_ids,logo=:u_logo,quantity=:u_quantity');

$get_shops = $db -> prepare('SELECT * FROM shops');

$upd_coupon = $db -> prepare('UPDATE coupons SET region=?, available=? WHERE shop_id=?');

$ins_categories = $db -> prepare('INSERT INTO categories (id,name,relation) VALUES (:id,:name,:relation)');

// fun get coupon cats
function get_coupon_categories($coupon, $cats) {
	$categories = array('txt' => '', 'ids' => '');
	$k = 0;
	
	foreach ($coupon -> categories -> children() as $value) {
		$categories['txt'] .= (($k) ? ', ' : '') . $cats[(int) $value];
		$categories['ids'] .= (($k) ? ',' : '') .'"'. (int) $value .'"';
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
			$categories['txt'] .= (($k) ? ', ' : '') . $cats[(int) $value];
			$categories['ids'] .= (($k) ? ',' : '') .'"'. (int) $value .'"';
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

// fun save logo
function save_logo($url) {
	$path = $_SERVER['DOCUMENT_ROOT'] .'/static/images/logos/';
	$img_name = array_pop(explode('/', $url));
	
	if (!file_exists($path . $img_name)) {
		file_put_contents($path . $img_name, file_get_contents($url));
	}
	
	return $img_name;
}

// fun category title
function get_title($str) {
	return trim(str_replace('&', 'и', $str)) .' промокоды и скидки';
}

// fun category meta title
function get_meta_title($str) {
	return 'Скидки на '. mb_strtolower(trim(str_replace('&', 'и', $str)), 'UTF-8')  .', промокоды';
}

// fun modify description
function mod_description($str) {
	$str = preg_replace('/(ввод промо(\-|\s)?кода не требуется|не требуется ввод промокода|промокод не требуется|промокод не нужен)(\.|!|;)?/ui', '', $str);
	
	return trim($str);
}

// insert coupons
$erase_coupons -> execute();

foreach ($coupons_xml -> coupons -> children() as $value) {
	$cats = get_coupon_categories($value, $couponsArr['coupons_cats']);
	$types = get_coupon_type($value, $couponsArr['coupons_type']);
	$descr = mod_description((string) $value -> description);
	$logo = save_logo((string) $value -> logo);
	
	$ins_coupons -> execute(array(
		'id' => (int) $value -> attributes()['id'],
		'category' => $cats['txt'],
		'category_ids' => $cats['ids'],
		'type' => $types,
		'title' => (string) $value -> name,
		'description' => $descr,
		'promocode' => (string) $value -> promocode,
		'discount' => (string) $value -> discount,
		'discount_abs' => (int) $value -> discount,
		'date_start' => (string) $value -> date_start,
		'date_end' => (string) $value -> date_end,
		'gotolink' => (string) $value -> gotolink,
		'logo' => $logo,
		'shop_id' => (int) $value -> advcampaign_id,
		'rating' => (float) $value -> rating,
		'u_category' => $cats['txt'],
		'u_category_ids' => $cats['ids'],
		'u_type' => $types,
		'u_title' => (string) $value -> name,
		'u_description' => $descr,
		'u_promocode' => (string) $value -> promocode,
		'u_discount' => (string) $value -> discount,
		'u_discount_abs' => (int) $value -> discount,
		'u_date_start' => (string) $value -> date_start,
		'u_date_end' => (string) $value -> date_end,
		'u_gotolink' => (string) $value -> gotolink,
		'u_logo' => $logo,
		'u_shop_id' => (int) $value -> advcampaign_id,
		'u_rating' => (float) $value -> rating
	));
}

$erase_deleted_coupons -> execute(array(''));

// reset shop quant
$get_shops -> execute();
$shops_result = $get_shops -> fetchAll(PDO::FETCH_ASSOC);

foreach ($shops_result as $value) {
	$upd_shop_qnt -> execute(array(0, $value['id']));
}

// update shops
foreach ($coupons_xml -> advcampaigns -> children() as $value) {
	$cats = get_shop_categories($value, $couponsArr['shop_cats']);
	$id = (int) $value -> attributes()['id'];
	$logo = get_logo($id, $coupon_sql);
	
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

// update coupon
$get_shops -> execute();
$shops_result = $get_shops -> fetchAll(PDO::FETCH_ASSOC);

foreach ($shops_result as $value) {
	$upd_coupon -> execute(array($value['region'], $value['available'], $value['id']));
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

header('Location:?route=categories');

$tit = 'Import coupons';
include('header.php');
?>
<div class="clr"></div>

<div class="wrap">

<p class="message">Купоны импортированы.</p>

<div class="clr"></div>
</div>