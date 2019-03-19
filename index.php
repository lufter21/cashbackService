<?php
/*$start = microtime(true);*/

error_reporting(E_ALL ^ E_NOTICE); 
ini_set('display_errors', 1);

//echo phpinfo();

if ((float)phpversion() < 5.3) {
	exit('App needs php version 5.3 or higher');
}

session_start();

require_once('router.php');

function __autoload($cl) {
	if(file_exists("classes/".$cl.".php")) {
		require_once("classes/".$cl.".php");
	}
}
if(class_exists($query['class'])){
	$lemon = new $query['class'];
	$lemon->getBody($query);
}

/*$time = microtime(true) - $start;
printf('Скрипт выполнялся %.4F сек.', $time);
*/
?>