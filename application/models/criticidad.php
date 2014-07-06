<?php 
// class Criticidad extends CI_Model {
class Criticidad extends MY_Model{
 

        public $_table = 'Criticidad';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
        public $primary_key = 'id';//Sobreescribiendo el id por defecto.
        function __construct()
        {
            // Call the Model constructor
            parent::__construct();
            // $this->load->database();    
        }

        function obtenerCriticidad($nivel){
            //Se retorna un arreglo con el tipo de 
            $criticidadObj=$this->get_by("nombre",$nivel);
            //Se castea el objeto retornado a una array asociativo.
            $criticidadArray= (array)$criticidadObj;
            return $criticidadArray["id"];
        }

        function obtenerNivelesDeCriticidad(){
            // echo "Llame a obtenerNiveles de criticidad\n";
            $resultados=$this->as_array()->get_all();
            $datosJSON=array();
            $i=0;
            foreach ($resultados as $criticidad) {
                // echo "Cricidad=".$criticidad["nombre"]."\n";
                $datosJSON[$i]='{"nombre":'.$criticidad["nombre"].', descripcion:'.$criticidad["descripcion"].'}';
                $i++;
            }
            $this->load->library('Services_JSON');
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
            return $json->encode($datosJSON);
        }
}

	// function getColCriticidades($valoresJSONizados)
 //    {
 //        $this->load->library("ConsultaJSON");
 //        //Se instacia la clase que se definió como parte de la libreria
 //        $consult=new ConsultaJSON();
 //        $consult->setConexion('postgre://adminpepe:adminpepe@localhost/ProyectoBacheo');
 //        return $consult->obtenerCriticidades($valoresJSONizados);          
 //    }


/* End of file bache.php */
/* Location: ./application/models/bache.php */
?>