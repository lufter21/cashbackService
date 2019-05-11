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

		// similar coupons
		if ($result['similar']) {
			$similar_arr = array();

			$similar_sql = $this->db->prepare('SELECT * FROM coupons WHERE id=?');

			foreach (json_decode($result['similar'], true) as $id) {
				$similar_sql->execute(array($id));

				$similar_arr[] = $similar_sql->fetch(PDO::FETCH_ASSOC);
			}

			$result['similar'] = $similar_arr;
		}

		return $result;
	}
}
