<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Multimedia{
			
			var $falla;
			var $nombreArchivo;
	
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->falla = Falla::getInstacia($datos->idFalla);;
				$this->nombreArchivo = $datos->nombreArchivo;
			}

			static public function getInstacia($datos){
				$multimedia = new Multimedia();
				$multimedia->inicializar($datos);
				return $multimedia;
			}

			static public function getAll($idFalla)
			{

				$CI = &get_instance();
				$multimedias = array();
				$datos = $CI->MultimediaModelo->getAll($idFalla[0]);
				$multimedias = array_map(function($obj){ return Multimedia::getInstacia($obj); },$datos);
				return $multimedias;
			}

		}	

?>