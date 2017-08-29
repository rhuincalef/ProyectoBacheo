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

	public static function obtenerMaterialesAsociados($idTipoFalla){
            $CI = &get_instance();
            $materiales =  $CI->TipoMaterialTipoFallaModelo->getMaterialesAsociados($idTipoFalla);
            $colMateriales = array();
            foreach ($materiales as $row) {
                log_message('debug','El material del row es -->');
                log_message('debug',$row->idTipoMaterial);
                $material = TipoMaterial::getInstancia($row->idTipoMaterial);
                array_push($colMateriales, $material);
            }
            log_message('debug','Obtenidos materiales');
            return $colMateriales;
    }
	
}