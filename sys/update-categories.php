<?php
$update_cats = $db -> prepare('INSERT INTO categories (id,name,meta_title,title,relation) VALUES (:id,:name,:meta_title,:title,:relation) ON DUPLICATE KEY UPDATE name=:u_name,meta_title=:u_meta_title,title=:u_title');

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
		'meta_title' => (string) $value,
		'title' => (string) $value,
		'relation' => 'shops',
		'u_name' => (string) $value,
		'u_meta_title' => (string) $value,
		'u_title' => (string) $value
	));
}

foreach ($coupons_xml -> categories -> children() as $value) {
	$id = (int) $value -> attributes()['id'];

	$update_cats -> execute(array(
		'id' => $id,
		'name' => (string) $value,
		'meta_title' => (string) $value,
		'title' => (string) $value,
		'relation' => 'coupons',
		'u_name' => (string) $value,
		'u_meta_title' => (string) $value,
		'u_title' => (string) $value
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