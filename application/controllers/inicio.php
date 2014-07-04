<?php
class Inicio extends CI_Controller {
	public function index()
	{
		echo "LLame al controlador de baches";
	}
	public function obtenerBaches()
	{
		$datosJsonizados= array();
		//Cargamos la librería JSON-PHP
		$this->load->library('Services_JSON');
        //Cargamos el modelo de la tabla nombres
    	$this->load->model('Bache');		
    	//TODO Tiene que obtener un arreglo de los baches cargados y luego recorrerlos en un foreach.
    	//Y JSONIZAR los ROWS del foreach.
		$datosJsonizados['respuestaJSON']=$this->Bache->getBache();
		$this->load->view('BacheView',$datosJsonizados);
	}

	public function altaBache(){
		$datosJsonizados= array();
		//Cargamos la librería JSON-PHP e instanciamos el objeto de conversion de JSON
		$this->load->library('Services_JSON');
		$json = new Services_JSON();
		//$entradaDatosJSON = file_get_contents('php://input', 1000000);
		//TODO Quitar estas dos lineas! Se asume que los datos vendran en formato JSON.
		$valoresEnviados= array("latitud"=>$_POST["latitud"],"longitud"=>$_POST["longitud"],
			"criticidad"=>$_POST["criticidad"],"calle"=>$_POST["calle"],"alturaCalle"=>$_POST["alturaCalle"],"descripcion" =>$_POST["descripcion"]);
		$valoresJSONizados = $json->encode($valoresEnviados);
		$this->load->model('Bache');		
		$datosJsonizados['respuestaJSON']=$this->Bache->darAltaBache($valoresJSONizados);
		$this->load->view('BacheView',$datosJsonizados);	
	}

	public function formBache(){
		$this->load->view('CargaDeBacheView');	
	}

	public function obtenerTiposCriticidad(){
		$datosJsonizados= array();
		$this->load->model('Criticidad');		
		$datosJsonizados['respuestaJSON']=$this->Criticidad->getColCriticidades();
		$this->load->view('BacheView',$datosJsonizados);	
	}

}
/* End of file bache.php */
/* Location: ./application/controllers/bache.php */
?>