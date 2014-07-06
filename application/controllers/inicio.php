<?php
class Inicio extends CI_Controller {

	/*URL de prueba: localhost/gitBaches/ProyectoBacheo/index.php/incio/AltaBache */
	public function index()
	{
		echo "LLame al controlador de baches";
	}
	public function AltaBache(){
		$this->load->database();
		$this->load->model('Bache');		
		/*Incluir los datos del bache en un array asociativo, donde clave es el attributo de la BD
		y valor es el valor de ese campo. En el caso de los atributos que tienen el mismo nombre en 
		la BD se antepone el nombre del atributo+nombreTabla*/
		$datosBache=array("latitud"=>10101001,"longitud"=>202020202,"nombreCriticidad"=>"alta",
			"nombreCalle"=>"E.E.U.U","descripcion"=>"Esta bache es un bache horrible","alturaCalle"=>"2100");
		$idBache['respuestaJSON']=$this->Bache->darAltaBache($datosBache);
		$this->load->view('BacheView',$idBache);	
	}

	public function BajaBache(){
		$this->load->database();
		$this->load->model('Bache');		
		$this->Bache->darDeBajaBache(32);
	}


	public function formBache(){
		$this->load->view('CargaDeBacheView');	
	}
}
/* End of file bache.php */
/* Location: ./application/controllers/bache.php */
?>
