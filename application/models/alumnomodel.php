<?php 
class AlumnoModel extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function leerAlumnos()
    {
        //$arr=array( 'nombre','apellido','edad','email');
        //$arr=array('*');
        $arr=array( 'nombre','apellido');
        $crits=array( array('campo' => 'apellido', 'valor' => 'quiroqueo'));
        $this->load->library("ConsultaJSON");
        //Se instacia la clase que se definió como parte de la libreria
        $consult=new ConsultaJSON();
        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/alumnos');
        //Funciona OK!
        //return $this->consultajson->obtenerTodasFilasJSON('alumno',$arr,$crits);
        $propsDestino=array('alumno.nombre','curso.apellido');
        $propsOrigen=array('curso.nombre');
        //Se obtiene nombre y apellido de los alumnos que estan en un curso determinado
        return $this->consultajson->obtenerFilasRelacionadas('alumno',$propsDestino,'curso',$propsOrigen);
    }   
}
/* End of file alumnomodel.php */
/* Location: ./application/models/alumnomodel.php */
?>
