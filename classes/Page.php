<?php
class Page extends Core {
	protected function getContent($query) {
		if(!empty($this->_alias)){
			$page = $this->_alias;
		}
		return $page;
	}
}
?>