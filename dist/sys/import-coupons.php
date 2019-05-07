<?php
$cur_time = date('Y-m-d H:i:s');

//get XML
$xml = simplexml_load_file(XML_FEED);

$xml_arr = array(
	'shop_cats' => array(),
	'coupons_cats' => array(),
	'coupons_type' => array()
);

// parse xml
foreach ($xml->advcampaign_categories->children() as $value) {
	$id = (int)$value->attributes()['id'];

	if ($id != 62) {
		$xml_arr['shop_cats'][$id] = (string)$value;
	}
}

foreach ($xml->categories->children() as $value) {
	$xml_arr['coupons_cats'][(int)$value->attributes()['id']] = (string)$value;
}

foreach ($xml->types->children() as $value) {
	$xml_arr['coupons_type'][(int)$value->attributes()['id']] = (string)$value;
}

// sql prepare
$erase_coupons = $db->prepare('DELETE FROM coupons WHERE date_end > 0 AND date_end < NOW()');

$erase_deleted_coupons = $db->prepare('DELETE FROM coupons WHERE modified < ?');

$ins_coupons = $db->prepare('INSERT INTO coupons (id,category,category_ids,type,type_ids,title,description,promocode,discount,discount_abs,date_start,date_end,gotolink,logo,shop_id,rating,modified) VALUES (:id,:category,:category_ids,:type,:type_ids,:title,:description,:promocode,:discount,:discount_abs,:date_start,:date_end,:gotolink,:logo,:shop_id,:rating,:modified) ON DUPLICATE KEY UPDATE type=:u_type,type_ids=:u_type_ids,title=:u_title,description=:u_description,promocode=:u_promocode,discount=:u_discount,discount_abs=:u_discount_abs,date_start=:u_date_start,date_end=:u_date_end,gotolink=:u_gotolink,logo=:u_logo,shop_id=:u_shop_id,rating=:u_rating,modified=:u_modified');

$coupon_sql = $db->prepare('SELECT * FROM coupons WHERE shop_id=?');

$upd_shop_qnt = $db->prepare('UPDATE shops SET quantity=? WHERE id=?');

$update_shops = $db->prepare('INSERT INTO shops (id,name,category,category_ids,logo,quantity) VALUES (:id,:name,:category,:category_ids,:logo,:quantity) ON DUPLICATE KEY UPDATE logo=:u_logo,quantity=:u_quantity,category=:u_category,category_ids=:u_category_ids');

$get_shops = $db->prepare('SELECT * FROM shops');

$get_coupons = $db->prepare('SELECT * FROM coupons');

$get_cats = $db->prepare('SELECT * FROM categories');

$upd_coupon = $db->prepare('UPDATE coupons SET by_reg=?, ru_reg=?, ua_reg=?, available=? WHERE shop_id=?');

$upd_coupon_cats = $db->prepare('UPDATE coupons SET category=? WHERE id=?');

$upd_shop_cats = $db->prepare('UPDATE shops SET category=? WHERE id=?');

$ins_categories = $db->prepare('INSERT INTO categories (id,name,origin_name,relation) VALUES (:id,:name,:origin_name,:relation) ON DUPLICATE KEY UPDATE origin_name=:u_origin_name');

// fun get cats name
function get_cat_names($cat_ids, $cats_arr)
{
	$names = array();

	if ($cat_ids) {
		foreach (json_decode($cat_ids, true) as $id) {
			if ((int)$id != 62) {
				$names[] = $cats_arr[(int)$id]['name'];
			}
		}
	}

	return implode(', ', $names);
}

// fun get names and ids
function get_names_and_ids($ids_arr, $src_arr)
{
	$result = array('names' => array(), 'ids' => array());

	foreach ($ids_arr as $id) {
		if ((int)$id != 62) {
			$result['names'][] = $src_arr[(int)$id];
			$result['ids'][] = (string)$id;
		}
	}

	$result['names'] = implode(', ', $result['names']);
	$result['ids'] = json_encode($result['ids']);

	return $result;
}

//fun get logo
function get_logo($id, $coupon_sql)
{
	$coupon_sql->execute(array($id));
	$coupon_result = $coupon_sql->fetch(PDO::FETCH_ASSOC);

	return $coupon_result['logo'];
}

// fun save logo
function save_logo($url)
{
	$path = $_SERVER['DOCUMENT_ROOT'] . '/static/images/logos/';
	$img_name = array_pop(explode('/', $url));

	if (!file_exists($path . $img_name)) {
		file_put_contents($path . $img_name, file_get_contents($url));
	}

	return $img_name;
}

