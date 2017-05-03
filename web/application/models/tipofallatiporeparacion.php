<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class TipoFallaTipoReparacion
 {

	function __construct()
	{
		
	}

 	public static  function getIdsReparacion($idFalla){
		$CI = &get_instance();
		$idsReparaciones = $CI->TipoFallaTipoReparacionModelo->getIdsReparacion($idFalla);
		return $idsReparaciones;
 	}
 	
		
}