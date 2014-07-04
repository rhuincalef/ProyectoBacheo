<?php
class Index extends CI_Controller {
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
    	$this->load->model('bache');		
		$datosJsonizados['respuestaJSON']=$this->ObtenerBachesModel->obtenerBaches();
		$this->load->view('BacheView',$datosJsonizados);
	}

	public function altaBache(){
		$datosJsonizados= array();
		//Cargamos la librería JSON-PHP e instanciamos el objeto de conversion de JSON
		$this->load->library('Services_JSON');
		$json = new Services_JSON();
		//$entradaDatosJSON = file_get_contents('php://input', 1000000);
		//TODO Quitar estas dos lineas! Se asume que los datos vendran en formato JSON.
		$valoresEnviados= array("latitud"=>$_POST['latitud'],"longitud"=>$_POST['longitud'],
			"criticidad"=>$_POST['criticidad'],"calle"=>$_POST['calle'],"altura"=>$_POST['altura'],"descripcion" =>$_POST['descripcion']);
		$valoresJSONizados = $json->encode($valoresJSONizados);
		$datosJsonizados['respuestaJSON']=$this->ObtenerBachesModel->darAltaBache($valoresJSONizados);
		$this->load->view('BacheView',$datosJsonizados);	
	}

	public function cargarBacheForm(){
		$this->load->view('CargaDeBacheView');	
	}

}
/* End of file bache.php */
/* Location: ./application/controllers/bache.php */
?>