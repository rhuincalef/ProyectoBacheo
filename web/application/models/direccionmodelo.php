<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class DireccionModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				$query = $this->db->get_where('DireccionModelo', array('id' => $id));
        		
        		return $query->result()[0];
			}
		}
 ?>