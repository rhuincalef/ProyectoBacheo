<?php 
class Multimedia extends MY_Model {

	private $idBache;
	private $nombre;
	private $tipo;
	private $ruta;	

	public $_table = 'Multimedia';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
    public $primary_key = 'id';//Sobreescribiendo el id por defecto.

    public $belongs_to = array( 'Bache' => array('model' => 'Bache', 'primary_key' => 'idBache' ));

	

 	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();

    }

    
	//Esta funcion permite subr una imagen enviada desde el cliente.
    function subirImagen($idBache){    
        $firephp = FirePHP::getInstance(true);
        $firephp->log("Dentro de subir imagen!");
        //Se carga la configuración para los tipos de archivos y el tamaño maximo que se admite
        $config['upload_path'] = './imgSubidas/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5120'; //5MB max file size.
        $this->load->library('upload', $config);
        //Se establece el nombre del campo del formulario del que se leerá la imagen!

        $campoFormulario = "file";

        $hayImagen=false;
        $hayImagen=$this->upload->do_upload($campoFormulario);
        if($hayImagen==true)
        {
            //Se obtiene la informacion de la imagen subida y se registra en la BD
            $firephp->log("Imagen subida correctamente al servidor!");
            $datosSubidos = $this->upload->data();
            $firephp->log($datosSubidos);
            $datosMultimedia=array(
                'idBache' =>intval($idBache),
                'nombre' =>strval($datosSubidos['file_name']),
                'tipo' =>strval($datosSubidos['file_ext']),
                'ruta' =>strval($datosSubidos['file_path'])
                );
            $firephp->log("Los datos que se insertarán en la tabla multimedia son:");
            $firephp->log($datosMultimedia);
            $firephp->log("-----------------------------------------------------:");

            //Se carga el modelo para subir la imagen            
            $this->load->model('Multimedia','multimedia');
        	$this->multimedia->insert($datosMultimedia);
            $firephp->log("Se insertaron correctamente los datos en la BD!");
        }
        if(!$hayImagen)
        {
            $firephp->log("NO se envio imagen desde el cliente.");
        }
    }//FIn de subirImagen

//TODO CONSULTAR: Haria falta que al borrar se borren las imagenes asociadas a un bache?

}
/* End of file multimedia.php */
/* Location: ./application/models/multimedia.php */
?>