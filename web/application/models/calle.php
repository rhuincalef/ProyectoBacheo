<?php 
require_once('FirePHP.class.php');
class Calle extends MY_Model{
		public $_table = 'Calle';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
        public $primary_key = 'id';//Sobreescribiendo el id por defecto.

		function __construct()
		{
			// Call the Model constructor
			parent::__construct();
		    $this->load->database();	
		}
		/*Se inserta la calle y se retorna el ID de la calle insertada*/
		function insertarCalle($nombreCalle){
			$firephp = FirePHP::getInstance(true);
			$nombreMin=strtolower($nombreCalle);
			$this->insert(array("nombre"=>ucfirst($nombreMin)));
			$firephp->log("La calle insertada en la BD fue:"+ucfirst($nombreCalle));
	        return $this->db->insert_id();
		}
		/*Borra la calle y retorna el id de la calle eliminada*/
		function borrarCalle($idCalle){
			$result=$this->delete($idCalle);
			return $idCalle;
		}

}
/* End of file calle.php */
/* Location: ./application/models/bache.php */
?>