<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class EstadoModelo extends MY_Model
	{
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		public function getUltimoEstado($idFalla)
		{
			$CI = &get_instance();
			$this->db->order_by("fecha", "desc");
			$query = $this->db->get_where('FallaEstadoModelo', array('idFalla' => $idFalla));
    		if (empty($query->result()))
    		{
				throw new MY_BdExcepcion('Sin resultados');
			}
			$datosEstadoFalla = $query->result()[0];

			$estado = $this->get($datosEstadoFalla->idEstado);
			$estado->fecha = $datosEstadoFalla->fecha;
			return $estado;
		}

		public function getEstados($idFalla)
		{
			$query = $this->db->get_where($this->table_name, array('idFalla' => $idFalla));
			if (empty($query->result()))
			{
				throw new MY_BdExcepcion('Sin resultados');
			}
			return $query->result();
		}

		public function save($estado)
		{
			$this->db->insert($this->table_name,
							array(  'idFalla' => $estado->falla->id,
									'idUsuario' => $estado->usuario,
									'idTipoEstado' => $estado->tipoEstado->id)
							);
			return $this->db->insert_id();
		}

	}
 ?>