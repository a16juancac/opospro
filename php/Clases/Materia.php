<?php 



class Materia implements JsonSerializable{

	private $id;
	private $nombre;
	

	function __construct($id, $nombre){

		$this->id = $id;
		$this->nombre = $nombre;
	
	}

	function jsonSerialize(){


		return array(
						"id"			=> $this->id,
						"nombre" 		=> $this->nombre
					
		);
}
	public function mostrarMaterias(){

		$resultado = array();
		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);
		$sql= 'SELECT 	*
	  				FROM materias';
	  	

		

			$resultado = $conecta->consultaPreparada($sql);

		
			return $resultado;


	}

//Obtener el nombre d ela materia por el id
	public function materiaxId($id=''){

		$resultado = array();
		$result = array();
		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);
		$sql= 'SELECT 	nombre
	  				FROM materias';
	  	$sql1= ' WHERE id=:id';
	  	$conecta->abrirConexion();
		$valor= array(":id"=>$id);
		
		if(empty($id)){


			$result['nombre'] = 'Todos';


		}

		else{
				$resultado = $conecta->consultaPreparada($sql . $sql1, $valor);
				$result = $resultado[0];
		}

		$conecta->cerrarConexion();
			
			
			return $result;

	}




}


		

 ?>