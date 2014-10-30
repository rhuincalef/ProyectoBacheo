<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class Estado{
			
			var $falla;
			var $fecha;			
			var $usuario;
			var $tipoEstado;
			var $monto;
			var $fechaFinReparacion;
			
			function __construct(){			
				
			}


			private function inicializar($datos){
				$this->falla = Falla::getInstancia($datos->idFalla);;
				$this->fecha = $datos->fecha;
				$this->usuario = $datos->idUsuario;
				$this->tipoEstado = TipoEstado::getInstancia($datos->idTipoEstado);
				$this->monto = $datos->monto;
				$this->fechaFinReparacion = $datos->fechaFinReparacion;
			}

			static public function getInstancia($datos){
				$estado = new Estado();
				$estado->inicializar($datos);
				return $estado;
			}

			static public function getAll($idFalla){
				$CI = &get_instance();
				$estados = array();
				$datos = $CI->EstadoModelo->getEstados($idFalla[0]);
				$estados = array_map(function($obj){ return Estado::getInstancia($obj); },$datos);
				return $estados;
			}

			static public function getEstadoActual($idFalla){
				$CI = &get_instance();
				$datos = $CI->EstadoModelo->getUltimoEstado($idFalla);
				$estado = Estado::getInstancia($datos);
				return $estado;
			}

		}	

?>