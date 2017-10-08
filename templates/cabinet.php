<?php
if(empty($meta)){
	$meta = array(
		'title'=> $user['name']
		);
}
include('header.php');
?>
<!--Container/-->
<div class="container wrap">
<div class="container__sidebar">
	<aside class="sidebar">
		<?php 
		echo $lemon->getMenu(array(
			'cabinet'=>'Кабинет',
			'cabinet/vivod'=>'Вывод средств',
			'cabinet/profile'=>'Настройка',
			)); 
		?>
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