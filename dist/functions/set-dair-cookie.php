<?php
function set_dair_cookie($value) {
   $cookie_arr = array();
   
   if (isset($_COOKIE['d_air_interest'])) {
      $cookie_arr = json_decode($_COOKIE['d_air_interest'], true);
      
      if ($cookie_arr[$value]) {
         $cookie_arr[$value] = $cookie_arr[$value] + 1;
      } else {
         $cookie_arr[$value] = 1;
      }
   } else {
      $cookie_arr[$value] = 1;
   }

   setcookie('d_air_interest', json_encode($cookie_arr), time() + 31104000, '/', 'dealersair.com');
}
?>