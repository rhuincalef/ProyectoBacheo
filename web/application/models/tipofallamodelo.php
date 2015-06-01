<?php 
	class TipoFallaModelo extends MY_Model
	{		
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
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