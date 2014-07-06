<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/*
  Clase que interactua con la base de datos, efectuando un tipo de operacion de BD (SELECCION, INSERCION, BORRADO o ACTUALIZACION) 
  y realiza la jsonizacion de los elementos para el cliente. Esta clase contiene los siguientes metodos:
    -->obtenerTodasFilasTabla() --> Este metodo realiza la seleccion de los elementos de la BD.(SELECCION)
    -->insertarFilaTabla() --> Realiza la inserción de elementos en la BD.(INSERCION)
    -->borrarElementoTabla() -->Realiza el borrado de elementos de la BD.(BORRADO)
    -->actualizarElementoTabla() -->Realiza la actualizacion de uno o mas elementos en la BD(ACTUALIZACION)

  Esta clase utiliza codigos de estado para indicar el estado de las operaciones seleccionadas,retornando para ello un JSON con el 
  siguinete formato en cada petición:
     {"resultado": <CODIGO CORRESPONDIENTE> ,"descripcion":<DESCRIPCION BREVE DEL PROBLEMA OCURRIDO> "datos": <ARREGLO CON LOS DATOS DE LA OPERACION>}

  Esta clase define los siguientes codigos de estado, numerados segun el tipo de operacion de BD:
    -->100 Codigos de estado para el tipo de operacion de SELECCION. 
        -->103 Respuesta vacia.
    -->200 Codigos de estado para el tipo de operacion de INSERCION. 
        -->201 Se inserto correctamente el bache
        -->203 El bache ya existe
    -->300 Codigos de estado para el tipo de operacion de BORRADO. 
    -->400 Codigos de estado para el tipo de operacion de ACTUALIZACION. 
    -->500 Codigos de estado OK para cualquier tipo de operación. 
    -->501 Error en el servidor .

  Se debe copiar ConsultaJSON.php dentro de application/libraries.
*/
class ConsultaJSON {
    public $json;
    public function __construct()
    {
        //Cargamos la librería JSON-PHP
        $CI=& get_instance();
        $CI->load->library('Services_JSON');
    }

    /*setConexion: Establece la conexion hacia la BD por medio de una 
     connectionString con el sigueinte formato: 'postgre://adminpepe:adminpepe@localhost/alumnos'.
    */
    public function setConexion($dsn)
    {
        $CI=& get_instance();
        $CI->load->database($dsn); 
    }

	  /*Este metodo retorna la query y toma como argumento el nombre de la tabla y las propiedades,
     retornando la $query con las rows. Opcionalmente se puede enviar un criterio como un arreglo.
     El criterio es un array asociativo donde $criterio['campo'] es el campo de la BD y 
     $criterio['valor'] es el valor de dicho campo en la BD. Si no se desea seleccionar un criterio de busqueda,
     se envia NULL como tercer argumento.
    Este metodo debería ir en un objeto de libreria propio. en application/libraries. */
    public function seleccionar($tabla,$props,$criterios)
    {
        $CI=& get_instance();
        $cad="";
        foreach ($props as $elem)
        {
          //TODO Corregir la comma al final para el ultimo >:(!
            $cad.=$elem.',';       
        }
        $CI->db->select($cad);
        if($criterios!=NULL){
          foreach ($criterios as $criterio)
          {
            $CI->db->where($criterio["campo"],$criterio["valor"]);
          }    
        }
        $query = $CI->db->get($tabla);
        return $query;
    }
    
   	public function transformarAJSON($query){
      //Variables para indicar el estado de la conexion
      $codigoEstado=500;
      $descripcion="Datos obtenidos correctamente";
      //Declaramos un nuevo objeto JSON
      $json = new Services_JSON();
      //Si no hay filas se retorna un json vacio
      if ($query->num_rows() == 0)
      {
        $codigoEstado=103;
        $descripcion="No existen elementos cargados que coincidan con este criterio de busqueda";
      }
      //Declaramos un nuevo objeto JSON
      $json = new Services_JSON();
      //Arreglo que contendra cada una de las filas de la tabla
      $datos = array();
      foreach ($query->result() as $row)
      {
          $datos[]=$row;
      }
      $datosReales= array('codigo' =>$codigoEstado,'descripcion'=>$descripcion,'datos'=>$datos);
      return $json->encode($datosReales);
   	}

    /* Metodo que se utiliza para obtener todas las filas de una tabla determinada(SELECT SQL.) y jsonizar la respuesta*/
   	public function obtenerTodasFilasJSON($tabla,$props,$criterios){
   		$consulta= new ConsultaJSON();
      $query=$consulta->seleccionar($tabla,$props,$criterios);
   		return $consulta->transformarAJSON($query);
   	}

