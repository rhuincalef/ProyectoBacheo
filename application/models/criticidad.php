<?php 
class Criticidad extends CI_Model {
		private $nombre;
		private $descripcion;

	function getColCriticidades($valoresJSONizados)
    {
        $this->load->library("ConsultaJSON");
        //Se instacia la clase que se definió como parte de la libreria
        $consult=new ConsultaJSON();
        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/ProyectoBacheo');
        return $consult->obtenerCriticidades($valoresJSONizados);          
    }
		


}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>