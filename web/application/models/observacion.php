<?php 
class Observacion extends MY_Model {


//URL DE PRUEBA --> http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formAsociarObservaciones
  
	private $idBache;
	private $nombreObservador;
	private $emailObservador;

    public $_table = 'Observacion';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
    public $primary_key = 'id';//Sobreescribiendo el id por defecto.

    public $belongs_to = array( 'Bache' => array('model' => 'Bache', 'primary_key' => 'idBache' ));
	

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertarObservacion($valores){
		$firephp = FirePHP::getInstance(true);        
		$firephp->log("array de valores es ...");
		$firephp->log($valores);
		$this->load->model("Observacion",'observacion');
        $this->observacion->insert($valores);
		$firephp->log("valores insertados...");
	}

	//Esta funcion borra las observaciones asociadas a un bache.
	function borrarObservaciones($idBache){
		$firephp = FirePHP::getInstance(true);        
		$observaciones=$this->delete_by("idBache",$idBache);
		$firephp->log("Se borraron correctamente las observaciones del bache!");
	}


}
/* End of file observacion.php */
/* Location: ./application/models/observacion.php */
?>