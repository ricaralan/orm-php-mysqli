<?php

class ParentModel {

	public $orm;

	public function getAll() {
		return $this->orm->getAll();
	}

	public function getById($id, $columns = null) {
		return $this->orm->getById($id, $columns);
	}

	public function getWhere($columns = null, $where) {
		$where = $this->getValidArrayByColumnsORM($where);
		return $this->orm->getWhere($columns, $where);
	}

	public function save($data, $where = null) {
		$data = $this->getValidArrayByColumnsORM($data);
		$this->setDataORM($data);
		return $this->orm->save($where);
	}

	public function delete($id) {
		return $this->orm->delete($id);
	}

	private function setDataORM($data) {
		$this->cleanDataORM();
		foreach ($data as $key => $value) {
			$this->orm->$key = $value;
		}
	}

	private function cleanDataORM() {
		foreach ($this->orm as $key => $value) {
			$this->orm->$key = null;
		}
	}

	private function getValidArrayByColumnsORM($array) {
		$columnsORM = array_keys(get_object_vars($this->orm));
		$validColumns = array();
		foreach ($array as $column => $value) {
			foreach ($columnsORM as $key => $validColumn) {
				if($column === $validColumn) {
					$validColumns[$column] = $value;
				}
			}
		}
		return $validColumns;
	}

}

?>
