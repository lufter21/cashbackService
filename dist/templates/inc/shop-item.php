<div class="shop-item">
   <div class="shop-item__logo">
      <img src="/static/images/logos/<?php echo $item['logo']; ?>" alt="<?php echo $item['name']; ?>">
   </div>
   <div class="shop-item__qnt">
      <?php echo $item['quantity'] .' '. n2w($item['quantity'], array('купон', 'купона', 'купонов')); ?>
   </div>
   <div class="shop-item__cats">
      <?php echo $item['category']; ?>
   </div>
   <a href="/shop/<?php echo $item['alias']; ?>" title="Скидки от <?php echo $item['name']; ?>" class="shop-item__link"></a>
</div>