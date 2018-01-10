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
		$sql_activity = $this->db->prepare('SELECT activity FROM users WHERE id=?');
		$sql_activity->execute(array($this->_user['user_id']));
		$activity_fetch = $sql_activity->fetch();
		
		$activity = (!empty($activity_fetch[0])) ? json_decode($activity_fetch[0]) : array();

		if (!in_array($date, $activity)) {
			$activity[] = $date;
			$new_activity = json_encode($activity);
			$update_activity = $this->db->prepare('UPDATE users SET activity=? WHERE id=?');
			$update_activity->execute(array($new_activity, $this->_user['user_id']));
		}
	}

}
?>