<?php
class Cabinet extends Core {

	protected function getContent() {

		if ($this->statTimeUpdate()) {
			$this->setStat();
			$this->statTimeUpdate(true);
		}
			
		return $this->getStat();
	}

	protected function setStat() {

		$sql_activity = $this->db->prepare('SELECT activity FROM users WHERE id=?');
		$sql_activity->execute(array($this->_user['user_id']));
		$activity_fetch = $sql_activity->fetch();

		$start_date = $this->_user['registration_date'];
		$end_date = $activity_fetch[0];

		$admitad_arr = $this->getAdmitadStat($start_date, $end_date);
		$other_arr = $this->getOtherStat($start_date, $end_date);

		$result_data_arr = array_merge_recursive($admitad_arr['data'], $other_arr['data']);

		if (!empty($result_data_arr)) {

			$add_stat = $this->db->prepare('INSERT INTO users_stat (id,userid,date,data) VALUES (:id,:userid,:date,:data) ON DUPLICATE KEY UPDATE data=:u_data');

			$result_sum_open = array('usd'=>0,'rub'=>0,'uah'=>0);
			$result_sum_approved = array('usd'=>0,'rub'=>0,'uah'=>0);

			foreach ($result_data_arr as $date => $val) {

				if (!empty($val)) {

					$data = json_encode($val);
					
					$add_stat->execute(array(
						'id'=>$this->_user['user_id'].str_replace('-', '', $date),
						'userid'=>$this->_user['user_id'],
						'date'=>$date,
						'data'=>$data,
						'u_data'=>$data
					));

				}
				
			}
			
			foreach ($result_sum_open as $key => $val) {
				$result_sum_open[$key] += $admitad_arr['sum_open'][$key] + $other_arr['sum_open'][$key];
				$result_sum_approved[$key] += $admitad_arr['sum_approved'][$key] + $other_arr['sum_approved'][$key];
			}

			$update_sum = $this->db->prepare('UPDATE users SET sum_open_usd=?, sum_approved_usd=?, sum_open_rub=?, sum_approved_rub=?, sum_open_uah=?, sum_approved_uah=? WHERE id=?');

			$update_sum->execute(array($result_sum_open['usd'], $result_sum_approved['usd'], $result_sum_open['rub'], $result_sum_approved['rub'], $result_sum_open['uah'], $result_sum_approved['uah'], $this->_user['user_id']));

		}
		
		return true;
	}

	protected function getStat() {
		$user = $this->db->prepare('SELECT * FROM users WHERE id=?');
		$user->execute(array($this->_user['user_id']));
		$user = $user->fetch(PDO::FETCH_ASSOC);

		$user_sum_open = array();
		$user_sum_approved = array();
		$user_sum_approved_arr = array();

		foreach ($user as $key => $val) {
			if ($val > 0) {
				switch ($key) {
					case 'sum_open_usd':
					$user_sum_open['usd'] = $this->mergeCur('usd', $val);
					break;

					case 'sum_open_rub':
					$user_sum_open['rub'] = $this->mergeCur('rub', $val);
					break;

					case 'sum_open_uah':
					$user_sum_open['uah'] = $this->mergeCur('uah', $val);
					break;

					case 'sum_approved_usd':
					$user_sum_approved_arr['usd'] = ($val-$user['payment_usd']-$user['paid_usd']);
					$user_sum_approved['usd'] = $this->mergeCur('usd', ($val-$user['payment_usd']-$user['paid_usd']));
					break;

					case 'sum_approved_rub':
					$user_sum_approved_arr['rub'] = ($val-$user['payment_rub']-$user['paid_rub']);
					$user_sum_approved['rub'] = $this->mergeCur('rub', ($val-$user['payment_rub']-$user['paid_rub']));
					break;

					case 'sum_approved_uah':
					$user_sum_approved_arr['uah'] = ($val-$user['payment_uah']-$user['paid_uah']);
					$user_sum_approved['uah'] = $this->mergeCur('uah', ($val-$user['payment_uah']-$user['paid_uah']));
					break;

				}
			}
		}

		$user_sum_payment = array();
		if ($user['payment_usd'] > 0) {
			$user_sum_payment['usd'] = $this->mergeCur('usd', $user['payment_usd']);
		}
		if ($user['payment_rub'] > 0) {
			$user_sum_payment['rub'] = $this->mergeCur('rub', $user['payment_rub']);
		}
		if ($user['payment_uah'] > 0) {
			$user_sum_payment['uah'] = $this->mergeCur('uah', $user['payment_uah']);
		}

		$users_stat = $this->db->prepare('SELECT * FROM users_stat WHERE userid=? ORDER BY date DESC');
		$users_stat->execute(array($this->_user['user_id']));
		$users_stat_return = $users_stat->fetchAll(PDO::FETCH_ASSOC);

		$result = array(
			'sum_open'=>implode('<span class="balance__sep"></span>', $user_sum_open), 
			'sum_approved'=>implode('<span class="balance__sep"></span>', $user_sum_approved),
			'sum_payment'=>implode('<span class="balance__sep"></span>', $user_sum_payment),
			'stat'=>$users_stat_return,
			'sum_approved_arr'=>$user_sum_approved_arr
			);
		
		return $result;
	}

	protected function statTimeUpdate($upd = false) {
		$cur_timestamp = time();
		if ($upd) {
			$update_time = $this->db->prepare('UPDATE users SET last_upd_stat_time=? WHERE id=?');
			$update_time->execute(array($cur_timestamp, $this->_user['user_id']));
		} else {
			$last_time = $this->db->prepare('SELECT last_upd_stat_time FROM users WHERE id=?');
			$last_time->execute(array($this->_user['user_id']));
			$last_time = $last_time->fetch();
			if ($cur_timestamp > ($last_time[0]+5*60)) {
				return true;
			} else {
				return false;
			}
		}
	}

