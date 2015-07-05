<?php 
		class NivelServicioModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				
				$query = $this->db->get_where('NivelServicioModelo', array('id' => $id));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getNivelesServicio(){
				$query = $this->db->get('NivelServicioModelo');
				return $query->result();
			}
		}	

	

 ?>