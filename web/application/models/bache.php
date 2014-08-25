<?php 


//TODO Comentar! Clase de firephp utilizada para la depuración.
require_once('FirePHP.class.php');


//Clase nueva que hereda de la libreria My_model.php.
class Bache extends MY_Model { 
	private $id;
    private $latitud;
	private $longitud;
	private $idCriticidad;
	private $idCalle;
	private $alturaCalle;
    //Atributos usados por la libreria
    public $_table = 'Bache';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
    public $primary_key = 'id';//Sobreescribiendo el id por defecto.
    //Relacion 1:1 a criticidad y calle desde Bache. 
    //-->Con belongs_to la el bache tiene clave foranea hacia la calle y hacia la criticidad. Cuando se especifica una relacion
        //belongs_to se especifica el modelo (i.e: Calle) y se pasa un array asociativo que posee: nombre de modelo(model) y cual es el 
        // campo que contiene la referencia hacia el modelo(atributo primary_key).

    //-->Con has_many  la tabla del array tiene muchas entradas hacia la tabla actual.

    public $belongs_to = array( 'Calle' => array('model' => 'Calle', 'primary_key' => 'idCalle' ), 'Criticidad' => array( 'primary_key' => 'id' ));
 
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('form', 'url'));
    }

    function getBache($idBache){
        $firephp = FirePHP::getInstance(true);
        $firephp->log("Dentro de getBache().-");
        
        $tuplaBacheConCalle=$this->with("Calle")->get($idBache);
        if(count($tuplaBacheConCalle)==0){
            echo "Error al encontrar bache y calles asociadas";
            return NULL;
        }

        $firephp->log("Tupla con la calle..");
        $firephp->log($tuplaBacheConCalle);

        $this->load->model('Criticidad');
        $tuplaBacheConCriticidad=$this->Criticidad->get($tuplaBacheConCalle->idCriticidad);
        
        $firephp->log("Tupla con la criticidad..");
        $firephp->log($tuplaBacheConCriticidad);

        $datos = array(
            "id" => $tuplaBacheConCalle->id,
            "latitud"=>$tuplaBacheConCalle->latitud,
            "longitud"=>$tuplaBacheConCalle->longitud,
            "alturaCalle"=>$tuplaBacheConCalle->alturaCalle,
            "calle" => $tuplaBacheConCalle->Calle->nombre,
            "criticidad" => $tuplaBacheConCriticidad->nombre,
            "imagenes"=> $this->obtenerImagenes($idBache),
            "observaciones"=>$this->obtenerObservaciones($idBache)
            );

        $firephp->log("Valores asociados obtenidos desde el bache!.");
        $firephp->log($datos);
        return $datos;
    }


    //Este metodo busca la calle en la BD, dividiendo el nombre de la calle por los espacios en blanco.
    //Luego se va concatenando la cadena original y buscando tanto por sus coincidencias con los caracteres
    //mayusculos o minuculos.
    function buscarCalle($nombreCalle){
        $firephp = FirePHP::getInstance(true);
        $firephp->log("Dentro de buscarCalle().");
        $resultado=$this->Calle->get_by('nombre',ucfirst($nombreCalle));
        return $resultado;
    }  //Fin buscarCalle()


    /*Enviar un array asociativo de elementos para dar de alta el bache. el metodo
    retorna el id del bache insertado*/
    function darAltaBache($valores)
    {
        $firephp = FirePHP::getInstance(true);
        $firephp->log("Debugeando con firephp");
        $firephp->log("valores recibidos:");
        $firephp->log($valores);

        //Se obtiene la criticidad asociada al bache
        $this->load->model("Criticidad");
        $idCriticidad = $valores["criticidad"]; //TODO: verificar qeu existe la criticidad. VIENE UN ID CRITICIDAD.
        $firephp->log("idCriticidad: $idCriticidad");

        $this->load->model("Calle");
        $myobj=NULL;
        $idCalle;
        $myobj=$this->buscarCalle(ucfirst(strtolower($valores["calle"])));
        if(!$myobj){
           $firephp->log("No se encontro la calle. Se insertará en la BD.");
           $idCalle = $this->Calle->insertarCalle($valores["calle"]);
           $firephp->log("El id de calle insertado fue: $idCalle");
        }else{
           $firephp->log("calle encontrada! ".$myobj->id);
           $firephp->log($myobj);
           $idCalle = $myobj->id;
        }
        
        $datos = array(
            'latitud'=>floatval($valores["latitud"]),
            'longitud'=>floatval($valores["longitud"]),
            'alturaCalle'=>intval($valores["altura"]),
            'idCalle'=>intval($idCalle),
            'idCriticidad'=>intval($idCriticidad),
            'titulo'=>strval($valores["titulo"])
            );

        $firephp->log("el objeto pasado como archivo para subir es el siguiente: ...");
        $firephp->log($datos);

        $this->load->model("Bache",'bache');
        $firephp->log("aNTES DE L INSERT");
        $this->bache->insert($datos);
        $firephp->log("Se insertaron los datos correctamente!");
        //Se retorna la utlima fila insertada.
        $idBache=$this->db->insert_id();
        $firephp->log("La ultima fila insertada fue:".$idBache);

        $this->load->model("Estado");
        $this->Estado->asociarEstado($idBache,"informado");
        $firephp->log("Se asocio el estado informado al bache!");

        return $idBache;
    }


    /*Si no se puede dar de baja el bache se retorna NULL*/
    function darDeBajaBache($idBache)
    {
        //Ejemplo de baja de bache, NO BORRAR.
        //Nota: El get($id) retorna un valor de la BD en base a su valor de clave primaria pasado como argumento.
        //En este metodo se obtienen las entradas de Calle que estan asociadas con el bache y, se añexan al boejto
        //que retorna el get() como un array asociativo.
        // $tupla=$this->with("Calle")->get($idBache);
        // echo "calle relacionada=".$tupla->Calle->nombre;

        $firephp = FirePHP::getInstance(true);
        $this->load->database();
        $firephp->log("Dentro de darDeBajaBache()");
        $tupla=$this->with("Calle")->get($idBache);
        if(count($tupla)==0){
            $firephp->log("Error al encontrar bache y calles asociadas");
            return NULL;
        }
        //Se elimina el estado del bache.
        $this->load->model("Estado");
        $this->Estado->borrarEstado($idBache);
        $firephp->log("Se borro el estado en la BD!");

        //Se borran las imagenes multimedia asociadas a un bache.
        $this->load->model("Multimedia");
        $this->Multimedia->borrarArchivos($idBache);

        //Se busca desde la tabla de baches, si existe algun otro bache asociado a la calle.
        $baches=$this->get_by("id",$idBache);
        $firephp->log("La cantidad de baches asociados a la calle es: ".count($baches));
        if(count($baches)==0){
            //Se borra la calle si no existe ningun bache que depende de ella.
            $this->load->model("Calle");
            if($this->Calle->borrarCalle($tupla->Calle->id)==NULL){
                $firephp->log("Error al borrar la calle");
                return NULL;
            }
        }

        //Se borran las observaciones del bache
        $this->load->model("Observacion");
        $this->Observacion->borrarObservaciones($idBache);

        //Se elimina el bache
        $this->delete($tupla->id);
        $firephp->log("Se ha borrado el bache de la tabla de Baches!");
        return $idBache;
    }


    //Este metodo dado un idBache, asocia observaciones al mismo con el nombre y el email.
    //Retorna el idOservacion de la observación asociada o NULL si no se puede añadir la observacion.
    //Valores pasados por parámetros: idBache, nombreObservador, emailObservador.
    function asociarObservacion($valores){
        $firephp = FirePHP::getInstance(true);        
        $this->load->model("Observacion");
        $this->Observacion->insertarObservacion($valores);
        $firephp->log("Observación agregada desde asociarObservacion().");
    }


    // Este metodo retorna las observaciones asociadas a un arreglo en particular
    function obtenerObservaciones($idBache){
        $firephp = FirePHP::getInstance(true);        
        $firephp->log("Dentro de obtenerObservaciones()");   
        $this->load->model("Observacion");
        $obs=$this->Observacion->get_many_by('idBache',$idBache);
        $firephp->log("Observacioens obtenidas...");   
        $firephp->log($obs);   
        return $obs;
    }

    //Este metodo obtiene las rutas de las imagenes para un determinado idBache.
    //retorna una arreglo con las rutas relativas al servidor.
    //Si no existe ninguan imagen asociada retorna un array vacio.
    function obtenerImagenes($idBache){
        $firephp = FirePHP::getInstance(true);        
        $firephp->log("Dentro de obtenerImagenes()");  
        $this->load->model("Multimedia");
        // NOTA: El metodo get_many_by() retorna un array  de imagenes asociadas
        // con un bache particular.
        $imgsBD=$this->Multimedia->get_many_by('idBache',$idBache);
        $firephp->log("Creando arrays de rutas-cant elementos:".count($imgsBD)); 
        $firephp->log($imgsBD);   

        $rutasImg=array();
        for ($i=0; $i < count($imgsBD); $i++) { 
            array_push($rutasImg,'imgSubidas/'.$imgsBD[$i]->nombre);
            $firephp->log("Agregado elemento: ".'imgSubidas/'.$imgsBD[$i]->nombre);  
        }
        $firephp->log("Imagenes obtenidas...");   
        $firephp->log($rutasImg);   
        return $rutasImg;
    }

}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>