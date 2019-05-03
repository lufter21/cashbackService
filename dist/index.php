<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// load classes
function loadClasses($class_name)
{
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php')) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
	}
}

spl_autoload_register('loadClasses');

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/set-dair-cookie.php';
set_dair_cookie('bombonus');

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/router.php';

if (class_exists($query['class'])) {
	$lemon = new $query['class'];
} else {
	$lemon = new Core;
}

$lemon->getBody($query);
