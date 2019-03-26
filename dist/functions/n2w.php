<?php
function n2w($n, $w) {
   $n %= 100;
   if ($n > 19) { $n %= 10; }
   
   switch ($n) {
      case 1:
      return $w[0];
      
      case 2:
      case 3: 
      case 4:
      return $w[1];
      
      default:
      return $w[2];
   }
}
?>