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
		$arrayCaracteres = array("A","T","G","C");
		$array2 = $_POST['dna'];
		$array2=explode(",",$array2);
		$arrayMatriz = array();
		for($i=0; $i < sizeof($array2); $i++) 
		{
			$fila = str_split($array2[$i]);
			array_push($arrayMatriz, $fila);
		}
		for($p=0;$p < sizeof($arrayCaracteres); $p++){
			$palabra_a_buscar = $arrayCaracteres[$p].$arrayCaracteres[$p].$arrayCaracteres[$p].$arrayCaracteres[$p];
			echo "palabra:".$palabra_a_buscar."<br>";
			if (strlen($palabra_a_buscar) > 0) 
			{
				for ($i=0; $i < sizeof($arrayMatriz); $i++) 
				{
					for ($j=0; $j < sizeof($arrayMatriz[$i]); $j++)
					{
						if ($arrayMatriz[$i][$j] === $palabra_a_buscar[0])
						{
							recursividad($i, $j, 0, $arrayMatriz, $palabra_a_buscar);
						}
					}
				}
			}
		}		
	}
	function recursividad($indice_i, $indice_j, $posicion, $array, $palabra_a_buscar) 
	{
			$posicion = $posicion+1;
			for ($i=$indice_i-1; $i < $indice_i+2; $i++) 
			{
				for ($j=$indice_j-1; $j < $indice_j+2; $j++) 
				{
					if (($i !== $indice_i) || ($j !== $indice_j)) 
					{
						if ($array[$i][$j] === $palabra_a_buscar[$posicion]) 
						{
							if ($posicion < strlen($palabra_a_buscar)) 
							{
								recursividad($i, $j, $posicion, $array, $palabra_a_buscar);
							} 
							else 
							{
								echo "La palabra existe";
							}
						}
					}
				}
			}
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
