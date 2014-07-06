<?php
class Alumno extends CI_Controller {
	public function index()
	{
		echo "LLame al alumno";

	}

	public function obtenerAlumnos()
	{
		$data= array();
		//Cargamos la librería JSON-PHP
		$this->load->library('Services_JSON');
        //Cargamos el modelo de la tabla nombres
    	$this->load->model('AlumnoModel');		
		$data['Rodrigojson']=$this->AlumnoModel->leerAlumnos();
		$this->load->view('AlumnoView',$data);
		
		//Declaramos un nuevo objeto JSON
	  	// $json = new Services_JSON();
		//Arreglo que contendra cada una de las filas de la tabla
		// $datos = array();
		//Obtenemos lo nombres de la tabla
		// $nombresAlumno = $this->AlumnoModel->leerAlumnos();
		//llenamos el arreglo con los datos resultados de la consulta
		// foreach($all_nombres->result_array() as $row)
		// {
		// 	$datos[] = $row;
		// }
		//convertimos en datos json nuestros datos
		// print $json->encode($datos);
		/*$data= array('consultaJSON' => $this->AlumnoModel->leerAlumnos(),
						 'SE_EJECUTO' => TRUE);*/
		
	}
}
/* End of file alumno.php */
/* Location: ./application/controllers/alumno.php */
?>
