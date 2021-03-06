<?php

class findMutants{
	private $conn;
	private $table_name = "adn";
	public $adn;
	public $palabra_a_buscar;
	public $coincidencias;
	public function __construct($db)
	{
	   $this->conn = $db;
	}

	function esMutante()
	{
		$arrayCaracteres = array("A","T","G","C");
		//$array2 = $_POST['dna'];
		$array2 = $this->adn;
		$array2=explode(",",$array2);
		$arrayMatriz = array();
		$coincidencias = 0;
		$encontradas = 0;
		for($i=0; $i < sizeof($array2); $i++) 
		{
			$fila = str_split($array2[$i]);
			array_push($arrayMatriz, $fila);
		}
		for($p=0;$p < sizeof($arrayCaracteres); $p++){
			$palabra_a_buscar = $arrayCaracteres[$p].$arrayCaracteres[$p].$arrayCaracteres[$p].$arrayCaracteres[$p];
			//echo "palabra:".$palabra_a_buscar."<br>";
			if (strlen($palabra_a_buscar) > 0) 
			{
				for ($i=0; $i < sizeof($arrayMatriz); $i++) 
				{
					for ($j=0; $j < sizeof($arrayMatriz[$i]); $j++)
					{
						if ($arrayMatriz[$i][$j] === $palabra_a_buscar[0])
						{
							$this->recursividad($i, $j, 0, $arrayMatriz, $palabra_a_buscar);
						}
					}
				}
			}
			if ($coincidencias = 4) {
			$encontradas = $encontradas +1;
			}
		}
		if ($encontradas >= 3) {			
			$mutante = true;
			$this->guardarCadena($this->adn,$mutante);
			return 1;
		}
		else
		{
			$mutante = false;
			this->guardarCadena($this->adn,$mutante);
			return 0;
		}

	}
	function recursividad($indice_i, $indice_j, $posicion, $array, $palabra_a_buscar) 
	{
				$posicion = $posicion+1;
				if($indice_i == 0 )
				{
					$indice_i = 1;
				}
				if ($indice_j == 0) 
				{
					$indice_i = 1;
				}
				for ($i=$indice_i-1; $i < $indice_i+2; $i++) 
				{
					for ($j=$indice_j-1; $j < $indice_j+2; $j++) 
					{
						if (($i !== $indice_i) || ($j !== $indice_j)) 
						{
							if ($array[$i][$j] === $palabra_a_buscar[$posicion]) 
							{
								$coincidencias = $coincidencias + 1;
								if ($posicion < strlen($palabra_a_buscar)) 
								{
									$this->recursividad($i, $j, $posicion, $array, $palabra_a_buscar);
								} 
								else 
								{
									break;
								}
							}
						}
					}
				}
	}

	function guardarCadena($adn,$mutante)
	{		
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
