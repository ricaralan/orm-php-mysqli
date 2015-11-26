<?php

require_once 'MySQLProvider.php';
require_once 'MySQLProvider.php';

class Database {

	private static $provider;
	protected $params;

	public function __construct() {
		self::$provider = new MySQLProvider();
		self::$provider->connect("localhost","root","RAOR940203","test_db");
	}

	public function getConnection() {
		return self::$provider;
	}

	private function replaceParams($params) {
		$p = current($this->params);
		next($this->params);
		return $p;
	}

	private function prepare($sql, $params = null) {
		$escaped = array();
		if($params) {
			$i = 0;
			foreach ($params as $key => $value) {
				if(is_bool($value)) {
					$value = ($value) ? 1 : 0;
				} else if(is_null($value)) {
					$value = NULL;
				} else if(is_string($value)) {
					$value = "\"$value\"";
				}
				$escaped[$i++] = $value;
			}
		}
		$this->params = $escaped;
		$query = preg_replace_callback("/(\?)/i", array($this, "replaceParams"), $sql);
        return $query;
	}

	public function sendQuery($query, $params = null) {
		$result = $this->prepare($query, $params);
		return self::$provider->query($this->prepare($query, $params));
	}

	public function execute($query, $array_index = null, $params = null) {
		return $this->sendQuery($query, $params);
	}

}

?>