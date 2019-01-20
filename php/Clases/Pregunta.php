<?php 


// include '../Conexion/Config.php';
// include '../Conexion/Conexion.php';

class Pregunta implements JsonSerializable{



	private $id;
	private $pregunta;
	private $correcta;
	private $materia;
	private $respuestas;
	private $activado;
	private $articulo;
	private $nombre_materia;




	function __construct($id, $pregunta, $correcta, $materia, $activado, $respuestas, $articulo, $nombre_materia){

		$this->id = $id;
		$this->pregunta = $pregunta;
		$this->correcta = $correcta;
		$this->materia = $materia;
		$this->activado = $activado;
		$this->respuestas = $respuestas;
		$this->articulo = $articulo;
		$this->nombre_materia = $nombre_materia;
		
	}


	function jsonSerialize(){


		return array(
						"id"			=> $this->id,
						"pregunta" 		=> $this->pregunta,
						"correcta" 		=> $this->correcta,
						"materia"		=> $this->materia,
						"activado"		=> $this->activado,
						"respuestas"	=> $this->respuestas,
						"articulo"		=> $this->articulo,
						"nombre_materia"=> $this->nombre_materia

						

		);


	}

//Funcion para mostrar las preguntas atendiendo al tipo de materia
	public function mostrarPreguntas($materia=''){
		// El numero de pregunta a mostrar en el tipo examen
		$numExamen = 100;
		$resultado = array();
		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);
		$sql= 'SELECT 	preguntas.id, preguntas.pregunta, preguntas.materia, materias.nombre as nombre_materia
	  				FROM preguntas INNER JOIN materias ON preguntas.materia= materias.id';
	  	$sql1= ' WHERE preguntas.materia=:materia';			
		$conecta->abrirConexion();
		$valor= array(":materia"=>$materia);

		if(empty($materia)){


			$resultado = $conecta->consultaPreparada($sql);


		}
		else{

			$resultado = $conecta->consultaPreparada($sql . $sql1, $valor);
		}


		$conecta->cerrarConexion();


		$pregunta = array();

		for ($i=0; $i < count($resultado); $i++) { 
			$pregunta[$i] = new Pregunta(
											$resultado[$i]['id'],
											$resultado[$i]['pregunta'],
											null,
											$resultado[$i]['materia'],
											false,
											Pregunta::respuestasAleatorias($resultado[$i]['id']),
											null,
											$resultado[$i]['nombre_materia']
											 );
		}
		

		if(empty($materia) && count($resultado) > $numExamen ){

			return Pregunta::preguntasAleatorias(count($pregunta), $pregunta, $numExamen);
		}
		else{

			return Pregunta::preguntasAleatorias(count($pregunta), $pregunta, count($pregunta));
		}
		


	}




	//Funcion que trae la respuesta correcta
	public function getCorrecta($id){

		$resultado = array();
		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);
		$sql= 'SELECT 	correcta
	  				FROM preguntas WHERE id=:id';

		$conecta->abrirConexion();
		$valor= array(":id"=>$id);
		$resultado = $conecta->consultaPreparada($sql, $valor);
		$conecta->cerrarConexion();

		return $resultado;


		}


