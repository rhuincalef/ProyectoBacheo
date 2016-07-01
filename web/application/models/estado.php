<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Estado
	// class Estado implements JsonSerializable
	{
		var $id;
		var $falla;
		var $usuario;
		var $tipoEstado;
		var $monto;
		var $fechaFinReparacionReal;
		var $fechaFinReparacionEstimada;
		
		function __construct()
		{
			
		}

		protected function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = Falla::getInstancia($datos->idFalla);
			$this->tipoEstado = TipoEstado::getInstancia($datos->idTipoEstado);
			// $this->fechaFinReparacionReal = $datos->fechaFinReparacionReal;
			// $this->fechaFinReparacionEstimada = $datos->fechaFinReparacionEstimada;
		}

		static public function getInstancia($datos)
		{
			$estado = new Estado();
			$estado->inicializar($datos);
			return $estado;
		}

		static public function getAll($idFalla)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("datos->getAll");
			$estados = array();
			$datos = $CI->EstadoModelo->getEstados($idFalla);
			$CI->utiles->debugger($datos);
			$estados = array_map(function($obj){ return Estado::getInstancia($obj); }, $datos);
			return $estados;
		}

		static public function getEstadoActual($idFalla)
		{
			$CI = &get_instance();
			$datos = $CI->EstadoModelo->getUltimoEstado($idFalla);
			// $CI->utiles->debugger($datos);
			$datosTipoEstado = $CI->TipoEstadoModelo->get($datos->idTipoEstado);
			$nombreTipoEstado = ucfirst($datosTipoEstado->nombre);
			$estado = $nombreTipoEstado::getInstancia($datos);
			// date('F jS, Y h:i:s', strtotime($date));
			// $estado->fecha = date("F d Y h:i:s", strtotime($datos->fecha));
			$estado->fecha = date("d-m-Y h:i", strtotime($datos->fecha));
			return $estado;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->EstadoModelo->save($this);
		}

		public function toJsonSerialize()
		{
			return $this->to_array($this->falla);
		}

		// public function jsonSerialize()
		// {
		// 	return;
		// }

	}

	
	class Informado extends Estado
	{

		public function __construct()
		{
			parent::__construct();
			$this->tipoEstado = TipoEstado::getTipoEstado(get_class($this));
		}

		static public function getInstancia($datos)
		{
			$estado = new Informado();
			$estado->inicializar($datos);
			return $estado;
		}

		protected function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = $datos->idFalla;
			// $this->falla = Falla::getInstancia($datos->idFalla);;
		}

		public function inicializarFalla($falla, $datos)
		{
			return;
		}

		public function cambiar($falla, $datos=array(), $usuario)
		{
			/*
				Datos para Confirmado: 
					- latitud, longitud y factorArea
						latitud y longitud se obtuvieron al informar la Falla
						"falla": {"influencia":2, "factorArea": .2}

					- tipoMaterial: se obtiene a través del tipo de falla

					- tipoFalla (id)
						"tipoFalla": {"id": 5}

					- criticidad
						"criticidad": {"id": 9}

					(direccion No va, se obtuvo al informar la Falla)
					- direccion (callePrincipal, calleSecundariaA, calleSecundariaB y altura)
						"direccion": {"altura": 150,"callePrincipal": "calleP", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}

					- observacion (comentario, -- email y usuario se obtienen de la sesion--)
						"observacion": {"comentario": "comentario falla"}

					- atributos (array -- es variable, depende del tipo de falla --)
						"atributos": [{"id": 9, "valor": '5'},{"id": 10,"valor": '4'}]

			{
				"datos":{
					"falla": {"id": 1, "factorArea": .2},
					"observacion": {"comentario": "comentario falla", "nombreObservador": "Pepe", "emailObservador": "pepe@pepe.com"},
					"tipoFalla": {"id": 88},
					"criticidad": {"id": 71},
					"observacion": {"comentario":""}
					"atributos": [{"id": 9, "valor": '5'},{"id": 10,"valor": '4'}],
					"reparacion": {"id":1}
					"fechaFin":"",
					"tipoObstruccion":"Parcial",
					"montoEstimado":""
				}
				Probar:..........
				$.post(
					"http://localhost/web/index.php/inicio/cambiarEstadoBache",
					{"datos" : JSON.stringify(
						{
							"falla" : {"id": 1, "factorArea": .2},
							"criticidad" : {"id": 1},
							"observacion": {"comentario": "comentario falla"},
							"atributos": [{"id": 1, "valor": '5'},{"id": 2,"valor": '4'}, {"id": 3, "valor": '2'}],
						}
					)},
					function (data) {
								
								alertar("Exito!","El bache ha cambiado de estado","success");
						}	
				);
			}
			*/
			// Por ahora se asume que no se cambia el tipo de falla al confirmar.
			$nuevoEstado = new Confirmado();
			$datos->observacion->nombreObservador = $usuario->nombre;
			$datos->observacion->emailObservador = $usuario->email;
			$nuevoEstado->usuario = $usuario->id;
			$CI = &get_instance();
			$falla->factorArea = $datos->falla->factorArea;
			// Buscar Material por si lo cambian
			// Buscar TipoFalla por si la cambian
			// $falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla);
			// $falla->tipoFalla = Criticidad::getInstancia($datos->criticidad);
			$falla->criticidad = Criticidad::getInstancia($datos->criticidad->id);
			// TipoAtributo
			$falla->atributos = array_map(function ($atributo)
			{
				$tipoAtributo = TipoAtributo::getInstancia($atributo->id);
				$tipoAtributo->valor = $atributo->valor;
				return $tipoAtributo;
			}, $datos->atributos);
			// Por cada tipo de atributo se establece una entrada en la tabla FallaTipoAtributoModelo
			$falla->asociarAtributos();
			$falla->observacion = new Observacion($datos->observacion, date("Y-m-d H:i:s"));
			$falla->observacion->falla = $falla;
			$falla->observacion->save();
			$tipoReparacion = TipoReparacion::getInstancia($datos->reparacion->id);
			$falla->tipoReparacion = $tipoReparacion;

			$nuevoEstado->falla = $falla;
			$nuevoEstado->id = $nuevoEstado->save();
			return $nuevoEstado;
		}

		public function to_array($falla)
		{
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->getNombre(),
            "criticidad" => "No se especifica en Informado",
            "imagenes"=> $falla->obtenerImagenes(),
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => $falla->tipoFalla->nombre,
            "estado" => "Informado",
            // "estado" => json_encode($falla->estado),
            );
            return $datos;
		}

		public function jsonSerialize()
		{
			$arrayJson = array(
				"nombre" => $this->tipoEstado->nombre,
				);
			return $arrayJson;
		}

		/*
		{"datos" : JSON.stringify(
			{
				"falla" : {"id": 1, "factorArea": .2},
				"criticidad" : {"id": 1},
				"observacion": {"comentario": "comentario falla"},
				"atributos": [{"id": 1, "valor": '5'},{"id": 2,"valor": '4'}, {"id": 3, "valor": '2'}],
			}
		)}
		*/
		public function validarDatos($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("validarDatos");
			$terminal1 = new NumericTerminalExpression("id", "integer", "true");
			$terminal2 = new NumericTerminalExpression("factorArea", "double", "true");
			$noTerminalFalla = new AndExpression(array($terminal1, $terminal2), "falla");

			$terminal1 = new NumericTerminalExpression("id", "integer", "true");
			$noTerminalCriticidad = new AndExpression(array($terminal1), "criticidad");

			$terminal1 = new StringTerminalExpression("comentario", "", "true");
			// $terminal2 = new StringTerminalExpression("nombreObservador", "", "true");
			// $terminal3 = new StringTerminalExpression("emailObservador", "", "true");
			$noTerminalObservacion = new AndExpression(array($terminal1), "observacion");

			$terminal1 = new NumericTerminalExpression("id", "integer", "true");
			$terminal2 = new NumericTerminalExpression("valor", "double", "true");
			$noTerminalAtributo = new AndExpression(array($terminal1, $terminal2), "atributos");

			$validator = new AndExpression(array($noTerminalFalla, $noTerminalCriticidad, $noTerminalObservacion, $noTerminalAtributo), "datos");
			return $validator->interpret($datos);
		}

	}

	class Confirmado extends Estado
	{

		public function __construct()
		{
			parent::__construct();
			$this->tipoEstado = TipoEstado::getTipoEstado(get_class($this));
		}

		public function setUsuario()
		{
			// $this->usuario = $idUsuario;
			// Se obtiene el usuario a traves de la libreria ion_auth
			$CI = &get_instance();
			$this->usuario = $CI->ion_auth->user()->row()->id;
		}

		static public function getInstancia($datos)
		{
			$estado = new Confirmado();
			$estado->inicializar($datos);
			return $estado;
		}

		public function inicializar($datos)
		{
			// parent::inicializar($datos);
			$this->id = $datos->id;
			// $this->usuario = $datos->idUsuario;
		}

		public function inicializarFalla($falla, $datos)
		{
			$falla->criticidad = Criticidad::getInstancia($datos->idCriticidad);
			$falla->tipoReparacion = TipoReparacion::getInstancia($datos->idTipoReparacion);
			$falla->factorArea = $datos->areaAfectada;
		}

		public function to_array($falla)
		{
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->callePrincipal->nombre,
            "criticidad" => $falla->criticidad->nombre,
            // "imagenes"=> $this->obtenerImagenes($idBache)
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => $falla->tipoFalla->nombre,
            "estado" => "Confirmado",
            // "estado" => json_encode($falla->estado),
            );
            return $datos;
		}

		public function cambiar($falla, $datos=array(), $usuario)
		{
			/*
				Datos para Reparando: 
					- monto

					- fechaFinReparacionEstimada
				
			$nuevoEstado = new Reparando();
			$nuevoEstado->falla = $falla;
			$nuevoEstado->id = $nuevoEstado->save();
			return $nuevoEstado;
			*/
			$nuevoEstado = new Reparando();
			$nuevoEstado->falla = $falla;
			$nuevoEstado->usuario = $usuario->id;
			$nuevoEstado->montoEstimado = $datos->estado->montoEstimado;
			$fechaFinReparacionEstimada = $datos->estado->fechaFinReparacionEstimada;
			$nuevoEstado->fechaFinReparacionEstimada = $fechaFinReparacionEstimada;
			// $nuevoEstado->id = $nuevoEstado->save();
			return $nuevoEstado;

		}

		public function validarDatos($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("validarDatos");
			$terminal1 = new NumericTerminalExpression("id", "integer", "true");
			$noTerminalFalla = new AndExpression(array($terminal1), "falla");

			$terminal1 = new NumericTerminalExpression("montoEstimado", "double", "true");
			$terminal2 = new StringTerminalExpression("fechaFinReparacionEstimada", "", "true");
			// $terminal3 = new StringTerminalExpression("emailObservador", "", "true");
			$noTerminalEstado = new AndExpression(array($terminal1, $terminal2), "estado");

			$validator = new AndExpression(array($noTerminalFalla, $noTerminalEstado), "datos");
			return $validator->interpret($datos);
		}

	}

	class Reparando extends Estado
	{

		public function __construct()
		{
			parent::__construct();
			$this->tipoEstado = TipoEstado::getTipoEstado(get_class($this));
		}

		static public function getInstancia($datos)
		{
			$estado = new Informado();
			$estado->inicializar($datos);
			return $estado;
		}

		protected function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = $datos->idFalla;
			// $this->falla = Falla::getInstancia($datos->idFalla);;
		}

	}
?>