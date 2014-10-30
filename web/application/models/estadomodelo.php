<?php 
		class EstadoModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function getUltimoEstado($idFalla){
				$this->db->order_by("fecha", "desc");
				$query = $this->db->get_where('EstadoModelo', array('idFalla' => $idFalla));
        		if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result()[0];
			}

			public function getEstados($idFalla){
				$query = $this->db->get_where('EstadoModelo', array('idFalla' => $idFalla));
				if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
				return $query->result();
			}
		}	

	

 ?>