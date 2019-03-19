<div class="coupon-item">
   <div class="inner">
      <?php if(!empty($item['discount'])){ ?>
         <div class="discount">
            <?php echo $item['discount']; ?>
         </div>
      <?php } ?>
      <a rel="nofollow" href="/go/coupon/<?php echo $item['id']; ?>" target="_blank" onclick="ga('send', 'event', 'outbound', 'click'); yaCounter39630900.reachGoal('outbound');" class="title" title="Перейти в <?php echo $content['shop_name'][$item['shop']]; ?>"><?php echo $item['title']; ?></a>
      <div class="logo">
         <a href="/shop/<?php echo $item['shop'];?>" title="Все промокоды от <?php echo $content['shop_name'][$item['shop']]; ?>"><img src="/images/logo/<?php echo $item['shop']; ?>.png" alt="<?php echo $content['shop_name'][$item['shop']]; ?>"></a>
      </div>
      <?php
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
      <a rel="nofollow" href="/coupon/<?php echo $item['id']; ?>" class="coupon-item__button">Получить промокод</a>
   </div>
</div>