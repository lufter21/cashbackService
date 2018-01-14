<?php
class MainPage extends Core	{

	protected function getContent($query) {
		
		if (!empty($this->_region)) {
			$cat = array('all', $this->_region, 1, 1);
			$par = '(region=? OR region=?) AND available=? AND popular=?';
		} else {
			$cat = array(1, 1);
			$par = 'available=? AND popular=?';
		}
		
		$sql = $this->db->prepare('SELECT * FROM shops WHERE '.$par);
		$sql->execute($cat);
		$result['shops'] = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
}
?>