<?php

// include database and object files
include_once $_SERVER['DOCUMENT_ROOT'].'/api/config/dbMutantes.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/api/objects/findMutants.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

$findMutants = new findMutants($db);

$findMutants->adn = $_POST['dna'];
if ($findMutants->esMutante() > 0) {
	echo"Es Mutante";
	http_response_code(200);
}
else{
	echo"es Humano";
	http_response_code(403);
}

?>