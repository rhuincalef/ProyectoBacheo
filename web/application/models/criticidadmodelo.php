<?php 
class CriticidadModelo extends MY_Model{
	
	// public $table_name;
	public $datos_tabla;

	function __construct()
	{
		parent::__construct();
		// $table_name heredad de MY_Model class
		$this->table_name = get_class($this);
	}

	public function save($criticidad)
	{
		$this->db->insert($this->table_name, array('nombre' => $criticidad->nombre, 'descripcion' => $criticidad->descripcion, 'ponderacion' => $criticidad->ponderacion));
		$id = $this->db->insert_id();
		if (empty($id))
		{
			throw new MY_BdExcepcion('Sin resultados');
		}
		return $id;
	}
}
?>