<?php
require_once ('../classes/DbConect.php');
$db = DbConect::getInstance();
$db = $db->getDb();

$response = array();

session_start();

if($_SESSION['access']){
	$access_key = $_SESSION['access'];

	$sql_users = $db->prepare('SELECT id FROM users WHERE access_key=?');
	$sql_users->execute(array($access_key));
	$user_data = $sql_users->fetch(PDO::FETCH_ASSOC);

	if ($user_data) {
		$user_id = $user_data['id'];
	}

	$currency = $_POST['currency'];
	$payment = $_POST['payment_'.$currency];
	$method = $_POST['method_'.$currency];
	$requisites = $_POST['requisites_'.$currency.'_'.$method];

	if (!empty($payment) && !empty($method) && !empty($requisites)) {

		$user_sum = $db->prepare('SELECT sum_approved_usd, sum_approved_rub, sum_approved_uah FROM users WHERE id=?');
		$user_sum->execute(array($user_id));
		$user_sum_return = $user_sum->fetch(PDO::FETCH_ASSOC);

		$approved = array(
			'usd' => $user_sum_return['sum_approved_usd'], 
			'rub' => $user_sum_return['sum_approved_rub'],
			'uah' => $user_sum_return['sum_approved_uah']
			);

		$payment = preg_replace(array('/[^\d,\.]/', '/,/'), array('', '.'), $payment);

		if ($payment <= $approved[$currency])  {

			$get_payment = $db->prepare('SELECT payment_usd, payment_rub, payment_uah FROM users WHERE id=?');
			$get_payment->execute(array($user_id));
			$get_payment = $get_payment->fetch(PDO::FETCH_ASSOC);

			$payment += $get_payment['payment_'.$currency];

			if (in_array($currency, array('usd','rub','uah'))) {
				$field = 'payment_'.$currency.'=?';

				$update_payment = $db->prepare('UPDATE users SET '.$field.' WHERE id=?');
				$update_payment->execute(array($payment, $user_id));
				$response['status'] = 'ok';
				$response['msg'] = 'Заявка принята';

				$utext = '<strong>ID пользователя:</strong> '.$user_id.'<br />';
				$utext .= '<strong>Вывод '.$currency.':</strong><br />';
				$utext .= 'Способ: '.$method.'<br />';
				$utext .= 'Назначение: '.$requisites.'<br />';
				$utext .= 'Сумма: '.$payment.'<br />';

				$mail="dealersair@gmail.com";
				$title="Заявка на вывод средств с сайта bombonus.dealersair.com";
				$header="Content-type: text/html; charset=\"utf-8\"\r\n";
				$header.="From: bombonus.dealersair.com <bombonus@dealersair.com>\r\n";
				mail($mail,$title,$utext,$header);

			} else {
				$response['status'] = 'error';
				$response['msg'] = 'Что-то пошло не так :*(';
			}
			
		} else {
			$response['status'] = 'error';
			$response['msg'] = 'Не достаточно средств для вывода.2';
		}


	} else {
		$response['status'] = 'error';
		$response['msg'] = 'Заполните все поля.1';
	}

} else {
	$response['status'] = 'error';
	$response['msg'] = 'Пользователь не подтвержден';
}

echo json_encode($response);
?>