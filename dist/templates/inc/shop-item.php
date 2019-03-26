<div class="shop-item">
   <div class="shop-item__logo"><img src="<?php echo $item['logo']; ?>" alt="<?php echo $item['name']; ?>"></div>
   <div class="shop-item__qnt"><?php echo $item['quantity'] .' '. n2w($item['quantity'], array('купон', 'купона', 'купонов')); ?></div>
   <a href="/shop/<?php echo $item['alias']; ?>" title="Скидки от <?php echo $item['name']; ?>" class="shop-item__link"></a>
</div>