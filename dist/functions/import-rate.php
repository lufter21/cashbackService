<?php
require_once ('../classes/DbConect.php');
$db = DbConect::getInstance();
$db = $db->getDb();

$xml = 'https://obmenka.ua/exchange-rates-xml';

$xml_obj = simplexml_load_file($xml);

$rate = array();

foreach ($xml_obj->item as $val) {

	if ($val->from == 'WMZ') {

		if ($val->to == 'YAMRUB') {
			$rate['rub'] = (float) $val->out;
		} elseif ($val->to == 'P24UAH') {
			$rate['uah'] = (float) $val->out;
		}

	}

}


$add_rate = $db->prepare('INSERT INTO rate (date, usd_rub, usd_uah) VALUES (:date, :usd_rub, :usd_uah)');

$add_rate->execute(array(
	'date'=>date('Y-m-d H-i-s'),
	'usd_rub'=>$rate['rub'],
	'usd_uah'=>$rate['uah']
));


print_r($rate);

?>