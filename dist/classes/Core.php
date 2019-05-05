<?php
class Core
{
	protected $db;
	protected $_region;
	protected $_alias;
	protected $_template;
	protected $_route;
	protected $_page_not_found;

	public function __construct()
	{
		$this->db = DbConnect::getInstance();
		$this->db = $this->db->getDb();
	}

	protected function getRegion($region = '')
	{
		if ($region) {
			$_SESSION['region'] = $region;
			SetCookie('bb_region', $region, time() + 2592000, '/');
			header('Location: /' . $this->_alias);
			exit;
		} else {
			if ($_SESSION['region']) {
				$region = $_SESSION['region'];
			} elseif ($_COOKIE['bb_region']) {
				$region = $_SESSION['region'] = $_COOKIE['bb_region'];
			}
		}

		return $region;
	}

	protected function getMeta()
	{
		$meta_sql = $this->db->prepare('SELECT * FROM meta WHERE route=?');
		$meta_sql->execute(array($this->_route));
		$result = $meta_sql->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	protected function getMenu($menu_arr)
	{
		$menu = '<ul class="menu">';
		foreach ($menu_arr as $key => $val) {
			$menu .= '<li class="menu__item ';

			if ($key == $this->_route) {
				$menu .= 'menu__item_current';
			} else if ($key == explode('/', $this->_route)[0]) {
				$menu .= 'menu__item_current-parent';
			} else if (is_array($val)) {
				foreach ($val[1] as $s_key => $s_val) {
					if ($s_key == $this->_route) {
						$menu .= 'menu__item_current-parent';
					}
				}
			}

			if (is_array($val)) {
				$menu .= ' menu__item_has-children"><a href="/' . $key . '" class="menu__a">' . $val[0] . '</a>';
				$menu .= '<ul class="sub-menu">';
				foreach ($val[1] as $s_key => $s_val) {
					$menu .= '<li><a href="/' . $s_key . '" class="menu__a">' . $s_val . '</a></li>';
				}
				$menu .= '</ul>';
			} else {
				$menu .= '"><a href="/' . $key . '" class="menu__a">' . $val . '</a>';
			}
			$menu .= '</li>';
		}
		$menu .= '</ul>';

		return $menu;
	}

	protected function getCategoryMenu()
	{
		$cats = $this->db->prepare('SELECT * FROM categories WHERE relation=? ORDER BY name');
		$categories_arr = array();

		if ($this->_template == 'coupons') {
			$cats->execute(array('coupons'));
			$cats = $cats->fetchAll(PDO::FETCH_ASSOC);

			switch ($this->_type) {
				case 'free-shipping':
					$type = 'f_ship';
					break;

				case 'discounts':
					$type = 'discount';
					break;

				case 'gifts':
					$type = 'gift';
					break;
			}

			foreach ($cats as $item) {
				$quant = json_decode($item['quantity'], true);

				if ($this->_region) {
					if ($quant[$this->_region . '_' . $type] > 0) {
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="sidebar__menu-item current"' : ' class="sidebar__menu-item"';
						$categories_arr[] .= '><a href="/' . $this->_type . '/' . $item['alias'] . '" class="sidebar__menu-a">' . $item['name'] . '</a></li>';
					}
				} else {
					if ($quant['by_' . $type] > 0 && $quant['ru_' . $type] > 0 && $quant['ua_' . $type] > 0) {
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="sidebar__menu-item current"' : ' class="sidebar__menu-item"';
						$categories_arr[] .= '><a href="/' . $this->_type . '/' . $item['alias'] . '" class="sidebar__menu-a">' . $item['name'] . '</a></li>';
					}
				}
			}
		} elseif ($this->_template == 'shops') {
			$cats->execute(array('shops'));
			$cats = $cats->fetchAll(PDO::FETCH_ASSOC);

			foreach ($cats as $item) {
				$quant = json_decode($item['quantity'], true);

				if ($this->_region) {
					if ($quant[$this->_region . '_shops'] > 0) {
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="sidebar__menu-item current"' : ' class="sidebar__menu-item"';
						$categories_arr[] .= '><a href="/shops/' . $item['alias'] . '" class="sidebar__menu-a">' . $item['name'] . '</a></li>';
					}
				} else {
					if ($quant['by_shops'] > 0 && $quant['ru_shops'] > 0 && $quant['ua_shops'] > 0) {
						$categories_arr[] = '<li';
						$categories_arr[] .= ($item['alias'] == $this->_alias) ? ' class="sidebar__menu-item current"' : ' class="sidebar__menu-item"';
						$categories_arr[] .= '><a href="/shops/' . $item['alias'] . '" class="sidebar__menu-a">' . $item['name'] . '</a></li>';
					}
				}
			}
		}

		$categories = '<ul class="sidebar__menu">';
		foreach ($categories_arr as $item) {
			$categories .= $item;
		}
		$categories .= '</ul>';

		return $categories;
	}

	public function getBody($query)
	{
		$lemon = $this;
		$template = $this->_template = $query['template'];
		$route = $this->_route = $query['route'];
		$alias = $this->_alias = $query['alias'];
		$region = $this->_region = $this->getRegion($query['region']);

		if ($template) {
			$content = $this->getContent($query);
		}

		$type = $this->_type;
		$meta = $this->getMeta();

		if (file_exists('templates/' . $template . '.php') && !$this->_page_not_found) {
			require_once('templates/' . $template . '.php');
		} else {
			require_once('templates/404.php');
		}
	}
}
