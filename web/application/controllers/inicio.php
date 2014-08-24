<?php

//TODO Comentar! Clase de firephp utilizada para la depuración.
require_once('FirePHP.class.php');

class Inicio extends CI_Controller {

	/*URL de prueba: http://localhost/gitBaches/ProyectoBacheo/index.php/incio/AltaBache 
					 http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formBache
	*/

	public $configAltaBache=array(
                                    array(
                                            'field' => 'titulo',
                                            'label' => 'Titulo',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'latitud',
                                            'label' => 'Latitud',
                                            'rules' => 'required|integer'
                                         ),
                                    array(
                                            'field' => 'longitud',
                                            'label' => 'Longitud',
                                            'rules' => 'required|integer'
                                         ),
                                    array(
                                            'field' => 'descripcion',
                                            'label' => 'Descripcion',
                                            'rules' => 'required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'calle',
                                            'label' => 'Calle',
                                            'rules' => 'required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'altura',
                                            'label' => 'Altura',
                                            'rules' => 'required|integer|max_length[4]'
                                         )
                                    // )
	);


	public function index()
	{
		echo "LLame al controlador de baches";
	}

	//Formulario de alta de baches.
	public function formBache(){
		$this->load->view('CargaDeBacheView');	
	}


	//Metodo del controlador que ataja la subida de imagenes
	//al servidor.	
	// http://localhost/gitBaches/ProyectoBacheo/web/
	public function subirImagen($idBache){
		$this->load->model("Multimedia");
		$this->Multimedia->subirImagen($idBache);
	}

	public function AltaBache(){
		$firephp = FirePHP::getInstance(True);
		
		//Se cargan las reglas los modulos para la validacion de los formularios.
		$this->load->database();
		$this->load->model('Bache');		
		$firephp->log("Inicio de altaBache()");
		$firephp->log("Resultado de la validacion: ".$this->sonDatosValidos('altaBache'));

		$firephp->log("Cargando las reglas...");		

		$firephp->log("--------------------------------------------------------------------------------");
		$firephp->log("--------------------------------------------------------------------------------");
		$datosBache=array( "titulo"=>$_POST["titulo"] ,"latitud"=>$_POST["latitud"],"longitud"=>$_POST["longitud"],"criticidad"=>$_POST["criticidad"],
			"calle"=>$_POST["calle"],"descripcion"=>$_POST["descripcion"],"altura"=>$_POST["altura"]);
			
		$firephp->log("El array de datos es...");
		$firephp->log($datosBache);
		$firephp->log("--------------------------------------------------------------------------------");
		$firephp->log("Arreglo...");
		$firephp->log("..........");
		$firephp->log("--------------------------------------------------------------------------------");


		if ($this->sonDatosValidos()==TRUE) {
			//Descomentar estas lineas para la entrega
			$datosBache=array( "titulo"=>$_POST["titulo"] ,"latitud"=>$_POST["latitud"],"longitud"=>$_POST["longitud"],"criticidad"=>$_POST["criticidad"],
			"calle"=>$_POST["calle"],"descripcion"=>$_POST["descripcion"],"altura"=>$_POST["altura"]);
			
			$firephp->log("El array de datos es...");
			$firephp->log($datosBache);

			//Nombre de la copia local del archivo que mantiene el servidor --> "file"=>$_FILES["file"]["tmp_name"]
			$idBache['respuestaJSON']=$this->Bache->darAltaBache($datosBache);

			$firephp->log("Despues de dar de alta el bache!");
			$this->load->view('BacheView',$idBache);	
		}else{
			$firephp->log("El valor de sonCamposValidos no es valido! y es:FALSE");
			//Se carga nuevamente el formulario
			// $this->load->view('CargaDeBacheView');
		}
		$firephp->log("Fin de altaBache()");

	}


	
	/*Esta funcion valida si los datos de los campos del formulario  cumplen con las reglas para 
	las validaciones. SI las cumple retorna True, si no cunmple con alguna retorna FALSE.
	Este metodo acepta como argumento el conjunto de reglas que serán ejecutadas para cada 
	formulario.
	*/
	// NOTA: Las reglas de validacion que acepta sonDatosValidos() estan definidas en el archivo
	// application/config/form_validation.php.
	private function sonDatosValidos(){
		$firephp = FirePHP::getInstance(True);
		$firephp->log("Dentro de sonDatosValidos()...");
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		//BACKUP! version funcionando
		// $this->form_validation->set_rules('titulo','Titulo','required');

		$firephp->log("El arreglo que se cargará es el siguiente:");
		$firephp->log($this->configAltaBache);
		$firephp->log("********************************************");
		$this->form_validation->set_rules($this->configAltaBache);
		$firephp->log("Se cargaron todas las reglas para el altaBache.");

		$sonCamposValidos=TRUE;
		if($this->form_validation->run()==FALSE){
			$firephp->log("Dio FALSE!!!");
			$sonCamposValidos=FALSE;			
		}else{
			$firephp->log("Dio TRUE!!!");
		}
		return $sonCamposValidos;
	}//Fin validarDatos().


