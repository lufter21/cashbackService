<?php
function translit($string)
{
	$table = array(
		'А' => 'A',
		'Б' => 'B',
		'В' => 'V',
		'Г' => 'G',
		'Д' => 'D',
		'Е' => 'E',
		'Ё' => 'YO',
		'Ж' => 'ZH',
		'З' => 'Z',
		'И' => 'I',
		'Й' => 'J',
		'К' => 'K',
		'Л' => 'L',
		'М' => 'M',
		'Н' => 'N',
		'О' => 'O',
		'П' => 'P',
		'Р' => 'R',
		'С' => 'S',
		'Т' => 'T',
		'У' => 'U',
		'Ф' => 'F',
		'Х' => 'KH',
		'Ц' => 'C',
		'Ч' => 'CH',
		'Ш' => 'SH',
		'Щ' => 'SCH',
		'Ь' => '',
		'Ы' => 'I',
		'Ъ' => '',
		'Э' => 'E',
		'Ю' => 'YU',
		'Я' => 'YA',
		'а' => 'a',
		'б' => 'b',
		'в' => 'v',
		'г' => 'g',
		'д' => 'd',
		'е' => 'e',
		'ё' => 'yo',
		'ж' => 'zh',
		'з' => 'z',
		'и' => 'i',
		'й' => 'j',
		'к' => 'k',
		'л' => 'l',
		'м' => 'm',
		'н' => 'n',
		'о' => 'o',
		'п' => 'p',
		'р' => 'r',
		'с' => 's',
		'т' => 't',
		'у' => 'u',
		'ф' => 'f',
		'х' => 'kh',
		'ц' => 'c',
		'ч' => 'ch',
		'ш' => 'sh',
		'щ' => 'sch',
		'ь' => '',
		'ы' => 'i',
		'ъ' => '',
		'э' => 'e',
		'ю' => 'yu',
		'я' => 'ya',
		'-,' => '',
		', ' => '-',
		' (' => '-',
		') ' => '',
		')' => '',
		'  ' => '-',
		' ' => '-',
		',' => '-',
		'+' => '-',
		"'" => '',
		'&' => 'i'
	);

	$alias = str_replace(array_keys($table), array_values($table), $string);
	$alias = strtolower($alias);

	return $alias;
}

function get_coupon_title($str, $type)
{
	switch ($type) {
		case 1:
		return trim(str_replace('&', 'и', $str)) . ', бесплатная доставка';
			break;
		
		case 2:
		return trim(str_replace('&', 'и', $str)) . ', скидка на заказ';
			break;
		
		case 3:
		return trim(str_replace('&', 'и', $str)) . ', подарок к заказу';
			break;
	}
}

function get_coupon_meta_title($str, $type)
{
	switch ($type) {
		case 1:
		return trim(str_replace('&', 'и', $str)) . ' с бесплатной доставкой';
			break;
		
		case 2:
		return trim(str_replace('&', 'и', $str)) . ' скидки на заказ';
			break;
		
		case 3:
		return trim(str_replace('&', 'и', $str)) . ' и подарки к заказу';
			break;
	}
}

function get_shop_title($str)
{
	return trim(str_replace('&', 'и', $str)) . ' со скидками';
}

function get_shop_meta_title($str)
{
	return trim(str_replace('&', 'и', $str)) . ' со скидками';
}

$update_alias = $db->prepare('UPDATE categories SET alias=? WHERE id=?');

$meta_sql = $db->prepare('INSERT INTO meta (id, route, title, meta_title, meta_description) VALUES (:id, :route, :title, :meta_title, :meta_description) ON DUPLICATE KEY UPDATE route=:u_route, title=:u_title, meta_title=:u_meta_title, meta_description=:u_meta_description');

$get_by_coupons = $db->prepare('SELECT id FROM coupons WHERE by_reg=? AND category_ids LIKE ? AND type_ids LIKE ? AND available=?');

$get_ru_coupons = $db->prepare('SELECT id FROM coupons WHERE ru_reg=? AND category_ids LIKE ? AND type_ids LIKE ? AND available=?');

$get_ua_coupons = $db->prepare('SELECT id FROM coupons WHERE ua_reg=? AND category_ids LIKE ? AND type_ids LIKE ? AND available=?');

$get_by_shops = $db->prepare('SELECT id FROM shops WHERE by_reg=? AND category_ids LIKE ? AND available=?');

$get_ru_shops = $db->prepare('SELECT id FROM shops WHERE ru_reg=? AND category_ids LIKE ? AND available=?');

$get_ua_shops = $db->prepare('SELECT id FROM shops WHERE ua_reg=? AND category_ids LIKE ? AND available=?');

$set_quantity = $db->prepare('UPDATE categories SET quantity=? WHERE id=?');

$cat_sql = $db->prepare('SELECT * FROM categories');
$cat_sql->execute();
$cats_arr = $cat_sql->fetchAll(PDO::FETCH_ASSOC);

