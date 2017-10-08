<?php
if(!empty($_POST['change-available'])){
	$update_disc = $db->db->prepare('UPDATE discounts SET available=? WHERE shop=?');
	$update_shop = $db->db->prepare('UPDATE shops SET available=? WHERE alias=?');
	foreach($_POST['available'] as $shop=>$val){
		$update_disc->execute(array($val,$shop));
		$update_shop->execute(array($val,$shop));
	}
}

function shops($db){
	$shops = $db->db->prepare('SELECT * FROM shops ORDER BY name');
	$shops->execute();
	$shops = $shops->fetchAll(PDO::FETCH_ASSOC);
	return $shops;
}

function quant($shop,$db){
	$pagcount = $db->db->prepare('SELECT id FROM discounts WHERE shop=?');
	$pagcount->execute(array($shop));
	$pagcount = $pagcount->rowCount();
	return $pagcount;
}

$tit = "Shops";
include('header.php');
?>
<form id="shops-form" class="shops-form" action="" method="POST">
<table>
<tr class="bold"><td>Shop</td><td>Discounts Quantity</td><td>Actions</td><tr>
<?php
foreach(shops($db) as $arr){
echo '<tr>
<td>'.$arr['name'].'</td>
<td>'.quant($arr['alias'],$db).'</td>
<td>
	<a href="?route=import-discounts&region='.$arr['region'].'&shop='.$arr['alias'].'" >Upload Discounts</a>
	<a href="?route=show-discounts&shop='.$arr['alias'].'" >Show Discounts List</a>
	<input type="hidden" name="change-available" value="true">
	<select name="available['.$arr['alias'].']">
		<option value="1"'; if($arr['available'] == 1){echo 'selected';}
		echo '>on</option>
		<option value="0"'; if($arr['available'] == 0){echo 'selected';}
		echo '>Off</option>
	</select>
</td>
</tr>';
}
?>
</table></form>