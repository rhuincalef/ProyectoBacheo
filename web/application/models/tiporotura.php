<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoRotura{
			
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
				$tipoRotura = new TipoRotura();
				$datos = $CI->TipoRoturaModelo->get($id);
				$tipoRotura->inicializar($datos);		
				return $tipoRotura;

			}


			static public function getTiposRotura(){
				$CI = &get_instance();
				$tiposRotura= array();
				try {
					$datos = $CI->TipoRoturaModelo->getTiposRotura();
	    			foreach ($datos as $row) {
	    				$tipoRotura = new TipoRotura();
	    				$tipoRotura->inicializar($row);
	    				array_push($tiposRotura, $tipoRotura);		
	    			}
				}	
				catch (MY_BdExcepcion $e) {
    				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
    			}
    			return $tiposRotura;
			}


		}	

	

 ?>