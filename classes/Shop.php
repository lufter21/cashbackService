<?php
class Shop extends Core {
	protected function getContent($query) {
		$sql = $this->db->prepare('SELECT * FROM shops WHERE alias=?');
		$sql->execute(array($this->_alias));
		$result = $sql->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}
?>