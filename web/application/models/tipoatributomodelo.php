<?php 
		class TipoAtributoModelo extends MY_Model
		{

			function __construct()
			{
				parent::__construct();
				$this->table_name = get_class($this);
			}

			public function get($id)
			{
				$query = $this->db->get_where('TipoAtributoModelo', array('id' => $id));
        		if (empty($query->result()))
        		{
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getTiposAtributos()
			{
				$query = $this->db->get('TipoAtributoModelo');
				return $query->result();
			}

			public function save($tipoAtributo)
			{
				$this->db->insert($this->table_name, array('nombre' => ucfirst($tipoAtributo->nombre), 'unidadMedida' => $tipoAtributo->unidadMedida, 'idTipoFalla' => $tipoAtributo->falla));
				return $this->db->insert_id();
			}

			public function getAtributosPorTipoFalla($idTipoFalla)
			{
				$query = $this->db->get_where($this->table_name, array('idTipoFalla' => $idTipoFalla));
				return $query->result();
			}


		}
 ?>