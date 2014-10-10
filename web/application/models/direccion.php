<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Direccion{
			
			var $id;
			var $callePrincipal;
			var $altura;
			var $calleSecundariaA;
			var $calleSecundariaB;
			
			
			function __construct(){			
				
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

		}
	

 ?>