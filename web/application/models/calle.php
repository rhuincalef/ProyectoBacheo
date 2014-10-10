<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Calle{
			
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
				
				$calle = new Calle();
				try {
					$datos = $CI->CalleModelo->get($id);
					$calle->inicializar($datos);		
				}	
				catch (MY_BdExcepcion $e) {
    				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
    			}
				return $calle;

			}

		}	

?>