<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Direccion
	{
		
		var $id;
		var $callePrincipal;
		var $altura;
		var $calleSecundariaA;
		var $calleSecundariaB;
		
		
		function __construct()
		{
			switch (count(func_get_args()))
			{
				case 1:
					return call_user_func_array(array($this,'constructor'), func_get_args());
					break;
				default:
					break;
			}
		}

		public function constructor($datos)
		{
			$this->altura = $datos->altura;
			$this->callePrincipal = $datos->callePrincipal;
			$this->calleSecundariaA = $datos->calleSecundariaA;
			$this->calleSecundariaB = $datos->calleSecundariaB;
		}

		private function inicializar($datos){
			$this->id = $datos->id;
			$this->altura = $datos->altura;
			$this->callePrincipal = Calle::getInstancia($datos->idCallePrincipal);
			$this->calleSecundariaA = Calle::getInstancia($datos->idCalleSecundariaA);
			$this->calleSecundariaB = Calle::getInstancia($datos->idCalleSecundariaB);
		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$direccion = new Direccion();
			$datos = $CI->DireccionModelo->get($id);
			$direccion->inicializar($datos);
			return $direccion;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->DireccionModelo->save($this);
		}

	}
 ?>