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
        $firephp->log("El directorio actual: ".getcwd());
        $ds = "/";
        $storeFolder = '../../imgSubidas';

        if (!empty($_FILES)) {    
            // $firephp->log('Files --> :'.$path = $_FILES['file']['name']);
            $firephp->log($_FILES['file']['name']);
            $tempFile = $_FILES['file']['tmp_name'];      
            $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
            $name = $_FILES['file']['name'];
            $targetFile =  $targetPath.$name ;
            $firephp->log("targetFile -->$targetFile");
            //$firephp->log($_FILES["file"]);
            //$firephp->log('asdsadasddasd asdasdsads');

            //move_uploaded_file("/home/pablo/Documentos/ProyectosWeb/ProyectoBacheo/web/application/models/../../imgSubidas/",$targetFile); 
            move_uploaded_file($tempFile,$targetFile);
            $firephp->log("Se almaceno la imagen correctamente!");
            // $firephp->log("resultado");
            // $firephp->log($r);

            $path = $_FILES['file']['name'];
            $firephp->log('El path es: '.$path);    
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $firephp->log('La extension es: '.$ext);    
            $datosMultimedia=array(
                'idBache' =>intval($idBache),
                'nombre' =>strval($_FILES['file']['name']),
                'tipo' =>strval($ext),
                'ruta' =>strval($targetPath)
                );
            $firephp->log("Los datos que se insertarán en la tabla multimedia son:");
            $firephp->log($datosMultimedia);
            $firephp->log("-----------------------------------------------------:");
            //Se carga el modelo para subir la imagen            
            $this->load->model('Multimedia','multimedia');
            $this->multimedia->insert($datosMultimedia);
            $firephp->log("Se insertaron correctamente los datos en la BD!");
        }
        return $idBache;


        // $datosSubidos=array('file_name'=>$targetFile, 'file_ext' =>".jpeg",'file_path' =>$targetPath);

        // Se obtiene la informacion de la imagen subida y se registra en la BD
        // $firephp->log("Imagen subida correctamente al servidor!");
        // $datosSubidos = $this->upload->data();
        // $firephp->log($datosSubidos);

        //BACKUP DE  LA VERSION VIEJA!!!
        //Se carga la configuración para los tipos de archivos y el tamaño maximo que se admite
        // $config['upload_path'] = './imgSubidas/';
        // $config['allowed_types'] = 'gif|jpg|png';
        // $config['max_size'] = '5120'; //5MB max file size.
        // $this->load->library('upload', $config);
        // //Se establece el nombre del campo del formulario del que se leerá la imagen!

        // $campoFormulario = "file";

        // $hayImagen=false;
        // $hayImagen=$this->upload->do_upload($campoFormulario);
        // if($hayImagen==true)
        // {
        //     //Se obtiene la informacion de la imagen subida y se registra en la BD
        //     $firephp->log("Imagen subida correctamente al servidor!");
        //     $datosSubidos = $this->upload->data();
        //     $firephp->log($datosSubidos);
        //     $datosMultimedia=array(
        //         'idBache' =>intval($idBache),
        //         'nombre' =>strval($datosSubidos['file_name']),
        //         'tipo' =>strval($datosSubidos['file_ext']),
        //         'ruta' =>strval($datosSubidos['file_path'])
        //         );
        //     $firephp->log("Los datos que se insertarán en la tabla multimedia son:");
        //     $firephp->log($datosMultimedia);
        //     $firephp->log("-----------------------------------------------------:");

        //     //Se carga el modelo para subir la imagen            
        //     $this->load->model('Multimedia','multimedia');
        // 	$this->multimedia->insert($datosMultimedia);
        //     $firephp->log("Se insertaron correctamente los datos en la BD!");
        // }
        // if(!$hayImagen)
        // {
        //     $firephp->log("No se envio imagen desde el cliente.");
        // }
    }//FIn de subirImagen

    //Este metodo borra los archivos multimedia asociados a un bache.
    public function borrarArchivos($idBache){
        $this->load->database();
        $firephp = FirePHP::getInstance(true);
        $firephp->log("Dentro de borrarArchivos()");
        //Se obtienen las tuplas que tienen el idBache y se borran del disco, luego se borran de la BD.
        $elementos=$this->get_many_by("idBache",$idBache);
        $firephp->log("Los elementos obtenidos son...");
        $firephp->log($elementos);
        for ($i=0; $i < count($elementos); $i++) { 
            $rutaArchivo=$elementos[$i]->ruta.$elementos[$i]->nombre;
            $firephp->log("El archivo a borrar es: ".$rutaArchivo);
            unlink($rutaArchivo);
        }
        //NOTA: delete_by() elimina cero o mas de los elementos en la BD que tengan el valor del atributo.
        $this->delete_by("idBache",$idBache);
        $firephp->log("Se borraron los datos de la BD!");
    }

}
/* End of file multimedia.php */
/* Location: ./application/models/multimedia.php */
?>