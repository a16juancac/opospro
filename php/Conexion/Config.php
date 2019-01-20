<?php 
session_start();

$datos = parse_ini_file('datos.txt', true);


if(isset($_SESSION['tipo'])){
	$localhost = $datos['host']['host'];
	$bdnombre = $datos['bd']['nombre'];
	$charset = $datos['charset']['charset'];
	$usuario = $datos[$_SESSION['tipo']]['usuario'];
	$contra = $datos[$_SESSION['tipo']]['password'];

}else{

	$localhost = $datos['host']['host'];
	$bdnombre = $datos['bd']['nombre'];
	$charset = $datos['charset']['charset'];
	$usuario = $datos[4]['usuario'];
	$contra = $datos[4]['password'];

}

define('HOST', $localhost);
define('USUARIO', $usuario);
define('CONTRA', $contra);
define('BDNOMBRE', $bdnombre);
define('CHARSET',$charset);

 ?>
