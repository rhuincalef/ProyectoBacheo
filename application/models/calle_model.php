<?php 
// class Calle extends CI_Model {
class Calle_model extends MY_Model{
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
			$this->insert(array("nombre"=>$nombreCalle));
			//echo "El idCalle obtenido es: ".$this->db->insert_id();
	        return $this->db->insert_id();
		}
}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>