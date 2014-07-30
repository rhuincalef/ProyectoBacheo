<?php 

// class Bache extends CI_Model {
// class Bache extends grocery_crud_model_Postgre {
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
    }
    function getBache($idBache){
        //TODO Completar funcionalidad de ObtenerInformacion de un bache
        $tupla=$this->with("Calle")->get($idBache);
        if(count($tupla)==0){
            echo "Error al encontrar bache y calles asociadas";
            return NULL;
        }
        var_dump($tupla);
        $datos = array(
            "id" => $tupla->id,
            "latitud"=>$tupla->latitud,
            "longitud"=>$tupla->longitud,
            "alturaCalle"=>$tupla->alturaCalle,
            "calle" => $tupla->Calle->nombre
            );
        return $datos;


    }
    /*Enviar un array asociativo de elementos para dar de alta el bache. el metodo
    retorna el id del bache insertado*/
    function darAltaBache($valores)
    {
        //Se obtiene la criticidad asociada al bache
        $this->load->model("Criticidad");
        $idCriticidad = $this->Criticidad->obtenerCriticidad($valores["nombreCriticidad"]);
        $this->load->model("Calle");
        $idCalle = $this->Calle->insertarCalle($valores["nombreCalle"]);
        $datos = array(
            "latitud"=>floatval($valores["latitud"]),
            "longitud"=>floatval($valores["longitud"]),
            "alturaCalle"=>intval($valores["alturaCalle"]),
            "idCalle"=>intval($idCalle),
            "idCriticidad"=>intval($idCriticidad)
            );
        $this->insert($datos);
        //Se retorna la utlima fila insertada.
        return $this->db->insert_id();
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
        $tupla=$this->with("Calle")->get($idBache);
        if(count($tupla)==0){
            echo "Error al encontrar bache y calles asociadas";
            return NULL;
        }
        $this->delete($tupla->id);
        // $tupla->Calle->delete($tupla->Calle->id);
        $this->load->model("Calle");
        if($this->Calle->borrarCalle($tupla->Calle->id)==NULL){
            echo "Error al borrar la calle";
            return NULL;
        }
        echo "Se ha dado de baja el bache y su calle asociada, correctamente!";
        return $idBache;
    }

    
}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>