<?php 
	class TipoFallaModelo extends CI_Model
	{		
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		public function get($id)
		{
			$query = $this->db->get_where('TipoFallaModelo', array('id' => $id));
    		if (empty($query->result()))
    		{
				throw new MY_BdExcepcion('Sin resultados');
				}
    		return $query->result()[0];
		}

		public function getTiposFalla()
		{
			$query = $this->db->get('TipoFallaModelo');
			return $query->result();
		}

		public function save($tipoFalla)
		{
			$this->db->insert($this->table_name, array('nombre' => $tipoFalla->nombre, 'influencia' => $tipoFalla->influencia));
			return $this->db->insert_id();
		}
	}
 ?>