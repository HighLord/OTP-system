<?php

  $cookie = "Newuser";

   $cookies = json_decode( $_COOKIE[ $cookie ] );
    $expiry = $cookies->expiry;
    $expire = time() - $expiry;
    $sum = $expire * -1;
   
if(( isset( $_GET['otp'] )) and ( isset($_COOKIE[$cookie])) and  (($sum >= 110) and ($sum <= 700))){
   
define( 'WP_USE_THEMES', true );
require __DIR__ . '/wp-blog-header.php'; 
    
} else if (($sum >= 110) and ($sum <= 700)){

define( 'WP_USE_THEMES', true );
require __DIR__ . '/wp-blog-header.php';

} else {
 header("Location: text.php");
   exit(); 
}
