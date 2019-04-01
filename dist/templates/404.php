<?php
header("HTTP/1.1 404 Not Found");

$meta = array(
	'meta_title' => '404 Страница не найдена',
	'meta_description' => '404 Страница не найдена'
);

require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
	<div class="row row_wrp">
		<div class="col-12">
			<h1 class="title">404 Страница не найдена</h1>
		</div>
	</div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] .'/templates/inc/footer.php'; ?>