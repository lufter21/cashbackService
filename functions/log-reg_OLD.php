<?php 
require_once ('../classes/DbConect.php');

session_start();

function do_login($identity, $password = ""){

	$db = DbConect::getInstance();
	$db = $db->getDb();

	$sql_users = $db->prepare('SELECT * FROM users WHERE identity=?');
	$sql_users->execute(array($identity));
	$result_users = $sql_users->fetch(PDO::FETCH_ASSOC);
	
	if(!empty($result_users)){
		if(!empty($password)){
			$current_password = md5($password.$result_users['seed']);
		} else {
			$current_password = md5($identity.$result_users['seed']);
		}
		
		if($result_users['password'] === $current_password){
			$user_arr = array(
				'identity'=>$result_users['identity'],
				'first_name'=>$result_users['first_name'],
				'last_name'=>$result_users['last_name']
				);
			$_SESSION['user_info'] = $user_arr;
			SetCookie('user_ediscount', serialize($user_arr), time()+3600*24*365, '/');

		} else {
			unset($_SESSION['user_info']);
			echo "Не верный e-mail или пароль";
			exit;
		}
	}
}

/*youLogin*/
if (isset($_POST['token'])){

	$result = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] .'&host=' . $_SERVER['HTTP_HOST']);
	$data = $result ? json_decode($result, true) : array();

	print_r($data);

	if (!empty($data) && !isset($data['error'])){

		$db = DbConect::getInstance();
		$db = $db->getDb();

		$sql_users = $db->prepare('SELECT * FROM users WHERE identity=?');
		$sql_users->execute(array($data['identity']));
		$result_users = $sql_users->fetch(PDO::FETCH_ASSOC);
		
		if(empty($result_users)){
			$seed = sha1(mt_rand());
			$password = md5($data['identity'].$seed);
			echo $password;
			$ins_users = $db->prepare('INSERT INTO users (identity,first_name,last_name,email,password,seed) VALUES (:identity,:first_name,:last_name,:email,:password,:seed)');
			$ins_users->execute(array(
				'identity'=>$data['identity'],
				'first_name'=>$data['first_name'],
				'last_name'=>$data['last_name'],
				'email'=>$data['email'],
				'password'=>$password,
				'seed'=>$seed
				));
		}
		
		do_login($data['identity']);
	}
	//header('Location:'.$_SERVER['HTTP_REFERER']);
}

/*formLoginReg*/
if(isset($_POST['form_role'])){

	if ($_POST['form_role'] == 'log'){
		do_login($_POST['email'],$_POST['pass_l']);
	} else if ($_POST['form_role'] == 'reg'){

		$db = DbConect::getInstance();
		$db = $db->getDb();

		$sql_users = $db->prepare('SELECT * FROM users WHERE identity=?');
		$sql_users->execute(array($_POST['email']));
		$result_users = $sql_users->fetch(PDO::FETCH_ASSOC);

		if(empty($result_users)){

			$seed = sha1(mt_rand());
			
			if($_POST['pass_r'] == $_POST['pass_r2']){
				$password = md5($_POST['pass_r'].$seed);
			}else{
				echo "Пароли не совпадают";
				exit;
			}
			
			$ins_users_f = $db->prepare('INSERT INTO users (identity,first_name,last_name,email,password,seed) VALUES (:identity,:first_name,:last_name,:email,:password,:seed)');
			$ins_users_f->execute(array(
				'identity'=>$_POST['email'],
				'first_name'=>$_POST['name'],
				'last_name'=>'',
				'email'=>$_POST['email'],
				'password'=>$password,
				'seed'=>$seed
				));

		} else {
			echo "Пользователь с таким E-mail уже существует.";
			exit;
		}
		
		do_login($_POST['email'], $_POST['pass_r']);
	}
	header('Location:'.$_SERVER['HTTP_REFERER']);	
}

?>