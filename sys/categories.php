<?php
function translit($string){
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
		'-,'=> '',
		', '=> '-',		   
		' ('=> '-',
		') '=> '',
		')'=> '',
		'  '=> '-',
		' '=> '-',
		','=> '-',
		'+'=> '-',
		"'"=>'',
		'&'=>'i'
	); 
	
	$alias = str_replace(array_keys($table),array_values($table),$string);
	$alias = strtolower($alias);

	return $alias;
}

function get_title($str) {
	return trim(str_replace('&', 'и', $str)) .' промокоды акции и скидки';
}

if(!empty($_GET['action']) && $_GET['action'] == 'rfd'){
	$del_discount = $db->prepare('DELETE FROM coupons WHERE id=?');
	$get_discounts = $db->prepare('SELECT id,date_end FROM coupons');
	$get_discounts->execute();
	$get_discounts_arr = $get_discounts->fetchAll(PDO::FETCH_ASSOC);
	$current_time = time();
	$i_del=0;
	foreach($get_discounts_arr as $item){
		$d_sec = strtotime($item['date_end']) - $current_time;
		if($d_sec <= 0){
			$i_del++;
			$del_discount->execute(array($item['id']));
		}
	}
}

if(!empty($_POST['update_cats']) || (!empty($_GET['action']) && $_GET['action'] == 'rfd')){
	$update_alias = $db->prepare('UPDATE categories SET alias=? WHERE id=?');

	$set_title = $db->prepare('UPDATE categories SET title=? WHERE id=?');
	
	$set_all_qnt = $db->prepare('UPDATE categories SET all_qnt=? WHERE id=?');
	$get_all_qnt = $db->prepare('SELECT id FROM coupons WHERE region=? AND category_ids LIKE ? AND available=?');
	
	$set_ru_qnt = $db->prepare('UPDATE categories SET ru_qnt=? WHERE id=?');
	$get_ru_qnt = $db->prepare('SELECT id FROM coupons WHERE region=? AND category_ids LIKE ? AND available=?');
	
	$set_ua_qnt = $db->prepare('UPDATE categories SET ua_qnt=? WHERE id=?');
	$get_ua_qnt = $db->prepare('SELECT id FROM coupons WHERE region=? AND category_ids LIKE ? AND available=?');
	
	$set_all_shops = $db->prepare('UPDATE categories SET all_shops=? WHERE id=?');
	$get_all_shops = $db->prepare('SELECT id FROM shops WHERE region=? AND category_ids LIKE ? AND available=?');
	
	$set_ru_shops = $db->prepare('UPDATE categories SET ru_shops=? WHERE id=?');
	$get_ru_shops = $db->prepare('SELECT id FROM shops WHERE region=? AND category_ids LIKE ? AND available=?');
	
	$set_ua_shops = $db->prepare('UPDATE categories SET ua_shops=? WHERE id=?');
	$get_ua_shops = $db->prepare('SELECT id FROM shops WHERE region=? AND category_ids LIKE ? AND available=?');
	
	$cat_sql = $db -> prepare('SELECT * FROM categories');
	$cat_sql -> execute();
	$cats_arr = $cat_sql -> fetchAll(PDO::FETCH_ASSOC);
	
	foreach($cats_arr as $item){
		// set alias
		$alias = translit(trim($item['name']));

		if (empty($item['alias'])) {
			$update_alias->execute(array($alias, $item['id']));
		}

		// set titles
		$tit = get_title(trim($item['name']));

		if (empty($item['title'])) {
			$set_title->execute(array($tit, $item['id']));
		}
		
		// set quantity
		$get_all_qnt->execute(array('all','%'.$item['id'].'%',1));
		$set_all_qnt->execute(array($get_all_qnt->rowCount(),$item['id']));
		
		$get_ru_qnt->execute(array('ru','%'.$item['id'].'%',1));
		$set_ru_qnt->execute(array($get_ru_qnt->rowCount(),$item['id']));
		
		$get_ua_qnt->execute(array('ua','%'.$item['id'].'%',1));
		$set_ua_qnt->execute(array($get_ua_qnt->rowCount(),$item['id']));
		
		$get_all_shops->execute(array('all','%'.$item['id'].'%',1));
		$set_all_shops->execute(array($get_all_shops->rowCount(),$item['id']));
		
		$get_ru_shops->execute(array('ru','%'.$item['id'].'%',1));
		$set_ru_shops->execute(array($get_ru_shops->rowCount(),$item['id']));
		
		$get_ua_shops->execute(array('ua','%'.$item['id'].'%',1));
		$set_ua_shops->execute(array($get_ua_shops->rowCount(),$item['id']));
	}
}


$show = $db->prepare('SELECT * FROM categories');
$show->execute();
$show = $show->fetchAll(PDO::FETCH_ASSOC);

$tit = 'Categories';
include('header.php');
if($i_del > 0){
	echo '<p class="message" style="padding-top:30px">Удалено '.$i_del.' скидок</p>';
}
?>

<div class="left">
<a href="?route=update-categories" class="btn">Update Categories</a>
</div>
<div class="clr"></div>
<form class="upd-cats" action="" method="POST">
<input type="hidden" name="update_cats" value="true">
<input class="upd-cats-btn" type="submit" value="Save Changes">
</form>

<?php
echo '<table><tr><td>Id</td><td>Alias</td><td>Name</td><td>Title</td><td>Description</td><td>All Disc</td><td>Ru Disc</td><td>Ua Disc</td><td>All Shops</td><td>Ru Shops</td><td>Ua Shops</td></tr>';

foreach($show as $show){
	echo '<tr><td>'.$show['id'].'</td><td>'.$show['alias'].'</td><td>'.$show['name'].'</td><td>'.$show['title'].'</td><td>'.$show['description'].'</td><td>'.$show['all_qnt'].'</td><td>'.$show['ru_qnt'].'</td><td>'.$show['ua_qnt'].'</td><td>'.$show['all_shops'].'</td><td>'.$show['ru_shops'].'</td><td>'.$show['ua_shops'].'</td><tr>';
}

echo '</table>';