<?php 

abstract class Persona{
	protected $id;
	protected $nombre;
	protected $apellido1;
	protected $apellido2;
	protected $NIF;
	protected $email;
	protected $telefono;
	protected $direccion;
	protected $localidad;
	protected $provincia;



	function __construct($id, $nombre, $apellido1, $apellido2, $NIF, $email, $telefono, $direccion, $localidad, $provincia){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->apellido1 = $apellido1;
		$this->apellido2 = $apellido2;
		$this->NIF = $NIF;
		$this->email = $email;
		$this->telefono = $telefono;
		$this->direccion = $direccion;
		$this->localidad = $localidad;
		$this->provincia = $provincia;
	}



	function __get($atributo) {
	if (property_exists(__CLASS__, $atributo)) {
	return $this->$atributo;
	}
	return null;
	}


	function __set($atributo, $valor) {
	if (property_exists(__CLASS__, $atributo)) {
		$this->$atributo = $valor;
		} else { echo "No existe el atributo $atributo."; }
	}

}

 ?>