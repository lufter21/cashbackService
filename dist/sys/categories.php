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

function get_title($str, $div)
{
	if ($div == 'shops') {
		return trim(str_replace('&', 'и', $str)) . ' с промокодами и скидками';
	} else {
		return trim(str_replace('&', 'и', $str)) . ' промокоды и скидки';
	}
}

function get_meta_title($str, $div)
{
	if ($div == 'shops') {
		return trim(str_replace('&', 'и', $str)) . ' с промокодами и скидками';
	} else {
		return 'Скидки на ' . mb_strtolower(trim(str_replace('&', 'и', $str)), 'UTF-8') . ', промокоды';
	}
}

$update_alias = $db->prepare('UPDATE categories SET alias=? WHERE id=?');

$set_title = $db->prepare('UPDATE categories SET title=? WHERE id=?');

$set_meta_title = $db->prepare('UPDATE categories SET meta_title=? WHERE id=?');

$get_by_coupons = $db->prepare('SELECT id FROM coupons WHERE by_reg=? AND category_ids LIKE ? AND available=?');
$get_ru_coupons = $db->prepare('SELECT id FROM coupons WHERE ru_reg=? AND category_ids LIKE ? AND available=?');
$get_ua_coupons = $db->prepare('SELECT id FROM coupons WHERE ua_reg=? AND category_ids LIKE ? AND available=?');

$get_by_shops = $db->prepare('SELECT id FROM shops WHERE by_reg=? AND category_ids LIKE ? AND available=?');
$get_ru_shops = $db->prepare('SELECT id FROM shops WHERE ru_reg=? AND category_ids LIKE ? AND available=?');
$get_ua_shops = $db->prepare('SELECT id FROM shops WHERE ua_reg=? AND category_ids LIKE ? AND available=?');

$set_by_qnt = $db->prepare('UPDATE categories SET by_qnt=? WHERE id=?');

$set_ru_qnt = $db->prepare('UPDATE categories SET ru_qnt=? WHERE id=?');

$set_ua_qnt = $db->prepare('UPDATE categories SET ua_qnt=? WHERE id=?');

$set_by_shops = $db->prepare('UPDATE categories SET by_shops=? WHERE id=?');

$set_ru_shops = $db->prepare('UPDATE categories SET ru_shops=? WHERE id=?');

$set_ua_shops = $db->prepare('UPDATE categories SET ua_shops=? WHERE id=?');

$cat_sql = $db->prepare('SELECT * FROM categories');
$cat_sql->execute();
$cats_arr = $cat_sql->fetchAll(PDO::FETCH_ASSOC);

foreach ($cats_arr as $item) {
	// set alias
	$alias = translit(trim($item['name']));

	if (empty($item['alias'])) {
		$update_alias->execute(array($alias, $item['id']));
	}

	// set titles
	$tit = get_title(trim($item['name']), $item['relation']);

	if (empty($item['title'])) {
		$set_title->execute(array($tit, $item['id']));
	}

	$m_tit = get_meta_title(trim($item['name']), $item['relation']);

	if (empty($item['meta_title'])) {
		$set_meta_title->execute(array($m_tit, $item['id']));
	}

	// Set Quantity
	// by
	$get_by_coupons->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$by_qnt = $get_by_coupons->rowCount();

	$set_by_qnt->execute(array($by_qnt, $item['id']));

	// ru
	$get_ru_coupons->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$ru_qnt = $get_ru_coupons->rowCount();

	$set_ru_qnt->execute(array($ru_qnt, $item['id']));

	// ua
	$get_ua_coupons->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$ua_qnt = $get_ua_coupons->rowCount();

	$set_ua_qnt->execute(array($ua_qnt, $item['id']));

	// by shops
	$get_by_shops->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$by_shops = $get_by_shops->rowCount();

	$set_by_shops->execute(array($by_shops, $item['id']));

	// ru shops
	$get_ru_shops->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$ru_shops = $get_ru_shops->rowCount();

	$set_ru_shops->execute(array($ru_shops, $item['id']));

	// ua shops
	$get_ua_shops->execute(array(1, '%"' . $item['id'] . '"%', 1));
	$ua_shops = $get_ua_shops->rowCount();

	$set_ua_shops->execute(array($ua_shops, $item['id']));
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
echo '<table><tr><td>Id</td><td>Alias</td><td>Name</td><td>Origin Name</td><td>Title</td><td>Description</td><td>By Disc</td><td>Ru Disc</td><td>Ua Disc</td></tr>';

foreach ($show_coupons_cats as $show) {
	echo '<tr><td>' . $show['id'] . '</td><td>' . $show['alias'] . '</td><td>' . $show['name'] . '</td><td>' . $show['origin_name'] . '</td><td>' . $show['title'] . '</td><td>' . $show['description'] . '</td><td>' . $show['by_qnt'] . '</td><td>' . $show['ru_qnt'] . '</td><td>' . $show['ua_qnt'] . '</td><tr>';
}

echo '</table>';

echo '<table><tr><td>Id</td><td>Alias</td><td>Name</td><td>Origin Name</td><td>Title</td><td>Description</td><td>By Shops</td><td>Ru Shops</td><td>Ua Shops</td></tr>';

foreach ($show_shops_cats as $show) {
	echo '<tr><td>' . $show['id'] . '</td><td>' . $show['alias'] . '</td><td>' . $show['name'] . '</td><td>' . $show['origin_name'] . '</td><td>' . $show['title'] . '</td><td>' . $show['description'] . '</td><td>' . $show['by_shops'] . '</td><td>' . $show['ru_shops'] . '</td><td>' . $show['ua_shops'] . '</td><tr>';
}

echo '</table>';
