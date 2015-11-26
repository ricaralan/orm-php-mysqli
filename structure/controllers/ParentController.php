<?php

class ParentController {

	public function getAll($model) {
		return json_encode($model->getAll());
	}

	public function getById($model, $id, $columns = null) {
		return json_encode($model->getById($id, $columns));
	}

	public function getWhere($model, $columns = null, $where) {
		return json_encode($model->getWhere($columns, $where));
	}

	public function save($model, $id = null, $data = array()) {
		return json_encode($model->save($data, $id));
	}

	public function delete($model, $id) {
		return json_encode($model->delete($id));
	}

}

?>