	//Dado un idBache se obtiene toda la información del bache, junto con la URL
	// de las imagenes.
	//Para fines de prueba la URL es: http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/obtenerInfo/2.
	//para id=2.
	// public function obtenerInfo($idBache){
	// 	$firephp = FirePHP::getInstance(true);
	// 	$firephp->log("El idBache pasado por parámetro es:".$idBache);
	// 	$this->load->model('Bache');
	// 	return $this->Bache->obtenerInfo($idBache);
	// }


	// http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/BajaBache/
	public function BajaBache($idBache){
		$this->load->database();
		$this->load->model('Bache');		
		$this->Bache->darDeBajaBache($idBache);
	}


	public function asociarObservacion(){
		$this->load->database();
		$this->load->model('Bache');		
		$datosBache=array( "idBache"=>$_POST["idBache"] ,"nombreObservador"=>$_POST["nombreObservador"],"emailObservador"=>$_POST["emailObservador"]);
		$this->Bache->asociarObservacion($datosBache);
	}

	public function formAsociarObservaciones(){
		$this->load->view('formAsociarObservacionesView');	
	}


	//Formulario de prueba para la modificacion de estado.
	//http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formCambiarEstado
	public function formCambiarEstado(){
		$this->load->view("formCambiarEstado");
	}
	//Metodo para modificar el estado de un bache, pasando como argumento el id del bache
	//URL de prueba --> http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formCambiarEstado

	public function modificarEstado(){
		$firephp = FirePHP::getInstance(True);
		$this->load->database();
		$this->load->model('Estado');
		//TODO Deshardcodear el idUsuario cuando se da cambia el estado (cuando este listo el manejo de sesions de usuarios).
		$idUsuario=1;
		$idBache=$_POST["idBache"];
		$estado=$_POST["estadoBache"];
		$firephp->log("idBache=".$idBache.";idUsuario=".$idUsuario.";estado=".$estado);
		$this->Estado->cambiarEstado($idBache,$idUsuario,$estado);
		$firephp->log("Se cambio el estado del bache!");
	}





	//Metodo de prueba para las criticidades
	public function getNiveles(){
		//Se debe realizar conexion en BD. Ver propiedad de config/Autoload.php para eliminar
		//esta instruccion de carga de los controladores y modelos.
		$this->load->database();
		$this->load->model("Criticidad");
		$listaNiveles = $this->Criticidad->obtenerNivelesDeCriticidad();
		foreach ($listaNiveles as $row){
			$nivel = array('id'=>$row["id"],'nombre' => $row["nombre"], 'descripcion'=>$row["descripcion"]);
			echo json_encode($nivel);
			echo "/";
		}
	}


	public function getBaches(){
		$baches = $this->db->get("Bache");
		foreach ($baches->result() as $row){
			echo json_encode($row);
			echo "/";
		}
	}
	// /index.php/inicio/getBache/id/3
	public function getBache(){
		$get = $this->uri->uri_to_assoc();
		$id = $get['id'];
		$this->load->model("Bache");
		$bache= $this->Bache->getBache($id);	
		$this->output->enable_profiler(FALSE);
		$this->template->build_page("bache",$bache);
		
	}

	//Get bache con calle y criticidad.
	//  /web/index.php/inicio/getBacheConCalle/1 
	public function getBacheConCalle($idBache){
		$this->load->model("Bache");
		return $this->Bache->getBache($idBache);
	}

}
/* End of file bache.php */
?>
