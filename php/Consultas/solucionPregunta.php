<?php 
session_start();
require_once('../Conexion/Config.php');
require_once('../Conexion/Conexion.php');
require_once('../Clases/Pregunta.php');


$json = file_get_contents('php://input');

$objt = json_decode($json);
//var_dump($objt);

  echo json_encode(Pregunta::respuestaPregunt($objt->idPregunta, $objt->idRespuesta));

// var_dump(json_encode(Pregunta::respuestaPregunta(1,8)));

 ?>