<?php
$meta = array('title' => $content['search'], 'description' => '', 'name' => $content['search'], 'text' => '');
include('header.php');
?>
<!--Container/-->
	<div class="container wrap">
<div class="clear">
	<article class="content-block search-page">
		<h1><span>вы ищите:</span> <?php echo $meta['name'];?></h1>
	</article>
	<?php
	if(!empty($content['discounts'])){
	?>
	<div class="sorting-block">
		<form id="sorting-form" action="/search" method="POST">
			<select name="sorting">
				<option value=" ORDER BY dis_count DESC" <?php if($content['sorting'] == ' ORDER BY dis_count DESC'){echo 'selected';}?>>Наибольшие скидки</option>
				<option value=" ORDER BY date_start DESC" <?php if($content['sorting'] == ' ORDER BY date_start DESC'){echo 'selected';}?>>Самые новые</option>
				<option value=" ORDER BY date_end ASC" <?php if($content['sorting'] == ' ORDER BY date_end ASC'){echo 'selected';}?>>Скоро заканчиваются</option>
			</select>
		</form>
	</div>
	<?php
	}
	?>
</div>
<div class="discounts-block clear">
<?php
if(!empty($content['discounts'])){
	$current_time = time();
	foreach($content['discounts'] as $item){
		$d_sec = strtotime($item['date_end']) - $current_time;
		if($d_sec > 0){
?>
<div class="discount-item">
	<div class="inner">
		<?php if(!empty($item['discount'])){ ?>
			<div class="discount">— <?php echo $item['discount']; ?></div>
		<?php } ?>
		<div class="logo">
			<img src="<?php echo $item['logo']; ?>" alt="e-discount">
		</div>
		<div class="title"><?php echo $item['title']; ?></div>
		<p><?php echo $item['description']; ?></p>
		
		<?php
			
			$days = floor($d_sec/86400);
			$d_sec = $d_sec-($days*86400);
			$hours = floor($d_sec/3600);
			$d_sec = $d_sec-($hours*3600);
			$minutes = floor($d_sec/60);
			echo '<div class="until"><span>До окончания:</span> ';
			if($days>0){
				echo $days.'д. ';
			}
			if($hours < 10){
				echo '0'.$hours.'ч. ';
			} 
			else{
				echo $hours.'ч. ';
			}
			if($minutes < 10){
				echo '0'.$minutes.'мин.';
			} 
			else{
				echo $minutes.'мин.';
			}
			echo '</div>';
		?>
		<a rel="nofollow" <?php if(!empty($item['promocode'])){ echo 'class="modal" data-window="promocode-modal" data-promocode="'.$item['promocode'].'"'; }; ?> href="<?php echo $item['url']; ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter36557175.reachGoal('outbound');">Получить скидку</a>
	</div>
</div>
<?php	
		}
		else{
			$lemon->delDiscount($item['id']);
			if($i >= $lemon->_itemsquantity){
				echo '<div class="message">По вашему запросу ничего не удалось найти. Измените свой поисковый запрос или воспользуйтесь меню "Все скидки"</div>';
			}
			$i++;
		}
	}
}
else{
	echo '<div class="message">По вашему запросу ничего не удалось найти. Измените свой поисковый запрос или воспользуйтесь меню "Все скидки"</div>';
}
?>
</div>

<div class="pagination">
	<?php echo $lemon->getPagenav(); ?>
</div>
	</div>
	<!--/Container-->
<?php include('footer.php');?>