<?php 
	class TipoFallaTipoReparacionModelo extends MY_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->table_name = get_class($this);
		}

		//Retorna los idsReparacion segun un tipoIdFalla
		public function getIdsReparacion($idFalla){
			//require_once('CustomLogger.php');
			//CustomLogger::log('En getIdsReparacion()...');
			//CustomLogger::log('idFalla tiene: ');
			//CustomLogger::log($idFalla);
			$rows = $this->get_all();
			$data = array();
			foreach ($rows as $row) {
				if ($row->idTipoFalla == $idFalla) {
					array_push($data,$row);
				}
			}
			//CustomLogger::log('Resultados de getIdsReparacion(): ');
			//CustomLogger::log($data);
			return $data;
		}

}

?>