<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class CalleModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				$query = $this->db->get_where('CalleModelo', array('id' => $id));
        		
        		return $query->result()[0];
			}
		}
 ?>