<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class MultimediaModelo extends CI_Model{
			
			function __construct(){			
				parent::__construct();
			}


			public function getAll($idFalla){
				$query = $this->db->get_where('MultimediaModelo', array('idFalla' => $idFalla));
				if (empty($query->result())) {
					throw new MY_BdExcepcion('Sin resultados');
  				}
        		return $query->result();
			}
		}
 ?>