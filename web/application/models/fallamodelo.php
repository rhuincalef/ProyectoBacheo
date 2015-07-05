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

	}
 ?>