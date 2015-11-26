<?php

require_once 'ParentModel.php';
require_once '../classes/Person.php';

class PersonModel extends ParentModel {

	public $orm;

	public function __construct() {
		$this->orm = new Person();
		$this->orm->setTableName("person");
		$this->orm->setNameId("per_id");
	}

}

?>
