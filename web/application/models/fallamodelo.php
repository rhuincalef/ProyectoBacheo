<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class FallaModelo extends MY_Model
	{
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		public function save($falla)
		{
			$this->db->insert($this->table_name,
							 array( 'latitud' => $falla->latitud,
							 		'longitud' => $falla->longitud,
							 		'idCriticidad' => $falla->criticidad->id,
							 		'idDireccion' => $falla->direccion->id,
							 		'idTipoMaterial' => $falla->tipoMaterial->id,
							 		'idTipoFalla' => $falla->tipoFalla->id,
							 		'idTipoReparacion' => $falla->tipoReparacion->id,
							 		'areaAfectada' => $falla->factorArea)
							 );
			return $this->db->insert_id();
		}

		public function saveAnonimo($falla)
		{
			$this->db->insert($this->table_name,
							 array( 'latitud' => $falla->latitud,
							 		'longitud' => $falla->longitud,
							 		'idDireccion' => $falla->direccion->id,
							 		'idTipoMaterial' => $falla->tipoMaterial->id,
							 		'idTipoFalla' => $falla->tipoFalla->id)
							 );
			return $this->db->insert_id();
		}

		public function asociarEstado($falla)
		{
			$this->db->insert('FallaEstadoModelo',
							array(  'idFalla' => $falla->id,
									'idEstado' => $falla->estado->id,
									'fecha' => date("Y-m-d H:i:s"))
							);
			return $this->db->insert_id();
		}

	}
 ?>