<?php 
		class TipoMaterialModelo extends MY_Model
		{
			
			function __construct()
			{
				parent::__construct();
				$this->table_name = get_class($this);
			}

			public function getTipoDeMaterialPorNombre($nombre)
			{
				// $query = $this->db->get_where('TipoMaterialModelo', array('nombre' => $nombre));
				$query = $this->db->like('LOWER(nombre)', strtolower($nombre))->get($this->table_name);
        		if (empty($query->result()))
        		{
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function save($material)
			{
				$this->db->insert($this->table_name, array('nombre' => $material->nombre));
				return $this->db->insert_id();
			}

			public function asociar($idTipoMaterial, $idTipoFalla)
			{
				$CI = &get_instance();
				$CI->utiles->debugger($idTipoMaterial);
				$CI->utiles->debugger($idTipoFalla);
				$this->db->insert('TipoMaterialTipoFallaModelo', array('idTipoMaterial' => $idTipoMaterial, 'idTipoFalla' => $idTipoFalla));
			}

			public function isUnique($nombre)
			{
				$query = $this->CI->db->get_where($this->table_name, array('nombre' => $nombre), 1, 0);
		        if ($query->num_rows() === 0) {
		            return TRUE;
		        }

		        return FALSE;
			}
		}
 ?>