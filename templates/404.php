<?php
header("HTTP/1.1 404 Not Found");
if(empty($meta)){
	$meta = array(
		'name'=>'404',
		'title'=>'404',
		'description' => 'Возвращаем деньги за совершенные вами покупки в интернет-магазинах. У нас самый большой процент кэшбэка.'
		);
}
include('templates/header.php');
?>
<!--Container/-->
<div class="container wrap pad">
	<article class="box">
		<div class="pad content">
			<h1><?php echo $meta['name'];?></h1>

			<p>
				Страница не найдена
			</p>

		</div>
	</article>
</div>
<!--/Container-->
<?php include('templates/footer.php');?>