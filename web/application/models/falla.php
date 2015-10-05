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
			$CI = &get_instance();
			$this->id = $datos->id;
			$this->latitud = $datos->latitud;
			$this->longitud = $datos->longitud;
			// A partir de confirmado ya se puede consultar
			// $this->criticidad = Criticidad::getInstancia($datos->idCriticidad);
			$this->direccion = Direccion::getInstancia($datos->idDireccion);
			$this->tipoMaterial = TipoMaterial::getInstancia($datos->idTipoMaterial);
			$this->tipoFalla = TipoFalla::getInstancia($datos->idTipoFalla);
			// $this->tipoReparacion= TipoReparacion::getInstancia($datos->idTipoReparacion);
			$this->estado = Estado::getEstadoActual($this->id);
			// $this->estado->falla = $this;
			$CI->utiles->debugger($this);
		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("getInstancia");
			$falla = new Falla();
			$datos = $CI->FallaModelo->get($id);
			$falla->inicializar($datos);
			return $falla;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->FallaModelo->save($this);
		}

		/*
		- Petición para crear una nueva falla en el estado Confirmado.
		$.post('crear/Falla', 
		{"clase": "Falla",
		"datos": JSON.stringify(
		  { "falla": {"latitud": -43.251741078254454, "longitud": -65.32084465026855, "influencia":2, "factorArea": .2},
		   "observacion": {"comentario": "comentario falla", "nombreObservador": "Pepe", "emailObservador": "pepe@pepe.com"},
		   "tipoFalla": {"id": 5},
		   "criticidad": {"id": 9},
       	   "reparacion": {"id": 6},
           "atributos": [{"id": 9, "valor": '5'},{"id": 10,"valor": '4'}],
		   "direccion": {"altura": 50,"callePrincipal": "Edison Norte", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
		  })
		})
		- Petición para crear definitivamente la falla, pasa del estado Informado al Confirmado.
		$.post('crear/Falla', 
		{"clase": "Falla",
		 "datos": JSON.stringify({
		   "falla": {"id": 1, "latitud": 12.2, "longitud": 54.2, "influencia":2, "factorArea": .2},
		   "observacion": {"comentario": "comentario falla", "nombreObservador": "Pepe", "emailObservador": "pepe@pepe.com"},
		   "tipoFalla": {"id": 88},
		   "criticidad": {"id": 71},
       	   "reparacion": {"id": 42},
		   "direccion": {"altura": 150,"callePrincipal": "calleP", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
		  })
		})
		*/
		static public function crear($datos)
		{
			$CI = &get_instance();
			/*
			Si la falla viene con id debe pasar del estado Informado a Confirmado.
			Sino se debe crear la falla directamente en el estado Confirmado.
			*/
			if (!property_exists($datos->falla, 'id'))
			{
				return self::crearFallaEnConfirmado($datos);
			}
			return self::crearFalla($datos);
		}

		public function insertarDireccion($datosDireccion)
		{
			// // TODO: Verificar si existe la direccion con los datos
			// $direccion = new Direccion($datosDireccion);
			// $direccion->id = $direccion->save();
			// return $direccion;
			// Direccion::insertarDireccion -> Si no existe se crea la calle
			return Direccion::insertarDireccion($datosDireccion);
		}

		public function validarDatos($datos)
		{
			$valor = $datos->clase;
			$CI = &get_instance();
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

		/*
		No se tienen en cuenta
			$falla->influencia = $datos->falla->influencia;
			$falla->factorArea = $datos->falla->factorArea;
		No se carga el tipo de reparacion ni la criticidad
		Se crea en el estado Informado
		saveAnonimo()
		asociar FallaEstadoModelo
		*/
		public function crearFallaAnonima($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("crearFallaAnonima");
			
			$falla = new Falla();
			$falla->latitud = $datos->falla->latitud;
			$falla->longitud = $datos->falla->longitud;
			// TipoFalla viene con id. getInstancia
			$falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla->id);
			// TipoMaterial se obtiene a traves del Tipo de Falla
			$falla->tipoMaterial = $falla->tipoFalla->getMaterial();
			$falla->direccion = $falla->insertarDireccion($datos->direccion);
			// A partir de aca cambia
			$falla->id = $falla->saveAnonimo();
			$observacion = new Observacion($datos->observacion);
			$observacion->falla = $falla;
			$observacion->save();
			$falla->estado = new Informado();
			$falla->estado->falla = $falla;
			$falla->estado->id = $falla->estado->save();
			$falla->asociarEstado();
			// TODO: Falta asociar la observacion
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

		/*
		Falla no informada
		Se crea en el estado Confirmado
		save()
		asociar FallaEstadoModelo
		*/
		public function crearFallaEnConfirmado($datos)
		{
			$CI = &get_instance();
			$falla = new Falla();
			$falla->latitud = $datos->falla->latitud;
			$falla->longitud = $datos->falla->longitud;
			// la influencia se obtiene a través del tipo de falla
			// $falla->influencia = $datos->falla->influencia;
			$falla->factorArea = $datos->falla->factorArea;
			// TipoFalla viene con id. getInstancia
			$falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla->id);
			$falla->influencia = $falla->tipoFalla->influencia;
			// TipoMaterial se obtiene a traves del Tipo de Falla
			$falla->tipoMaterial = $falla->tipoFalla->getMaterial();
			// TipoReparacion se obtiene a traves del Tipo de Falla
			// Se establece más tarde en el próximo estado
			// $falla->tipoReparacion = TipoReparacion::getInstancia($datos->reparacion->id);
			$falla->direccion = $falla->insertarDireccion($datos->direccion);
			// $falla->criticidad = Criticidad::getInstancia($datos->criticidad->id);
			$falla->observaciones = array();
			// TODO: Ver donde acomodarlo mejor
			$user = $CI->ion_auth->user()->row();
			$datos->observacion->nombreObservador = $user->username;
			$datos->observacion->emailObservador = $user->email;
			// 
			$observacion = new Observacion($datos->observacion);
			array_push($falla->observaciones, $observacion);
			$falla->direccion = $falla->insertarDireccion($datos->direccion);
			$falla->id = $falla->save();
			$observacion->falla = $falla;
			$observacion->save();
			// TipoAtributo
			$falla->atributos = array_map(function ($atributo)
			{
				$tipoAtributo = TipoAtributo::getInstancia($atributo->id);
				$tipoAtributo->valor = $atributo->valor;
				return $tipoAtributo;
			}, $datos->atributos);
			// Por cada tipo de atributo se establece una entrada en la tabla FallaTipoAtributoModelo
			$falla->asociarAtributos();
			// 
			$falla->estado = new Confirmado();
			$falla->estado->setUsuario();
			$falla->estado->falla = $falla;
			$falla->estado->id = $falla->estado->save();
			$falla->asociarEstado();
			$CI->utiles->debugger($falla);
		}

		static public function crearFalla($datos)
		{
			$CI = &get_instance();
			$falla = self::getInstancia($datos->falla->id);
			// $falla->influencia = $datos->falla->influencia;
			$falla->factorArea = $datos->falla->factorArea;
			// TipoFalla viene con id. getInstancia
			$falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla->id);
			$falla->influencia = $falla->tipoFalla->influencia;
			// TipoMaterial se obtiene a traves del Tipo de Falla
			$falla->tipoMaterial = $falla->tipoFalla->getMaterial();
			// TipoReparacion se obtiene a traves del Tipo de Falla
			$falla->tipoReparacion = TipoReparacion::getInstancia($datos->reparacion->id);
			$falla->criticidad = Criticidad::getInstancia($datos->criticidad->id);
			// Observacion
			$falla->observaciones = array();
			// TODO: Ver donde acomodarlo mejor
			$user = $CI->ion_auth->user()->row();
			$datos->observacion->nombreObservador = $user->username;
			$datos->observacion->emailObservador = $user->email;
			// 
			$observacion = new Observacion($datos->observacion);
			$observacion->falla = $falla;
			$observacion->save();
			array_push($falla->observaciones, $observacion);
			// TipoAtributo
			$falla->atributos = array_map(function ($atributo)
			{
				$tipoAtributo = TipoAtributo::getInstancia($atributo->id);
				$tipoAtributo->valor = $atributo->valor;
				return $tipoAtributo;
			}, $datos->atributos);
			// Por cada tipo de atributo se establece una entrada en la tabla FallaTipoAtributoModelo
			$falla->asociarAtributos();
			// 
			$falla->estado = Estado::getEstadoActual($falla->id);
			$falla->estado = $falla->estado->cambiar($falla);
			$falla->actualizar();
			$falla->asociarEstado();
			$CI->utiles->debugger($falla);
		}

		public function actualizar()
		{
			$CI = &get_instance();
			return $CI->FallaModelo->actualizar($this);
		}

		static public function getAll()
		{
			$CI = &get_instance();
			$fallas = array();
			try {
				$datos = $CI->FallaModelo->get_all();
    			foreach ($datos as $row)
    			{
    				$falla = new Falla();
    				$falla->inicializar($row);
    				array_push($fallas, $falla);
    			}
			}	
			catch (MY_BdExcepcion $e) {
				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			}
			return $fallas;
		}

		public function asociarAtributos()
		{
			$CI = &get_instance();
			return $CI->FallaModelo->asociarAtributos($this);
		}

		public function to_array()
		{
			$datos = array(
            "id" => $this->id,
            "latitud" => $this->latitud,
            "longitud" => $this->longitud,
            "alturaCalle" => $this->direccion->altura,
            "calle" => $this->direccion->callePrincipal->nombre,
            "criticidad" => $this->criticidad->nombre,
            // "imagenes"=> $this->obtenerImagenes($idBache)
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => $this->tipoFalla->nombre,
            "estado" => json_encode($this->estado),
            );
			return $datos;
		}

	}
 ?>