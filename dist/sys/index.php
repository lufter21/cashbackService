<?php
require_once ('../classes/DbConect.php');

$adm_log = 'l';
$adm_pass = '21';

error_reporting(E_ALL ^ E_NOTICE); 
ini_set('display_errors', 1);

session_start();		
	if(isset($_SESSION['log']) && isset($_SESSION['pass']) && $_SESSION['log']==$adm_log && $_SESSION['pass']==$adm_pass)
	{
		$db = DbConect::getInstance();
		$db = $db->getDb();

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
			if($_POST['login']==$adm_log && $_POST['pass']==$adm_pass){
				$_SESSION['log'] = $adm_log;
				$_SESSION['pass'] = $adm_pass;
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