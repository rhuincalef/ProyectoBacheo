<?php 
		class TipoEstadoModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				
				$query = $this->db->get_where('TipoEstadoModelo', array('id' => $id));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getTiposEstado(){
				$query = $this->db->get('TipoEstadoModelo');
				return $query->result();
			}
		}	

	

 ?>