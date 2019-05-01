<?php
class MainPage extends Core {
	protected function getContent($query) {
		if (!empty($this -> _region)) {
			$cat = array('all', $this -> _region, 1);
			$par = '(region=? OR region=?) AND available=?';
		} else {
			$cat = array('all', 1);
			$par = 'region=? AND available=?';
		}
		
		$coupons_sql = $this -> db -> prepare('SELECT * FROM coupons WHERE '. $par .' AND (date_end = 0 OR date_end > NOW()) ORDER BY rating DESC LIMIT 5');
		$coupons_sql -> execute($cat);
		$result['coupons'] = $coupons_sql -> fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
}
?>