<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Criticidad{
			
			var $id;
			var $nombre;
			var $descripcion;
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->id = $datos->id;		
				$this->nombre = $datos->nombre;
				$this->descripcion = $datos->descripcion;
			}

			static public function getInstancia($id)
			{

				$CI = &get_instance();
				$criticidad = new Criticidad();
				$datos = $CI->CriticidadModelo->get($id);
				$criticidad->inicializar($datos);		
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


			
    		public function toJson() {
        		return ['id'=> $this->id,'nombre' => $this->nombre,'descripcion' => $this->descripcion];
    		}


		}	

	

 ?>