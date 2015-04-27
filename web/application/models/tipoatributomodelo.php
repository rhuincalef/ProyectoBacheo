<?php 
		class TipoAtributoModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function get($id)
			{
				
				$query = $this->db->get_where('TipoAtributoModelo', array('id' => $id));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getTiposAtributos(){
				$query = $this->db->get('TipoAtributoModelo');
				return $query->result();
			}
		}	

	

 ?>