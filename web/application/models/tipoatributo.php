<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoAtributo
		{
			
			var $id;
			var $falla;
			var $nombre;
			var $unidadMedida;
			
			function __construct()
			{
				
			}

			private function inicializar($datos)
			{
				$this->id = $datos->id;		
				$this->nombre= $datos->nombre;
				$this->falla = $datos->falla;
				$this->unidadMedida = $datos->unidadMedida;

			}

			static public function getInstancia($id)
			{
				$CI = &get_instance();
				$tipoAtributo = new TipoAtributo();
				$datos = $CI->TipoAtributo->get($id);
				$tipoAtributo->inicializar($datos);		
				return $tipoMaterial;
			}

			public function save()
			{
				$CI = &get_instance();
				return $CI->TipoAtributoModelo->save($this);
			}

			public function crear($datos)
			{
				$CI = &get_instance();
				$CI->utiles->debugger($datos);
				$tipoAtributo = new TipoAtributo();
				$tipoAtributo->nombre= $datos->nombre;
				$tipoAtributo->unidadMedida = $datos->unidadMedida;
				$tipoAtributo->falla = $datos->falla;
				$CI->utiles->debugger($tipoAtributo);
				$tipoAtributo->save();
				return $tipoAtributo;
			}
		}	
 ?>