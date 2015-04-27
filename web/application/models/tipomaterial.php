<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoMaterial{
			
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
				$tipoMaterial = new TipoMaterial();
				$datos = $CI->TipoMaterialModelo->get($id);
				$tipoMaterial->inicializar($datos);		
				return $tipoMaterial;
			}

			static public function getTiposMaterial(){
				$CI = &get_instance();
				$tiposMaterial = array();
				$datos = $CI->TipoMaterialModelo->getTiposMaterial();
    			foreach ($datos as $row) {
    				$tipoMaterial = new TipoMaterial();
    				$tipoMaterial->inicializar($row);
    				array_push($tiposMaterial, $tipoMaterial);		
    			}
				
    			return $tiposMaterial;
			}



		}	
 ?>