<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class TipoMaterialTipoFalla
 {

	function __construct()
	{
		
	}


 	public static function getIdsMaterial($idFalla){
		$CI = &get_instance();
		$idsMaterial = $CI->TipoMaterialTipoFallaModelo->getIdsMaterial($idFalla);
		return $idsMaterial;
 	}
 	
		
}