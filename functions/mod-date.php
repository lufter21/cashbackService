<?php
function mod_date($value){
	$arr = explode('-', $value);
	$repl = array(
		'01' => 'января',
		'02' =>  'февраля',
		'03' => 'марта',
		'04' => 'апреля',
		'05' => 'мая',
		'06' => 'июня',
		'07' => 'июля',
		'08' => 'августа',
		'09' => 'сентября',
		'10' => 'октября',
		'11' => 'ноября',
		'12' => 'декабря'
	);
	$month = str_replace(array_keys($repl), array_values($repl), $arr[1]);
	return $arr[2].' '.$month.' '.$arr[0];
}
?>