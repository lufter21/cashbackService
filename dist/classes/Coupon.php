<?php
class Coupon extends Core
{
	protected function getContent($query)
	{
		$coupon_sql = $this->db->prepare('SELECT * FROM coupons WHERE id=?');
		$coupon_sql->execute(array($this->_alias));
		$result = $coupon_sql->fetch(PDO::FETCH_ASSOC);

		if (empty($result)) {
			$this->_page_not_found = true;
			return;
		}

		// get shop
		$shop_sql = $this->db->prepare('SELECT * FROM shops WHERE id=?');
		$shop_sql->execute(array($result['shop_id']));
		$result['shop'] = $shop_sql->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
}
