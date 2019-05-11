<?php
// get cats
$get_cats = $db->prepare('SELECT * FROM categories');
$get_cats->execute();
$cats_result = $get_cats->fetchAll(PDO::FETCH_ASSOC);

$coupon_cats_result = array();
$cats_arr = array();

foreach ($cats_result as $value) {
	if ($value['relation'] == 'coupons') {
		$coupon_cats_result[] = $value;
	}

	$cats_arr[$value['id']] = $value;
}

// fun get coupon cats
function get_categories_data($cat_ids_arr, $cats_arr)
{
	$categories = array('txt' => '', 'ids' => array());
	$k = 0;

	foreach ($cat_ids_arr as $value) {
		$categories['txt'] .= (($k) ? ', ' : '') . $cats_arr[$value]['name'];
		$categories['ids'][] = (string)$value;
		$k++;
	}

	$categories['ids'] = json_encode($categories['ids']);

	return $categories;
}

// change cats
if (!empty($_POST['change-available'])) {
	$update_coupon = $db->prepare('UPDATE coupons SET category=?, category_ids=?, manual_cats=? WHERE id=?');

	if ($_POST['cat_id']) {
		foreach ($_POST['cat_id'] as $cp_id => $val) {
			$cat = get_categories_data($val, $cats_arr);

			$update_coupon->execute(array($cat['txt'], $cat['ids'], 1, $cp_id));
		}
	}

	// change deeplink
	$update_coupon_deeplink = $db->prepare('UPDATE coupons SET deeplink=? WHERE id=?');

	if ($_POST['dpl']) {
		foreach ($_POST['dpl'] as $cp_id => $val) {
			$update_coupon_deeplink->execute(array($val, $cp_id));
		}
	}

	// change similar
	$update_coupon_similar = $db->prepare('UPDATE coupons SET similar=? WHERE id=?');

	if ($_POST['sim']) {
		foreach ($_POST['sim'] as $cp_id => $val) {
			$update_coupon_similar->execute(array($val, $cp_id));
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
if ($_GET['shop_id']) {
	$coupons = $db->prepare('SELECT * FROM coupons WHERE shop_id=? ORDER BY rating DESC');
	$coupons->execute(array($_GET['shop_id']));
	$coupons = $coupons->fetchAll(PDO::FETCH_ASSOC);
} elseif ($_GET['order_empty_cat']) {
	$coupons = $db->prepare('SELECT * FROM coupons ORDER BY category_ids DESC');
	$coupons->execute();
	$coupons = $coupons->fetchAll(PDO::FETCH_ASSOC);
} else {
	$coupons = $db->prepare('SELECT * FROM coupons ORDER BY rating DESC');
	$coupons->execute();
	$coupons = $coupons->fetchAll(PDO::FETCH_ASSOC);
}

// update coupon categories
if ($_GET['upd_cats']) {
	$upd_coupon_cats = $db->prepare('UPDATE coupons SET category=?, category_ids=?  WHERE id=?');

	$shops_arr = array();

	// get shops
	$shops = $db->prepare('SELECT * FROM shops');
	$shops->execute();
	$shops_result = $shops->fetchAll(PDO::FETCH_ASSOC);

	foreach ($shops_result as $val) {
		$shops_arr[$val['id']] = $val;
	}

	// process
	foreach ($coupons as $item) {
		if ($item['manual_cats']) {
			continue;
		}

		$new_coupon_cat_ids_arr = array();

		$coupon_cat_ids = json_decode($item['category_ids'], true);

		$shop_cat_ids = json_decode($shops_arr[$item['shop_id']]['category_ids'], true);

		foreach ($coupon_cat_ids as $k => $cat_id) {
			$related = $cats_arr[$cat_id]['related_cats'];

			if (in_array($related, $shop_cat_ids)) {
				$new_coupon_cat_ids_arr[] = $cat_id;
			}
		}

		$cat = get_categories_data($new_coupon_cat_ids_arr, $cats_arr);

		$upd_coupon_cats->execute(array($cat['txt'], $cat['ids'], $item['id']));
	}
}

$tit = "Coupons";
include('header.php');
?>
<div class="left">
	<a href="?route=coupons&upd_cats=1" class="btn btn_red">Update Cats!</a>
</div>
<div class="left">
	<a href="?route=coupons&order_empty_cat=1">Order by empty Cats</a>
</div>
<div class="clr"></div>

<form id="coupons-form" class="coupons-form" action="" method="POST">
	<input type="submit" value="Save">
	<input type="hidden" name="change-available" value="true">

	<table>
		<tr class="bold">
			<td>id</td>
			<td>Deeplink</td>
			<td>Similar(json)</td>
			<td>Title</td>
			<td>Desc</td>
			<?php foreach ($coupon_cats_result as $val) { ?>
				<td><?php echo $val['name']; ?></td>
			<?php } ?>
		</tr>

		<?php foreach ($coupons as $k => $arr) { ?>
			<tr <?php echo ($arr['category_ids'] == '[]') ? 'class="bg-yellow"' : ''; ?>>
				<td>
					<a href="/coupon/<?php echo $arr['id']; ?>" target="_blank"><?php echo $arr['id']; ?></a>
				</td>
				<td>
					<input type="text" data-name="dpl[<?php echo $arr['id']; ?>]" value="<?php echo $arr['deeplink']; ?>">
				</td>
				<td>
					<input type="text" data-name="sim[<?php echo $arr['id']; ?>]" value="<?php echo $arr['similar']; ?>">
				</td>
				<td>
					<?php echo $arr['title']; ?>
					<input type="text" data-name="tr_tit[<?php echo $arr['id']; ?>]" value="<?php echo $arr['title_translated']; ?>">
				</td>
				<td>
					<?php echo $arr['description']; ?>
					<input type="text" data-name="tr_desc[<?php echo $arr['id']; ?>]" value="<?php echo $arr['description_translated']; ?>">
				</td>

				<?php foreach ($coupon_cats_result as $key => $val) { ?>
					<td><input type="checkbox" data-name="cat_id[<?php echo $arr['id']; ?>][<?php echo $key; ?>]" value="<?php echo $val['id']; ?>" <?php echo (strpos($arr['category_ids'], '"' . $val['id'] . '"') !== false) ? 'checked' : ''; ?>></td>
				<?php } ?>
			</tr>


			<?php if ($k > 0 && $k % 5 == 0) { ?>
				<tr class="bold">
					<td>id</td>
					<td>Deeplink</td>
					<td>Similar(json)</td>
					<td>Title</td>
					<td>Desc</td>
					<?php foreach ($coupon_cats_result as $val) { ?>
						<td><?php echo $val['name']; ?></td>
					<?php } ?>
				</tr>
			<?php } ?>

		<?php } ?>

	</table>
	<input type="submit" value="Save">
</form>