<?php
if(!empty($_POST['change-available'])){
	$update_shop = $db -> prepare('UPDATE shops SET available=?, popular=? WHERE alias=?');

	foreach($_POST['available'] as $shop => $val){
		$update_shop -> execute(array($val, $_POST['popular'][$shop], $shop));
	}
}

// get shops
$shops = $db -> prepare('SELECT * FROM shops ORDER BY name');
$shops -> execute();
$shops = $shops -> fetchAll(PDO::FETCH_ASSOC);

// coupons available
if(!empty($_POST['change-available'])){
	$upd_coupons_available = $db -> prepare('UPDATE coupons SET available=? WHERE shop_id=?');

	foreach ($shops as $item) {
		$upd_coupons_available -> execute(array($item['available'], $item['id']));
	}
}

$tit = "Shops";
include('header.php');
?>
<div class="clr"></div>

<form id="shops-form" class="shops-form" action="" method="POST">
<table>
<tr class="bold"><td>Shop</td><td>Country</td><td>Coupons Quantity</td><td>-actions-</td><tr>
<?php
foreach($shops as $arr){
echo '<tr>
<td>'. $arr['name'] .'</td>
<td>'. $arr['region'] .'</td>
<td>'. $arr['quantity'] .'</td>
<td>';

echo '<input type="hidden" name="change-available" value="true">
	<select name="available['.$arr['alias'].']"'; if($arr['available'] == 0){echo ' class="bg-orange"';}  echo '>
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
</table>
</form>