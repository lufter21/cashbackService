<?php
if(!empty($_POST['change-available'])){
	$update_disc = $db->prepare('UPDATE discounts SET available=? WHERE shop=?');
	$update_shop = $db->prepare('UPDATE shops SET available=?, popular=? WHERE alias=?');
	foreach($_POST['available'] as $shop => $val){
		$update_disc->execute(array($val, $shop));
		$update_shop->execute(array($val, $_POST['popular'][$shop], $shop));
	}
}

function shops($db){
	$shops = $db->prepare('SELECT * FROM shops ORDER BY name');
	$shops->execute();
	$shops = $shops->fetchAll(PDO::FETCH_ASSOC);
	return $shops;
}

function quant($shop,$db){
	$pagcount = $db->prepare('SELECT id FROM discounts WHERE shop=?');
	$pagcount->execute(array($shop));
	$pagcount = $pagcount->rowCount();
	return $pagcount;
}

$tit = "Shops";
include('header.php');
?>

<div class="right">
	<a class="btn" href="?route=update-shops">Update shops</a>
</div>

<div class="clr"></div>

<form id="shops-form" class="shops-form" action="" method="POST">
<table>
<tr class="bold"><td>Shop</td><td>Country</td><td>Coupons Quantity</td><td>-actions-</td><tr>
<?php
foreach(shops($db) as $arr){
echo '<tr>
<td>'.$arr['name'].'</td>
<td>'.$arr['region'].'</td>
<td>'.quant($arr['alias'],$db).'</td>
<td>';

echo '<a href="?route=show-discounts&shop='.$arr['alias'].'" >Show Coupons List</a>';

echo '<input type="hidden" name="change-available" value="true">
	<select name="available['.$arr['alias'].']">
		<option value="1"'; if($arr['available'] == 1){echo 'selected';}
		echo '>on</option>
		<option value="0"'; if($arr['available'] == 0){echo 'selected';}
		echo '>Off</option>
	</select>
	<select name="popular['.$arr['alias'].']">
		<option value="1"'; if($arr['popular'] == 1){echo 'selected';}
		echo '>IS POPULAR</option>
		<option value="0"'; if($arr['popular'] == 0){echo 'selected';}
		echo '>no popular</option>
	</select>
</td>
</tr>';
}
?>
</table></form>