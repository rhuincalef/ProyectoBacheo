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
		var $estados;
		
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
			// return 1;
			$CI = &get_instance();
			return $CI->FallaModelo->save($this);
		}

		/*
		$.post('crear/Falla', 
		{"clase": "Falla",
		"datos": JSON.stringify(
		  { "falla": {"latitud": 12.2, "longitud": 54.2, "influencia":2, "factorArea": .2},
		   "observacion": {"comentario": "comentario falla", "nombreObservador": "Pepe", "emailObservador": "pepe@pepe.com"},
		   "tipoFalla": {"id": 88},
		   "criticidad": {"id": 71},
		   "multimedias": {},
       	   "reparacion": {"id": 42},
		   "direccion": {"altura": 150,"callePrincipal": "calleP", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
		  })
		})
		*/
		static public function crear($datos)
		{
			$CI = &get_instance();
			$falla = new Falla();
			$falla->latitud = $datos->falla->latitud;
			$falla->longitud = $datos->falla->longitud;
			$falla->influencia = $datos->falla->influencia;
			$falla->factorArea = $datos->falla->factorArea;
			// TipoFalla viene con id. getInstancia
			$falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla->id);
			// TipoMaterial se obtiene a traves del Tipo de Falla
			$falla->tipoMaterial = $falla->tipoFalla->getMaterial();
			// TipoReparacion se obtiene a traves del Tipo de Falla
			$falla->tipoReparacion = TipoReparacion::getInstancia($datos->reparacion->id);
			// Criticidad viene con id. getInstancia
			$falla->criticidad = Criticidad::getInstancia($datos->criticidad->id);
			$falla->observaciones = array();
			$observacion = new Observacion($datos->observacion);
			$observacion->falla = $falla->id;
			// $observacion->id = $observacion->save();
			array_push($falla->observaciones, $observacion);
			$falla->direccion = $falla->insertarDireccion($datos->direccion);
			// $falla->cargar('Multimedia', $datos->multimedias);
			$falla->id = $falla->save();
			$falla->crearEstado();
			$CI->utiles->debugger($falla);
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
			/* Crear estado Informado */
			$this->estado = new Informado();
			$this->estado->falla = $this;
			$this->estado->setUsuario();
			$this->estado->id = $this->estado->save();
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
				'multimedias' => array('nombre' => array('string', '\w'), 'costo' => array('double', '\w'), 'descripcion' => array('string', '\w')),
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
						// if (!property_exists($datos->$clave, $key) || !isset($datos->$clave->$key) || (gettype($datos->$clave->$key) != $value[0]))
							if (!property_exists($datos->$clave, $key) || !isset($datos->$clave->$key))
						{
							return FALSE;
						}
					}
				}else{
					foreach($datos->$clave as $c => $v)
					{
						foreach ($valor as $key => $value)
						{
							// if (!property_exists($v, $key) || !isset($v->$key) || (gettype($v->$key) != $value[0]))
							if (!property_exists($v, $key) || !isset($v->$key))
							{
								return FALSE;
							}
						}
					}
				}
			}
			return TRUE;
		}

		public function validarDatos($datos)
		{
			$valor = $datos->clase;
			$CI = &get_instance();
			$CI->utiles->debugger($valor);
			switch ($valor) {
				case 'Falla':
					return self::validarDatosFalla($datos);
					// break;
				case 'FallaAnonima':
					return self::validarDatosFallaAnonima($datos);
					// break;
				default:
					return false;
					// break;
			}
		}

		public function validarDatosFalla($datos)
		{
			return true;
		}

		public function validarDatosFallaAnonima($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("validarDatosFallaAnonima");
			// Creando arbol para validar los datos de FallaAnonima
			$terminal1 = new NumericTerminalExpression("latitud", "double", "true");
			$terminal2 = new NumericTerminalExpression("longitud", "double", "true");
			$noTerminalFalla = new AndExpression(array($terminal1, $terminal2), "falla");

			$terminal1 = new StringTerminalExpression("comentario", "", "true");
			$terminal2 = new StringTerminalExpression("nombreObservador", "", "true");
			$terminal3 = new StringTerminalExpression("emailObservador", "", "true");
			$noTerminalObservacion = new AndExpression(array($terminal1, $terminal2, $terminal3), "observacion");

			$terminal1 = new NumericTerminalExpression("id", "integer", "true");
			$noTerminaTipolFalla = new AndExpression(array($terminal1), "tipoFalla");

			$terminal1 = new NumericTerminalExpression("altura", "integer", "true");
			$terminal2 = new StringTerminalExpression("callePrincipal", "", "true");
			$terminal3 = new StringTerminalExpression("calleSecundariaA", "", "true");
			$terminal4 = new StringTerminalExpression("calleSecundariaB", "", "true");
			$noTerminalDireccion = new AndExpression(array($terminal1, $terminal2, $terminal3, $terminal4), "direccion");

			$validator = new AndExpression(array($noTerminalFalla, $noTerminalObservacion, $noTerminalDireccion, $noTerminaTipolFalla), "datos");
			return $validator->interpret($datos);
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

		public function crearFallaAnonima($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("crearFallaAnonima");
			$CI->utiles->debugger($datos);
			/*
			Primera parte muy parecida a crear
			No se tienen en cuenta
				$falla->influencia = $datos->falla->influencia;
				$falla->factorArea = $datos->falla->factorArea;
			No se carga el tipo de reparacion, la criticidad
			Se crea en el estado Informado
			saveAnonimo()
			asociar FallaEstadoModelo
			*/
			$falla = new Falla();
			$falla->latitud = $datos->falla->latitud;
			$falla->longitud = $datos->falla->longitud;
			$CI->utiles->debugger($datos->tipoFalla->id);
			// TipoFalla viene con id. getInstancia
			$falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla->id);
			// TipoMaterial se obtiene a traves del Tipo de Falla
			$falla->tipoMaterial = $falla->tipoFalla->getMaterial();
			$falla->direccion = $falla->insertarDireccion($datos->direccion);
			$falla->id = $falla->saveAnonimo();
			$falla->estado = new Informado();
			$falla->estado->falla = $falla;
			$falla->estado->id = $falla->estado->save();
			$falla->asociarEstado();
			$CI->utiles->debugger($falla);
		}

		public function saveAnonimo()
		{
			$CI = &get_instance();
			return $CI->FallaModelo->saveAnonimo($this);
		}

		public function asociarEstado()
		{
			$CI = &get_instance();
			return $CI->FallaModelo->asociarEstado($this);
		}

	}
 ?>