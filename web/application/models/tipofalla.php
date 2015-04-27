<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoFalla{
			
			var $id;
			var $nombre;
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->id = $datos->id;		
				$this->nombre = $datos->nombre;
				
			}

			static public function getInstancia($id)
			{

				$CI = &get_instance();
				$tipoFalla = new TipoFalla();
				$datos = $CI->TipoFallaModelo->get($id);
				$tipoFalla->inicializar($datos);		
				return $tipoFalla;

			}


			static public function getTiposFalla(){
				$CI = &get_instance();
				$tiposRotura= array();
				try {
					$datos = $CI->TipoFallaModelo->getTiposFalla();
	    			foreach ($datos as $row) {
	    				$tipoFalla = new TipoFalla();
	    				$tipoFalla->inicializar($row);
	    				array_push($tiposRotura, $tipoFalla);		
	    			}
				}	
				catch (MY_BdExcepcion $e) {
    				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
    			}
    			return $tiposRotura;
			}


		}	

	

 ?>