<?php
class Go extends Core
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

		if ($result['deeplink']) {
			$result['gotolink'] .= '&ulp=' . urlencode($result['deeplink']);
		}

		return $result;
	}
}
