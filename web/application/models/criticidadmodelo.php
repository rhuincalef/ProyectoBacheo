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

	public function asociar($idCriticidad, $idTipoFalla)
	{
		$CI = &get_instance();
		$CI->utiles->debugger($idCriticidad);
		$CI->utiles->debugger($idTipoFalla);
		$this->db->insert('TipoFallaCriticidadModelo', array('idCriticidad' => $idCriticidad, 'idTipoFalla' => $idTipoFalla));
	}

	public function getCriticidadesPorTipoFalla($idTipoFalla)
	{
		$query = $this->db->get_where('TipoFallaCriticidadModelo', array('idTipoFalla' => $idTipoFalla));
		return $query->result();
	}

}
?>