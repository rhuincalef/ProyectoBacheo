<?php 

class Bache extends CI_Model {
	private $id;
    private $latitud;
	private $longitud;
	private $idCriticidad;
	private $idCalle;
	private $alturaCalle;
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getBaches(){
        $arr=array('*');
        $this->load->library("ConsultaJSON");
        //Se instacia la clase que se definió como parte de la libreria
        $consult=new ConsultaJSON();
        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/ProyectoBacheo');
        return $this->consultajson->obtenerTodasFilasJSON('Bache',$arr,NULL);
    }

    function darAltaBache($valoresJSONizados)
    {
        $this->load->library("ConsultaJSON");
        //Se instacia la clase que se definió como parte de la libreria
        $consult=new ConsultaJSON();
        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/ProyectoBacheo');
        return $consult->registrarBache($valoresJSONizados);          
    }

}
/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>