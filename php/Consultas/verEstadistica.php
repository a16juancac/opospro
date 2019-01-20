<?php 
session_start();
require_once('../Persona/Persona.php');
require_once('../Persona/Usuario/Usuario.php');
require_once('../Conexion/Config.php');
require_once('../Conexion/Conexion.php');
require_once('../Clases/Pregunta.php');


$json = file_get_contents('php://input');

$objt = json_decode($json);
//var_dump($objt);

$estadistica= array();

$id_usuario = $objt->id;



	$veritoken = array();
//Recogemos el token que enviamos por la url
if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{50}$/i', $_GET["token"])) {
	//verificamos que el token exista
	$veritoken = Usuario::verificarToken($_GET["token"]);

	//Si existe enviamos los datos
	if($veritoken){


			$estadistica= Pregunta::verEstadistica($id_usuario);


			//Cambiar el formato a la fecha
			for($i=0; $i<count($estadistica); $i++){


				
			$timestamp = strtotime($estadistica[$i]['fecha']);
			$dt = new DateTime();
			$dt->setTimestamp($timestamp);

			$fecha= $dt->format('d/m/Y');

			$estadistica[$i]['fecha']=$fecha;
			}


			echo json_encode($estadistica);

		}
	}
 ?>