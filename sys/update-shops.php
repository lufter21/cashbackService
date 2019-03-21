<?php
$update_shops = $db->prepare('INSERT INTO shops (id,name,category,category_ids) VALUES (:id,:name,:category,:category_ids) ON DUPLICATE KEY UPDATE category=:u_category,category_ids=:u_category_ids');

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

foreach ($coupons_xml -> advcampaigns -> children() as $value) {
	$cats = get_shop_categories($value, $couponsArr['shop_cats']);
	
	$update_shops->execute(array(
		'id' => (int) $value -> attributes()['id'],
		'name' => (string) $value -> name,
		'category' => $cats['txt'],
		'category_ids' => $cats['ids'],
		'u_category' => $cats['txt'],
		'u_category_ids' => $cats['ids']
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