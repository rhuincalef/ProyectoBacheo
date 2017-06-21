<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class FallaMultimedia
{
	
	var $idFalla;
	var $idMultimedia;

	function __construct()
	{
		
	}

	// Retorna una nueva instancia siempre de una fallaMultiemdia
	static public function getInstancia($datos)
	{
		$CI = &get_instance();
		$fallaMultimedia = new FallaMultimedia();
		$fallaMultimedia->idFalla = $datos->idFalla;
		$fallaMultimedia->idMultimedia = $datos->idMultimedia;
		return $fallaMultimedia;
	}

	public function save()
	{
		$CI = &get_instance();
		log_message('debug', 'En FallaMultimedia.save()...');
		log_message('debug', 'tipo de fallaMultimedia: '.gettype($this));
		log_message('debug', 'tipo de FallaMultimediaModelo: '.gettype($CI->FallaMultimediaModelo));
		return $CI->FallaMultimediaModelo->save($this);
	}

	static public function getAll($idFalla)
	{
		$CI = &get_instance();
		$multimedias = array();
		$datos = $CI->FallaMultimediaModelo->getAll($idFalla);
		$multimedias = array_map(function($obj){ return self::getInstancia($obj); },$datos);
		return $multimedias;
	}

}
