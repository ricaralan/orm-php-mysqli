<?php

require_once 'Database.php';

class ORM {

	private static $nameId;
	private static $table;
	private static $database;
	protected static $_conn;

	public function __construct() {
		self::$database = new Database();
	}

	public function setTableName($tableName) {
		self::$table = $tableName;
	}

	public function setNameId($nameId) {
		self::$nameId = $nameId;
	}

	public function getAll() {
		return self::$database->execute("SELECT * FROM ".self::$table)["objects"];
	}

	public function getById($id, $columns = null) {
		if($columns) {
            $columns = $this->getValidColumns($columns);
            if(sizeof($columns) > 0) {
            	$columns = join(", ", $columns);
            } else {
            	$columns = "*";
            }
		} else {
			$columns = "*";
		}
		$query = "SELECT ".$columns." FROM ".self::$table." WHERE ".self::$nameId."='$id'";
		return self::$database->execute($query);
	}

	public function getWhere($columns, $where) {
		if($columns) {
			$columns = $this->getValidColumns($columns);
			$columns = join(", ", $columns);
		} else {
			$columns = "*";
		}
		if($where) {
			$columnsWhere = join(" = ? AND ", array_keys($where));
			$columnsWhere .= ' = ?';
		}
		$query = "SELECT ".$columns." FROM ".self::$table." WHERE ".$columnsWhere;
		return self::$database->execute($query, null, $where);
	}

	public function save($id = null) {
		$values = get_object_vars($this);
		$filtered = null;
		foreach ($values as $key => $value) {
			if($value !== null && $value !== '') {
				$filtered[$key] = $value;
			}
		}
		$columns = array_keys($filtered);
		if($id) {
			// UPDATE
			$columns = join(" = ?, ", $columns);
			$columns.= ' = ?';
			$query = "UPDATE ".self::$table." SET $columns WHERE "
					.self::$nameId."=".(is_string($id)?"\"$id\"":$id);
		} else {
			// CREATE
			$params = join(", ", array_fill(0, count($columns), "?"));
            $columns = join(", ", $columns);
            $query = "INSERT INTO ".self::$table." ($columns) VALUES ($params)";
		}
		return self::$database->execute($query, null, $filtered);
	}

	public function getValidColumns($columns) {
		$thisVars = get_object_vars($this);
		$arrColumns = array();
		foreach ($thisVars as $columnName => $columnValue) {
			foreach ($columns as $key => $value) {
				if($columnName === $value) {
					array_push($arrColumns, $value);
				}
			}
		}
		return $arrColumns;
	}

	public function delete($id) {
		$query = 'DELETE FROM '.self::$table.' WHERE ';
		if(is_array($id)) {
			$query .= join(" = ?,", array_keys($id));
			$query .= " = ?";
		} else {
			$query .= self::$nameId.'=?';
			$id = array(id=>$id);
		}
		return self::$database->execute($query, null, $id);
	}

	public function query($query) {
		return self::$database->execute($query, null, null);
	}

}

?>
