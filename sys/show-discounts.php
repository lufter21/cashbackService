<?php

if(!empty($_POST['update'])){
	if(!empty($_POST['param'])){
		$update_disc = $db->prepare('UPDATE discounts SET category=? WHERE id=?');
		foreach($_POST['param'] as $key=>$val){
			$update_disc->execute(array($val['category'],$key));
		}
	}
}

$pre = $db->prepare('SELECT * FROM discounts WHERE shop=? ORDER BY category');
$pre->execute(array($_GET['shop']));
$pre = $pre->fetchAll(PDO::FETCH_ASSOC);

$del = $db->prepare('DELETE FROM discounts WHERE id=?');

$tit = $_GET['shop'].' discounts';
include('header.php');
echo '<form class="upd-cats" action="" method="POST">
<input type="hidden" name="update" value="true">
<table><tr class="bold"><td>Category</td><td>Title</td><td>Description</td></tr>';
$current_time = time();
foreach($pre as $pre){
	$d_sec = strtotime($pre['date_end']) - $current_time;
	if($d_sec > 0){
	echo '<tr id="row'.$pre['id'].'" data-id="'.$pre['id'].'" ';
	echo '><td id="category'.$pre['id'].'" style="color:brown">'.$pre['category'].'</td>
	<td style="color:green">'.$pre['title'].'</td>
	<td style="color:gray">'.$pre['description'].'</td>
	<tr>';
	}
	else{
		$del->execute(array($pre['id']));
	}
}
echo '</table><input class="upd-cats-btn" type="submit" value="Save Changes"></form>';
?>