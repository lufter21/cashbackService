<?php

if(!empty($_POST['update_cats'])){
	
	if(!empty($_POST['del_cat'])){
		$del_cats = $db->prepare('DELETE FROM categories WHERE id=?');
		foreach($_POST['del_cat'] as $val){
			$del_cats->execute(array($val));
		}
	}
	
	if(!empty($_POST['param'])){
		$update_cats = $db->prepare('UPDATE categories SET nav=?,id=?,name=?,title=?,description=? WHERE id=?');
		foreach($_POST['param'] as $key=>$val){
			$update_cats->execute(array($val['nav'],$val['id'],$val['name'],$val['title'],$val['description'],$key));
		}
	}
}


if(!empty($_POST['add_cat'])){
	
	$add_cat = $db->prepare('INSERT INTO categories (id,nav,id,name,title) VALUES (:id,:nav,:id,:name,:title)');
	
	$add_cat->execute(array(
		'id'=>$_POST['param']['id'],
		'nav'=>$_POST['param']['nav'],
		'id'=>$_POST['param']['id'],
		'name'=>$_POST['param']['name'],
		'title'=>$_POST['param']['title']
	));
}



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

function par_al($pre_par_id,$db){
	$pre_par = $db->prepare('SELECT * FROM categories WHERE id=?');
	$pre_par->execute(array($pre_par_id));
	$pre_par = $pre_par->fetch(PDO::FETCH_ASSOC);
	return $pre_par;
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

if(!empty($_POST['add_cat']) || !empty($_POST['update_cats']) || (!empty($_GET['action']) && $_GET['action'] == 'rfd')){
	$update_alias = $db->prepare('UPDATE categories SET alias=? WHERE id=?');
	
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

	$pre = $db->prepare('SELECT * FROM categories');
	$pre->execute();
	$pre = $pre->fetchAll(PDO::FETCH_ASSOC);

	foreach($pre as $pre){
		$alias = translit(trim($pre['name']));
		if (empty($pre['alias'])) {
			$update_alias->execute(array($alias,$pre['id']));
		}
		
		$get_all_qnt->execute(array('all','%'.$pre['id'].'%',1));
		$set_all_qnt->execute(array($get_all_qnt->rowCount(),$pre['id']));
		
		$get_ru_qnt->execute(array('ru','%'.$pre['id'].'%',1));
		$set_ru_qnt->execute(array($get_ru_qnt->rowCount(),$pre['id']));
		
		$get_ua_qnt->execute(array('ua','%'.$pre['id'].'%',1));
		$set_ua_qnt->execute(array($get_ua_qnt->rowCount(),$pre['id']));
		
		$get_all_shops->execute(array('all','%'.$pre['id'].'%',1));
		$set_all_shops->execute(array($get_all_shops->rowCount(),$pre['id']));
		
		$get_ru_shops->execute(array('ru','%'.$pre['id'].'%',1));
		$set_ru_shops->execute(array($get_ru_shops->rowCount(),$pre['id']));
		
		$get_ua_shops->execute(array('ua','%'.$pre['id'].'%',1));
		$set_ua_shops->execute(array($get_ua_shops->rowCount(),$pre['id']));
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