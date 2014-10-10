<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Bache{
			
			var $id;
			var $latitud;
			var $longitud;
			var $ancho;
			var $largo;
			var $profundidad;

			var $criticidad;
			var $direccion;
			var $material;
			var $tipoObstruccion;
			
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->id = $datos->id;
				$this->latitud = $datos->latitud;
				$this->longitud = $datos->longitud;
				$this->ancho = $datos->ancho;
				$this->largo = $datos->largo;
				$this->profundidad = $datos->profundidad;
				$this->criticidad = Criticidad::getInstancia($datos->idCriticidad);
				$this->direccion = Direccion::getInstancia($datos->idDireccion);
				// $this->calleSecundariaA = Material::getInstancia($datos->idCalleSecundariaA);
			}

			static public function getInstancia($id)
			{

				$CI = &get_instance();
				
				$bache = new Bache();
				$datos = $CI->BacheModelo->get($id);
				$bache->inicializar($datos);		
				return $bache;

			}

		}
	

 ?>