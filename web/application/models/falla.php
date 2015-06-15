<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Falla
	{
		var $id;
		var $latitud;
		var $longitud;
		var $criticidad;
		var $direccion;
		var $tipoMaterial;
		var $tipoFalla;
		var $tipoReparacion;
		var $influencia;
		var $factorArea;
		
		function __construct()
		{
			
		}

		private function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->latitud = $datos->latitud;
			$this->longitud = $datos->longitud;
			$this->criticidad = Criticidad::getInstancia($datos->idCriticidad);
			$this->direccion = Direccion::getInstancia($datos->idDireccion);
			$this->tipoMaterial = TipoMaterial::getInstancia($datos->idTipoMaterial);
			$this->tipoFalla = TipoFalla::getInstancia($datos->idTipoFalla);
			$this->tipoReparacion= TipoReparacion::getInstancia($datos->idTipoReparacion);
		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$falla = new Falla();
			$datos = $CI->FallaModelo->get($id[0]);
			$falla->inicializar($datos);
			return $falla;
		}

		public function save()
		{
			return 1;
			// $CI = &get_instance();
			// return $CI->FallaModelo->save($this);
		}

		/*
		$.post('crear/Falla', 
		{"clase": "Falla",
		"datos": JSON.stringify(
		  { "falla": {"latitud": 12.2, "longitud": 54.2, "influencia":2, "factorArea": .2},
		   "observacion": {"comentario": "comentario falla", "nombreObservador": "Pepe", "emailObservador": "pepe@pepe.com"},
		   "tipoFalla": {"id": 1},
		   "criticidad": {"id": 1},
		   "multimedias": {},
		   "direccion": {"altura": 150,"callePrincipal": "calleP", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
		  })
		})
		*/
		static public function crear($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger($datos);
			$falla = new Falla();
			$falla->latitud = $datos->falla->latitud;
			$falla->longitud = $datos->falla->longitud;
			$falla->influencia = $datos->falla->influencia;
			$falla->factorArea = $datos->falla->factorArea;
			// TipoFalla viene con id. getInstancia
			$falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla->id);
			// TipoMaterial viene con id. getInstancia
			$falla->tipoMaterial = $falla->tipoFalla->getMaterial();
			// Criticidad viene con id. getInstancia
			$falla->criticidad = Criticidad::getInstancia($datos->criticidad->id);
			$falla->id = $falla->save();
			$falla->observaciones = array();
			$observacion = new Observacion($datos->observacion);
			$observacion->falla = $falla->id;
			// $observacion->id = $observacion->save();
			array_push($falla->observaciones, $observacion);
			$falla->direccion = $falla->insertarDireccion($datos->direccion);
			// $falla->cargar('Multimedia', $datos->multimedias);
			$falla->crearEstado();
			return $falla;
		}

		public function insertarDireccion($datosDireccion)
		{
			// Si no existe se crea la calle
			$datosDireccion->callePrincipal = Calle::buscarCalle($datosDireccion->callePrincipal);
			$datosDireccion->calleSecundariaA = Calle::buscarCalle($datosDireccion->calleSecundariaA);
			$datosDireccion->calleSecundariaB = Calle::buscarCalle($datosDireccion->calleSecundariaB);
			$direccion = new Direccion($datosDireccion);
			$direccion->id = $direccion->save();
			return $direccion;
		}

		public function crearEstado()
		{
			$CI = &get_instance();
			/* Crear estado Informado */
			$estado = new Estado();
			$estado->tipoEstado = TipoEstado::getTipoEstado('Informado');
			$estado->falla = $this->id;
			$CI->utiles->debugger($estado);
		}

		static public function datosCrearValidos($datos)
		{
			/* Se arman los valores requerido y su tipo */
			$datos_validar_falla = array(
				'falla' => array(
					'latitud' => array('double', '\w'),
					'longitud' => array('double', '\w'),
					'influencia' => array('integer', '\w'),
					'factorArea' => array('double', '\w')
					),
				'observacion' => array(
					'comentario' => array('string', '\w'),
					'nombreObservador' => array('string', '\w'),
					'emailObservador' => array('string', '\w')
					),
				'tipoFalla' => array('id' => array('integer', '\w')),
				'criticidad' => array('id' => array('integer', '\w')),
				// 'multimedias' => array('nombre' => array('string', '\w'), 'costo' => array('double', '\w'), 'descripcion' => array('string', '\w')),
				'direccion' => array(
					'altura' => array('integer', '\w'),
					'callePrincipal' => array('string', '\w'),
					'calleSecundariaA' => array('string', '\w'),
					'calleSecundariaB' => array('string', '\w')
					)
			);
			foreach ($datos_validar_falla as $clave => $valor)
			{
				if (!is_array($datos->$clave)) {
					foreach ($valor as $key => $value)
					{
						if (!property_exists($datos->$clave, $key) || !isset($datos->$clave->$key) || (gettype($datos->$clave->$key) != $value[0]))
						{
							return FALSE;
						}
					}
				}else{
					foreach($datos->$clave as $c => $v)
					{
						foreach ($valor as $key => $value)
						{
							if (!property_exists($v, $key) || !isset($v->$key) || (gettype($v->$key) != $value[0]))
							{
								return FALSE;
							}
						}
					}
				}
			}
			return TRUE;
		}

		public function obtenerImagenes()
		{
			# code...
		}

		// Metodo llamado por el formulario de twitter para obtener los comentarios de un bache.
		public function obtenerObservacionesTw($hashtag)
		{
			# code...
		}

	}
 ?>