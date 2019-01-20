<?php 

session_start();
require_once('../Persona/Persona.php');
require_once('../Persona/Usuario/Usuario.php');
require_once('../Conexion/Config.php');
require_once('../Conexion/Conexion.php');




$json = file_get_contents('php://input');
$objt = json_decode($json);


if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{50}$/i', $_GET["token"])) {


	$veritoken = Usuario::verificarToken($_GET["token"]);

	//Si existe enviamos los datos
	if($veritoken){

		session_unset();
		session_destroy();
		$_SESSION=array();
		Usuario::quitarToken($_GET["token"]);

	}
}




echo json_encode(array('respuesta'=>false));

 ?>