<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Observacion{
			
			var $falla;
			var $fecha;
			var $comentario;
			var $nombreObservador;
			var $emailObservador;
			
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->falla = Falla::getInstacia($datos->idFalla);
				$this->comentario = $datos->comentario;
				$this->nombreObservador = $datos->nombreObservador;
				$this->emailObservador = $datos->emailObservador;
				$this->fecha = $datos->fecha;
			}

			static public function getInstacia($datos){
				$observacion = new Observacion();
				$observacion->inicializar($datos);
				return $observacion;
			}

			static public function getAll($idFalla)
			{

				$CI = &get_instance();
				$observaciones = array();
				$datos = $CI->ObservacionModelo->getAll($idFalla[0]);
				$observaciones = array_map(function($obj){ return Observacion::getInstacia($obj); },$datos);
				return $observaciones;
			}

		}	

?>