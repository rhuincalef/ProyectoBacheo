<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class DireccionModelo extends MY_Model
	{
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		public function save($direccion)
		{
			$this->db->insert($this->table_name,
							array('idCallePrincipal' => $direccion->callePrincipal->id,
								'altura' => $direccion->altura,
								'idCalleSecundariaA' => $direccion->calleSecundariaA->id,
								'idCalleSecundariaB' => $direccion->calleSecundariaB->id
								)
							);
			return $this->db->insert_id();
		}
	}
 ?>