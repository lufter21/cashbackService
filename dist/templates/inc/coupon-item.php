<?php
$until = '';
$block_class = '';
$d_sec = 0;
$end = true;
$expired = false;

if ($item['date_end'] != 0) {
   $d_sec = strtotime($item['date_end']) - time();
} else {
   $end = false;
}

if ($end) {
   if ($d_sec > 0) {
      $days = floor($d_sec / 86400);
      $d_sec = $d_sec - ($days * 86400);
      $hours = floor($d_sec / 3600);
      $d_sec = $d_sec - ($hours * 3600);
      $minutes = floor($d_sec / 60);

      if ($days > 0) {
         $until .= $days . 'д. ';
      }

      if ($hours > 0) {
         if ($hours < 10) {
            $until .= '0' . $hours . 'ч. ';
         } else {
            $until .= $hours . 'ч. ';
         }
      }

      if ($minutes < 10) {
         $until .= '0' . $minutes . 'мин.';
      } else {
         $until .= $minutes . 'мин.';
      }
   } else {
      $until .= 'Купон просрочен';
      $block_class = ' coupon-item_expired';
      $expired = true;
   }
} else {
   $until .= 'Не установлен';
}

$title = $item['title_translated'] ?: $item['title'];
$description = $item['description_translated'] ?: $item['description'];

if (mb_strlen($description) > 175) {
   $description = mb_substr($description, 0, 175) . '...';
}

$btn_txt = 'Получить промокод';

switch ($type) {
   case 'discounts':
      $btn_txt = 'Получить скидку';
      break;

   case 'gifts':
      $btn_txt = 'Получить подарок';
      break;

   case 'free-shipping':
   default:
      $btn_txt = 'Получить промокод';
      break;
}
?>

<div class="coupon-item<?php echo $block_class; ?>">

   <div class="coupon-item__head">
      <div class="row row_nw row_col-middle">
         <div class="col">
            <?php if (!$expired) { ?>
               <div class="coupon-item__until until-icon"><?php echo $until; ?></div>
            <?php } ?>
         </div>

         <?php if ($view_logo !== false) { ?>
            <div class="col-4-5 col_right p-0">
               <a href="/shop/<?php echo $content['shops'][$item['shop_id']]['alias']; ?>" title="Все купоны от <?php echo $content['shops'][$item['shop_id']]['name']; ?>" class="coupon-item__logo"><img src="/static/images/logos/<?php echo $item['logo']; ?>" alt="<?php echo $content['shops'][$item['shop_id']]['name']; ?>"></a>
            </div>
         <?php } ?>

      </div>
   </div>

   <?php
   if ($item['discount']) {
      if ($expired) {
         ?>
         <span class="discount"><?php echo $item['discount']; ?></span>
      <?php } else { ?>
         <a rel="nofollow" href="/coupon/<?php echo $item['id']; ?>" class="discount"><?php echo $item['discount']; ?></a>
      <?php
   }
}

if ($expired) {
   ?>
      <span class="coupon-item__title"><?php echo $title; ?></span>
   <?php } else { ?>
      <a href="/coupon/<?php echo $item['id']; ?>" class="coupon-item__title"><?php echo $title; ?></a>

      <?php if ($description) { ?>
         <div class="coupon-item__desc">
            <?php echo $description; ?>
         </div>
      <?php } ?>
   <?php } ?>

   <?php if ($expired) { ?>
      <div class="coupon-item__expired">Купон просрочен</div>
   <?php } else { ?>
      <a rel="nofollow" href="/coupon/<?php echo $item['id']; ?>" class="coupon-item__button"><?php echo $btn_txt; ?></a>
   <?php } ?>
</div>