<?php
class MainPage extends Core
{
	protected function getContent($query)
	{
		if (!empty($this->_region)) {
			$cat = array(1, 1);
			$par = $this->_region . '_reg=? AND available=?';
		} else {
			$cat = array(1, 1, 1, 1);
			$par = 'by_reg=? AND ru_reg=? AND ua_reg=? AND available=?';
		}

		$coupons_sql = $this->db->prepare('SELECT * FROM coupons WHERE ' . $par . ' AND (date_end = 0 OR date_end > NOW()) ORDER BY rating DESC LIMIT 5');
		$coupons_sql->execute($cat);
		$result['coupons'] = $coupons_sql->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
}