// fun modify description
function mod_coupon_description($str)
{
	$str = preg_replace('/(ввод промо(\-|\s)?кода не требуется|не требуется ввод промокода|промокод не требуется|промокод не нужен)(\.|!|;)?/ui', '', $str);

	return trim($str);
}

// insert/update coupons
$erase_coupons->execute();

foreach ($xml->coupons->children() as $value) {
	$cats = get_names_and_ids($value->categories->children(), $xml_arr['coupons_cats']);
	$types = get_names_and_ids($value->types->children(), $xml_arr['coupons_type']);
	$descr = mod_coupon_description((string)$value->description);
	$logo = save_logo((string)$value->logo);

	$ins_coupons->execute(array(
		'id' => (int)$value->attributes()['id'],
		'category' => $cats['names'],
		'category_ids' => $cats['ids'],
		'type' => $types['names'],
		'type_ids' => $types['ids'],
		'title' => (string)$value->name,
		'description' => $descr,
		'promocode' => (string)$value->promocode,
		'discount' => (string)$value->discount,
		'discount_abs' => (int)$value->discount,
		'date_start' => (string)$value->date_start,
		'date_end' => (string)$value->date_end,
		'gotolink' => (string)$value->gotolink,
		'logo' => $logo,
		'shop_id' => (int)$value->advcampaign_id,
		'rating' => (float)$value->rating,
		'modified' => $cur_time,
		'u_type' => $types['names'],
		'u_type_ids' => $types['ids'],
		'u_title' => (string)$value->name,
		'u_description' => $descr,
		'u_promocode' => (string)$value->promocode,
		'u_discount' => (string)$value->discount,
		'u_discount_abs' => (int)$value->discount,
		'u_date_start' => (string)$value->date_start,
		'u_date_end' => (string)$value->date_end,
		'u_gotolink' => (string)$value->gotolink,
		'u_logo' => $logo,
		'u_shop_id' => (int)$value->advcampaign_id,
		'u_rating' => (float)$value->rating,
		'u_modified' => $cur_time
	));
}

$erase_deleted_coupons->execute(array($cur_time));

// reset shop quant
$get_shops->execute();
$shops_result = $get_shops->fetchAll(PDO::FETCH_ASSOC);

foreach ($shops_result as $value) {
	$upd_shop_qnt->execute(array(0, $value['id']));
}

// insert/update shops
foreach ($xml->advcampaigns->children() as $value) {
	$cats = get_names_and_ids($value->categories->children(), $xml_arr['shop_cats']);
	$id = (int)$value->attributes()['id'];
	$logo = get_logo($id, $coupon_sql);

	$coupon_sql->execute(array($id));
	$quant = $coupon_sql->rowCount();

	$update_shops->execute(array(
		'id' => $id,
		'name' => (string)$value->name,
		'category' => $cats['names'],
		'category_ids' => $cats['ids'],
		'logo' => $logo,
		'quantity' => $quant,
		'u_logo' => $logo,
		'u_quantity' => $quant,
		'u_category' => $cats['names'],
		'u_category_ids' => $cats['ids']
	));
}

// update coupons region and available
foreach ($shops_result as $value) {
	$upd_coupon->execute(array($value['by_reg'], $value['ru_reg'], $value['ua_reg'], $value['available'], $value['id']));
}

// insert categories
foreach ($xml_arr['shop_cats'] as $key => $value) {
	$ins_categories->execute(array(
		'id' => $key,
		'name' => $value,
		'origin_name' => $value,
		'relation' => 'shops',
		'u_origin_name' => $value
	));
}

foreach ($xml_arr['coupons_cats'] as $key => $value) {
	$ins_categories->execute(array(
		'id' => $key,
		'name' => $value,
		'origin_name' => $value,
		'relation' => 'coupons',
		'u_origin_name' => $value
	));
}

// get categories
$get_cats->execute();
$cats_result = $get_cats->fetchAll(PDO::FETCH_ASSOC);

$cats_arr = array();

foreach ($cats_result as $value) {
	$cats_arr[$value['id']] = $value;
}

// update shop category names
foreach ($shops_result as $value) {
	$categories = get_cat_names($value['category_ids'], $cats_arr);

	$upd_shop_cats->execute(array($categories, $value['id']));
}

// update coupons category names
$get_coupons->execute();
$coupons_result = $get_coupons->fetchAll(PDO::FETCH_ASSOC);

foreach ($coupons_result as $value) {
	$categories = get_cat_names($value['category_ids'], $cats_arr);

	$upd_coupon_cats->execute(array($categories, $value['id']));
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