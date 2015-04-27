<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Falla{
			
			var $id;
			var $latitud;
			var $longitud;
			var $criticidad;
			var $direccion;
			var $tipoMaterial;
			var $tipoFalla;
			var $tipoReparacion;
			var $influencia;
			var $factorArea;
			
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->id = $datos->id;
				$this->latitud = $datos->latitud;
				$this->longitud = $datos->longitud;
				$this->criticidad = Criticidad::getInstancia($datos->idCriticidad);
				$this->direccion = Direccion::getInstancia($datos->idDireccion);
				$this->tipoMaterial = TipoMaterial::getInstancia($datos->idTipoMaterial);
				$this->tipoFalla = TipoFalla::getInstancia($datos->idTipoFalla);
				$this->tipoReparacion= TipoReparacion::getInstancia($datos->idTipoReparacion);

			}

			static public function getInstancia($id)
			{

				$CI = &get_instance();
				$falla = new Falla();
				$datos = $CI->FallaModelo->get($id[0]);
				$falla->inicializar($datos);		
				return $falla;

			}

		}
	

 ?>