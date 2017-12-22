<?php
if(empty($meta)){
	$meta = array(
		'title'=>'Скидки и промокоды от лучших интернет магазинов',
		'name'=>'Скидки/промокоды'
	);
}
include('header.php');
?>
<!--Container/-->
<div class="container wrap row">

	<div class="col-3">
		<aside id="js-sidebar" class="sidebar box">
			<div class="pad">
				<div class="title">Категории</div>
				<?php echo $lemon->getCategoryMenu(); ?>
			</div>
		</aside>
	</div>

	<div class="col-9 pad-0">

		<div class="pad mb-28">
			<div class="box">
				<div class="row-col-mid">
					<div class="col-9">
						<article>
							<h1><?php echo $meta['name'];?></h1>
							<div class="article-block pad">
								<?php echo $meta['text'];?>
							</div>
						</article>
					</div>

					<?php
					if(!empty($content['discounts'])){
						?>
						<div class="sorting-block col-3">
							<form id="sorting-form" action="/discounts<?php echo (!empty($alias)) ? '/'.$alias : '';?>" method="POST">
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
			</div>
		</div>
		

		<div id="flex-wrap" class="flex-wrap">
			<?php
			if(!empty($content['discounts'])){
				$i = 1;
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
								<a rel="nofollow" href="<?php echo $lemon->getUserLink($item['url']); ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="title" title="Перейти в <?php echo $content['shop_name'][$item['shop']]; ?>"><?php echo $item['title']; ?></a>
								<div class="logo">
									<a href="/shop/<?php echo $item['shop'];?>" title="Подробнее о <?php echo $content['shop_name'][$item['shop']]; ?>"><img src="/images/logo/<?php echo $item['shop']; ?>.png" alt="<?php echo $content['shop_name'][$item['shop']]; ?>"></a>
								</div>

								<?php 
								/*cashback*/
								if(!empty($content['shop_cashback'][$item['shop']])){
									echo '<div class="cashback"><span>'.$content['shop_cashback'][$item['shop']].'</span></div>';
								}

								/*untill*/
								$days = floor($d_sec/86400);
								$d_sec = $d_sec-($days*86400);
								$hours = floor($d_sec/3600);
								$d_sec = $d_sec-($hours*3600);
								$minutes = floor($d_sec/60);
								echo '<div class="until">';
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
								<div class="promocode">
									<?php
									if(!empty($item['promocode'])){
										echo '<span class="code">'.$item['promocode'].'</span>';
									}else{
										echo '<span class="prc-none">Промокод не требуется</span>';
									}
									?>
								</div>
								<a rel="nofollow" href="<?php echo $lemon->getUserLink($item['url']); ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="button" title="Перейти в <?php echo $content['shop_name'][$item['shop']]; ?>">В магазин</a>
							</div>
						</div>
						<?php	
					}
					else{
						$lemon->delDiscount($item['id']);
						if($i >= $lemon->_itemsquantity){
							echo '<div class="message">На данный момент, в этом разделе нет акций и скидок</div>';
						}
						$i++;
					}
				}
			}
			else{
				echo '<div class="message">На данный момент, в этом разделе нет акций и скидок</div>';
			}
			?>
		</div>
		<div class="pagination">
			<?php echo $lemon->getPagenav(); ?>
		</div>
		
	</div>

</div>
<!--/Container-->

<?php include('footer.php');?>