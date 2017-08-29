<?php 
	class TipoMaterialTipoFallaModelo extends MY_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		//Retorna los idsReparacion segun un tipoIdFalla
		public function getIdsMaterial($idFalla){
			$rows = $this->get_all();
			$data = array();
			foreach ($rows as $row) {
				if ($row->idTipoFalla == $idFalla) {
					array_push($data,$row);
				}
			}
			return $data;
		}

		//Retorna un array de ids TipoFalla-TipoMaterial
        public function getMaterialesAsociados($idTipoFalla)
        {
            $query = $this->db->get_where('TipoMaterialTipoFallaModelo', array('idTipoFalla' => $idTipoFalla));
            if (empty($query->result())) {
             throw new MY_BdExcepcion('Sin resultados de criticidad');
            }
            return $query->result();
        }

}

?>