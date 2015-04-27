<?php 
		class TipoFallaModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{				
				$query = $this->db->get_where('TipoFallaModelo', array('id' => $id));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getTiposFalla(){
				$query = $this->db->get('TipoFallaModelo');
				return $query->result();
			}
		}	

	

 ?>