<?php

error_reporting(E_ALL ^ E_NOTICE); 
ini_set('display_errors', 1);

class Db{
	public $db;
	function __construct(){
		$this->db = new PDO('mysql:host=localhost;dbname=bombonus','root','');
		$this->db->query('SET NAMES utf8');
	}
}

session_start();		
	if(isset($_SESSION['log']) && isset($_SESSION['pass']) && $_SESSION['log']=="l" && $_SESSION['pass']=="21")
	{
		$db = new Db;
		$route = 'shops';
		$log = $_SESSION['log'].' &nbsp;&nbsp;<a href="/sys/logout.php">Logout</a>';
		if(isset($_GET['route']))
		{
			$route = $_GET['route'];
		}
	} 
	else
	{
		$route = 'login';
		$log = 'Enter login and password!';

		if(isset($_POST['login']) && isset($_POST['pass']))
		{	
			if($_POST['login']=="l" && $_POST['pass']=="21"){
				$_SESSION['log'] = $_POST['login'];
				$_SESSION['pass'] = $_POST['pass'];
				header("Location: /sys");
				exit;
			}
			else
			{
				$route = 'login';
				$log = '<span style="background:red">Wrong login or password!</span>';
			}
		}
	}

include($route.'.php');
?>
</div>
</body>
</html>