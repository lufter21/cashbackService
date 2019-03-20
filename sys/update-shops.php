<?php
$update_shops = $db->prepare('INSERT INTO shops (id,name,category) VALUES (:id,:name,:category) ON DUPLICATE KEY UPDATE category=:u_category');

//get XML
$coupons_xml = simplexml_load_file('admitad_coupons.xml');

$couponsArr = array(
	'shop_cats' => array()
);

foreach ($coupons_xml -> advcampaign_categories -> children() as $value) {
   $couponsArr['shop_cats'][(int) $value -> attributes()['id']] = (string) $value;
}

function get_shop_categories($shop, $cats) {
	$categories = '';
	$k = 0;

	foreach ($shop -> categories -> children() as $value) {
		if ((int) $value != 62) {
			$categories .= (($k) ? ', ' : ''). $cats[(int) $value];
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
		'category' => $cats,
		'u_category' => $cats
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