	protected function mergeCur($cur, $val) {
		switch ($cur) {
			case 'usd':
			$rtn = '$'.$val;
			break;

			case 'rub':
			$rtn = $val.' руб';
			break;

			case 'uah':
			$rtn = $val.' грн';
			break;
		}
		return $rtn;
	}

	protected function calcCash($pay, $cart) {
		
		$cur_perc = $pay/($cart/100);

		if ($cur_perc <= 2) {
			$com_perc = 0.5;
		} else if($cur_perc <= 3) {
			$com_perc = 1;
		} else {
			$com_perc = 1.5;
		}

		return round($pay-(($cart/100)*$com_perc), 2);
	}

	protected function getRate() {
		$sql_rate = $this->db->prepare('SELECT * FROM rate ORDER BY id DESC');
		$sql_rate->execute();
		$rate = $sql_rate->fetch(PDO::FETCH_ASSOC);

		$result = array();

		$result['rub'] = $this->mergeCur('rub', $rate['usd_rub']);
		$result['uah'] = $this->mergeCur('uah', $rate['usd_uah']);

		if ($this->_user['country'] == 'ru') {
			$result['user'] = $result['rub'];
		} else if ($this->_user['country'] == 'ua') {
			$result['user'] = $result['uah'];
		}
		
		return $result;
	}

	/*Admitad Statistics*/
	protected function getAdmitadStat($st_date,$end_date){

		$stat_arr = array(array());
		$sum_open = array();
		$sum_approved = array();

		$end_d = strtotime($end_date);
		$start_date = date('Y-m-d', strtotime('-5 months', $end_d));

		$xml = 'https://www.admitad.com/ru/webmaster/statistics/actions_xml/?export&format=xml&code=4091f1232c&user=lufter&start_date='.$start_date.'&end_date='.$end_date.'&sub_ids=userid'.$this->_user['user_id'];

		$xml_obj = simplexml_load_file($xml);

		foreach ($xml_obj->stat as $val) {

			if ((float) $val->payment) {

				$cashback = $this->calcCash((float) $val->payment, (float) $val->cart);
				$status = (string) $val->status;

				if ($status == 'approved' && (empty($val->closing_date) || $val->closing_date == '-')) {
					$status = 'pending';
				}
				
				$currency = strtolower((string) $val->currency);

				$date = explode(' ', (string) $val->action_date);

				$stat_arr[$date[0]][] = array(
					'shop_name'=>(string) $val->advcampaign_name,
					'cashback'=>$this->mergeCur($currency, $cashback),
					'status'=>$status,
					'currensy'=>$currency,
					'product_image'=>(string) $val->product_image,
					'product_name'=>(string) $val->product_name,
					'price'=>$this->mergeCur($currency, (float) $val->cart)
					);


				if ($status == 'pending') {
					switch ($currency) {
						case 'usd':
						$sum_open['usd'] += $cashback;
						break;

						case 'rub':
						$sum_open['rub'] += $cashback;
						break;

						case 'uah':
						$sum_open['uah'] += $cashback;
						break;
					}

				} elseif ($status == 'approved') {
					switch ($currency) {
						case 'usd':
						$sum_approved['usd'] += $cashback;
						break;

						case 'rub':
						$sum_approved['rub'] += $cashback;
						break;

						case 'uah':
						$sum_approved['uah'] += $cashback;
						break;
					}

				}

			}

		}

		return array('sum_open'=>$sum_open, 'sum_approved'=>$sum_approved, 'data'=>$stat_arr);
	}


	/*other Statistics*/
	protected function getOtherStat($start_date,$end_date){

		$stat_arr = array(array());
		$sum_open = array();
		$sum_approved = array();

		$xml = 'test-xml/a-2017-08-30-userid'.$this->_user['user_id'].'.xml';

		if(file_exists($xml)){
			$xml_obj = simplexml_load_file($xml);

			foreach ($xml_obj->stat as $val) {

				if ((float) $val->payment) {

					$cashback = $this->calcCash((float) $val->payment, (float) $val->cart);
					$status = (string) $val->status;
					$currency = strtolower((string) $val->currency);

					$date = explode(' ', (string) $val->action_date);

					$stat_arr[$date[0]][] = array(
						'shop_name'=>(string) $val->advcampaign_name,
						'cashback'=>$this->mergeCur($currency, $cashback),
						'status'=>$status,
						'currensy'=>$currency,
						'product_image'=>(string) $val->product_image,
						'product_name'=>(string) $val->product_name,
						'price'=>$this->mergeCur($currency, (float) $val->cart)
						);

					if ($status == 'pending') {
						switch ($currency) {
							case 'usd':
								$sum_open['usd'] += $cashback;
								break;

							case 'rub':
								$sum_open['rub'] += $cashback;
								break;
							
							case 'uah':
								$sum_open['uah'] += $cashback;
								break;

							default:
								$sum_open[$currency] += $cashback;
								break;
						}
						
					} elseif ($status == 'approved') {
						switch ($currency) {
							case 'usd':
								$sum_approved['usd'] += $cashback;
								break;

							case 'rub':
								$sum_approved['rub'] += $cashback;
								break;
							
							case 'uah':
								$sum_approved['uah'] += $cashback;
								break;

							default:
								$sum_approved[$currency] += $cashback;
								break;
						}

					}
					
				}

			}

		}

		return array('sum_open'=>$sum_open, 'sum_approved'=>$sum_approved, 'data'=>$stat_arr);
	}

	
}
?>