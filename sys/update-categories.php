<?php
$update_cats = $db -> prepare('INSERT INTO categories (id,name,relation) VALUES (:id,:name,:relation)');

//get XML
$coupons_xml = simplexml_load_file('admitad_coupons.xml');


foreach ($coupons_xml -> advcampaign_categories -> children() as $value) {
	$id = (int) $value -> attributes()['id'];

	if ($id == 62) {
		continue;
	}

	$update_cats -> execute(array(
		'id' => $id,
		'name' => (string) $value,
		'relation' => 'shops'
	));
}

foreach ($coupons_xml -> categories -> children() as $value) {
	$id = (int) $value -> attributes()['id'];

	$update_cats -> execute(array(
		'id' => $id,
		'name' => (string) $value,
		'relation' => 'coupons'
	));
}

$tit = 'Update Categories';
include('header.php');
?>
<div class="clr"></div>

<div class="wrap">

<p class="message">Категории обновлены. Поправьте некоторые поля в базе данных вручную.</p>

<div class="clr"></div>
</div>