<?php 
require_once('FirePHP.class.php');
class Estado extends MY_Model {
	private $id;
	private $idTipoEstado;
	private $idBache;
	private $idUsuario;

	//Atributos usados por la libreria
    public $_table = 'Estado';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
    public $primary_key = 'id';//Sobreescribiendo el id por defecto.

 	//-->Se indica la clave foranea desde Estado hacia Bache y TipoEstado
    public $belongs_to = array( 'TipoEstado' => array('model' => 'Estado', 'primary_key' => 'idTipoEstado' ),'Bache' => array('model' => 'Bache', 'primary_key' => 'idBache' ));



    //Esta funcion asocia un bache con un estado. Es llamada desde el altaBache().
    public function asociarEstado($idBache,$estado){
    	$firephp = FirePHP::getInstance(True);
    	$this->load->database();
    	$firephp->log("Dentro de estado->asociarEstado()");
    	$this->load->model("TipoEstado");
    	$idTipoEstado=$this->TipoEstado->obtenerTipoEstado($estado);
    	$firephp->log("El idTipoEstado es:".$idTipoEstado);

    	//Se obtiene la fecha actual en la que se setea la tupla.
    	$fecha=date("d-m-Y", time());
		$firephp->log("La fecha actual es la siguiente:".$fecha);    	
    	$estado= array(
    		"idTipoEstado" => $idTipoEstado,
    		"idBache" => $idBache,
    		"fecha" =>$fecha 
    		);
    	$this->insert($estado);
		$firephp->log("Se dio de alta correctamente el estado de bache en la BD!"); 
		return $idBache;
    }

    //Esta funcion cambia el estado de un bache con un determinado $idBache y asocia el usuario logueado
    // con el $idUsuario. Recibe por parametro $idBache, $idUsuario y el nombre del nuevo estado.
    public function cambiarEstado($idBache,$idUsuario,$estadoNuevo){
    	$firephp = FirePHP::getInstance(True);
    	$this->load->database();
    	$this->load->model("TipoEstado");
    	$idTipoEstado=$this->TipoEstado->obtenerTipoEstado($estadoNuevo);
    	//Se busca el estado del bache y se modifica por $idBache
		$this->update_by('idBache',$idBache,array(
    		'idTipoEstado'=>$idTipoEstado,
    		'idUsuario'=>$idUsuario
    		));
		$firephp->log("Se cambio el estado del bache correctamente");
    }

    public function borrarEstado($idBache){
    	$firephp = FirePHP::getInstance(True);
    	$this->load->database();
    	$this->delete_by("idBache",$idBache);
    	$firephp->log("Se borro el estado del bache");
    }



}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>