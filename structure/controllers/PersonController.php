<?php
include_once 'ParentController.php';
include_once '../models/PersonModel.php';

class PersonController extends ParentController {

	public $personModel = null;

	public function __construct() {
		$this->personModel = new PersonModel();
	}

}

$controller = new PersonController();

/* ======== EXAMPLE 1 ==========
// CREATE
echo $controller->save($controller->personModel, null, array(
	"per_id" => 1,
	"per_name" => "A Name",
	"per_last_name" => "A Last Name"
));
*/

/* ======== EXAMPLE 2 ==========
// UPDATE
echo $controller->save($controller->personModel, 1, array(
	"per_name" => "A Name 2",
	"per_last_name" => "A Last Name 2"
));
*/

/* ======== EXAMPLE 3 ==========
// DELETE
echo $controller->delete($controller->personModel, 1);
*/

/* // GET ALL
echo $controller->getAll($controller->personModel);
*/

/* ======== EXAMPLE 4 ==========
// GET * WHERE
echo $controller->getWhere($controller->personModel, null, array(
	"per_name" => "A name-"
	));

// GET ["per_name", "per_last_name"] WHERE 
echo $controller->getWhere($controller->personModel, array("per_name", "per_last_name"), array(
	"per_name" => "A name-"
	));
*/

/* ======== EXAMPLE 5 ========== 
// GET * BY ID
echo $controller->getById($controller->personModel, 1);

// GET ["per_name", "per_last_name"] BY ID
echo $controller->getById($controller->personModel, 1, array("per_name", "per_last_name"));

*/

?>
