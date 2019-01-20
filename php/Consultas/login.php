<?php 


require_once('../Persona/Persona.php');
require_once('../Persona/Usuario/Usuario.php');
require_once('../Conexion/Conexion.php');
require_once('../Conexion/Config.php');


$json = file_get_contents('php://input');

$objt = json_decode($json);

$login = htmlentities(addslashes($objt->usu));
$password = htmlentities(addslashes($objt->pass));

$resultado = array();
$usuario = array();
	$resultado = Usuario::verificarUsuario($login);
				if(isset($resultado)){

					if(password_verify($password, $resultado[0]['password']))
					{ 
						//Añadimos el token
						$token = Usuario::generarToken();
						Usuario::insertarToken($resultado[0]['id'], $token);

					session_start();

					$_SESSION["id"] = $resultado[0]['id'];
					$_SESSION["nombre"] = $resultado[0]['nombre'];
					$_SESSION["email"] = $resultado[0]['email'];
					$_SESSION["tipo"]= $resultado[0]['tipo'];
					$_SESSION["fecha_sesion"] = $resultado[0]['fecha_sesion'];



					
					if($resultado[0]['tipo'] == '1'){


						$usuario = new Usuario      ($resultado[0]['id'],
													 $resultado[0]['nombre'],
													 $resultado[0]['apellido1'],
													 $resultado[0]['apellido2'],
													 $resultado[0]['NIF'],
													 $resultado[0]['email'],
													 $resultado[0]['telefono'],
													 $resultado[0]['direccion'],
													 $resultado[0]['localidad'],
													 $resultado[0]['provincia'],
													 'ok',
													 $resultado[0]['tipo'],
													 $resultado[0]['fecha_sesion'],
													 $token);

					}
				

					$usuario->actualizarFechaSesion($_SESSION["id"]);


				}

				 else{

						$usuario = false;
				 }

				}


				else{

					$usuario=false;
				}

			


			
			 echo json_encode($usuario);
			

 ?> 
