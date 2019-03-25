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
      $days = floor($d_sec/86400);
      $d_sec = $d_sec-($days*86400);
      $hours = floor($d_sec/3600);
      $d_sec = $d_sec-($hours*3600);
      $minutes = floor($d_sec/60);
      
      if ($days > 0) {
         $until .= $days .'д. ';
      }

      if ($hours > 0) {
         if ($hours < 10) {
         $until .= '0'.$hours.'ч. ';
         } else {
            $until .= $hours.'ч. ';
         }
      }
      
      if ($minutes < 10) {
         $until .= '0'.$minutes.'мин.';
      } else {
         $until .= $minutes.'мин.';
      }
   } else {
      $until .= 'Купон просрочен';
      $block_class = ' coupon-item_expired';
      $expired = true;
   }
} else {
   $until .= 'Вечно';
}
?>

<div class="coupon-item<?php echo $block_class; ?>">
   <?php
   if (!empty($item['discount'])) {
      if ($expired) {
   ?>
   <span class="discount"><?php echo $item['discount']; ?></span>
   <?php } else { ?>
   <a rel="nofollow" href="/coupon/<?php echo $item['id']; ?>" class="discount"><?php echo $item['discount']; ?></a>
   <?php
      }
   }
   ?>

   <?php if ($expired) { ?>
   <span class="coupon-item__title"><?php echo $item['title']; ?></span>
   <?php } else { ?>
   <a href="/coupon/<?php echo $item['id']; ?>" class="coupon-item__title"><?php echo $item['title']; ?></a>
   <?php } ?>

   <div class="coupon-item__logo">
      <a href="/shop/<?php echo $content['shops'][$item['shop_id']]['alias']; ?>" title="Все промокоды от <?php echo $content['shops'][$item['shop_id']]['name']; ?>"><img src="<?php echo $item['logo']; ?>" alt="<?php echo $content['shops'][$item['shop_id']]['name']; ?>"></a>
   </div>
   
   <?php if (!$expired) { ?>
   <div class="coupon-item__until until-icon"><?php echo $until; ?></div>
   <a rel="nofollow" href="/coupon/<?php echo $item['id']; ?>" class="coupon-item__button">Получить промокод</a>
   <?php } else { ?>
   <div class="coupon-item__expired">Купон просрочен</div>
   <?php } ?>
</div>