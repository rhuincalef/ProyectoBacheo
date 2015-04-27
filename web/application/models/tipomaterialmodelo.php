<?php 
		class TipoMaterialModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				
				$query = $this->db->get_where('TipoMaterialModelo', array('id' => $id));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getTiposMaterial(){
				$query = $this->db->get('TipoMaterialModelo');
				return $query->result();
			}
		}	

	

 ?>