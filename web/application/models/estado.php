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
    	// $firephp->log("Dentro de estado->asociarEstado() con estado: ".$estado);
    	$this->load->model("TipoEstado");
    	$idTipoEstado=$this->TipoEstado->obtenerTipoEstado($estado);
    	// $firephp->log("El idTipoEstado es:".$idTipoEstado);

    	//Se obtiene la fecha actual en la que se setea la tupla.
    	$fecha=date("d-m-Y", time());
		// $firephp->log("La fecha actual es la siguiente:".$fecha);    	
    	$estado= array(
    		"idTipoEstado" => $idTipoEstado,
    		"idBache" => $idBache,
    		"fecha" =>$fecha 
    		);
    	$this->insert($estado);
		// $firephp->log("Se dio de alta correctamente el estado de bache en la BD!"); 
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

    public function obtenerEstadosBache($idBache){
        $this->load->database();
       // var_dump($this->-get_where(array("idBache"=>$idBache)));
        $this->order_by('fecha');
        $estados = $this->get_many_by("idBache",$idBache); //$this->db->get_where("Estado",array("idBache"=>$idBache));
        return $estados;
                
    }

    public function asociarNuevoEstado($idBache){
        $firephp = FirePHP::getInstance(True);
        // $firephp->log($idBache);
        $this->load->database();
        $estados = $this->obtenerEstadosBache($idBache);
        $estadoActual = end($estados);
        $this->load->model("TipoEstado");
        $tiposEstados = $this->TipoEstado->obtenerTiposEstados();
        $firephp->log($tiposEstados);
        $firephp->log("obteniendo nuevo estado");

        $idNuevoEstado = ($estadoActual->idTipoEstado+1)%(count($tiposEstados));
        if ($idNuevoEstado == 0) {
            $idNuevoEstado = count($tiposEstados);
        }
        $firephp->log($idNuevoEstado);
        $nuevoEstado = $tiposEstados[$idNuevoEstado-1]["nombre"];
        $firephp->log($nuevoEstado);
        $this->asociarEstado($idBache, $nuevoEstado);
        return $idNuevoEstado;
    }


}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>