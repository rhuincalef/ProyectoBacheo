<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoEstado{
			
			var $id;
			var $nombre;
			
			function __construct(){			
				
			}

			private function inicializar($datos){
				$this->id = $datos->id;		
				$this->nombre= $datos->nombre;
			}

			static public function getInstancia($id){
				$CI = &get_instance();
				$tipoEstado = new TipoEstado();
				$datos = $CI->TipoEstadoModelo->get($id);
				$tipoEstado->inicializar($datos);		
				return $tipoEstado;
			}

			static public function getTiposEstado(){
				$CI = &get_instance();
				$tiposEstado = array();
				$datos = $CI->TipoEstadoModelo->getTiposEstado();
    			foreach ($datos as $row) {
    				$tipoEstado = new TipoEstado();
    				$tipoEstado->inicializar($row);
    				array_push($tiposEstado, $tipoEstado);		
    			}
				
    			return $tiposEstado;
			}



		}	
 ?>