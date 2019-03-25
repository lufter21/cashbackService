<?php
if(!$meta){
	$meta = array(
		'name'=>'Все магазины',
		'title'=>'Каталог магазинов',
		'description'=>'Каталог магазинов для покупок с кэшбэком'
	);
}

include $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp">
		<div class="col-3">
			<aside class="sidebar">
				<div class="sidebar__title">Категории</div>
				<?php echo $lemon -> getCategoryMenu(); ?>
			</aside>
		</div>
		<div class="col-9 p-0">
			<div class="row row_col-middle row_nw">
				<div class="col-12">
					<h1 class="title"><?php echo $meta['title'];?></h1>
				</div>
			</div>

			<div class="row tile">
			<?php
			if (!empty($content['shops'])) {
				foreach ($content['shops'] as $item) {
					echo '<div class="col-4">';
					include $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/shop-item.php';
					echo '</div>';
				}
			} else {
				echo '<div class="message">На данный момент, в этом разделе нет магазинов</div>';
			}
			?>
			</div>
			<div class="row">
				<div class="col-12">
					<ul class="paginate">
					<?php echo $lemon -> getPagenav(); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/MAIN-->

<?php include $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>