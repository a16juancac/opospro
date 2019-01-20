<?php 
session_start();
require_once('../Conexion/Config.php');
require_once('../Conexion/Conexion.php');
require_once('../Clases/Pregunta.php');


$json = file_get_contents('php://input');

$objt = json_decode($json);
$notafinal = array();

$id_usuario = $objt->id;

$notafinal = Pregunta::calcularNota($objt->correct, $objt->incorrect, $objt->todo, $objt->time, $objt->id);

$agrega = Pregunta::agregarNota($notafinal['correctas'], $notafinal['incorrectas'], $notafinal['sin_responder'], $notafinal['total'], $notafinal['puntos'], $notafinal['tiempo'], $id_usuario);

echo json_encode($notafinal);
 ?>