<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class TipoMaterial
	{
		
		var $id;
		var $nombre;
		
		function __construct()
		{
			
		}

		private function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->nombre= $datos->nombre;
		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$tipoMaterial = new TipoMaterial();
			$datos = $CI->TipoMaterialModelo->get($id);
			$tipoMaterial->inicializar($datos);
			return $tipoMaterial;
		}

		static public function getAll()
		{
			$CI = &get_instance();
			$tiposMaterial = array();
			try {
				// $datos = $CI->CriticidadModelo->getCriticidades();
				$datos = $CI->TipoMaterialModelo->get_all();
    			foreach ($datos as $row)
    			{
    				$tipoMaterial = new TipoMaterial();
    				$tipoMaterial->inicializar($row);
    				array_push($tiposMaterial, $tipoMaterial);
    			}
			}	
			catch (MY_BdExcepcion $e) {
				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			}
			return $tiposMaterial;
		}

		static public function getTipoMaterial($id)
		{
			$CI = &get_instance();
			$CI->utiles->debugger('pepe');
			$datos = $CI->TipoMaterialModelo->get($id);
			$tipoMaterial = new TipoMaterial();
			$tipoMaterial->inicializar($datos);
			return $tipoMaterial;
		}

		static public function getTipoDeMaterialPorNombre($nombre)
		{
			$CI = &get_instance();
			$datos = $CI->TipoMaterialModelo->getTipoDeMaterialPorNombre($nombre);
			// $datos = TipoMaterialModelo::getTipoDeMaterialPorNombre($nombre);
			$tipoMaterial = new TipoMaterial();
			$tipoMaterial->inicializar($datos);
			return $tipoMaterial;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->TipoMaterialModelo->save($this);
		}

		static public function crear($datos)
		{
			$CI = &get_instance();
			$tipoMaterial = new TipoMaterial();
			$tipoMaterial->nombre = $datos->nombre;
			$tipoMaterial->id = $tipoMaterial->save();
			return $tipoMaterial;
		}

		public function asociar($idTipoFalla)
		{
			$CI = &get_instance();
			$CI->TipoMaterialModelo->asociar($this->id, $idTipoFalla);
		}

		static public function validarDatos($datos)
		{
			$terminal1 = new StringTerminalExpression("nombre", "", "true");
			$noTerminalMaterial = new AndExpression(array($terminal1), "datos");
			return $noTerminalMaterial->interpret($datos);
		}

		static public function getAlly()
		{
			$CI = &get_instance();
			$tiposMaterial = array();
			try {
				$datos = $CI->TipoMaterialModelo->get_all();
    			foreach ($datos as $row)
    			{
    				$tipoMaterial = new TipoMaterial();
    				$tipoMaterial->inicializar($row);
    				$tipoMaterial->fallas = array();
    				$fallas = TipoFalla::getTiposFallaPorMaterial($tipoMaterial->id);
    				array_map(function($falla) use (&$tipoMaterial)
    				{
    					array_push($tipoMaterial->fallas, $falla->id);
    				}, $fallas);
    				array_push($tiposMaterial, $tipoMaterial);
    			}
			}	
			catch (MY_BdExcepcion $e) {
				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			}
			return $tiposMaterial;
		}

	}
 ?>