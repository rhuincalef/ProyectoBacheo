<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class MultimediaModelo extends MY_Model
	{
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		public function getAll($idFalla)
		{
			$query = $this->db->get_where('MultimediaModelo', array('idFalla' => $idFalla));
			if (empty($query->result()))
			{
				throw new MY_BdExcepcion('Sin resultados');
			}
    		return $query->result();
		}

		public function save($multimedia)
		{
			$this->db->insert($this->table_name, array('nombreArchivo' => $multimedia->nombreArchivo));
			return $this->db->insert_id();
		}

		public function update($multimedia)
		{
			$this->db->where('id', $multimedia->id);
			$this->db->update($this->table_name, array('nombreArchivo' => $multimedia->nombreArchivo));
		}

	}
 ?>