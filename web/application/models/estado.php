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
			$estados = array();
			$datos = $CI->EstadoModelo->getEstados($idFalla);
			$estados = array_map(function($obj){ return Estado::getInstancia($obj); }, $datos);
			return $estados;
		}

		static public function getEstadoActual($idFalla)
		{
			$CI = &get_instance();
			$datos = $CI->EstadoModelo->getUltimoEstado($idFalla);
			//$CI->utiles->debugger($datos);
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

		//AGREGADO RODRIGO
		//Conserva la falla solamente si esta informada 
		public function filtrar($f,$calleDecodificada)
		{	
			return NULL;
		}

		public function esCalleBuscada($falla,$calleDecodificada1){
			return FALSE;
		}

		public function esEstadoActual($tipoEstado)
	    {
	    	return $this->tipoEstado->esTipoEstadoActual($tipoEstado);
	    }

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
		public function cambiar($falla, $datos=array(), $usuario)
		{
			// Por ahora se asume que no se cambia el tipo de falla al confirmar.
			$nuevoEstado = new Confirmado();
			$nuevoEstado->usuario = $usuario->id;
			$CI = &get_instance();
			$falla->factorArea = $datos->falla->factorArea;
			// Buscar Material por si lo cambian
			if ($datos->material->id!=$falla->tipoMaterial->id) {
				$falla->tipoMaterial = TipoMaterial::getInstancia($datos->material->id);
			}
			// Buscar TipoFalla por si la cambian
			if ($datos->tipoFalla->id!=$falla->tipoFalla->id) {
				$falla->tipoFalla = TipoFalla::getInstancia($datos->tipoFalla->id);
			}
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
			if (property_exists($datos, 'observacion')) {
				$datos->observacion->nombreObservador = $usuario->nombre;
				$datos->observacion->emailObservador = $usuario->email;
				$falla->observacion = new Observacion($datos->observacion, date("Y-m-d H:i:s"));
				$falla->observacion->falla = $falla;
				$falla->observacion->save();
			}
			if (property_exists($datos, 'reparacion')) {
				$tipoReparacion = TipoReparacion::getInstancia($datos->reparacion->id);
				$falla->tipoReparacion = $tipoReparacion;
			}
			$nuevoEstado->falla = $falla;
			$nuevoEstado->id = $nuevoEstado->save();
			$falla->actualizar();
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
            "imagenes"=> json_encode($falla->obtenerImagenes()),
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => ucfirst($falla->tipoFalla->nombre),
            "estado" => get_class($this),
            'tipoFalla' => json_encode($falla->tipoFalla),
            "posicion" => array($falla->latitud, $falla->longitud),
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
			$terminal1 = new NumericTerminalExpression("id", "int", "true");
			$terminal2 = new NumericTerminalExpression("factorArea", "double", "true");
			$noTerminalFalla = new AndExpression(array($terminal1, $terminal2), "falla");

			$terminal1 = new NumericTerminalExpression("id", "int", "true");
			$noTerminalCriticidad = new AndExpression(array($terminal1), "criticidad");

			$terminal1 = new StringTerminalExpression("comentario", "", "true");
			$noTerminalObservacion = new AndExpression(array($terminal1), "observacion");

			$terminal1 = new NumericTerminalExpression("id", "int", "true");
			$terminal2 = new NumericTerminalExpression("valor", "double", "true");
			$noTerminalAtributo = new AndExpression(array($terminal1, $terminal2), "atributos");

			$validator = new AndExpression(array($noTerminalFalla, $noTerminalCriticidad, $noTerminalAtributo), "datos");
			return $validator->interpret($datos);
		}

		public function esCalleBuscada($falla,$calleDecodificada1){
			$nombreCalle = strtolower($falla->direccion->getNombre());
			$calleDecodificada = strtolower($calleDecodificada1);
			//CustomLogger::log("nombreCalle: ".$nombreCalle);
			//CustomLogger::log("calleDecodificada: ".$calleDecodificada);
			//CustomLogger::log("strcmp($nombreCalle,$calleDecodificada) = ".strcmp($nombreCalle,$calleDecodificada) );
			//CustomLogger::log("strlen(nombreCalle) = ". strlen( rtrim(ltrim($nombreCalle))));
			//CustomLogger::log("strlen(calleDecodificada) = ". strlen($calleDecodificada));

			//Se eliminan los espacios en blanco al inicio y al final de la calle enviada por parametro y la calle de la BD.
			$cadTrimeada1 = rtrim(ltrim($nombreCalle));
			$cadTrimeada2 = rtrim(ltrim($calleDecodificada));
			CustomLogger::log("strcmp($cadTrimeada1,$cadTrimeada2) = ".strcmp($cadTrimeada1,$cadTrimeada2));

			$result = FALSE;
			if (strcmp($cadTrimeada1,$cadTrimeada2) == 0) {
				$result = TRUE;
			}
			if ($result== TRUE) {
				CustomLogger::log("retornando resultado TRUE");
			}else{
				CustomLogger::log("retornando resultado FALSE");
			}
			CustomLogger::log("-----------------------------------------");
			return $result;
		}
		
		// Este metodo filtra aquellas fallas informadas que  se situen
		// sobre la calle enviada por el usuario.
		public function filtrar($f,$calleDecodificada){
			require_once('CustomLogger.php');
        	CustomLogger::log('Dentro de filtrar para idFalla: '.$f->getId());
        	
			$array_falla = array();
			//NOTA IMPORTANTE: Las calles informadas no tienen rangosEstimados, sino que la altura fue cargada desde la pagina web.
			/*
			TODO: por lo que se modifica, todas las fallas tienen rangos estimados.
			Este método debería ser $falla->esInformada().
			return $falla;
			El estado de la Falla conoce como se debe parsear a json la falla.
			*/
        	if ( $this->esCalleBuscada($f,$calleDecodificada) == TRUE ) {
	            $array_falla["id"] = $f->getId();
	            $array_falla["calle"] = $f->direccion->getNombre();
	            $array_falla["altura"] = $f->direccion->getAltura();
        	}
            return $array_falla;
		}

	}

	class Confirmado extends Estado
	{
		/*
		TODO: Confirmado debe estimar el monto de la reparacion.
		Suponemos***
		Precio del tipo de material * (dimension) + costo de la mano de obra
		El tipo de falla tiene costo según dimensión.

		costoTipoReparacion == mano de obra
		costoTipoFalla == valor de material * (unidad de medida)

		valorEstimadoReparacion == costoTipoFalla + costoTipoReparacion

		*/

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
			$this->id = $datos->id;
		}

		public function inicializarFalla($falla, $datos)
		{

			log_message('debug','En estado.inicializarFalla()');
			$falla->criticidad = Criticidad::getInstancia($datos->idCriticidad);
			log_message('debug','idCriticidad: ');
			log_message('debug',$datos->idCriticidad);

			if ($datos->idTipoReparacion!=NULL) {
				//log_message('debug','Entre por el tipo reparacion!');
				$falla->tipoReparacion = TipoReparacion::getInstancia($datos->idTipoReparacion);
			}

			log_message('debug','Despues del if de tipo reparacion!');
			$falla->factorArea = $datos->areaAfectada;
			CustomLogger::log('En estado->inicializarFalla()...');	

			$falla->atributos = Falla::getAtributos($falla->id);

			CustomLogger::log('Fin de estado->inicializarFalla()! ');	
			
			log_message('debug','factorArea: ');
			log_message('debug',$datos->factorArea);
			log_message('debug','Fin estado.inicializarFalla()');
			

		}

		//NUEVA VERSION.
		//Se convierten los parametros segun el tipo de falla confirmada que sea,
		//ya sea las que se crean desde la webapp con TipoAtributos y las que se 
		//suben desde appCliente.
		// 
		public function to_array($falla)
		{
			CustomLogger::log('En estado.to_array()');	
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->callePrincipal->nombre,
            "criticidad" => ucfirst($falla->criticidad->nombre),
            "imagenes"=> json_encode($falla->obtenerImagenes()),
			'montoCalculado' => $falla->calcularMonto(),            
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => ucfirst($falla->tipoFalla->nombre),
            "estado" => get_class($this),
            'tipoFalla' => $falla->tipoFalla,
            'tipoReparacion' => $falla->getTipoReparacion(),
            // "estado" => json_encode($falla->estado),
            );
            return $datos;
		}


		/*
		public function to_array($falla)
		{
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->callePrincipal->nombre,
            "criticidad" => ucfirst($falla->criticidad->nombre),
            "imagenes"=> json_encode($falla->obtenerImagenes()),
            'montoCalculado' => $falla->calcularMonto(),
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => ucfirst($falla->tipoFalla->nombre),
            "estado" => get_class($this),
            'tipoFalla' => $falla->tipoFalla,
            'tipoReparacion' => $falla->getTipoReparacion(),
            // "estado" => json_encode($falla->estado),
            );
            return $datos;
		}
		*/


		public function cambiar($falla, $datos=array(), $usuario)
		{
			/*
				Datos para Reparando: 
					- monto
					- fechaFinReparacionEstimada
			*/
			$nuevoEstado = new Reparando();
			$nuevoEstado->falla = $falla;
			$CI = &get_instance();
			$nuevoEstado->usuario = $usuario->id;
			$nuevoEstado->montoEstimado = $datos->estado->montoEstimado;
			// TODO: verificar fecha mayor a dia de hoy... Seria genial si es calculada a partir del tipo de reparacion...
			$fechaFinReparacionEstimada = date("d-m-Y", strtotime($datos->estado->fechaFinReparacionEstimada));
			$CI->utiles->debugger('fechaFinReparacionEstimada');
			$CI->utiles->debugger($datos->estado->fechaFinReparacionEstimada);
			$CI->utiles->debugger($fechaFinReparacionEstimada);
			$nuevoEstado->fechaFinReparacionEstimada = $fechaFinReparacionEstimada;
			//TODO: verque el tipo de reparacion exista y pertenezca al tipo de falla...
			$arrayTipoReparacion = $falla->tipoFalla->getTiposDeReparacion();
			$existeTipoReparacion = false;
			foreach ($arrayTipoReparacion as $tipoReparacion) {
				if ($tipoReparacion->id == $datos->falla->tipoReparacion) {
					$existeTipoReparacion = true;
				}
			}
			if ($existeTipoReparacion != true) {
				return null;
			}
			if ($datos->falla->tipoReparacion != $falla->tipoReparacion->id) {
				$nuevoEstado->falla->tipoReparacion = TipoReparacion::getInstancia($datos->falla->tipoReparacion);
				$nuevoEstado->falla->actualizarReparacion();
			}
			$nuevoEstado->id = $nuevoEstado->saveReparando();
			return $nuevoEstado;
		}

		public function validarDatos($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("validarDatos");
			$terminal1 = new NumericTerminalExpression("id", "int", "true");
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
			$estado = new Reparando();
			$estado->inicializar($datos);
			return $estado;
		}

		protected function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = $datos->idFalla;
			$CI = &get_instance();
			$this->monto =$datos->montoEstimado;
			$this->fechaFinReparacionEstimada = $datos->fechaFinReparacionEstimada;
			// $this->falla = Falla::getInstancia($datos->idFalla);;
		}

		public function saveReparando()
		{
			$CI = &get_instance();
			return $CI->EstadoModelo->saveReparando($this);
		}

		public function inicializarFalla($falla, $datos)
		{
			$falla->criticidad = Criticidad::getInstancia($datos->idCriticidad);
			$falla->tipoReparacion = TipoReparacion::getInstancia($datos->idTipoReparacion);
			$falla->factorArea = $datos->areaAfectada;
			$falla->atributos = Falla::getAtributos($falla->id);
			return;
		}

		public function to_array($falla)
		{
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->callePrincipal->nombre,
            "criticidad" => ucfirst($falla->criticidad->nombre),
            "imagenes"=> json_encode($falla->obtenerImagenes()),
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => ucfirst($falla->tipoFalla->nombre),
            "estado" => get_class($this),
            'tipoFalla' => $falla->tipoFalla,
            'tipoReparacion' => $falla->getTipoReparacion(),
            'montoCalculado' => $falla->calcularMonto(),
            'fechaFinReparacionEstimada' => $this->fechaFinReparacionEstimada,
            // "estado" => json_encode($falla->estado),
            );
            return $datos;
		}

		public function cambiar($falla, $datos=array(), $usuario)
		{
			/*
				Datos para Reparando: 
					- montoReal
					- fechaFinReparacionReal
			*/
			$nuevoEstado = new Reparado();
			$nuevoEstado->falla = $falla;
			$nuevoEstado->usuario = $usuario->id;
			$nuevoEstado->montoReal = $datos->estado->montoReal;
			// TODO: tener en cuenta que la fecha ingresada en reparacion real sea mayor a la fecha estimada...
			$fechaFinReparacionReal = date("d-m-Y", strtotime($datos->estado->fechaFinReparacionReal));
			$nuevoEstado->fechaFinReparacionReal = $fechaFinReparacionReal;
			//$nuevoEstado->falla->tipoReparacion = TipoReparacion::getInstancia($datos->estado->idTipoReparacion);
			$nuevoEstado->id = $nuevoEstado->saveReparado();
			//$nuevoEstado->falla->actualizarReparacion();
			return $nuevoEstado;
		}

		public function validarDatos($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("validarDatos");
			$terminal1 = new NumericTerminalExpression("id", "int", "true");
			$noTerminalFalla = new AndExpression(array($terminal1), "falla");

			$terminal1 = new NumericTerminalExpression("montoReal", "double", "true");
			$terminal2 = new StringTerminalExpression("fechaFinReparacionReal", "", "true");
			$noTerminalEstado = new AndExpression(array($terminal1, $terminal2), "estado");

			$validator = new AndExpression(array($noTerminalFalla, $noTerminalEstado), "datos");
			return $validator->interpret($datos);
		}

	}

	/**
	* 
	*/
	class Reparado extends Estado
	{
		
		function __construct()
		{
			parent::__construct();
			$this->tipoEstado = TipoEstado::getTipoEstado(get_class($this));
		}

		static public function getInstancia($datos)
		{
			$estado = new Reparado();
			$estado->inicializar($datos);
			return $estado;
		}

		protected function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = $datos->idFalla;
		}

		public function saveReparado()
		{
			$CI = &get_instance();
			return $CI->EstadoModelo->saveReparado($this);
		}

		public function inicializarFalla($falla, $datos)
		{
			$falla->criticidad = Criticidad::getInstancia($datos->idCriticidad);
			$falla->tipoReparacion = TipoReparacion::getInstancia($datos->idTipoReparacion);
			$falla->factorArea = $datos->areaAfectada;
			$falla->atributos = Falla::getAtributos($falla->id);
			return;
		}

		public function to_array($falla)
		{
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->callePrincipal->nombre,
            "criticidad" => ucfirst($falla->criticidad->nombre),
            "imagenes"=> json_encode($falla->obtenerImagenes()),
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => ucfirst($falla->tipoFalla->nombre),
            "estado" => get_class($this),
            'tipoFalla' => $falla->tipoFalla,
            'montoCalculado' => $falla->calcularMonto(),
            'fechaFinReparacionEstimada' => $this->fechaFinReparacionEstimada,
            );
            return $datos;
		}

	}
