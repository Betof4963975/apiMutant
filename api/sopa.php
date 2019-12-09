<?php

$array2 = array("ATGCGA",
	            "CAGTGC",
	            "TTATGT",
	            "AGAAGG",	            
	            "CCCCTA",
	            "TCACTG");
$arrayMatriz = array();
//intento de armado de matriz
for($i=0; $i < sizeof($array2); $i++) {
	$fila = str_split($array2[$i]);
	array_push($arrayMatriz, $fila);
}
///////////////////////////////
//var_dump($arrayMatriz);
//echo "<br>";

$coincidenciasFila = 0;
$coincidenciasCol = 0;
$coincidenciasDiag = 0;
$encontradas = 0;
$encontradasLinea = 0;
$encontradasDiag = 0;
$encontradasCol = 0;

$esBueno = false;

// ---------------------------------------

for ($i=0; $i < sizeof($arrayMatriz); $i++) {

	$encontradasLinea = buscarlinea($i,$arrayMatriz);
	$encontradasCol =  buscarColumna($i,$arrayMatriz);
	$encontradasDiag =  buscarDiagonal($i,$arrayMatriz);
}
echo "lineas encontradas=".$encontradasLinea."<br>";
echo "columnas encontradas=".$encontradasCol."<br>";
echo "diagonales encontradas=".$encontradasDiag."<br>";
$total = $encontradasLinea + $encontradasCol + $encontradasDiag;
if ($total >= 2) {
	$esBueno = true;
}

// ---------------------------------------

//echo "Cantidad de coincidencias:".$encontradas."<br>";
if ($esBueno == true) {
	echo "Se encontro resultado".$total."<br>";
	http_response_code(200);
}
else{
	http_response_code(403);
	echo "No se encontro nada".$total."<br>";
}

function buscarlinea($indice,$matriz)
{	
	$coincidencias = 0;
	$encontradasFila = 0;
	$encontradas = 0;
	$elemento = $matriz[$indice][$indice];
	//echo "Valor indicieFila:".$indice;
	//echo "Elemento Indice Fila:".$elemento."<br>";
	for ($j=0; $j <count($matriz[$indice],1) ; $j++) {		
		$comparar = $matriz[$indice][$j];
		//echo "Valor J:".$j;
		//echo "elemento fila:".$comparar."<br>";
		if ($matriz[$indice][$indice] == $matriz[$indice][$j])
		{
			
			$coincidencias = $coincidencias + 1;
		}
		else{
			break;
		}
	}
	if ($coincidencias >= 4) {
		$encontradas =  1;
	}
	return $encontradas;
}

function buscarColumna($indice,$matriz)
{
	$coincidencias = 0;
	$encontradasColumna = 0;
	$j = $indice;
	$elemento = $matriz[$indice][$indice];
	//echo "Valor indicieCol:".$indice;
	//echo "Elemento Indice Col:".$elemento."<br>";
	for ($i=0; $i <sizeof($matriz[$indice]) ; $i++) {
		//var_dump($matriz[$indice][$indice]);
		//echo "Valor I:".$i;
		$comparar = $matriz[$i][$indice];
		//echo "elemnto Col:".$comparar."<br>";
		if ($matriz[$indice][$indice] == $matriz[$i][$j]) {
			$coincidencias = $coincidencias + 1;
		}
		else{
			break;
		}
	}
	if ($coincidencias >= 4) {
		$encontradasColumna =  1;
	}
	return $encontradasColumna;
}

function buscarDiagonal($indice,$matriz)
{
	$coincidencias = 0;
	$encontradasDiagonal = 0;
	$j = $indice;
	echo "Valor indicieDiag:".$indice;
	echo "Elemento Indice Diag:".$elemento."<br>";
	for ($i=0; $i <sizeof($matriz[$indice]) ; $i++) {
		echo "Valor I:".$i;
		$comparar = $matriz[$i][$i];
		echo "elemnto Diag:".$comparar."<br>";
		if ($matriz[$indice][$indice] == $matriz[$i][$i]) {
			$coincidencias = $coincidencias + 1;
			echo "coincidencias Diag=".$coincidencias."<br>";
		}
		else{
			break;
		}
	}
	if ($coincidencias >= 4) {
		$encontradasDiagonal = 1;		
	}
	echo "encontradas Diag=".$encontradasDiagonal."<br>";
	return $encontradasDiagonal;
}

?>