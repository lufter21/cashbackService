<?php
class Go extends Core {

	protected function getContent($query) {

		if ($query['units'] == 'shop') {
			$unit_sql = $this->db->prepare('SELECT * FROM shops WHERE id=?');
		} elseif ($query['units'] == 'discount') {
			$unit_sql = $this->db->prepare('SELECT * FROM discounts WHERE id=?');
		}

		$unit_sql->execute(array($query['id']));
		$unit = $unit_sql->fetch(PDO::FETCH_ASSOC);

		if ($this->_user['user_id']) {

			$this->updateActivity();

			if (strpos($unit['url'], '?')) {
				$red_url = $unit['url'].'&subid=userid'.$this->_user['user_id'];
			} else {
				$red_url = $unit['url'].'?subid=userid'.$this->_user['user_id'];
			}
			
		} else {
			$red_url = $unit['url'];
		}

		$unit['red_url'] = $red_url;
		
		return $unit;
	}

	protected function updateActivity() {
		$date = date('Y-m-d');
		$update_activity = $this->db->prepare('UPDATE users SET activity=? WHERE id=?');
		$update_activity->execute(array($date, $this->_user['user_id']));
	}

}
?>