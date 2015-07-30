<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class ObservacionModelo extends MY_Model
	{
		
		function __construct()
		{	
			parent::__construct();
			$this->table_name = get_class($this);
		}

		public function getAll($idFalla)
		{
			$query = $this->db->get_where('ObservacionModelo', array('idFalla' => $idFalla));
			if (empty($query->result()))
			{
				throw new MY_BdExcepcion('Sin resultados');
			}
    		return $query->result();
		}

		public function save($observacion)
		{
			$this->db->insert($this->table_name,
							array(
								'idFalla' => $observacion->falla->id,
								'fecha' => date("Y-m-d H:i:s"),
								'comentario' => $observacion->comentario,
								'nombreObservador' => $observacion->nombreObservador,
								'emailObservador' => $observacion->emailObservador)
							);
			// Id = ('idFalla', 'fecha')
			// return $this->db->insert_id();
		}

	}
 ?>