<?php 
session_start();
require_once('../Conexion/Config.php');
require_once('../Conexion/Conexion.php');
require_once('../Clases/Materia.php');


$json = file_get_contents('php://input');

$objt = json_decode($json);

echo json_encode(Materia::materiaxId($objt->id));


 ?>