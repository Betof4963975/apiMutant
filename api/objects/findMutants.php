<?php

class findMutants{
	private $conn;
	private $table_name = "adn";
	public $adn;
	public function __construct($db)
	{
	   $this->conn = $db;
	}

	function esMutante()
	{
		$adnIngresado = $this->adn;
		$coincidenciasFila = 0;
		$coincidenciasCol = 0;
		$coincidenciasDiag = 0;
		$encontradas = 0;
		$encontradasLinea = 0;
		$encontradasDiag = 0;
		$encontradasCol = 0;
		$esBueno = false;
		//obtengo el array desde el string adn
		$arrayCadenaAdn = explode(",", $this->adn);
		//creo una matriz con cada elemento del array adn
		$arrayMatriz = array();
		//intento de armado de matriz
		for($i=0; $i < sizeof($arrayCadenaAdn); $i++) {
			$fila = str_split($arrayCadenaAdn[$i]);
			array_push($arrayMatriz, $fila);
		}
		//var_dump($arrayMatriz);
		for ($i=0; $i < sizeof($arrayMatriz); $i++) {

			$encontradasLinea = $this->buscarlinea($i,$arrayMatriz);
			$encontradasCol =  $this->buscarColumna($i,$arrayMatriz);
			$encontradasDiag =  $this->buscarDiagonal($i,$arrayMatriz);
		}
		echo "lineas encontradas=".$encontradasLinea."<br>";
		echo "columnas encontradas=".$encontradasCol."<br>";
		echo "diagonales encontradas=".$encontradasDiag."<br>";
		$total = $encontradasLinea + $encontradasCol + $encontradasDiag;
		if ($total >= 2) {
			$esBueno = true;
		}
		echo "resultado=".$esBueno;
		// ---------------------------------------
		echo "Cadena a guardar Primero =".$adnIngresado."<br>";
		$this->guardarCadena($adnIngresado,$esBueno);
		//echo "Cantidad de coincidencias:".$encontradas."<br>";
		if ($esBueno == true) {
			return 1;
		}
		else{
			return 0;
		}
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

	function guardarCadena($adn,$mutante)
	{
		echo "Cadena a guardar =".$adn."<br>";
		echo "Se encontro mutante =".$mutante."<br>";
		echo "Tabla bd=".$this->table_name."<br>";
		$database = new Database();
		$db = $database->getConnection();

		if ($mutante == true) {
			$mutante = 1;
		}
		else{
			$mutante = 0;
		}
		$query = "INSERT INTO
	             " . $this->table_name . "
	             SET
	              cadenas_adn=:cadenas_adn, es_mutante=:es_mutante";

	     $stmt = $db->prepare($query);
	     $stmt->bindParam(":cadenas_adn", $adn);
	     $stmt->bindParam(":es_mutante", $mutante);
	     $stmt->execute();
	     return true;
	}
}
?>