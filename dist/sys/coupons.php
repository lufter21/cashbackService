<?php
// get cats
$get_cats = $db->prepare('SELECT * FROM categories WHERE relation=?');
$get_cats->execute(array('coupons'));
$cats_result = $get_cats->fetchAll(PDO::FETCH_ASSOC);

// fun get coupon cats
function get_coupon_categories($coupon, $cats)
{
	$categories = array('txt' => '', 'ids' => '');
	$k = 0;

	foreach ($coupon as $value) {
		$categories['txt'] .= (($k) ? ', ' : '') . $cats[$value];
		$categories['ids'] .= (($k) ? ',' : '') . '"' . $value . '"';
		$k++;
	}

	return $categories;
}


if (!empty($_POST['change-available'])) {
	// change cats
	$cats_arr = array();

	foreach ($cats_result as $value) {
		$cats_arr[$value['id']] = $value['name'];
	}

	$update_coupon = $db->prepare('UPDATE coupons SET category=?, category_ids=? WHERE id=?');

	if ($_POST['cat_id']) {
		foreach ($_POST['cat_id'] as $cp_id => $val) {
			$cat = get_coupon_categories($val, $cats_arr);

			$update_coupon->execute(array($cat['txt'], $cat['ids'], $cp_id));
		}
	}

	// change translated title
	$update_coupon_tit = $db->prepare('UPDATE coupons SET title_translated=? WHERE id=?');

	if ($_POST['tr_tit']) {
		foreach ($_POST['tr_tit'] as $cp_id => $val) {
			$update_coupon_tit->execute(array($val, $cp_id));
		}
	}

	// change translated description
	$update_coupon_desc = $db->prepare('UPDATE coupons SET description_translated=? WHERE id=?');

	if ($_POST['tr_desc']) {
		foreach ($_POST['tr_desc'] as $cp_id => $val) {
			$update_coupon_desc->execute(array($val, $cp_id));
		}
	}
}

// get coupons
$coupons = $db->prepare('SELECT * FROM coupons ORDER BY rating DESC');
$coupons->execute();
$coupons = $coupons->fetchAll(PDO::FETCH_ASSOC);


$tit = "coupons";
include('header.php');
?>
<div class="clr"></div>

<form id="coupons-form" class="coupons-form" action="" method="POST">
	<input type="submit" value="Save">
	<input type="hidden" name="change-available" value="true">

	<table>
		<tr class="bold">
			<td>id</td>
			<td>Title</td>
			<td>Desc</td>
			<?php foreach ($cats_result as $val) { ?>
				<td><?php echo $val['name']; ?></td>
			<?php } ?>
		</tr>

		<?php foreach ($coupons as $k => $arr) { ?>
			<tr>
				<td>
					<?php echo $arr['id']; ?>
				</td>
				<td>
					<?php echo $arr['title']; ?>
					<input type="text" data-name="tr_tit[<?php echo $arr['id']; ?>]" value="<?php echo $arr['title_translated']; ?>">
				</td>
				<td>
					<?php echo $arr['description']; ?>
					<input type="text" data-name="tr_desc[<?php echo $arr['id']; ?>]" value="<?php echo $arr['description_translated']; ?>">
				</td>

				<?php foreach ($cats_result as $key => $val) { ?>
					<td><input type="checkbox" data-name="cat_id[<?php echo $arr['id']; ?>][<?php echo $key; ?>]" value="<?php echo $val['id']; ?>" <?php echo (strpos($arr['category_ids'], '"' . $val['id'] . '"') !== false) ? 'checked' : ''; ?>></td>
				<?php } ?>
			</tr>


			<?php if ($k > 0 && $k % 5 == 0) { ?>
				<tr class="bold">
					<td>id</td>
					<td>Title</td>
					<td>Desc</td>
					<?php foreach ($cats_result as $val) { ?>
						<td><?php echo $val['name']; ?></td>
					<?php } ?>
				</tr>
			<?php } ?>

		<?php } ?>

	</table>
	<input type="submit" value="Save">
</form>