//Función para obtener las respuestas de una pregunta 
	private function getRespuestas($idPregunta){

		$resultado = array();
		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);
		$sql= 'SELECT 	id, respuesta, id_pregunta
	  				FROM respuestas WHERE id_pregunta=:id';


		$conecta->abrirConexion();
		$valor= array(":id"=>$idPregunta);
		$resultado = $conecta->consultaPreparada($sql, $valor);
		$conecta->cerrarConexion();

		return $resultado;

	}

	private function generarAleatorios($cantidad=4){

		$i=0;
		$aleatorios = array();

		while ( $i< $cantidad) {

			$num_ale= rand(0,$cantidad-1);
			if(!in_array($num_ale, $aleatorios)){

				array_push($aleatorios, $num_ale);

				$i++;
			}
		}
			
		return $aleatorios;
	}

	private function preguntasAleatorias($cantidad, $arraypregu, $cantPreguntas){

		$arrayfinal = array();

		$arrayale = Pregunta::generarAleatorios($cantidad);

		for ($i=0; $i <$cantPreguntas; $i++) { 
			array_push($arrayfinal, $arraypregu[$arrayale[$i]]);
		}

		 return $arrayfinal;

	}

	private function colocarAbcd ($array){

		$pregu = array('a) ', 'b) ', 'c) ', 'd) ');

		for ($i=0; $i < count($array); $i++	) { 
			$array[$i]['respuesta'] = $pregu[$i] . $array[$i]['respuesta']; 
		}


		return $array;
	}

	private function respuestasAleatorias($idPregunta){
		$respuestas = array();
		$arrayale = array();
		$arrayfinal = array();
		
		$respuestas = Pregunta::getRespuestas($idPregunta);

		$arrayale = Pregunta::generarAleatorios();

		for ($i=0; $i <count($respuestas); $i++) { 
			array_push($arrayfinal, $respuestas[$arrayale[$i]]);
		}

		 return Pregunta::colocarAbcd($arrayfinal);
		// return $arrayfinal;
	}

	//Devuelve true si la respuesta es correcta y la solución si es incorrecta


	public function respuestaPregunt($idPregunta, $idRespuesta){
		$resulta = array();
		$resultado = array();
		$resultado1 = array();
		$resultadofinal = array();
		$resultadofinal['respuesta']='Incorrecta';
		$resultadofinal['simbolo']= 'cancel';
		$flat = false;
		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);
		$sql= 'SELECT 	*
	  				FROM preguntas WHERE id=:id';
	 

		$conecta->abrirConexion();
		$valor= array(":id"=>$idPregunta);


		$resultado = $conecta->consultaPreparada($sql, $valor);
		$resulta = $resultado[0];
		
			if($resulta['correcta']==$idRespuesta){
			
			$flat = true; 
			
			}
		
			if($flat){

				$resultadofinal['respuesta']= 'Correcta';
				$resultadofinal['simbolo']= 'check_circle';

			}
			
				$resultadofinal['correcta']=$resulta['correcta'];
				$resultadofinal['articulo']=$resulta['articulo'];

				
				
			

			
		$conecta->cerrarConexion();

		return $resultadofinal;


	}




	public function calcularNota($correctas, $incorrectas, $total, $tiempo, $id_usuario){

		$notafinal = array();

		$notafinal['puntos'] = $correctas - ($incorrectas * 0.25);
		$notafinal['total'] = $total;
		$notafinal['sin_responder'] = $total - ($correctas + $incorrectas);
		$notafinal['correctas']= $correctas;
		$notafinal['incorrectas'] = $incorrectas;
		$notafinal['tiempo'] = $tiempo;


		return $notafinal;

	}



	public function agregarNota($correctas, $incorrectas, $blanco, $total, $puntos, $tiempo, $id_usuario){

			
		$resultado= array();
		$valor = array(	":id" 				=> null,
						":correctas"		=> $correctas,
						":incorrectas"		=> $incorrectas,
						":blanco"			=> $blanco,
						":total"			=> $total,
						":puntos" 			=> $puntos,
						":tiempo"  			=> $tiempo,
						":id_usuario"		=> $id_usuario
					
					);
		


		$sql = 'INSERT INTO estadistica (id, correctas, incorrectas, blanco, total, puntos, tiempo, fecha, id_usuario) VALUES (:id, :correctas, :incorrectas, :blanco, :total, :puntos, :tiempo, CURRENT_TIMESTAMP, :id_usuario)';

		
	

		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);

		$conecta->abrirConexion();


		$resultado = $conecta->anadirDato($sql, $valor);

		$conecta->cerrarConexion();	

		return 'ok';

	}


	public function verEstadistica($id_usuario){

		$resultado = array();
		$conecta = new Conexion(BDNOMBRE, HOST, USUARIO, CONTRA, CHARSET);
		$sql= 'SELECT 	*
	  				FROM estadistica WHERE id_usuario=:id_usuario ORDER BY id DESC';

		$conecta->abrirConexion();
		$valor= array(":id_usuario"=>$id_usuario);
		$resultado = $conecta->consultaPreparada($sql, $valor);
		$conecta->cerrarConexion();

		return $resultado;
	}

}
	// var_dump(Pregunta::generarAleatorios());
	//var_dump(json_encode(Pregunta::mostrarPreguntas()));


 ?>