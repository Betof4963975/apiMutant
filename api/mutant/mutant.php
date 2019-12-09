<?php

// include database and object files
include_once '../config/dbMutantes.php';
include_once '../objects/findMutants.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
$findMutants = new findMutants($db);
$findMutants->adn = $_GET['adn'];
if ($findMutants->esMutante() > 0) {
	http_response_code(200);
}
else{
	http_response_code(403);
}

?>