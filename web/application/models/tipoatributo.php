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
			// $this->falla = $datos->falla;
			$this->unidadMedida = $datos->unidadMedida;
		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$datos = $CI->TipoAtributoModelo->get($id);
			$tipoAtributo = new TipoAtributo();
			$tipoAtributo->inicializar($datos);
			return $tipoAtributo;
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

		public function getAtributosPorTipoFalla($idTipoFalla)
		{
			$CI = &get_instance();
			$arrayTiposAtributosId = $CI->TipoAtributoModelo->getAtributosPorTipoFalla($idTipoFalla);
			$arrayTiposAtributos = array();
			foreach ($arrayTiposAtributosId as $key => $value) {
				// $criticidad = self::get($value->idCriticidad);
				array_push($arrayTiposAtributos, $value->id);
			}
			return $arrayTiposAtributos;
		}

	}
 ?>