    /*Este metodo realiza un join entre tablas solamente por ID, donde:
      $nombreTablaDestino: string con el  nombre de la tabla de la que se filtrarán las consultas
      $propsDestino: array asociativo con los campos de la tabla de destino que serán filtrados por la consulta. 
                    Se debe enviar el nombre del  "id" que será utilizado para realizar el join entre las tablas.
      $nombreTablaOrigen: String con el nombre de la tabla sobre la que se realizará la cruza entre tablas..
      $propsOrigen:  array asociativo con los campos de la tabla de origen que serán filtrados por la consulta. 
                    Se debe enviar el nombre del "id" que será utilizado para realizar el join entre las tablas.
      $criteriosFiltrado: array asociativo indicando los criterios de filtrado para las tuplas que resultan de un JOIN.
      Se puede enviar el valor NULL en caso de que no se desee filtrar por ningun criterio.
    */
    public function cruzarTablas($nombreTablaDestino,$propsDestino,$nombreTablaOrigen,$propsOrigen,$criteriosFiltrado)
    {
        $CI=& get_instance();
        //$CI->db->select('*');
        //Se concatenan los nombres de las tablas
        $CI->db->from($nombreTablaDestino);
        $CI->db->join($nombreTablaOrigen, "$nombreTablaDestino.".$propsDestino["id"]." = $nombreTablaOrigen.".$propsOrigen["id"]."");
        //Se filtran las tuplas en base a uno o mas criterios
        if($criteriosFiltrado!=NULL){
          $CI->db->where($criteriosFiltrado);
        }
        //$CI->db->where("Calle.nombre","Irigoyen");
        $query = $CI->db->get();   
        return $query;
    }

    /*Metodo que retorna las filas de una tabla cuyo id coincide con los ids de otra tabla.*/
    public function obtenerFilasRelacionadas($nombreTablaDestino,$propsDestino,$nombreTablaOrigen,$propsOrigen,$criteriosFiltrado){
      $consulta= new ConsultaJSON();
      $query=$consulta->cruzarTablas($nombreTablaDestino,$propsDestino,$nombreTablaOrigen,$propsOrigen,$criteriosFiltrado);
      return $consulta->transformarAJSON($query);           
    }
    //BACKUP
    // public function insertarCriticidad($criticidad)
    // { 
    //     $CI=& get_instance();
    //     $result=$CI->db->insert("Criticidad",$criticidad);
    //     //Se debe obtener el ID de la ultima criticidad registrada
    //     //$result=$CI->db->count_all('Criticidad');
    //     return $CI->db->insert_id();
    // }  

    public function seleccionarCriticidad($criticidad)
    { 
      $CI=& get_instance();
      echo "criticidad=".$criticidad;
      $CI->db->select("id")->where("nombre","$criticidad");
      $query=$CI->db->get('Criticidad');
      //Se retorna el primer id
      foreach ($query->result() as $row)
      {
          return $row->id;
      }
    }
    public function insertarCalle($calle)
    { 
        $CI=& get_instance();
        $result=$CI->db->insert("Calle",$calle);
        //Se debe obtener el ID de la ultima calle registrada
        //$result=$CI->db->count_all('Calle');
        return $CI->db->insert_id();
    }  

    public function insertarBache($bache,$id_criticidad,$id_calle)
    { 
        $CI=& get_instance();
        $result=$CI->db->insert("Bache",array("latitud"=>$bache['latitud'],"longitud"=>$bache['longitud'],
          "idCriticidad"=>$id_criticidad,"idCalle"=>$id_calle));
        //$result=$CI->db->count_all('Bache');
        return $CI->db->insert_id();
    }

    /*Este metodo realiza la inserción de los baches en la BD.*/
    public function registrarBache($datosJSONizados)
    {
        $CI=& get_instance();
        //Se carga la libreria para decodificar el JSON
        $CI->load->library('Services_JSON');
        $json = new Services_JSON();
        //Se decodifican los valores en JSON, conviertiendolos en un array asociativo
        //$datosDesJSONizados= $json->decode($datosJSONizados);
        $datosDesJSONizados = json_decode($datosJSONizados,TRUE);
        //Se selecciona la criticidad enviada por JSON.
        //$criticidadRow=$this->seleccionar("Criticidad",array("id","nombre"),array("criterio" => "nombre","valor" => $datosDesJSONizados['criticidad']));
        
        $idCriticidad=$this->seleccionarCriticidad($datosDesJSONizados['criticidad']);
        $idCalle=$this->insertarCalle(array("nombre" => $datosDesJSONizados['calle']));
        $idBache=$this->insertarBache(array("latitud" => $datosDesJSONizados['latitud'],"longitud" => $datosDesJSONizados['longitud']),$idCriticidad,$idCalle);
        //Se arma el JSON y se retorna como respuesta.
        $codigoEstado=201;
        $descripcion="Se inserto correctamente el bache";
        return $json->encode(array('codigo' =>$codigoEstado,'descripcion'=>$descripcion,
          'datos'=> array("id" =>$idBache,  "latitud" => $datosDesJSONizados['latitud'],"longitud" => $datosDesJSONizados['longitud'], "idCriticidad" => $idCriticidad ,"idCalle" =>$idCalle)));

        //Backup!
        // return $json->encode(array("id" =>$idBache,  "latitud" => $datosDesJSONizados['latitud'],"longitud" => $datosDesJSONizados['longitud'],
        //  "idCriticidad" => $idCriticidad ,"idCalle" =>$idCalle));
    }

    public function obtenerCriticidades(){
        $CI=& get_instance();
        //Se carga la libreria para decodificar el JSON
        $CI->load->library('Services_JSON');
        $json = new Services_JSON();
        $query=$this->seleccionar("Criticidad",array("nombre"),NULL);
        return $this->transformarAJSON($query);    
    }

}
?>