<?php
require_once ('../classes/DbConect.php');
$db = DbConect::getInstance();
$db = $db->getDb();
$sql_users = $db->prepare('SELECT * FROM users WHERE identity=?');
$sql_users->execute(array($_POST['email']));
$result_users = $sql_users->fetch(PDO::FETCH_ASSOC);

if ($_POST['form_role'] == 'log') {

	$current_password = md5($_POST['pass_l'].$result_users['seed']);
	
	if($result_users['password'] === $current_password){
		echo "ok";
	} else {
		echo "Не верный e-mail или пароль.";
	}

} else if($_POST['form_role'] == 'reg') {

	if(empty($result_users)){
		echo 'ok';
	} else {
		echo "Пользователь с таким E-mail уже существует.";
	}

}
exit;
?>