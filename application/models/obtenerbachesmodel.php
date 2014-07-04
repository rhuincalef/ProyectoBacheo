<?php 
class ObtenerBachesModel extends CI_Model {
    //ACLARO: Despues voy a cambiar este nombre para respetar la convencion (no me olvide de lo que hablamos)
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function obtenerBaches()
    {
        $arr=array('*');
        //$arr=array( 'latitud','longitud');
        //$crits=array( array('campo' => 'latitud', 'valor' => 'quiroqueo'));
        $this->load->library("ConsultaJSON");
        //Se instacia la clase que se definió como parte de la libreria
        $consult=new ConsultaJSON();
        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/ProyectoBacheo');
        return $this->consultajson->obtenerTodasFilasJSON('Bache',$arr,NULL);
        //No funciona el metodo obtenerFIlasRelacionadas() --> falla al haber campos con el mismo nombre en distintas tablas!
        //Se obtiene nombre y apellido de los alumnos que estan en un curso determinado
        //return $this->consultajson->obtenerFilasRelacionadas('alumno',$propsDestino,'curso',$propsOrigen);
    }   
    /*Metodo usado para obtener los baches y sus calles asociadas.*/
    function filtrarBache()
    {
        $this->load->library("ConsultaJSON");
        //Se instacia la clase que se definió como parte de la libreria
        $consult=new ConsultaJSON();
        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/ProyectoBacheo');
        $tablaOrigen='Bache';
        $critsOrigen=array( "id" =>"idCalle");
        $tablaDestino='Calle';
        $critsDestino=array( "id" =>"id");
        $criteriosFiltrado=array("nombre" => "Belgrano");
        //Ejemplo de array asociativo con indices predefinidos:
        //echo "Crits origen -->".$critsOrigen["props"]["id"];
        return $this->consultajson->obtenerFilasRelacionadas($tablaOrigen,$critsOrigen,$tablaDestino,$critsDestino,$criteriosFiltrado);        
    }

    function darAltaBache($valoresJSONizados){
        $this->load->library("ConsultaJSON");
        //Se instacia la clase que se definió como parte de la libreria
        $consult=new ConsultaJSON();
        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/ProyectoBacheo');
        return $this->consultajson->insertarBache($valoresJSONizados);          
    }


}
/* End of file ObtenerBaches.php */
/* Location: ./application/models/ObtenerBaches.php */
?>