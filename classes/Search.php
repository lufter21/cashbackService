<?php
class Search extends Core{
	
	private $_page;
	protected $_itemsquantity;
	
	protected function getContent($query) {
		
		if(isset($_POST['search'])){
			$search = $_POST['search'];
			$_SESSION['search'] = $search;
		}
		else{
			$search = $_SESSION['search'];
		}
		
		$result['search'] = $search = trim(htmlspecialchars(strip_tags($search)));
		
		if(!empty($search)) {
			
			$search = explode(' ',$search);
			$new_search = array();
			$regular = "/(ый|ой|ая|ое|ые|ому|а|о|у|е|ого|ему|и|ство|ых|ох|ия|ий|ие|ь|я|он|ют|ат|щин|чин)$/i";
			
			foreach($search as $search){
				if(mb_strlen($search,'utf-8')>3) {
					$word = preg_replace($regular,'',$search);
					$new_search[] .= $word;
				}
			}
			
			$search_count = count($new_search);
			
			if($search_count>1){
				$search_query = '';
				$words = array();
				foreach($new_search as $key=>$new_search){
					$search_query .= '(title LIKE ? OR description LIKE ? OR category LIKE ?)';
					if($key+1<$search_count){
						$search_query .= ' AND ';
					}
					for($i=1;$i<=3;$i++){
						$words[] .= '%'.$new_search.'%';
					}
				}		
			}
			else{
				$search_query = '(title LIKE ? OR description LIKE ? OR category LIKE ?)';
				$words[0] = '%'.$new_search[0].'%';
				$words[1] = '%'.$new_search[0].'%';
				$words[2] = '%'.$new_search[0].'%';
			}
			
			$this->_page = $query['page'];
			if(empty($this->_page)){
				$page = 1;
			}
			else{
				$page = $this->_page;
			}
			$page = ($page-1)*24;
			
			
			$cat = array();
			if(!empty($this->_region)){
				$cat[0] = 'all';
				$cat[1] = $this->_region;
				$cat[2] = 1;
				$par = '(region=? OR region=?) AND available=? AND ';
				$words = array_merge($cat,$words);
			}
			else{
				$cat[0] = 1;
				$par = 'available=?';
				$words = array_merge($cat,$words);
			}
			
			$result['sorting'] = $sorting = $this->getSorting();
			
			$pag = $this->db->prepare('SELECT * FROM discounts WHERE '.$par.$search_query);
			$pag->execute($words);
			$this->_itemsquantity = $pag->rowCount();
			
			$sql = $this->db->prepare('SELECT * FROM discounts WHERE '.$par.$search_query.$sorting.' LIMIT '.$page.',24');
			$sql->execute($words);
			$result['discounts'] = $sql->fetchAll(PDO::FETCH_ASSOC);
			
			/*$shops = $this->db->prepare('SELECT alias,url,name FROM shops');
			$shops->execute();
			$shops = $shops->fetchAll(PDO::FETCH_ASSOC);
			foreach($shops as $shop) {
				$result['shops'][$shop['alias']] = array('name'=>$shop['name'],'url'=>$shop['url']);
			}*/
		}
		return $result;
	}
	
	protected function getPagenav() {
		
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
				$pagination = '<a rel="nofollow" href="/search/page/1" title="1-я страница">1</a>'.$dots;
			}
			for($i;$i<=$pag;$i++)
			{
				if($page==$i)
				{
					$pagination .= '<span class="current-page">'.$i.'</span>';
				}
				else
				{
					$pagination .= '<a rel="nofollow" href="/search/page/'.$i.'" title="'.$i.'-я страница">'.$i.'</a>';
				}
			}
			if($pages>5 && $page<$pages-2)
			{
				$dots = '';
				if($page!=$pages-3 && $pages!=6)
				{
					$dots = '<span class="dots">...</span>';
				}
				$pagination .= $dots.'<a rel="nofollow" href="/search/page/'.$pages.'" title="'.$pages.'-я страница">'.$pages.'</a>';
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