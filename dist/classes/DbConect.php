<?php
class DbConect {
	private $_connection;
	private static $_instance;
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	private function __construct(){
		$this->_connection = new PDO('mysql:host=localhost;dbname=bombonus','root','');
		$this->_connection -> query('SET NAMES utf8');
	}
	
	private function __clone(){}
	
	public function getDb(){
		return $this->_connection;
	}
}
?>