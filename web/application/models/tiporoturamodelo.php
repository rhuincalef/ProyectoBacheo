<?php 
		class TipoRoturaModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				
				$query = $this->db->get_where('TipoRoturaModelo', array('id' => $id));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getTiposRotura(){
				$query = $this->db->get('TipoRoturaModelo');
				return $query->result();
			}
		}	

	

 ?>