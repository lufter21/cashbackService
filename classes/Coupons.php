<?php
class Coupons extends Core {

	private $_page;
	protected $_itemsquantity;
	protected $_category_id;

	protected function getContent($query) {
		
		$cat = array();
		if(!empty($this->_alias)){
			$category = $this->db->prepare('SELECT id,key_s,all_qnt,ru_qnt,ua_qnt FROM categories WHERE alias=?');
			$category->execute(array($this->_alias));
			$category_arr = $category->fetch(PDO::FETCH_ASSOC);
			
			$this->_category_id = $category_arr['id'];

			if (empty($this->_category_id)) {
				$this->_page_not_found = true;
			}

			if(!empty($this->_region)){
				$cat[0] = '%'.$category_arr['key_s'].'%';
				$cat[1] = 'all';
				$cat[2] = $this->_region;
				$cat[3] = 1;
				$par = 'category LIKE ? AND (region=? OR region=?) AND available=?';
				$this->_itemsquantity = $category_arr['all_qnt'] + $category_arr[$this->_region.'_qnt'];
			}
			else{
				$cat[0] = '%'.$category_arr['key_s'].'%';
				$cat[1] = 1;
				$par = 'category LIKE ? AND available=?';
				$this->_itemsquantity = $category_arr['all_qnt'] + $category_arr['ru_qnt'] + $category_arr['ua_qnt'];
			}
		}
		else{
			if(!empty($this->_region)){
				$cat[0] = 'all';
				$cat[1] = $this->_region;
				$cat[2] = 1;
				$par = '(region=? OR region=?) AND available=?';
			}
			else{
				$cat[0] = 1;
				$par = 'available=?';
			}
			$sql = $this->db->prepare('SELECT COUNT(*) FROM discounts WHERE '.$par);
			$sql->execute($cat);
			$this->_itemsquantity = $sql->fetchColumn();
		}
		
		$this->_page = $query['page'];
		if(empty($this->_page)){
			$page = 1;
		}
		else{
			$page = $this->_page;
		}
		$page = ($page-1)*24;
		
		$result['sorting'] = $sorting = $this->getSorting();
		
		$sql = $this->db->prepare('SELECT * FROM discounts WHERE '.$par.$sorting.' LIMIT '.$page.',24');
		$sql->execute($cat);
		$result['discounts'] = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		$shops = $this->db->prepare('SELECT alias,cashback,name FROM shops');
		$shops->execute();
		$shops = $shops->fetchAll(PDO::FETCH_ASSOC);
		foreach($shops as $shop) {
			$result['shop_cashback'][$shop['alias']] = $shop['cashback'];
			$result['shop_name'][$shop['alias']] = $shop['name'];
		}
		
		return $result;
	}

	protected function getPagenav() {

		if(!empty($this->_alias)){
			$alias = '/'.$this->_alias;
		}
		else{
			$alias = '';
		}
		
		if(empty($this->_page)){
			$page = 1;
		}
		else{
			$page = $this->_page;
		}
		
		$pages = ceil($this->_itemsquantity / 24);
		$pagination = '';
		if($this->_itemsquantity > 24)
		{
			if($pages<=5)
			{
				$pag = $pages;
				$i = 1;
			}
			else
			{
				$pag = 5;
				$i = 1;
				if($page>3)
				{
					$i = $page-2;
					$pag = $page+2;
				}
				if($page>$pages-2)
				{
					$i = $pages-4;
					$pag = $pages;
				}
			}
			if($pages>5 && $page>3)
			{
				$dots = '';
				if($page>4 && $pages!=6)
				{
					$dots = '<span class="dots">...</span>';
				}
				$pagination = '<a rel="nofollow" href="/discounts'.$alias.'/page/1" title="1-я страница">1</a>'.$dots;
			}
			for($i;$i<=$pag;$i++)
			{
				if($page==$i)
				{
					$pagination .= '<span class="current-page">'.$i.'</span>';
				}
				else
				{
					$pagination .= '<a rel="nofollow" href="/discounts'.$alias.'/page/'.$i.'" title="'.$i.'-я страница">'.$i.'</a>';
				}
			}
			if($pages>5 && $page<$pages-2)
			{
				$dots = '';
				if($page!=$pages-3 && $pages!=6)
				{
					$dots = '<span class="dots">...</span>';
				}
				$pagination .= $dots.'<a rel="nofollow" href="/discounts'.$alias.'/page/'.$pages.'" title="'.$pages.'-я страница">'.$pages.'</a>';
			}
		}
		return $pagination;
	}
	
	private function getSorting(){
		if(isset($_POST['sorting'])) {
			$result = $_SESSION['sorting'] = $_POST['sorting'];
			$this->_page = 1;
		}
		else{
			if(isset($_SESSION['sorting'])) {
				$result = $_SESSION['sorting'];
			}
			else {
				$result = ' ORDER BY dis_count DESC';
			}
		}
		
		if(empty($this->_page)){
			unset($_SESSION['sorting']);
			$result = ' ORDER BY dis_count DESC';
		}
		return $result;
	}
	
	protected function delDiscount($id) {
		$del = $this->db->prepare('DELETE FROM discounts WHERE id=?');
		$del->execute(array($id));
	}
	
}
?>