<?php
function country_code($value){
	$value = mb_strtolower($value,'UTF-8');

	switch ($value) {
		case 'украина':
		$code = 'ua';
		break;

		case 'россия':
		$code = 'ru';
		break;

		case 'ua':
		case 'ru':
		$code = $value;
		break;
		
		default:
		$code = '';
		break;
	}

	return $code;
}
//echo country_code($_GET['c']);
?>