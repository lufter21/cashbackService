<?php
class Core {
	
	protected $db;
	protected $_region;
	protected $_alias;
	protected $_template;
	protected $_route;
	protected $_user;
	
	public function __construct() {
		$this->db = DbConect::getInstance();
		$this->db = $this->db->getDb();
	}
	
	protected function getUser($update=''){

		if(!$_SESSION['access']){
			if($_COOKIE['access']){
				$access_key = $_SESSION['access'] = $_COOKIE['access'];
			}
		} else {
			$access_key = $_SESSION['access'];
		}

		if ($access_key) {

			if ($update) {
				if ($update['country']) {
					$update_user_country = $this->db->prepare('UPDATE users SET country=? WHERE access_key=?');
					$update_user_country->execute(array($update['country'], $access_key));
				} elseif ($update['activity']) {
					$update_user_activity = $this->db->prepare('UPDATE users SET activity=? WHERE access_key=?');
					$update_user_activity->execute(array($update['activity'], $access_key));
				}
			}

			$sql_users = $this->db->prepare('SELECT * FROM users WHERE access_key=?');
			$sql_users->execute(array($access_key));
			$user_data = $sql_users->fetch(PDO::FETCH_ASSOC);

			if ($user_data) {
				$user_info = array(
					'user_id'=>$user_data['id'],
					'name'=>$user_data['name'],
					'country'=>$user_data['country'],
					);
			}

		}

		return $user_info ?: array();
	}

	protected function getUserLink($link){
		if ($this->_user['user_id']) {
			$userid = $this->_user['user_id'];
			if (strpos($link, '?')) {
				$new_link = $link.'&subid=userid'.$userid;
			} else {
				$new_link = $link.'?subid=userid'.$userid;
			}
			return $new_link;
		} else {
			return $link;
		}
	}
	
	protected function getRegion($region='') {
		if ($region) {
			$_SESSION['region'] = $region;
			if ($this->_user && !$this->_user['country']) {
				$this->getUser(array('country'=>$region));
			}
		} else {

			if ($_SESSION['region']) {

				$region = $_SESSION['region'];
				if ($this->_user && !$this->_user['country']) {
					$this->getUser(array('country'=>$region));
				}

			} else {
				if ($this->_user['country']) {
					$region = $_SESSION['region'] = $this->_user['country'];
				}
			}

		}
		
		return $region;
	}
	
	protected function getMeta(){
		if($this->_category_id){	
			$cats = $this->db->prepare('SELECT name,title,description,text FROM categories WHERE id=?');
			$cats->execute(array($this->_category_id));
			$result = $cats->fetch(PDO::FETCH_ASSOC);
			return $result;
		}
	}
	
	protected function getMenu($menu_arr){
		$menu = '<ul class="menu">';
		foreach($menu_arr as $key=>$val){
			$menu .= '<li class="menu__item ';
			
			if ($key == $this->_route) {
				$menu .= 'menu__item_current';
			} else if($key == $this->_template){
				$menu .= 'menu__item_current-parent';
			} else if (is_array($val)){
				foreach($val[1] as $s_key=>$s_val){
					if ($s_key == $this->_route) {
						$menu .= 'menu__item_current-parent';
					}
				}
			}
			
			if(is_array($val)){
				$menu .= ' menu__item_has-sub-menu"><a href="/'.$key.'">'.$val[0].'</a>';
				$menu .= '<ul class="menu__sub-menu">';
				foreach($val[1] as $s_key=>$s_val){
					$menu .= '<li><a href="/'.$s_key.'">'.$s_val.'</a></li>';
				}
				$menu .= '</ul>';
			} else {
				$menu .= '"><a href="/'.$key.'">'.$val.'</a>';
			}
			$menu .= '</li>';
		}
		$menu .= '</ul>';
		
		return $menu;
	}
	
	protected function getCategoryMenu(){
		$cats = $this->db->prepare('SELECT * FROM categories ORDER BY nav');
		$cats->execute();
		$cats = $cats->fetchAll(PDO::FETCH_ASSOC);
		$categories_arr = array();
		
		if($this->_template == 'discounts'){
			foreach($cats as $item){
				if($this->_region){
					if($item['all_qnt'] > 0 || $item[$this->_region.'_qnt'] > 0){
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="current"':'';
						$categories_arr[] .= '><a href="/discounts/'.$item['alias'].'">'.$item['nav'].'</a></li>';
					}
				} else {
					if($item['all_qnt'] > 0 || $item['ru_qnt'] > 0 || $item['ua_qnt'] > 0){
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="current"':'';
						$categories_arr[] .= '><a href="/discounts/'.$item['alias'].'">'.$item['nav'].'</a></li>';
					}
				}
			}
		}
		elseif($this->_template == 'shops'){
			foreach($cats as $item){
				if($this->_region){
					if($item['all_shops'] > 0 || $item[$this->_region.'_shops'] > 0){
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="current"':'';
						$categories_arr[] .= '><a href="/shops/'.$item['alias'].'">'.$item['nav'].'</a></li>';
					}
				} else {
					if($item['all_shops'] > 0 || $item['ru_shops'] > 0 || $item['ua_shops'] > 0){
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="current"':'';
						$categories_arr[] .= '><a href="/shops/'.$item['alias'].'">'.$item['nav'].'</a></li>';
					}
				}
			}
		}
		
		
		$categories = '<ul>';
		foreach($categories_arr as $item){
			$categories .= $item;
		}
		$categories .= '</ul>';
		
		return $categories;
	}


	
	public function getBody($query) {
		$lemon = $this;
		$user = $this->_user = $this->getUser();
		$template = $this->_template = $query['template'];
		$this->_route = $query['route'];
		$alias = $this->_alias = $query['alias'];
		$region = $this->_region = $this->getRegion($query['region']);
		$content = $this->getContent($query);
		$meta = $this->getMeta();
		if(file_exists('templates/'.$template.'.php')){
			include('templates/'.$template.'.php');
		}
	}
	
}
?>