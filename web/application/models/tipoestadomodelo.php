<?php 
		class TipoEstadoModelo extends MY_Model
		{
			
			function __construct()
			{
				parent::__construct();
				$this->table_name = get_class($this);
			}

			public function getTiposEstado()
			{
				$query = $this->db->get('TipoEstadoModelo');
				return $query->result();
			}

			public function getTipoEstado($nombre)
			{
				return $this->get_by(array('nombre' => $nombre));
			}
		}	

	

 ?>