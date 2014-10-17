<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Multimedia{
			
			var $idFalla;
			var $nombre;
			var $tipo;			
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->idFalla = $datos->idFalla;
				$this->nombre = $datos->nombre;
				$this->tipo = $datos->tipo;
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