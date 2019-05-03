<?php
class Shops extends Core
{
	private $_page;
	protected $_itemsquantity;
	protected $_category_id;

	protected function getContent($query)
	{
		$cat = array();

		if ($this->_alias) {
			$category = $this->db->prepare('SELECT * FROM categories WHERE alias=? AND relation=?');
			$category->execute(array($this->_alias, 'shops'));
			$category_arr = $category->fetch(PDO::FETCH_ASSOC);

			$this->_category_id = $category_arr['id'];

			if (empty($this->_category_id)) {
				$this->_page_not_found = true;
			}

			if (!empty($this->_region)) {
				$cat[0] = '%"' . $category_arr['id'] . '"%';
				$cat[1] = 1;
				$cat[2] = 1;

				$par = 'category_ids LIKE ? AND ' . $this->_region . '_reg=? AND available=?';
			} else {
				$cat[0] = '%"' . $category_arr['id'] . '"%';
				$cat[1] = 1;
				$cat[2] = 1;
				$cat[3] = 1;
				$cat[4] = 1;

				$par = 'category_ids LIKE ? AND by_reg=? AND ru_reg=? AND ua_reg=? AND available=?';
			}
		} else {
			if (!empty($this->_region)) {
				$cat[0] = 1;
				$cat[1] = 1;

				$par = $this->_region . '_reg=? AND available=?';
			} else {
				$cat[0] = 1;
				$cat[1] = 1;
				$cat[2] = 1;
				$cat[3] = 1;

				$par = 'by_reg=? AND ru_reg=? AND ua_reg=? AND available=?';
			}
		}

		// pages
		$this->_page = $query['page'];

		if (empty($this->_page)) {
			$page = 1;
		} else {
			$page = $this->_page;
		}

		$page = ($page - 1) * 24;

		// quantity
		$sql = $this->db->prepare('SELECT COUNT(*) FROM shops WHERE ' . $par . ' AND quantity > 0');
		$sql->execute($cat);
		$this->_itemsquantity = $sql->fetchColumn();

		// get shops
		$sql = $this->db->prepare('SELECT * FROM shops WHERE ' . $par . ' AND quantity > 0 ORDER BY quantity DESC LIMIT ' . $page . ',24');
		$sql->execute($cat);
		$result['shops'] = $sql->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	protected function getPagenav()
	{
		$base = 'shops';

		if (!empty($this->_alias)) {
			$alias = '/' . $this->_alias;
		} else {
			$alias = '';
		}

		if (empty($this->_page)) {
			$page = 1;
		} else {
			$page = $this->_page;
		}

		$pages = ceil($this->_itemsquantity / 24);

		if ($this->_itemsquantity > 24) {
			// prev link
			if ($page > 1) {
				if ($page == 2) {
					$pagination = '<li class="paginate__item"><a rel="nofollow" href="/' . $base . $alias . '" class="paginate__prev"></a></li>';
				} else {
					$pagination = '<li class="paginate__item"><a rel="nofollow" href="/' . $base . $alias . '/page/' . ($page - 1) . '" class="paginate__prev"></a></li>';
				}
			} else {
				$pagination = '<li class="paginate__item"><span class="paginate__prev paginate__prev_disabled"></span></li>';
			}

			// page links
			if ($pages <= 5) {
				$pag = $pages;
				$i = 1;
			} else {
				$pag = 5;
				$i = 1;

				if ($page > 3) {
					$i = $page - 2;
					$pag = $page + 2;
				}

				if ($page > ($pages - 2)) {
					$i = $pages - 4;
					$pag = $pages;
				}
			}

			if ($pages > 5 && $page > 3) {
				$dots = '';

				if ($page > 4 && $pages != 6) {
					$dots = '<li class="paginate__item">...</li>';
				}

				$pagination .= '<li class="paginate__item"><a rel="nofollow" href="/' . $base . $alias . '" title="1-я страница" class="paginate__a">1</a></li>' . $dots;
			}

			for ($i; $i <= $pag; $i++) {
				if ($page == $i) {
					$pagination .= '<li class="paginate__item"><span class="paginate__curr">' . $i . '</span></li>';
				} else {
					if ($i == 1) {
						$pagination .= '<li class="paginate__item"><a rel="nofollow" href="/' . $base . $alias . '" title="1-я страница" class="paginate__a">1</a></li>';
					} else {
						$pagination .= '<li class="paginate__item"><a rel="nofollow" href="/' . $base . $alias . '/page/' . $i . '" title="' . $i . '-я страница" class="paginate__a">' . $i . '</a></li>';
					}
				}
			}

			if ($pages > 5 && $page < ($pages - 2)) {
				$dots = '';

				if ($page != ($pages - 3) && $pages != 6) {
					$dots = '<li class="paginate__item">...</li>';
				}

				$pagination .= $dots . '<li class="paginate__item"><a rel="nofollow" href="/' . $base . $alias . '/page/' . $pages . '" title="' . $pages . '-я страница" class="paginate__a">' . $pages . '</a></li>';
			}

			// next link
			if ($page < $pages) {
				$pagination .= '<li class="paginate__item"><a rel="nofollow" href="/' . $base . $alias . '/page/' . ($page + 1) . '" class="paginate__next"></a></li>';
			} else {
				$pagination .= '<li class="paginate__item"><span class="paginate__next paginate__next_disabled"></span></li>';
			}
		}

		return $pagination;
	}
}
