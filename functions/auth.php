<?php 
require_once ('../classes/DbConect.php');
require_once ('../functions/country-code.php');

session_start();

function do_login($user_data, $password = ""){

	$db = DbConect::getInstance();
	$db = $db->getDb();

	$identity = md5($user_data['identity']);

	$sql_users = $db->prepare('SELECT * FROM users WHERE identity=?');
	$sql_users->execute(array($identity));
	$user_data = $sql_users->fetch(PDO::FETCH_ASSOC);

	if($password){
		$current_password = md5($password.$user_data['seed']);
	} else {
		$current_password = md5($identity.$user_data['seed']);
	}

	if($user_data['password'] === $current_password){

		$access_key = $identity.sha1(mt_rand());

		$set_access_key = $db->prepare('UPDATE users SET access_key=? WHERE identity=?');
		$set_access_key->execute(array($access_key, $identity));

		$user_info = array(
			'user_id'=>$user_data['id'],
			'name'=>$user_data['name'],
			'country'=>$user_data['country'],
			);
		$_SESSION['access'] = $access_key;
		$_SESSION['region'] = $user_data['country'];
		SetCookie('access', $access_key, time()+3600*24, '/');
		return "login";
	} else {
		unset($_SESSION['access']);
		return 'error';
	}
}


function do_registr($user_data, $password = ""){

	$db = DbConect::getInstance();
	$db = $db->getDb();

	$identity = md5($user_data['identity']);

	$user_data['seed'] = sha1(mt_rand());
	if($password){
		$user_data['password'] = md5($password.$user_data['seed']);
	} else {
		$user_data['password'] = md5($identity.$user_data['seed']);
	}
	
	$ins_users = $db->prepare('INSERT INTO users (identity,network,name,email,password,seed,registration_date,activity,country) VALUES (:identity,:network,:name,:email,:password,:seed,:registration_date,:activity,:country)');

	$ins_users->execute(array(
		'identity'=>$identity,
		'network'=>$user_data['network'],
		'name'=>$user_data['name'],
		'email'=>$user_data['email'],
		'password'=>$user_data['password'],
		'seed'=>$user_data['seed'],
		'registration_date'=>date('Y-m-d'),
		'activity'=>date('Y-m-d'),
		'country'=>country_code($user_data['country'])
		));

	$result = do_login($user_data, $password);

	return $result;
}

/*get message*/
function get_message($value){
	$network = array(
		'vkontakte'=>'Вконтакте',
		'facebook'=>'Facebook',
		'twitter'=>'Twitter',
		'yandex'=>'Яндекс',
		'odnoklassniki'=>'Одноклассники',
		'google'=>'Google',
		'mailru'=>'MailRU'
		);
	
	$msg = 'Вы входили ранее через аккаунт '.str_replace(array_keys($network), array_values($network), $value).'. Попробуйте авторизироваться используя соответствующую кнопку.';

	return $msg; 
}


$response = array();

/*formLoginReg*/
if(isset($_POST['form_role'])){

	$db = DbConect::getInstance();
	$db = $db->getDb();

	$sql_users = $db->prepare('SELECT * FROM users WHERE email=?');
	$sql_users->execute(array($_POST['email']));
	$result_users = $sql_users->fetch(PDO::FETCH_ASSOC);


	if ($_POST['form_role'] == 'log'){

		$user_data = array(
			'identity'=>$_POST['email']
		);

		if ($result_users['network']) {
			$response['msg'] = get_message($result_users['network']);
		} else {

			$msg = do_login($user_data, $_POST['pass_l']);

			$response['msg'] = ($msg == 'error') ? 'Не верный e-mail или пароль.' : $msg;

		}

	} else if ($_POST['form_role'] == 'reg'){

		$user_data = array(
			'identity'=>$_POST['email'],
			'network'=>'',
			'name'=>$_POST['name'],
			'email'=>$_POST['email']
		);

		if(!$result_users){

			if ($_POST['pass_r'] == $_POST['pass_r2']) {
				$response['msg'] = do_registr($user_data, $_POST['pass_r']);
			} else {
				$response['msg'] = "Пароли не совпадают";
			}

		} else {
			if ($result_users['network']) {
				$response['msg'] = get_message($result_users['network']);
			} else {
				$response['msg'] = "Пользователь с таким e-mail уже существует.";
			}
		}	
	}
}


/*checkUser*/
if (isset($_POST['token'])){
	$user_data = file_get_contents('https://ulogin.ru/token.php?token='.$_POST['token'].'&host=https://bombonus.dealersair.com');
	$user_data = $user_data ? json_decode($user_data, true) : array();

	$db = DbConect::getInstance();
	$db = $db->getDb();

	$sql_users = $db->prepare('SELECT * FROM users WHERE identity=?');
	$sql_users->execute(array(md5($user_data['identity'])));
	$result_users = $sql_users->fetch(PDO::FETCH_ASSOC);

	if ($result_users) {
		
		$msg = do_login($user_data);

		$response['msg'] = ($msg == 'error') ? 'Ошибка авторизации пользователя' : $msg;

	} else {

		$sql_users_email = $db->prepare('SELECT * FROM users WHERE email=?');
		$sql_users_email->execute(array($user_data['email']));
		$result_users_email = $sql_users_email->fetch(PDO::FETCH_ASSOC);

		if ($result_users_email) {
			$response['msg'] = get_message($result_users_email['network']);
		} else {
			$user_data['name'] = $user_data['first_name'].' '.$user_data['last_name'];
			$response['msg'] = do_registr($user_data);
		}

	}

}

echo json_encode($response);

?>