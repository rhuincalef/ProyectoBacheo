<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoAtributo{
			
			var $id;
			var $fallas;
			var $nombre;
			var $unidadMedida;
			
			function __construct(){			
				
			}

			private function inicializar($datos){
				$this->id = $datos->id;		
				$this->nombre= $datos->nombre;
				$this->falla = $datos->falla;
				$this->unidadMedida = $datos->unidadMedida;

			}

			static public function getInstancia($id){
				$CI = &get_instance();
				$tipoAtributo=new TipoAtributo();
				$datos = $CI->TipoAtributo->get($id);
				$tipoAtributo->inicializar($datos);		
				return $tipoMaterial;
			}


		}	
 ?>