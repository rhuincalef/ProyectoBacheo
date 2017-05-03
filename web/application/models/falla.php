	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Falla implements JsonSerializable
	// class Falla
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
		// var $estados;
		
		function __construct()
		{
			
		}

		private function inicializar($datos)
		{
			$CI = &get_instance();
			// $CI->utiles->debugger($datos);
			$this->id = $datos->id;
			$this->latitud = $datos->latitud;
			$this->longitud = $datos->longitud;
        	CustomLogger::log('asignadas lat y long');
			$this->direccion = Direccion::getInstancia($datos->idDireccion);
        	CustomLogger::log('asiganada direccion');
			$this->tipoMaterial = tipoMaterial::getInstancia($datos->idTipoMaterial);
        	CustomLogger::log('asiganada tipofalla');
			$this->tipoFalla = TipoFalla::getInstancia($datos->idTipoFalla);
			$this->estado = Estado::getEstadoActual($this->id);
        	CustomLogger::log('asignado estado');
			// El estado de la conoce los demás atributos que se deben inicializar 
			$this->estado->inicializarFalla($this, $datos);
        	CustomLogger::log('despues de inicializarFalla()...');
			$this->estado->falla = $this;
			// $this->estado->falla = $this;
			// $CI->utiles->debugger($this);
		}



		public function getId(){
			return $this->id;
		}
		
		static public function getInstancia($id)
		{
			$CI = &get_instance();
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
           "atributos": [{"id": 9, "valor": parseFloat('5')},{"id": 10,"valor": parseFloat('4')}],
		   "direccion": {"altura": 50,"callePrincipal": "Edison Norte", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
		  })
		})
		- Petición para crear definitivamente la falla, pasa del estado Informado al Confirmado.
		$.post('crear/Falla', 
		{"clase": "Falla",
		"datos": JSON.stringify(
		  { "falla": {"id": 20, "latitud": -43.251741078254454, "longitud": -65.32084465026855, "influencia":2, "factorArea": .2},
		   "observacion": {"comentario": "comentario falla", "nombreObservador": "Pepe", "emailObservador": "pepe@pepe.com"},
		   "tipoFalla": {"id": 1},
		   "criticidad": {"id": 2},
       	   "reparacion": {"id": 1},
       	   "atributos": [{"id": 1, "valor": 5},{"id": 2,"valor": 4}, {"id":3, "valor":'3'}],
		   "direccion": {"altura": 50,"callePrincipal": "Edison Norte", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
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
			// Direccion::insertarDireccion -> Si no existe se crea la calle
			return Direccion::insertarDireccion($datosDireccion);
		}

		static public function validarDatos($datos)
		{
			/* Desacoplar en estados */
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
/*
		static public function validarDatosFalla($datos)
		{
			return true;
		}
*/
		/*
		{ "falla": {"latitud": -43.251741078254454, "longitud": -65.32084465026855, "influencia":2, "factorArea": .2},
		"observacion": {"comentario": "comentario falla"},
		"tipoFalla": {"id": 5},
		"criticidad": {"id": 9},
		   "reparacion": {"id": 6},
		"atributos": [{"id": 9, "valor": '5'},{"id": 10,"valor": '4'}],
		"direccion": {"altura": 50,"callePrincipal": "Edison Norte", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
		}
		*/

		static public function validarDatosFalla($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("validarDatosFalla");
			// Creando arbol para validar los datos de Falla
			$terminal1 = new NumericTerminalExpression("latitud", 'double', true);
			$terminal2 = new NumericTerminalExpression("longitud", 'double', true);
			$terminal3 = new NumericTerminalExpression("factorArea", 'double', true);
			$terminal4 = new NumericTerminalExpression("id", 'int', false);
			$noTerminalFalla = new AndExpression(array($terminal1, $terminal2, $terminal3, $terminal4), "falla");

			$terminal1 = new StringTerminalExpression("comentario", "", true);
			$noTerminalObservacion = new AndExpression(array($terminal1), "observacion");

			$terminal1 = new NumericTerminalExpression("id", 'int', true);
			$noTerminaTipoFalla = new AndExpression(array($terminal1), "tipoFalla");

			$terminal1 = new NumericTerminalExpression("id", 'int', true);
			$noTerminalCriticidad = new AndExpression(array($terminal1), "criticidad");

			$terminal1 = new NumericTerminalExpression("id", 'int', true);
			$noTerminalReparacion = new AndExpression(array($terminal1), "reparacion");

			$terminal1 = new NumericTerminalExpression("id", 'int', true);
			$terminal2 = new NumericTerminalExpression("valor", 'double', true);
			$noTerminalAtributo = new AndExpression(array($terminal1, $terminal2), "atributos");

			$terminal1 = new NumericTerminalExpression("altura", 'int', true);
			$terminal2 = new StringTerminalExpression("callePrincipal", "", true);
			$terminal3 = new StringTerminalExpression("calleSecundariaA", "", true);
			$terminal4 = new StringTerminalExpression("calleSecundariaB", "", true);
			$noTerminalDireccion = new AndExpression(array($terminal1, $terminal2, $terminal3, $terminal4), "direccion");
/*
			$validator = new AndExpression(array($noTerminalFalla, $noTerminalObservacion, $noTerminalDireccion, $noTerminaTipolFalla, $noTerminaCriticidad, $noTerminalAtributo), "datos");
*/
			$validator = new AndExpression(array($noTerminalFalla, $noTerminalObservacion, $noTerminaTipoFalla, $noTerminalCriticidad, $noTerminalDireccion, $noTerminalReparacion, $noTerminalAtributo), "datos");
			return $validator->interpret($datos);
		}

		static public function validarDatosFallaAnonima($datos)
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

			$terminal1 = new NumericTerminalExpression("id", "int", "true");
			$noTerminaTipolFalla = new AndExpression(array($terminal1), "tipoFalla");

			$terminal1 = new NumericTerminalExpression("altura", "int", "true");
			$terminal2 = new StringTerminalExpression("callePrincipal", "", "true");
			$terminal3 = new StringTerminalExpression("calleSecundariaA", "", "true");
			$terminal4 = new StringTerminalExpression("calleSecundariaB", "", "true");
			$noTerminalDireccion = new AndExpression(array($terminal1, $terminal2, $terminal3, $terminal4), "direccion");

			$validator = new AndExpression(array($noTerminalFalla, $noTerminalObservacion, $noTerminalDireccion, $noTerminaTipolFalla), "datos");
			return $validator->interpret($datos);
		}

		public function obtenerImagenes()
		{
			/*$imagenes = Multimedia::getAll($this->id);
			return $imagenes;*/
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
		static public function crearFallaAnonima($datos)
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
			$observacion = new Observacion($datos->observacion, date("Y-m-d H:i:s"));
			$observacion->falla = $falla;
			$observacion->save();
			$falla->estado = new Informado();
			$falla->estado->falla = $falla;
			$falla->estado->id = $falla->estado->save();
			$falla->asociarEstado();
			// TODO: Falta asociar la observacion
			// TODO: realizar los save's dependientes en save Falla
			$CI->utiles->debugger($falla);
			return $falla;
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
		static public function crearFallaEnConfirmado($datos)
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
			$falla->direccion = $falla->insertarDireccion($datos->direccion);
			// $falla->criticidad = Criticidad::getInstancia($datos->criticidad->id);
			$falla->tipoReparacion = TipoReparacion::getInstancia($datos->reparacion->id);
			$falla->criticidad = Criticidad::getInstancia($datos->criticidad->id);
			$falla->observaciones = array();
			// TODO: Ver donde acomodarlo mejor
			$user = $CI->ion_auth->user()->row();
			$datos->observacion->nombreObservador = $user->username;
			$datos->observacion->emailObservador = $user->email;
			// 
			$observacion = new Observacion($datos->observacion, date("Y-m-d H:i:s"));
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
			return $falla;
		}

		/*
		Falla en estado Informado
		Se realiza el cambio de estado de Informado->Confirmado
		*/
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
			$observacion = new Observacion($datos->observacion, date("Y-m-d H:i:s"));
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
			$usuario = new stdClass();
			$usuario->id = $user->id;
			$usuario->nombre = $user->username;
			$usuario->email = $user->email;

			$falla->estado = Estado::getEstadoActual($falla->id);
			$falla->estado = $falla->estado->cambiar($falla, $datos, $usuario);
			$falla->actualizar();
			$falla->asociarEstado();
			$CI->utiles->debugger($falla);
			return $falla;
		}

		public function actualizar()
		{
			$CI = &get_instance();
			return $CI->FallaModelo->actualizar($this);
		}

		static public function getAll()
		{
    		require_once('CustomLogger.php');
        	CustomLogger::log('EN falla.getAll()...');
			$CI = &get_instance();
			$fallas = array();
			try {
				$datos = $CI->FallaModelo->get_all();
				//NOTA: Tira "Excepcion capturada: Sin resultados" si la falla no tiene los campos obligatorios usados en los metodos de inicializacion
    			foreach ($datos as $row)
    			{
        			CustomLogger::log('Instanciando $row: ');
        			CustomLogger::log($row);
        			CustomLogger::log('------------------------ ');
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
			$datos = $this->estado->to_array($this);
			return $datos;
		}

		static public function obtenerObservaciones($idBache)
		{
			$observaciones = Observacion::getAll($idBache);
			// Por cada observacion se arma un array fijado para no romper la view.
			return array_map(function($elemento)
			{
	            return array(
	                'fecha' => $elemento->fecha,
	                'texto' => $elemento->comentario,
	                'usuario' => $elemento->nombreObservador
	            );
        	}, $observaciones);
		}

		public function asociarObservacionAnonima($datos)
		{
			$observacion = new Observacion();
			$observacion->comentario = $datos->comentario;
			$observacion->nombreObservador = $datos->nombreObservador;
			$observacion->emailObservador = $datos->emailObservador;
			$falla = new self();
			$falla->id = $datos->idFalla;
			$observacion->falla = $falla;
			$observacion->save();
		}

		public function cambiarEstado($datos, $usuario)
		{
			$CI = &get_instance();
			$nuevoEstado = $this->estado->cambiar($this, $datos, $usuario);
			$this->estado = $nuevoEstado;
			$CI->utiles->debugger($nuevoEstado);
			// $this->asociarEstado();
		}

		public function jsonSerialize() {
			// Estado conoce los datos que debe mostrar
	        // return array('id' => $this->id, );
	        return $this->estado->toJsonSerialize();
	    }

	    //Filtra las fallas que tienen estado Informado del servidor
	    public function filtrar($calleDecodificada){
	    	return $this->estado->filtrar($this,$calleDecodificada);
	    }


	    //Crea una falla nueva capturada en la calle y le asigna el estado
	    // "Confirmado".

	    //Retorna un array asociativo con los datos:
	    //		-estado: codigo de error del problema o de la peticion OK
	    //		-msg: informacion para ser usada en el campo 'infolog' de la respuesta.
	    //		-dataFalla: Atributos de la falla subida(solamente idFalla)

	   	public static function inicializarFallaAnonima($lat,$long,$nombreTipoFalla,$nombreTipoMaterial,$nombreCriticidad,$observacion,$tipoEstado,$tipoReparacion){

        	log_message('debug','Dentro de inicializarFallaAnonima()...');
        	$estadoPeticion = array(
        		'estado' => FALLA_ANONIMA_INICIALIZADA_OK,
        		'msg' => 'OK falla anonima generada'
        		);
        	$idFallaNueva = FALLA_INVALIDA;
   			$rangoEstimado1 = $rangoEstimado2 =  $altura = FALLA_PHP_CALLE_NO_DISPONIBLE;
            $calleSecundariaA = $calleSecundariaB = $calle = CALLE_NO_OBTENIDA;
        	
        	log_message('debug','$rangoEstimado1 tiene:');
        	log_message('debug',$rangoEstimado1);
        	log_message('debug','$rangoEstimado2 tiene:');
        	log_message('debug',$rangoEstimado2);
        		
    		Direccion::estaCalleEnCiudad($lat,$long); 	   		
   			try {
   				//Si ocurrio un error de geocoding para la calle o la interseccion, se emplean datos invalidos.
	            $arrDatos = Direccion::obtener_datos_direccion_v2($lat,$long);

   			}catch (Geocoder\Exception\NoResult $e){
	            $msgResult = "Consulta de geocoding sin resultados";
	            CustomLogger::log($msgResult);
	            $estadoPeticion = array(
	                            'estado' => DIRECCION_PHP_PETICION_SIN_RESULTADOS,
	                            'msg' => $msgResult );

	        }catch (Geocoder\Exception\QuotaExceeded $e){
	            $msgResult = "Cuota de consultas ofrecidas por el proveedor excedida";
	            CustomLogger::log($msgResult);
	            $estadoPeticion = array(  
	                            'estado' => DIRECCION_PHP_QUOTA_EXCEDIDA,
	                            'msg' => $msgResult );

	        }catch (Geocoder\Exception\UnsupportedOperation $e){
	            $msgResult = "Operacion no valida para el proveedor de geolocalizacion seleccionado";
	            CustomLogger::log($msgResult);
	            $estadoPeticion = array(
	                            'estado' => DIRECCION_PHP_OPERACION_GEOCODING_NO_SOPORTADA,
	                            'msg' => $msgResult );

	        }catch (Geocoder\Exception\InvalidCredentials $e){
	            $msgResult = "API KEY invalida";
	            CustomLogger::log($msgResult);
	            $estadoPeticion = array(
	                            'estado' => DIRECCION_PHP_API_KEY_INVALIDA,
	                            'msg' => $msgResult);

	        }catch (Ivory\HttpAdapter\HttpAdapterException $e){
	            $msgResult = "No se pudieron obtener las coordenadas de GoogleMaps. Timeout excedido.Intentelo de nuevo mas tarde.";
	            CustomLogger::log($msgResult);
	            log_message('debug',$msgResult);
	            $estadoPeticion = array(
	                            'estado' => DIRECCION_PHP_HTTP_ADAPTER_TIMEOUT_EXCEDIDO,
	                            'msg' => $msgResult);
	        }
            
            if ($arrDatos["estado"] == FALLA_PHP_PETICION_REST_OK) {
   				log_message('debug',"Dentro del if con 'FALLA_PHP_PETICION_REST_OK' ");
            	$calle= $arrDatos["calle"];
            	//$altura= $arrDatos["altura"];
            	$rangoEstimado1= $arrDatos["rangoEstimado1"]; 
            	$rangoEstimado2= $arrDatos["rangoEstimado2"]; 
            	$calleSecundariaA = $arrDatos["calleSecundariaA"];
            	$calleSecundariaB = $arrDatos["calleSecundariaB"];
   				
   				log_message('debug',"calle: ");
   				log_message('debug', $calle);
   				log_message('debug',"rangoEstimado1: ");
   				log_message('debug', $rangoEstimado1);
   				log_message('debug',"rangoEstimado2: ");
   				log_message('debug', $rangoEstimado2);
   				log_message('debug',"calleSecundariaA: ");
   				log_message('debug', $calleSecundariaA);
   				log_message('debug',"calleSecundariaB: ");
   				log_message('debug', $calleSecundariaB);
   				log_message('debug',"");
            }
            
            # Se busca si la calle esta cargada como calle primaria
            # en la BD(sino esta se carga automaticamente en buscarCalle) y luego se instancia el obj. direccion de la falla, con:
            #   - callePrincipal como la calle obtenida por medio de la api de Google
            #   -calleSecundariaA y calleSecundariaB se obtienen por medio de la API de geonames, como la interseccion mas cercada a la calle donde se encuentra localizada la falla.

            $datosDireccion = array('callePrincipal' =>$calle,
                                    'calleSecundariaA' => $calleSecundariaA,
                                    'calleSecundariaB' => $calleSecundariaB,
                                    'altura' => $altura,
                                    'rangoEstimado1' =>$rangoEstimado1,
                                    'rangoEstimado2' =>$rangoEstimado2
                                 	);
            $dir = Direccion::insertarDireccion((object)$datosDireccion);
			
			#Se instancia el tipo de falla como "Bache".
           	$tipoFalla = TipoFalla::getTipoFallaPorNombre($nombreTipoFalla);

            #Se instancia el  tipo de material a la falla (Id=0 por defecto)
            $tipoMaterial = TipoMaterial::getTipoDeMaterialPorNombre($nombreTipoMaterial);


			#Se instancia la criticidad media(id=2 por defecto).
           	$crit = Criticidad::getCriticidadPorNombre($nombreCriticidad);

           	$tipoRep = TipoReparacion::getTipoReparacionPorNombre($tipoReparacion);

           	log_message('debug',"Instanciando falla...");
				//NOTA: El tipoReparacion se carga desde el sistema web, cuando la falla haya sido reparada.Como esta es una falla recien descubierta es una falla que no tiene un tipoReparacion asociado aun.
            //Se instancia la falla
            $falla = new Falla();
            //$falla->id = $datos->id;
			$falla->latitud = $lat;
			$falla->longitud = $long;
			$falla->direccion = $dir;
			$falla->criticidad = $crit;
			$falla->tipoFalla = $tipoFalla;
			$falla->tipoMaterial = $tipoMaterial;
			$falla->tipoReparacion = $tipoRep;

			//Se guarda la Falla en BD y se le asigna el nuevo ID
			$idFallaNueva = $falla->save();
			$falla->id = $idFallaNueva;
			log_message('debug','Falla nueva agregada con ID ');
			log_message('debug',$idFallaNueva);
			
			log_message('debug','Datos asociados a la falla: ');
			log_message('debug','idDireccion: ');
			log_message('debug',$dir->id);
			log_message('debug','idCriticidad: ');
			log_message('debug',$crit->id);
			log_message('debug','tipoFalla: ');
			log_message('debug',$tipoFalla->id);
			log_message('debug','++++++++++++++++++++++++++++++++++ ');

			//Se asocia una observacion enviada por la appCliente
			$dataObservacion = (object)(array(
										'comentario' => $observacion, 
										'nombreObservador' => NOMBRE_EMPLEADO_VIAL_DEFAULT, 
										'emailObservador' => EMAIL_EMPLEADO_VIAL_DEFAULT 
												)); 

			$observacion = new Observacion($dataObservacion,date("Y-m-d H:i:s"));
			$observacion->falla = $falla;
			$observacion->save();
			log_message('debug','Observacion Guardada!!!');
		
			//Se asocia el estado confirmado a la falla en BD
			log_message('debug','Configurando el estado...');
			$falla->estado = new Confirmado();
			$falla->estado->falla = $falla;
			$falla->estado->tipoEstado = TipoEstado::getTipoEstadoPorNombre($tipoEstado);
			log_message('debug','Instanciado el estado...');
			$falla->estado->id = $falla->estado->save();
			log_message('debug','Guardado en BD estado!');
			
			log_message('debug','Asociando estado a falla...');
			//Este metodo modifica la FallaEstadoModelo para
			//mantener la secuencia de estados de una falla.
			$idFallaEstado = $falla->asociarEstado();
           	log_message('debug',"Falla nueva guardada!! ");
           	log_message('debug',"idFallaEstado =  ");
           	log_message('debug',$idFallaEstado);

           	//Se agrega el idFallaNueva generado a la respuesta.
           	$datosFallaNueva = array(
            						'idFallaNueva' => $idFallaNueva
            						);
           	$estadoPeticion['dataFalla'] = $datosFallaNueva;
            return $estadoPeticion;
	   	}
	 
	 //Asocia una captura previamente almacenada en el servidor, a una falla existente. 
	 public static function asociarCapturaAFalla($idFalla,$nombre_archivo){
	 	log_message('debug', 'En asociarCapturaAFalla ...');
	 	log_message('debug', 'idFalla: ');
	 	log_message('debug', $idFalla);
	 	log_message('debug', 'nombre_archivo: ');
	 	log_message('debug', $nombre_archivo);
	 	log_message('debug', '--------------------------------------------- ');
        $multimediaCaptura = new Multimedia();
        $multimediaCaptura->nombreArchivo = $nombre_archivo;
        $id_nuevo_mult = $multimediaCaptura->save();

        log_message('debug', 'Despues de guardar objeto MultimediaModelo ...');

	 	log_message('debug','Guardando FallaMultimedia');
        $obj_fallamult = new FallaMultimedia();
        $obj_fallamult->idFalla = $idFalla;
        $obj_fallamult->idMultimedia = $id_nuevo_mult;
        $obj_fallamult->save();
	 	log_message('debug', 'Fin de asociarCapturaAFalla ...');
	 }

    public function esCalle($calle)
    {
    	return $this->direccion->esCalle($calle);
    }

    public function esEstadoActual($estado)
    {
    	return $this->estado->esEstadoActual($estado);
    }

    static public function getFallasPorTipoFalla($idTipoFalla)
    {
    	$CI = &get_instance();
    	try {	    		
			$idsFalla = $CI->FallaModelo->getFallasPorTipoFalla($idTipoFalla);
    	} catch (MY_BdExcepcion $e) {
    		$idsFalla = array();
    	}
		$fallas = array();
		foreach ($idsFalla as $key => $value) {
			array_push($fallas, Falla::getInstancia($value->id));
		}
		return $fallas;
    }

    static public function getFallasPorCalle($idTipoFalla, $calle)
    {
    	$fallas = self::getFallasPorTipoFalla($idTipoFalla);
    	$fallasPorCalle = array();
    	foreach ($fallas as $key => $value) {
    		if (!strcmp($value->direccion->callePrincipal->nombre, $calle)) {
    			array_push($fallasPorCalle, $value);
    		}
    	}
    	return $fallasPorCalle;
    }

	}
 ?>