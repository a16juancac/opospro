<?php 
session_start();
require_once('../Persona/Persona.php');
require_once('../Persona/Usuario/Usuario.php');
require_once('../Conexion/Config.php');
require_once('../Conexion/Conexion.php');
require_once('../Clases/Materia.php');


$veritoken = array();
//Recogemos el token que enviamos por la url
if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{50}$/i', $_GET["token"])) {
	//verificamos que el token exista
	$veritoken = Usuario::verificarToken($_GET["token"]);

	//Si existe enviamos los datos
	if($veritoken){

			echo json_encode(Materia::mostrarMaterias());
	}
}



?>