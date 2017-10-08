<?php
require_once ('../classes/DbConect.php');
$db = DbConect::getInstance();
$db = $db->getDb();

$user_id = $_POST['user_id'];

$response = array();

$payment = array(
	'usd' => $_POST['payment_usd'], 
	'rub' => $_POST['payment_rub'],
	'uah' => $_POST['payment_uah']
	);

$method = array(
	'usd' => $_POST['method_usd'], 
	'rub' => $_POST['method_rub'],
	'uah' => $_POST['method_uah']
	);

$requisites = array(
	'usd' => $_POST['requisites_usd'], 
	'rub' => $_POST['requisites_rub'],
	'uah' => $_POST['requisites_uah']
	);

$err_1 = 0;
$utext = '<strong>ID пользователя:</strong> '.$user_id.'<br />';

foreach ($_POST['currensy'] as $val) {
	if (empty($payment[$val]) || empty($method[$val]) || empty($requisites[$val])) {
		$err_1++;
	} else {
		$utext .= '<strong>Вывод '.$val.':</strong><br />';
		$utext .= 'Способ: '.$method[$val].'<br />';
		$utext .= 'Назначение: '.$requisites[$val].'<br />';
		$utext .= 'Сумма: '.$payment[$val].'<br />';
	}
}

if(!$err_1){

	$user_sum = $db->prepare('SELECT sum_approved_usd, sum_approved_rub, sum_approved_uah FROM users WHERE id=?');
	$user_sum->execute(array($user_id));
	$user_sum_return = $user_sum->fetch(PDO::FETCH_ASSOC);

	$approved = array(
		'usd' => $user_sum_return['sum_approved_usd'], 
		'rub' => $user_sum_return['sum_approved_rub'],
		'uah' => $user_sum_return['sum_approved_uah']
		);

	$err_2 = 0;
	foreach ($_POST['currensy'] as $val) {
		$payment[$val] = preg_replace(array('/[^\d,\.]/', '/,/'), array('', '.'), $payment[$val]);
		if ($payment[$val] > $approved[$val]) {
			$err_2++;
		}
	}

	if (!$err_2) {

		$get_payment = $db->prepare('SELECT payment_usd, payment_rub, payment_uah FROM users WHERE id=?');
		$get_payment->execute(array($user_id));
		$get_payment = $get_payment->fetch(PDO::FETCH_ASSOC);

		$payment['usd'] += $get_payment['payment_usd'];
		$payment['rub'] += $get_payment['payment_rub'];
		$payment['uah'] += $get_payment['payment_uah'];

		$update_payment = $db->prepare('UPDATE users SET payment_usd=?, payment_rub=?, payment_uah=? WHERE id=?');
		$update_payment->execute(array($payment['usd'], $payment['rub'], $payment['uah'], $user_id));
		$response['status'] = 'ok';
		$response['msg'] = 'Заявка принята';

		$mail="dealersair@gmail.com";
		$title="Заявка на вывод средств с сайта bombonus.dealersair.com";
		$header="Content-type: text/html; charset=\"utf-8\"\r\n";
		$header.="From: bombonus.dealersair.com <bombonus@dealersair.com>\r\n";
		mail($mail,$title,$utext,$header);
			
	} else {
		$response['status'] = 'error';
		$response['msg'] = 'Не достаточно средств для вывода.2';
	}
	

} else {
	$response['status'] = 'error';
	$response['msg'] = 'Заполните все поля.1';
}

echo json_encode($response);
?>