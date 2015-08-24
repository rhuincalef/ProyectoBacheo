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
			$this->db->insert($this->table_name, 
				array('nombre' => $tipoFalla->nombre,
					  'influencia' => $tipoFalla->influencia,
					  'idMultimedia' => $tipoFalla->multimedia->id)
				);
			return $this->db->insert_id();
		}

		public function getMaterial($id)
		{
			$query = $this->db->get('TipoMaterialTipoFallaModelo', array('idTipoFalla' => $id));
			if (empty($query->result())) {
			 throw new MY_BdExcepcion('Sin resultados');
			}
			return $query->result()[0]->idTipoMaterial;
		}

		public function getTiposFallaMaterial($idTipoMaterial)
		{
			$CI = &get_instance();
			$query = $this->db->get_where('TipoMaterialTipoFallaModelo', array('idTipoMaterial' => $idTipoMaterial));
			// $CI->utiles->debugger('TipoMaterialTipoFallaModelo');
			// $CI->utiles->debugger($query->result());
			return $query->result();
		}

	}
 ?>