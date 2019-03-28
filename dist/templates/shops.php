<?php
if(!$meta){
	$meta = array(
		'meta_title' => 'Лучшие интернет магазины с промокодами и скидками',
		'title' => 'Интернет магазины с промокодами',
		'meta_description' => 'Покупайте с промокодами в лучших интернет магазинах'
	);
}

require_once $_SERVER['DOCUMENT_ROOT'] .'/functions/n2w.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
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
			<div class="row">
				<div class="col-12">
					<h1 class="title"><?php echo $meta['title'];?></h1>
				</div>
			</div>

			<div class="row tile">
			<?php
			if (!empty($content['shops'])) {
				foreach ($content['shops'] as $item) {
					echo '<div class="col-3">';
					include $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/shop-item.php';
					echo '</div>';
				}
			} else {
				echo '<div class="col-12">На данный момент, в этой категории нет магазинов.</div>';
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

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>