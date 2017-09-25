<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class FallaModelo extends MY_Model {
		
	function __construct()
	{
		parent::__construct();
		$this->table_name = get_class($this);
	}

	public function save($falla)
	{
		$fallaRow = array( 'latitud' => $falla->latitud,
					 		'longitud' => $falla->longitud,
					 		'idCriticidad' => $falla->criticidad->id,
					 		'idDireccion' => $falla->direccion->id,
					 		'idTipoMaterial' => $falla->tipoMaterial->id,
					 		'idTipoFalla' => $falla->tipoFalla->id,
					 		'areaAfectada' => $falla->factorArea);
		/*
		TODO: verificar si tipo de reparacion set.
		Save por tipo de estado.
		if ($falla->tipoReparacion) {
			$fallaRow['idTipoReparacion'] = $falla->tipoReparacion->id,
		}
		*/
		$this->db->insert($this->table_name, $fallaRow);
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

	public function actualizar($falla)
	{
		$CI = &get_instance();
		$CI->utiles->debugger('actualizar falla');
		$CI->utiles->debugger($falla);
		$this->db->where('id', $falla->id);
		$this->db->update($this->table_name,
						array(	'idCriticidad' => $falla->criticidad->id,
								'idTipoMaterial' => $falla->tipoMaterial->id,
								'idTipoFalla' => $falla->tipoFalla->id,
								'idTipoReparacion' => $falla->tipoReparacion->id,
								'areaAfectada' => $falla->factorArea,
								)
						);
	}

	public function asociarAtributos($falla)
	{
		$idFalla = $falla->id;
		$arrayIds = array_map(function($tipoAtributo) use ($idFalla)
		{
			$this->db->insert('FallaTipoAtributoModelo',
				array(
					'idFalla' => $idFalla,
					'idTipoAtributo' => $tipoAtributo->id,
					'valor' => $tipoAtributo->valor
					)
				);
			// return $this->db->insert_id();
		}, $falla->atributos);
	}

	public function getEstado($id)
	{
		$query = $this->db->get_where("FallaEstadoModelo", array('idFalla' => $id));
		if (empty($query->result())) {
		    throw new MY_BdExcepcion('Sin resultados');
		}
		return $query->result()[0];
	}

	public function getFallasPorTipoFalla($id)
	{
		$query = $this->db->get_where("FallaModelo", array('idTipoFalla' => $id));
		if (empty($query->result()))
		{
		    throw new MY_BdExcepcion('Sin resultados');
		}
		return $query->result();
	}

	public function getAtributos($idFalla)
	{
		log_message('debug','En fallamodelo.getAtributos()');
		$query = $this->db->get_where('FallaTipoAtributoModelo', array('idFalla' => $idFalla));
		
		log_message('debug','$query->result()');
		$aux = print_r($query->result(),true);
		log_message('debug',$aux);

		if (empty($query->result()))
		{
			//throw new MY_BdExcepcion('Sin resultados');
			log_message('debug','Falla '.$idFalla.' sin tipoAtributos!');
			$query = array();
			return $query;
		}
		log_message('debug','Fin falla.getAtributos()');
		return $query->result();
	}

	public function actualizarPor($value='')
	{
		$this->db->update($this->table_name, $value);
	}

}