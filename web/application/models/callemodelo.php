<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class CalleModelo extends MY_Model
	{
		
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		public function save($calle)
		{
			$this->db->insert($this->table_name, array('nombre' => $calle->nombre));
			return $this->db->insert_id();
		}
	}
 ?>