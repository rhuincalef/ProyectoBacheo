<?php
 
class Pcd_upload_model extends CI_Model
{


     public static function generarCsv($dir,$nombre_archivo,$content) {
        $data_array = explode("\n",$content);
        $csv = ""; //String de salida
        foreach ($data_array as $record){
            $csv.= $record."\n"; //Append data to csv
        }           
        $ruta = $_SERVER['DOCUMENT_ROOT']."/repoProyectoBacheo/web/".$dir."/".$nombre_archivo;
        // Se appendea la data al archivo si ya existe en el servidor.
        $csv_handler = fopen ($ruta,'a+');
        $res = fwrite ($csv_handler,$csv);
        fclose ($csv_handler);
        return $res;
    } 


    //Crea un directorio con permisos de escritura dado por parametro
    public static function  crearDir($upload_path){
        $anterior = umask();
        umask(0);
        mkdir($upload_path);
        //chmod($upload_path, 0777);
        umask($anterior);
    }



    // Almacena el .csv en la carpeta de la falla,inserta la tupla en Multimedia, y retorna TRUE si se pudo realizar y FALSE en caso contrario.
    // NOTA IMPORTANTE: La peticion se debe hacer con el siguiente JSON PARA QUE FUNCIONE:
    // { "id": 8, "nombre_captura": "<CUALQUIER NOMBRE>.csv"}
    // https://www.codeigniter.com/userguide3/libraries/file_uploading.html
    public function subir_falla($datosPeticion){
        $estadoPeticion = array();
        $estadoInicializarAnonima = array();
        $info = ""; //Var. para guardar la info de logging de appCliente
        $estadoGeocoding = 0; //Var para almacenar el codigo de error de las operaciones de geocoding

        log_message('debug', 'Estoy en subir_falla() ...');    
        #Se verifica si es un bache nuevo o un bache informado obtenido del server
        log_message('debug', 'valores enviados en el cuerpo');
        log_message('debug', '$datosPeticion["id"]');
        log_message('debug', $datosPeticion["id"]);
        log_message('debug', '$datosPeticion["latitud"]');
        log_message('debug', $datosPeticion["latitud"]);
        log_message('debug', '$datosPeticion["longitud"]');
        log_message('debug', $datosPeticion["longitud"]);
        
        log_message('debug', 'is_numeric(id) retorno: ');
        log_message('debug', is_numeric($datosPeticion['id']) );
        
        try {

            $idFallaEnviado = $datosPeticion['id'];
            if ( is_numeric($datosPeticion['id']) !== TRUE) {
                log_message('debug', 'ID NO NUMERICO, es un bache nuevo con lat y long');
                log_message('debug', 'ID = ');
                log_message('debug', $datosPeticion['id']);

                $estadoInicializarAnonima = Falla::inicializarFallaAnonima(
                                $datosPeticion['latitud'],
                                $datosPeticion['longitud'],
                                $datosPeticion['nombreTipoFalla'],
                                $datosPeticion['nombreTipoMaterial'],
                                $datosPeticion['nombreCriticidad'],
                                $datosPeticion['observacion'],
                                $datosPeticion['tipoEstado'],
                                $datosPeticion['tipoReparacion']
                                                );

                //Error en inicializarFallaAnonima, se adjunta al mensaje el error a la salida final.
                if ($estadoInicializarAnonima["estado"] !== FALLA_ANONIMA_INICIALIZADA_OK) {
                    $cad = "Error API externa(codigo=".$estadoInicializarAnonima["estado"]."; info= ".$estadoInicializarAnonima["msg"].")";
                    $info .= $cad;
                    $estadoGeocoding = $estadoInicializarAnonima["estado"]; 
                }
                $idFallaEnviado = $estadoInicializarAnonima["dataFalla"]["idFallaNueva"];


            }else{
                log_message('debug', 'ID NUMERICO VALIDO, es un bache informado existente');
                log_message('debug', 'ID = ');
                log_message('debug', $datosPeticion['id']);
            } //Fin if-else


            log_message('debug', 'idFallaEnviado tiene un nuevo valor:');
            log_message('debug', $idFallaEnviado );
            
            $archivosSubidos = $this->subir_archivo($idFallaEnviado);
            log_message('debug', 'Guardado los objetos FallaMultimedia en BD...');
            foreach ($archivosSubidos as $nombArchivo) {
                log_message('debug', 'Asociando nombArchivo a falla ');
                log_message('debug', $nombArchivo);
                Falla::asociarCapturaAFalla($idFallaEnviado,$nombArchivo);
            }

            log_message('debug', 'Objetos FallaMUltimedia guardados!');
            //Se arma la respuesta a la appCliente con:
            //      -estado: estado del registro de la falla en el servidor 
            //      -infolog: informacion para loguear desde appCliente,si ocurre un fallo o no, con respecto a la obtencion de los datos de las direcciones en el servidor.
            $info = "Falla ".$idFallaEnviado.":"." Capturas subidas correctamente al servidor! ". $info;
            $estadoPeticion = array(
                                    'estado' =>DIRECCION_PHP_FALLA_REGISTRADA_OK ,
                                    'estadoGeocoding' => $estadoGeocoding,
                                    'infolog' => $info
                                    );

        }catch (ExcepcionLatLng $e){
            $info = "Falla ".$idFallaEnviado.":"." ExcepcionLatLng ocurrio. Latitud o longitud invalidas.";
            CustomLogger::log($info);
            $estadoPeticion = array(
                            'estado' => DIRECCION_PHP_LAT_LONG_NO_VALIDAS,
                            'estadoGeocoding' => $estadoGeocoding,
                            'infolog' => $info );
        
        }catch (ExcepcionCalleFueraCiudad $e){
            CustomLogger::log($e->getMessage());
            log_message('debug',$e->getMessage());
            $info = "Falla ".$idFallaEnviado.": ".$e->getMessage();
            $estadoPeticion = array(
                            'estado' => DIRECCION_PHP_LAT_LONG_FUERA_CIUDAD,
                            'estadoGeocoding' => $estadoGeocoding,
                            'infolog' => $info);

        }catch (Exception $e){
            $info = "Falla ".$idFallaEnviado.":"." Excepcion ('Exception') desconocida al ejecutar la consulta subir_falla()";
            CustomLogger::log($info);
            $estadoPeticion = array(
                            'estado' => DIRECCION_PHP_EXCEPCION_GENERICA,
                            'estadoGeocoding' => $estadoGeocoding,
                            'infolog' => $info);
        }finally{

            return $estadoPeticion;
        }

    }


