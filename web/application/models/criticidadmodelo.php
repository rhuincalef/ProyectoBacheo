<?php 
		class CriticidadModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				
				$query = $this->db->get_where('CriticidadModelo', array('id' => $id));
        		
        		return $query->result()[0];
			}

			public function getCriticidades(){
				$query = $this->db->get('CriticidadModelo');
				return $query->result();
			}
		}	

	

 ?>