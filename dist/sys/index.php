<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DbConnect.php';

$adm_log = U_LOG;
$adm_pass = U_PASS;

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

$db = DbConnect::getInstance();
$db = $db->getDb();

$route = 'shops';

if (isset($_GET['route'])) {
	$route = $_GET['route'];
}

session_start();

if ($route == 'shops' || $route == 'coupons') {
	if (isset($_SESSION['log']) && isset($_SESSION['pass']) && $_SESSION['log'] == $adm_log && $_SESSION['pass'] == $adm_pass) {
		$log = $_SESSION['log'] . ' &nbsp;&nbsp;<a href="/sys/logout.php">Logout</a>';
	} else {
		$route = 'login';
		$log = 'Enter login and password!';

		if (isset($_POST['login']) && isset($_POST['pass'])) {
			if ($_POST['login'] == $adm_log && $_POST['pass'] == $adm_pass) {
				$_SESSION['log'] = $adm_log;
				$_SESSION['pass'] = $adm_pass;
				header("Location: /sys");
				exit;
			} else {
				$route = 'login';
				$log = '<span style="background:red">Wrong login or password!</span>';
			}
		}
	}
}

include($route . '.php');
?>
</div>
</body>

</html>