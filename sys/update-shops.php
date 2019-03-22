<?php
$update_shops = $db->prepare('INSERT INTO shops (id,name,category,category_ids,logo) VALUES (:id,:name,:category,:category_ids,:logo) ON DUPLICATE KEY UPDATE category=:u_category,category_ids=:u_category_ids,logo=:u_logo');

//get XML
$coupons_xml = simplexml_load_file('admitad_coupons.xml');

$couponsArr = array(
	'shop_cats' => array()
);

foreach ($coupons_xml -> advcampaign_categories -> children() as $value) {
   $couponsArr['shop_cats'][(int) $value -> attributes()['id']] = (string) $value;
}

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

// get logo
$coupon_sql = $db -> prepare('SELECT logo FROM coupons WHERE shop_id=?');

function get_logo($id, $coupon_sql) {
	$coupon_sql -> execute(array($id));
	$coupon_result = $coupon_sql -> fetch(PDO::FETCH_ASSOC);

	return $coupon_result['logo'];
}

foreach ($coupons_xml -> advcampaigns -> children() as $value) {
	$cats = get_shop_categories($value, $couponsArr['shop_cats']);
	$id = (int) $value -> attributes()['id'];
	$logo = get_logo($id, $coupon_sql);
	
	$update_shops->execute(array(
		'id' => $id,
		'name' => (string) $value -> name,
		'category' => $cats['txt'],
		'category_ids' => $cats['ids'],
		'logo' => $logo,
		'u_category' => $cats['txt'],
		'u_category_ids' => $cats['ids'],
		'u_logo' => $logo
	));
}

$tit = 'Update Shops';
include('header.php');
?>
<div class="clr"></div>

<div class="wrap">

<p class="message">Магазины обновлены. Поправьте некоторые поля в базе данных вручную.</p>

<div class="clr"></div>
</div>