<?php
class MainPage extends Core	{

	protected function getContent($query) {
		
		$cat = array();

		if (!empty($this->_region)) {
			$cat[0] = 'all';
			$cat[1] = $this->_region;
			$cat[2] = 1;
			$par = '(region=? OR region=?) AND available=?';
		} else {
			$cat[0] = 1;
			$par = 'available=?';
		}

		$shops_id_list = array(1,4,5,6,7,12,38,40,41,43);
		$shops_id_list_count = count($shops_id_list);

		$par .= ' AND (';
		foreach ($shops_id_list as $key => $val) {
			$cat[] = $val;
			if ($key < ($shops_id_list_count-1)) {
				$par .= 'id=? OR ';
			} else {
				$par .= 'id=?';
			}
		}
		$par .= ')';
		
		$sql = $this->db->prepare('SELECT * FROM shops WHERE '.$par);
		$sql->execute($cat);
		$result['shops'] = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
}
?>