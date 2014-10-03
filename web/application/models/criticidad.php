<?php 
		class Criticidad{
			
			var $id;
			var $nombreFormal;
			var $nombreInformal;
			var $descripcion;
			


			
			
			function __construct(){			
				
			}

			private function inicializar($datos){
				$this->id = $datos->id;		
				$this->nombreInformal = $datos->nombreInformal;
				$this->nombreFormal = $datos->nombreFormal;
				$this->descripcion = $datos->descripcion;
			}

			static public function getInstancia($id)
			{

				$CI = &get_instance();
				
				$criticidad = new Criticidad();
				try {
					$datos = $CI->CriticidadModelo->get($id);
					$criticidad->inicializar($datos);		
				}	
				catch (MY_BdExcepcion $e) {
    				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
    			}
				
				return $criticidad;

			}


			static public function getCriticidades(){
				$CI = &get_instance();
				$criticidades = array();
				try {
					$datos = $CI->CriticidadModelo->getCriticidades();
	    			foreach ($datos as $row) {
	    				$criticidad = new Criticidad();
	    				$criticidad->inicializar($row);
	    				array_push($criticidades, $criticidad);		
	    			}
				}	
				catch (MY_BdExcepcion $e) {
    				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
    			}
    			return $criticidades;
			}




		}	

	

 ?>