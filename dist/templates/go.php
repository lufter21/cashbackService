<?php
if ($_GET['force']) {
   header('Location: ' . $content['gotolink']);
   exit;
}

$title = 'Переход в магазин...';

$meta = array(
   'meta_title' => $title,
   'meta_description' => ''
);

$goUrl = $content['gotolink'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/header.php';
?>

<!--MAIN/-->
<div class="main">
   <div class="row row_wrp">
      <main class="col-12">
         <article class="coupon coupon_go">
            <h1 class="title"><?php echo $title; ?></h1>
            <p class="mt-45 fs-14 lh-1_5 c-gray">
               Если автоматическое перенаправление в магазин не произошло — перейдите по <a href="/go/<?php echo $content['id']; ?>&force=1" class="link">этой&nbsp;ссылке</a>.
            </p>
         </article>
      </main>
   </div>
</div>
<!--/MAIN-->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/inc/footer.php'; ?>