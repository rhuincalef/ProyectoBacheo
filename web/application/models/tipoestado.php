<?php 

require_once('FirePHP.class.php');

class TipoEstado extends MY_Model {
	private $id;
  	private $nombre;
  	//Atributos usados por la libreria
    public $_table = 'TipoEstado';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
    public $primary_key = 'id';//Sobreescribiendo el id por defecto.


    //Esta funcion obtiene el id del estado en base a un nombre pasado por parámetro.
	public function obtenerTipoEstado($nombreEstado){
		$tupla=$this->get_by("nombre",$nombreEstado);
		return $tupla->id;
	}    

	public function obtenerTiposEstados()
	{
		return $this->as_array()->get_all();

	}
}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>