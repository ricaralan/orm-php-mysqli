<?php

class MySQLProvider {

	private $resourceMysqli = null;

	public function connect($host, $user, $pass, $DBName) {
		$this->resourceMysqli = new mysqli($host, $user, $pass, $DBName);
		if($this->resourceMysqli->connect_errno) {
			print $this->resourceMysqli->connect_error;
			error_log($this->resourceMysqli->connect_error);
		} else {
			$this->setCharset('utf-8');
		}
		return $this;
	}

	public function query($query) {
		$result = $this->resourceMysqli->query($query);
		if(is_object($result) && $result->num_rows > 0) {
			return $this->getStatus($this->getObjectsByResult($result));
		}
		$status = $this->getStatus();
		$status["query"] = "$query";
		return $status;
	}

	public function fetchArray($result) {
		$result->fetch_assoc();
		return $this;
	}

	public function disconnect() {
		$this->resourceMysqli->close();
	}

	public function isConnected() {
		return !is_null($this->resourceMysqli);
		return $this;
	}

	private function getStatus($objects = null) {
		return array(
			"affected_rows" => $this->resourceMysqli->affected_rows,
			"inserted" => $this->resourceMysqli->affected_rows>0 && $this->resourceMysqli->insert_id !== 0,
			"updated" => !($this->resourceMysqli->affected_rows>0 && $this->resourceMysqli->insert_id !== 0) 
							&& !($this->resourceMysqli->affected_rows <= 0),
			"unchanged" => $this->resourceMysqli->affected_rows <= 0,
			"insert_id" => $this->resourceMysqli->insert_id,
			"error" => $this->resourceMysqli->error,
			"objects" => $objects
			);
	}

	private function getObjectsByResult($result) {
		$objects = array();
		while($object = $result->fetch_assoc()) {
			foreach ($object as $key => $value) {
				$posibleNumber = doubleval($value);
				if($posibleNumber > 0) {
					$object[$key] = $posibleNumber;					
				}
			}
			array_push($objects, $object);
		}
		return $objects;
	}

	public function setCharset($charset) {
		$this->resourceMysqli->set_charset($charset);
		return $this;
	}

}

?>
