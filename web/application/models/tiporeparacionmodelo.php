<?php 
	class TipoReparacionModelo extends MY_Model
	{
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		/*
			Busca la coincidencia de los valores en las columnas de la base
			$array de la forma column => value
			public function getBy($datos)
			// Arma la consulta por AND
			$this->db->like($datos);
			// Arma la consulta por OR
			$this->db->or_like($datos);
			// Obtiene el resultado
			$query = $this->db->get(get_class($this));
		*/
		public function getTipoDeReparacionPorNombre($nombre)
		{
			// $query = $this->db->get_where('TipoReparacionModelo', array('nombre' => $nombre));
			// To search the nombre no case sensitive
			$this->db->like('LOWER(nombre)', strtolower($nombre));
			$query = $this->db->get($this->table_name);
    		if (empty($query->result()))
    		{
				throw new MY_BdExcepcion('Sin resultados');
				}
    		return $query->result()[0];
		}

		public function save($tipoReparacion)
		{
			$this->db->insert($this->table_name,
				array(	'nombre' => $tipoReparacion->nombre,
						'descripcion' => $tipoReparacion->descripcion,
						'costo' => $tipoReparacion->costo
					)
				);
			return $this->db->insert_id();
		}

		public function asociar($idTipoReparacion, $idTipoFalla)
		{
			$CI = &get_instance();
			$CI->utiles->debugger($idTipoReparacion);
			$CI->utiles->debugger($idTipoFalla);
			$this->db->insert('TipoFallaTipoReparacionModelo', array('idTipoReparacion' => $idTipoReparacion, 'idTipoFalla' => $idTipoFalla));
		}

		public function getReparacionesPorTipoFalla($idTipoFalla)
		{
			$query = $this->db->get_where('TipoFallaTipoReparacionModelo', array('idTipoFalla' => $idTipoFalla));
			return $query->result();
		}

	}
 ?>