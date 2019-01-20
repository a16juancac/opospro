<?php 


$tiempo = $_SERVER["REQUEST_TIME"];

//Limite sin actividad 10 minutos
$limite = 600;

if(isset($_SESSION['ultima']) && ($tiempo - $_SESSION['ultima']) > $limite){


session_unset();
session_destroy();
$_SESSION=array();

}

$_SESSION['ultima'] = $tiempo;

 ?> 
