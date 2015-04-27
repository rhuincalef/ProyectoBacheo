<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoReparacion{
			
			var $id;
			var $nombre;
			var $descripcion;
			var $costo;
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->id = $datos->id;
				$this->nombre = $datos->nombre;
				$this->descripcion = $datos->descripcion;
				$this->costo = $datos->costo;

			}

			static public function getInstancia($id)
			{

				$CI = &get_instance();
				$tipoReparacion = new TipoReparacion();
				$datos = $CI->TipoReparacionModelo->get($id[0]);
				$tipoReparacion->inicializar($datos);		
				return $tipoReparacion;

			}

		}
	

 ?>