$types = array(
	'free-shipping' => 1,
	'discounts' => 2,
	'gifts' => 3
);

foreach ($cats_arr as $item) {
	$quantity_arr = array();

	// set alias
	$alias = translit(trim($item['name']));

	if (empty($item['alias'])) {
		$update_alias->execute(array($alias, $item['id']));
	}

	// set meta
	if ($item['relation'] == 'coupons') {
		foreach ($types as $key => $val) {
			$tit = get_coupon_title(trim($item['name']), $val);
			$m_tit = get_coupon_meta_title(trim($item['name']), $val);

			$meta_sql->execute(array(
				'id' => $val . $item['id'] . $val,
				'route' => $key . '/' . $item['alias'],
				'title' => $tit,
				'meta_title' => $m_tit,
				'meta_description' => '',
				'u_route' => $key . '/' . $item['alias'],
				'u_title' => $tit,
				'u_meta_title' => $m_tit,
				'u_meta_description' => ''
			));
		}
	} else {
		$tit = get_shop_title(trim($item['name']));
		$m_tit = get_shop_meta_title(trim($item['name']));

		$meta_sql->execute(array(
			'id' => $item['id'],
			'route' => 'shops/' . $item['alias'],
			'title' => $tit,
			'meta_title' => $m_tit,
			'meta_description' => '',
			'u_route' => 'shops/' . $item['alias'],
			'u_title' => $tit,
			'u_meta_title' => $m_tit,
			'u_meta_description' => ''
		));
	}

	// Set Quantity
	// by
	$get_by_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"2"%', 1));
	$by_disc = $get_by_coupons->rowCount();

	$get_by_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"1"%', 1));
	$by_f_ship = $get_by_coupons->rowCount();

	$get_by_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"3"%', 1));
	$by_gift = $get_by_coupons->rowCount();

	$quantity_arr['by_discount'] = $by_disc;
	$quantity_arr['by_f_ship'] = $by_f_ship;
	$quantity_arr['by_gift'] = $by_gift;

	// ru
	$get_ru_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"2"%', 1));
	$ru_disc = $get_ru_coupons->rowCount();

	$get_ru_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"1"%', 1));
	$ru_f_ship = $get_ru_coupons->rowCount();

	$get_ru_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"3"%', 1));
	$ru_gift = $get_ru_coupons->rowCount();

	$quantity_arr['ru_discount'] = $ru_disc;
	$quantity_arr['ru_f_ship'] = $ru_f_ship;
	$quantity_arr['ru_gift'] = $ru_gift;

	// ua
	$get_ua_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"2"%', 1));
	$ua_disc = $get_ua_coupons->rowCount();

	$get_ua_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"1"%', 1));
	$ua_f_ship = $get_ua_coupons->rowCount();

	$get_ua_coupons->execute(array(1, '%"' . $item['id'] . '"%', '%"3"%', 1));
	$ua_gift = $get_ua_coupons->rowCount();

	$quantity_arr['ua_discount'] = $ua_disc;
	$quantity_arr['ua_f_ship'] = $ua_f_ship;
	$quantity_arr['ua_gift'] = $ua_gift;

	// by shops
	$get_by_shops->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$by_shops = $get_by_shops->rowCount();

	$quantity_arr['by_shops'] = $by_shops;

	// ru shops
	$get_ru_shops->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$ru_shops = $get_ru_shops->rowCount();

	$quantity_arr['ru_shops'] = $ru_shops;

	// ua shops
	$get_ua_shops->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$ua_shops = $get_ua_shops->rowCount();

	$quantity_arr['ua_shops'] = $ua_shops;

	// set quantity
	$set_quantity->execute(array(json_encode($quantity_arr), $item['id']));
}

$show = $db->prepare('SELECT * FROM categories WHERE relation=?');

$show->execute(array('coupons'));
$show_coupons_cats = $show->fetchAll(PDO::FETCH_ASSOC);

$show->execute(array('shops'));
$show_shops_cats = $show->fetchAll(PDO::FETCH_ASSOC);

$tit = 'Categories';
include('header.php');
?>
<div class="clr"></div>

<?php
echo '<table><tr><td>Id</td><td>Alias</td><td>Name</td><td>Origin Name</td><td>Quantity JSON</td></tr>';

foreach ($show_coupons_cats as $show) {
	echo '<tr><td>' . $show['id'] . '</td><td>' . $show['alias'] . '</td><td>' . $show['name'] . '</td><td>' . $show['origin_name'] . '</td><td>' . $show['quantity'] . '</td></tr>';
}

echo '</table>';

echo '<table><tr><td>Id</td><td>Alias</td><td>Name</td><td>Origin Name</td><td>Quantity JSON</td></tr>';

foreach ($show_shops_cats as $show) {
	echo '<tr><td>' . $show['id'] . '</td><td>' . $show['alias'] . '</td><td>' . $show['name'] . '</td><td>' . $show['origin_name'] . '</td><td>' . $show['quantity'] . '</td></tr>';
}

echo '</table>';