    public function subir_archivo($carpetaFalla){

        log_message('debug', "Iniciando subir_archivo()... ");
        $PCD_UPLOAD_FOLDER = "_/dataMultimedia/".$carpetaFalla;
        //Se obtiene la instancia de la falla en el servidor, y se  
        // $falla = Falla::getInstancia($id);
        
        // Leer archivos enviados (desde $_FILES) por POST desde CI -->
        // https://www.codeigniter.com/userguide2/libraries/file_uploading.html
        $config['upload_path'] = $_SERVER['DOCUMENT_ROOT']."/repoProyectoBacheo/web/".$PCD_UPLOAD_FOLDER."/";
        $this->crearDir($config['upload_path']);
        
        //$config['allowed_types'] = '*';
        $config['allowed_types'] = 'text|txt|csv';
        $config['overwrite'] = FALSE;
        $config['max_size'] = '0';

        // Se inicializa la libreria upload con los valores de configuracion. 
        $this->load->library('upload',$config);
        $this->upload->initialize($config);


        log_message('debug', '$config["upload_path"] construido es ...');
        log_message('debug', $config['upload_path']);
        $archivosSubidos = array();
        //Se recorre el array de archivos enviados en $_FILES
        foreach($_FILES as $nombre_archivo=>$dataArchActual){
            if ($this->upload->do_upload($nombre_archivo) ) {
                $res = TRUE;
                log_message('debug', 'HECHO EL UPLOAD! ');
            }else{
                $res = FALSE;
               log_message('debug', 'ERROR EN UPLOAD! ');
            }
            log_message('debug', "config.file_name tiene: ");
            log_message('debug',  $this->upload->data()["file_name"]);
            log_message('debug', "config.file_type tiene: ");
            log_message('debug',  $this->upload->data()['file_type'] );
            log_message('debug', "config.file_size (Kb) tiene: ");
            log_message('debug',  $this->upload->data()['file_size'] );
            array_push($archivosSubidos, $nombre_archivo);
        }
        log_message('debug', "Fin de subir_archivo()... ");
        return $archivosSubidos;
    }


    # Retorna solo las fallas con estado "informada".
    # NOTA: La herramienta de debugging envia los msg del servidor en las  cabeceras HTTP, desactivar el debugging del lado del server cuando se pruebe este metodo con la app, sino produce error de cabecera muy larga con requests.   
    public function obtener_informados($calle){
        require_once('CustomLogger.php');
        CustomLogger::log('EN Pcd_upload_model.obtener_informados()...');
        
        log_message('debug', 'EN Pcd_upload_model.obtener_informados()...');
        
        $calleDecodificada = urldecode($calle);
        log_message('debug', "la calle convertida es: ");
        log_message('debug', $calleDecodificada);
        log_message('debug', "--------------+++++++-------------------");

        $fallas = Falla::getAll();
        $codigo = 300;
        $mensaje = "No hay elementos para mostrar";
        $data = array();
        if(count($fallas) != 0)
        {
            $codigo = 200;
            CustomLogger::log("Cantidad de fallas leidas son:".count($fallas));
            foreach ($fallas as $f) {
                $array_falla = NULL;
                //Se filtran solo las fallas informadas en base al estado de c/u.
                $array_falla = $f->filtrar($calleDecodificada);

                if ($array_falla != NULL) {
                    $data[$f->getId()] = $array_falla;
                }
            }
        }
        $respuesta = array('codigo' => $codigo, 'datos' => $data);
        //return $data;
        return $respuesta;
    }



    
}


?>