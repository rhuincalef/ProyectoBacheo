<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class MaterialModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id){
				$query = $this->db->get_where('MaterialModelo', array('id' => $id));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}
		}
 ?>