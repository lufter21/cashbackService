<?php
class Shop extends Core {
	protected function getContent($query) {
		$shop_sql = $this -> db -> prepare('SELECT * FROM shops WHERE alias=?');
		$shop_sql -> execute(array($this->_alias));
		$result = $shop_sql -> fetch(PDO::FETCH_ASSOC);

		if (empty($result)) {
			$this -> _page_not_found = true;
		}

		// get coupons
		$coupons_sql = $this -> db -> prepare('SELECT * FROM coupons WHERE shop_id=? ORDER BY rating DESC');
		$coupons_sql -> execute(array($result['id']));
		$result['coupons'] = $coupons_sql -> fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
}
?>