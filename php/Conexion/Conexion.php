<?php 

// include 'Config.php';

class Conexion{


private $conexionBD;
private $user;
private $host;
private $password;
private $bd;
private $charset;


	function __construct($bd, $host, $user, $password, $charset){
		$this->bd = $bd;
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->charset = $charset;
	}
	
	//Funcion para abrir la conexion
	public function abrirConexion(){
		try {
			$conect = $this->conexionBD = new PDO("mysql:host=" . $this->host . "; dbname=".$this->bd ."; charset=" . $this->charset, $this->user, $this->password);
			
			$conect->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $conect;

		} catch (Exception $e) {
			
			echo 'la línea de error es: ' . $e->getLine() . '<br>';
			die('Error: '. $e->getMessage()) ;
		}

	
	}

	//Funcion para cerrar la conexion
	public function cerrarConexion(){

		return $this->conexionBD = null;
	}
	

	//Funcion con prepare para retornar datos de la BD(SELECT)
	public function consultaPreparada($sentenciaSQL, $valores=''){
			$resulta = array();

			if(empty($valores)){
				$consulta = $this->abrirConexion()->query($sentenciaSQL);
			}

			else{

				$consulta = $this->abrirConexion()->prepare($sentenciaSQL);
		
				$consulta->execute($valores);

			}

		
			while ($registros = $consulta->fetch(PDO::FETCH_ASSOC)){
			//Cada registro se guarda en el array resulta
			array_push($resulta, $registros);	
			
			}

		return $resulta;
	}

	//Funcion con transaccion para consultas multiples para Updates e Inserts

	public function actualizarDatos($sentenciaSQL, $valores){

			$consulta = $this->abrirConexion();


		try{

			$consulta->beginTransaction();

			for($i=0; $i<count($sentenciaSQL); $i++){

				$consult = $consulta->prepare($sentenciaSQL[$i]);
		
				$consult->execute($valores[$i]);
			}
			
			$consulta->commit();

		}
		catch(Exception $e){

			echo $e->getMessage();
			$consulta->rollBack();

		}
	}

	
	public function numFilas($sentenciaSQL){
		$resulta = array();
		$consulta = $this->abrirConexion()->query($sentenciaSQL);

		return $consulta->rowCount();

		}

		//Funcion con transaccion para consultas simple para Updates e Inserts

		function anadirDato($sentenciaSQL, $valores){

			$consulta = $this->abrirConexion();


		try{

			$consulta->beginTransaction();

				$consult = $consulta->prepare($sentenciaSQL);
		
				$consult->execute($valores);

				$consulta->commit();
			}	
			
		catch(Exception $e){

			echo $e->getMessage();
			$consulta->rollBack();

		}
	}

		

}





 ?>