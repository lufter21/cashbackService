<?php
if(empty($meta)){
	$meta = array(
		'title'=> $user['name']
		);
}
include('header.php');
?>
<!--Container/-->
<div class="container wrap row vw1000-row-col">

	<div class="col-3">
		<aside class="sidebar box">
			<div class="pad">
				<?php 
				echo $lemon->getMenu(array(
					'cabinet'=>'Кабинет',
					'cabinet/vivod'=>'Вывод средств',
					'cabinet/profile'=>'Настройка',
					)); 
				?>
			</div>
		</aside>
	</div>
	
	<?php
	if (!empty($alias)) {
		include ('cabinet/'.$alias.'.php');
	} else {
		include ('cabinet/index.php');
	}
	?>
	
</div>
<!--/Container-->
<?php include('footer.php');?>