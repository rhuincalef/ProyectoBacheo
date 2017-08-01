<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Direccion
	{
		
		var $id;
		var $callePrincipal;
		var $altura;
		var $calleSecundariaA;
		var $calleSecundariaB;
		//AGREGADO RODRIGO
		var $rangoEstimado1;
		var $rangoEstimado2;		
		
		function __construct()
		{
			switch (count(func_get_args()))
			{
				case 1:
					return call_user_func_array(array($this,'constructor'), func_get_args());
					break;
				default:
					break;
			}
		}

		public function constructor($datos)
		{
			$this->altura = $datos->altura;
			$this->callePrincipal = $datos->callePrincipal;
			$this->calleSecundariaA = $datos->calleSecundariaA;
			$this->calleSecundariaB = $datos->calleSecundariaB;
		}

		private function inicializar($datos){
			$this->id = $datos->id;
			$this->altura = $datos->altura;
			$this->callePrincipal = Calle::getInstancia($datos->idCallePrincipal);
			$this->calleSecundariaA = Calle::getInstancia($datos->idCalleSecundariaA);
			$this->calleSecundariaB = Calle::getInstancia($datos->idCalleSecundariaB);
			//AGREGADO RODRIGO
			$this->rangoEstimado1 = $datos->rangoestimado1;
			$this->rangoEstimado2 = $datos->rangoestimado2;
		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$direccion = new Direccion();
			$datos = $CI->DireccionModelo->get($id);
			$direccion->inicializar($datos);
			return $direccion;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->DireccionModelo->save($this);
		}

		/*
		* insertarDireccion
		* Devuelve una Direccion. Si no existe se crea la Direccion.
		* @access	public
		* @param    array => array asociativo con los datos de la direccion
		*					 array('callePrincipal' =>, 'altura' =>,'calleSecundariaA' =>, 'calleSecundariaB'=>)
		*/
		static public function insertarDireccion($datosDireccion)
		{
			$CI = &get_instance();
			// Calle::buscarCalle -> Si no existe se crea la calle
			$callePrincipal = Calle::buscarCalle($datosDireccion->callePrincipal);
			$calleSecundariaA = Calle::buscarCalle($datosDireccion->calleSecundariaA);
			$calleSecundariaB = Calle::buscarCalle($datosDireccion->calleSecundariaB);
			$direccion = new Direccion();
			try {
				$buscar = new stdClass();
				$buscar->idCallePrincipal = $callePrincipal->id;
				$buscar->idCalleSecundariaA = $calleSecundariaA->id;
				$buscar->idCalleSecundariaB = $calleSecundariaB->id;
				$buscar->altura = $datosDireccion->altura;
				//AGREGADO RODRIGO
				log_message('debug', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
				log_message('debug', "$datosDireccion->rangoEstimado1");
				$buscar->rangoestimado1 = $datosDireccion->rangoEstimado1;
				$buscar->rangoestimado2 = $datosDireccion->rangoEstimado2;
				$datos = $CI->DireccionModelo->get_by($buscar);
				$direccion->inicializar($datos);
				log_message('debug',"Inicializando direccion guardada anteriormente... ");
			} catch (MY_BdExcepcion $e) {
				log_message('debug',"Excepcion en Direccion.insertarDireccion().Insertando nuevo elemento direccion en BD...");
				$direccion->altura = $datosDireccion->altura;
				//AGREGADO RODRIGO
				$direccion->rangoestimado1 = $datosDireccion->rangoEstimado1;
				$direccion->rangoestimado2 = $datosDireccion->rangoEstimado2;
				$direccion->callePrincipal = $callePrincipal;
				$direccion->calleSecundariaA = $calleSecundariaA;
				$direccion->calleSecundariaB = $calleSecundariaB;
				$direccion->id = $direccion->save();
			}finally{
				return $direccion;
			}

		}

		public function getNombre()
		{
			return $this->callePrincipal->getNombre();
		}

		public function getAltura()
		{
			return $this->altura;
		}

		//Agregado Rodrigo
		public function getRangosEstimados(){
			return array($this->rangoEstimado1, $this->rangoEstimado2);
		}		

		//Obtiene la calle, rangoEstimado1-rangoEstimado2, y calleSecundariaA y calleSecundariaB y retorna un array con esa data. 
	    public static function obtener_datos_direccion_v2($lat,$long){
			$dataCalle = array();
	        
			log_message('debug',"En obtener_datos_direccion_v2()");
	        require_once('CustomLogger.php');
			require_once(GEOCODER_PHP_BASE_PATH.AUTO_LOAD_NAME_COMPOSER);
			require_once(GEOCODER_PHP_BASE_PATH.MODULE_CURL_ADAPTER_HTTP);
			require_once(GEOCODER_PHP_BASE_PATH.EXCEPCION_HTTP_ADAPTER);
			require_once(MODELS_PATH.MODULE_EXCEPCION_LAT_LONG);

			CustomLogger::log('Cargado autoload.php...');
	    	//Tira excepcion esLatLongValida si no es un formato valido de latitud y longitud 
			Direccion::esLatLongValida($lat,$long);
			log_message('debug',"Cargado autoload.php");
	    	$resultado = FALSE;
			$adapter = new Ivory\HttpAdapter\CurlHttpAdapter();
			log_message('debug',"Instanciado CurlHttpAdapter");
	    	$provider = new Geocoder\Provider\GoogleMaps($adapter,null,null,API_KEY_GOOGLE_MAPS);
			log_message('debug',"Instanciado provider\GoogleMaps !");

			$addr_objects = $provider->reverse($lat, $long);
			log_message('debug',"Obtenido addr_objects ");

			$calleObj = $addr_objects->get(0);
			if (count($addr_objects->all()) > 0) {
				log_message('debug',"Dentro del if con add_obects >0");
				//Se obtiene la primer Address que tiene los datos de la calle del objeto AddressCollection
		    	$calleObj = $addr_objects->get(0);
		    	$calle = $calleObj->getStreetName();

		    	//Se toma el rango completo de GoogleMaps
				$rangoEstimado1 = explode("-",$calleObj->getStreetNumber())[0];
				$rangoEstimado2 = explode("-",$calleObj->getStreetNumber())[1];
				
		    	// Se obtienen las calles en la interseccion mas cercana a
		    	// las fallas.
		    	CustomLogger::log('Llamando a obtener_interseccion()...');
				log_message('debug','Llamando a obtener_interseccion()...');
		        $calleSecundariaA = $calleSecundariaB = $calle;
		        $datos = Direccion::obtenerIntersecCercana($lat,$long);
				log_message('debug','Despues de obtenerIntersecCercana()...');

		        if ($datos['estado'] !== DIRECCION_PHP_INTERSECCION_TIMEOUT_EXCEDIDO and $datos['estado'] !== DIRECCION_PHP_PETICION_INTERSECCION_FALLIDA ) {

		        	$calleSecundariaA = $datos["datos"]["calle1"];
		        	$calleSecundariaB = $datos["datos"]["calle2"];
		        }
		        // Se instancia el array con todos los datos de la calle 
		        // donde se encuentra la falla.
		        $dataCalle = array(
								'estado' => DIRECCION_PHP_PETICION_GEOCODING_OK,
								'calle' =>$calle ,
								'rangoEstimado1' =>$rangoEstimado1,
								'rangoEstimado2' =>$rangoEstimado2,
								'calleSecundariaA' => $calleSecundariaA,
								'calleSecundariaB' => $calleSecundariaB
								);
		        log_message('debug','Retornado ok data completa de la calle...');

			}else{
				$msgResult = "No se pudieron resolver los datos de la direccion asociada a las coordenadas proporcionadas"; 
				CustomLogger::log($msgResult);
		        log_message('debug',$msgResult);
	        	$dataCalle = array(
	        				'estado' => DIRECCION_PHP_DIRECCION_NO_RETORNADA,
							'msg' => $msgResult );
			}
	        log_message('debug',"En el return datacalle; con dataCalle cargado...");
	        return $dataCalle;
	    }

	    //AGREGADO RODRIGO
	    // PRUEBA WEB CON --> http://mygeoposition.com/

	//La peticion para Patagonia e Hipolito Irigoyen: http://api.geonames.org/findNearestIntersectionOSMJSON?formatted=true&lat=-43.2661595&lng=-65.2882451&username=demo&style=full
	    //Tiene que dar la sig. respuesta -->
	    // {
	    // "intersection": {
		//  "street2Bearing": "137",
		//  "lng": "-65.2881281",
		//  "distance": "0.02",
		//  "countryCode": "AR",
		//  "highway1": "residential",
		//  "highway2": "secondary",
		//  "street1": "Patagonia",
		//  "street2": "Av. Hipólito Yrigoyen",
		//  "street1Bearing": "44",
		//  "lat": "-43.26602"
		// 						}
		// }

	    public static function obtenerIntersecCercana($lat,$long){
	    	require_once('CustomLogger.php');
	        CustomLogger::log('El APP_CLIENTE_ID es:');
	        CustomLogger::log(APP_CLIENTE_ID);
	       
			require_once(GEONAMES_BASE_PATH.AUTO_LOAD_NAME_COMPOSER);
			//require_once(GEONAMES_BASE_PATH.MODULE_GEONAMES_PATH);
			//require_once(GEONAMES_BASE_PATH.MODULE_RESPONSE_PATH);

	    	$client = new \spacedealer\geonames\api\Geonames(APP_CLIENTE_ID);
	    	$msg = "";
	    	$estado = 0;
	    	$datos = array();
			try {
			    $response = $client->findNearestIntersectionOSM([
			        'lat' => $lat,
			        'lng' => $long,
			        'username'=> APP_CLIENTE_ID]);
			    if ($response->isOk()) {
	        		CustomLogger::log("Respuesta correcta con lat: ".$lat);
	        		CustomLogger::log("La respuesta es ");
	        		CustomLogger::log($response["street1"]);
	        		CustomLogger::log($response["street2"]);
	        		CustomLogger::log($response["distance"]);
	        		CustomLogger::log("------------------------------- ");

	        		$calle1 = $response["street1"];
	        		$calle2 = $response["street2"];
	        		$distancia = $response["distance"] * 1000; #Se pasa a mts la distancia. Por default en km.
			        $estado = DIRECCION_PHP_PETICION_GEOCODING_OK;
			        $msg= "OK";
			        $datos = array(
			        				"calle1" => $calle1,
			        				"calle2" => $calle2,
			        				"distancia" => $distancia
			        				);
			    } else {
			    	$estado = DIRECCION_PHP_PETICION_INTERSECCION_FALLIDA;
			        $msg = "Error en la peticion: ".$response->getPath('message').PHP_EOL;
			        log_message('debug',"--------------------------------------------------");
			        log_message('debug',"");
			        log_message('debug',"Error en la peticion");
			        log_message('debug',"Instanciando falla...");
			        log_message('debug',"Instanciando falla...");
			        log_message('debug',"Instanciando falla...");
	        		CustomLogger::log("Error en la respuesta: ".$estado);
	        		CustomLogger::log($msg);
			    }
			} catch (\RuntimeException $e) {
			    $estado = DIRECCION_PHP_INTERSECCION_TIMEOUT_EXCEDIDO;
			    //$msg = "RuntimeException: ". $e->getMessage() . PHP_EOL;
			    $msg = "Timeout excedido obtener interseccion (no se puede resolver host geonames).";
	        	log_message('debug',"-------------------------------------------------");
	        	log_message('debug',"Estado de la peticion:");
	        	log_message('debug',$estado);
	        	log_message('debug',"Mensaje:");
	        	log_message('debug',$msg);
	        	log_message('debug',"");
	        	log_message('debug',"-------------------------------------------------");
	        	CustomLogger::log("Error en la respuesta: ".$estado);
	        	CustomLogger::log($msg);
			}finally{
				return array( 'estado' => $estado,
							  'mensaje' => $msg,
							  'datos' => $datos
							);
			}
	    }

	    //Verifica si lat y long son validas contra una regex
	    public static function esLatLongValida($lat,$lng){
	    	if (!preg_match(REGEX_LAT_LONG, $lat)) {
	            throw new ExcepcionLatLng('Invalid latitude');
	        }

	        if (!preg_match(REGEX_LAT_LONG, $lng)) {
	            throw new ExcepcionLatLng('Invalid longitude');
	        }
	    }

	    //Retorna TRUE si las coordenadas de la la calle pertenecen a una calle dentro de la ciudad de TW.
	    //URL de prueba  para Trelew-->
	    //http://localhost/repoProyectoBacheo/web/restapi/es_calle_valida/latitud/-43.2613433/longitud/-65.2985527
	    //URL de prueba para Puerto Madryn
	    //http://localhost/repoProyectoBacheo/web/restapi/es_calle_valida/latitud/-42.753839/longitud/-65.055183

	    //INSTALACION DE Geocoder con composer-->
	    // 1. $ sudo apt-get install curl php5-cli git
	    // 2. $ curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
	    // 3. $ IR al directorio de instalacion de geocoder, donde se desea que
	    // se instale el directorio vendor/ con el autoload.php usado para
	    // cargar todas las dependencias de Php.
	    // 4. $ cd /var/www/html/repoProyectoBacheo/web/
	    // 5. $ mkdir geocoder 
	    // 6. $ cd geocoder 
	    // 7. sudo chmod -R 777 vendor/
	    // 4. $ composer require willdurand/geocoder
	    public static function estaCalleEnCiudad($lat,$long){
			require_once('CustomLogger.php');
			CustomLogger::log('Dentro de es_calle_valida()...');
			require_once(GEOCODER_PHP_BASE_PATH.AUTO_LOAD_NAME_COMPOSER);
			require_once(GEOCODER_PHP_BASE_PATH.MODULE_CURL_ADAPTER_HTTP);
			CustomLogger::log('Cargado autoload.php11111111111 ...');
			try {
				$adapter = new Ivory\HttpAdapter\CurlHttpAdapter();
		    	$provider = new Geocoder\Provider\GoogleMaps($adapter,null,null,API_KEY_GOOGLE_MAPS);
				CustomLogger::log('Registrado provider111111111111 ...');
				$addr_objects = $provider->reverse($lat, $long);
					//Se obtiene la primer Address que tiene los datos de la calle
		    	// del objeto AddressCollection
		    	$calle = $addr_objects->get(0);
		    	CustomLogger::log('CALLE TIENE: ');
		    	CustomLogger::log(explode("-",$calle->getStreetNumber())[1].'; '.$calle->getStreetName().'; '.$calle->getLocality());

		    	$calle->getLocality();

		    	if ($calle->getLocality() !== NOMBRE_LOCALIDAD) {
		    		CustomLogger::log('La localidad NO es Trelew!!! es: '.$calle->getLocality());
		    		log_message('debug',"No esta dentro de la ciudad la coordenada!!");
		    		$msg = 'La calle ubicada en ('.$lat.','.$long.')  se encuentra fuera del limites la ciudad';
					throw new ExcepcionCalleFueraCiudad($msg);
		    	}else{
		    		CustomLogger::log('La localidad ES Trelew!!! ');
		    	}
			}catch (Geocoder\Exception\NoResult $e){
		    	log_message('debug',"esCalleValida(): Sin resultados en geocode");
	        }catch (Geocoder\Exception\QuotaExceeded $e){
		    	log_message('debug',"esCalleValida():Cuota excedida");
	        }catch (Geocoder\Exception\UnsupportedOperation $e){
		    	log_message('debug',"esCalleValida():Operacion no permitida");
	        }catch (Geocoder\Exception\InvalidCredentials $e){
		    	log_message('debug',"esCalleValida():API_KEY INVALIDA ");
	        }catch (Ivory\HttpAdapter\HttpAdapterException $e){
		    	log_message('debug',"esCalleValida():Timeout excedido");
	        }
	    }

		public function esCalle($calle)
		{
			return $this->callePrincipal->esCalle($calle);
		}

	}