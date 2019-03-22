<?php
class Coupon extends Core {
	protected function getContent($query) {
		$sql = $this->db->prepare('SELECT * FROM coupons WHERE alias=?');
		$sql->execute(array($this->_alias));
		$result = $sql->fetch(PDO::FETCH_ASSOC);

		if (empty($result)) {
			$this->_page_not_found = true;
		}
		
		return $result;
	}
}
?>