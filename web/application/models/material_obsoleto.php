<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Material{
			
			var $id;
			var $tipoMaterial;
			var $tipoRotura;
			var $numeroBaldosa;
 
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->id = $datos->id;
				$this->tipoMaterial = TipoMaterial::getInstancia($datos->idTipoMaterial); 
				$this->tipoRotura = TipoRotura::getInstancia($datos->idTipoRotura);
				$this->numeroBaldosa = $datos->numeroBaldosa;
				
				
			}

			static public function getInstancia($id)
			{

				$CI = &get_instance();
				$material = new Material();
				$datos = $CI->MaterialModelo->get($id[0]);
				$material->inicializar($datos);		
				return $material;

			}

		}
	

 ?>