<?php
/*
Import of discounts
*/

$ins_act = $db->prepare('INSERT INTO discounts (id,category,title,description,promocode,discount,dis_count,date_start,date_end,url,shop,region) VALUES (:id,:category,:title,:description,:promocode,:discount,:dis_count,:date_start,:date_end,:url,:shop,:region)');

function get_shop($shop,$db){
	$get_act = $db->prepare('SELECT id,csv_discounts FROM shops WHERE alias=?');
	$get_act->execute(array($shop));
	$return = $get_act->fetch(PDO::FETCH_ASSOC);
	return $return;
}

function check_csv($csv_link){
	$row=1;
	$f_csv = fopen ($csv_link,'r');
	while ($row < 3 && ($data = fgetcsv($f_csv,0,';')) !== false){
		$import[$row] = $data;
		$row++;
	}
	fclose ($f_csv);
return $import;	
}

function import_csv($import_csv_link){
	$row=1;
	$f_csv = fopen ($import_csv_link,'r');
	while (($data = fgetcsv($f_csv,0,';')) !== false){
		if($row!==1){
			$import[$row] = $data;
		}
		$row++;
	}
	fclose ($f_csv);
return $import; 
}

if(isset($_GET['shop'])){
	$shop = $_GET['shop'];
	$region = $_GET['region'];
}
elseif(isset($_POST['shop'])){
	$shop = $_POST['shop'];
	$region = $_POST['region'];
}
if(isset($_GET['shop'])){
	$the_shop = get_shop($_GET['shop'],$db);
	$the_link = $the_shop['csv_discounts'];
	$the_shop_name = $the_shop['name'];
}

$tit = 'Upload '.$the_shop_name.' Discounts';
include('header.php');

if(isset($_POST['import_csv_link'])){
	$get_discounts = $db->prepare('SELECT id,date_end FROM discounts WHERE shop=?');
	$del_discount = $db->prepare('DELETE FROM discounts WHERE id=?');
	$get_discounts->execute(array($shop));
	$get_discounts_arr = $get_discounts->fetchAll(PDO::FETCH_ASSOC);
	$current_time = time();
	foreach($get_discounts_arr as $item){
		$d_sec = strtotime($item['date_end']) - $current_time;
		if($d_sec <= 0){
			$del_discount->execute(array($item['id']));
		}
	}
	
	
	$import_csv = import_csv($_POST['import_csv_link']);
	
	
	
	foreach($import_csv as $field){
		
		if($field[$_POST['promocode']] != 'Не нужен'){
			$field_promocode = $field[$_POST['promocode']];
		}
		else{
			$field_promocode = '';
		}
		
		if(!empty($field[$_POST['discount']])){
			$dis_count = substr($field[$_POST['discount']],0,-1);
		}
		else{
			$dis_count = 0;
		}
		
		$ins_act->execute(array(
		'id'=>$the_shop['id'].$field[0].$the_shop['id'],
		'category'=>$field[$_POST['category']],
		'title'=>$field[$_POST['title']],
		'description'=>$field[$_POST['description']],
		'promocode'=>$field_promocode,
		'discount'=>$field[$_POST['discount']],
		'dis_count'=>$dis_count,
		'date_start'=>$field[$_POST['date_start']],
		'date_end'=>$field[$_POST['date_end']],
		'url'=>$field[$_POST['url']],
		'shop'=>$shop,
		'region'=>$region
		));
	}
echo '<p class="message">Загружено</p>';
}
else if(isset($_GET['shop'])){
	$import_fields = check_csv($the_link);
?>
<div class="wrap">
<form action="" method="POST" class="key-form">
	<p><label>category*</label><input type="text" name="category" value="17" required/></p>
	<p><label>title*</label><input type="text" name="title" value="1" required/></p>
	<p><label>description*</label><input type="text" name="description" value="8" required/></p>
	<p><label>promocode*</label><input type="text" name="promocode" value="10" required/></p>
	<p><label>discount*</label><input type="text" name="discount" value="19" required/></p>
	<p><label>date_start*</label><input type="text" name="date_start" value="13" required/></p>
	<p><label>date_end*</label><input type="text" name="date_end" value="14" required/></p>
	<p><label>url*</label><input type="text" name="url" value="12" required/></p>

	<input type="hidden" name="import_csv_link" value="<?php echo $the_link;?>" />
	<input type="submit" value="Import" />
</form>
<div class="key-form check">
<?php
foreach($import_fields[1] as $key_field=>$name_field){
	echo '<p><b>'.$key_field.'*</b> - '.$name_field.'</p>';
}
?>	
</div>
<div style="width:621px" class="key-form check">
<?php
if(!empty($import_fields[2])){
	foreach($import_fields[2] as $key_field=>$name_field){
		echo '<p><b>'.$key_field.'*</b> - '.$name_field.'</p>';
	}
}
else{
	echo '<p><b>Empty</b></p>';
}


?>	
</div>
<div class="clr"></div>
</div>
<?php
}
?>