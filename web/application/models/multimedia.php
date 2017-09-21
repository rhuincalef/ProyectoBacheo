<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Multimedia
{
	
	// var $falla;
	var $id;
	var $nombreArchivo;
	var $extension;
	
	function __construct()
	{

	}

	private function inicializar($datos)
	{
		$this->id = $datos->id;
		$this->nombreArchivo = $datos->nombreArchivo;
		$this->extension = $datos->extension;
	}

	static public function getInstacia($datos)
	{
		$multimedia = new Multimedia();
		$multimedia->inicializar($datos);
		return $multimedia;
	}

	static public function get($idMultimedia)
	{
		$CI = &get_instance();
		$datos = $CI->MultimediaModelo->get($idMultimedia);
		$multimedia = Multimedia::getInstacia($datos);
		return $multimedia;
	}

	static public function getAll($idFalla)
	{
		$CI = &get_instance();
		$multimedias = array();
		$datos = $CI->MultimediaModelo->getAll($idFalla);
		$multimedias = array_map(function($obj){ return Multimedia::getInstacia($obj); },$datos);
		return $multimedias;
	}

	// Usado para almacenar los pcd
	public function savePCD()
	{
		$CI = &get_instance();
		$this->id = $CI->MultimediaModelo->save($this);
		$this->accion();
		$CI->MultimediaModelo->update($this);
		return $this->id;
	}


	public function save()
	{
		/* Do something. */
		$CI = &get_instance();
		//$this->accion();
		$this->id = $CI->MultimediaModelo->save($this);
		// asociar_con_falla
		$CI->FallaMultimediaModelo->save2($this);
		return $this->id;
	}

	protected function accion()
	{		
		/*		
		Utilizado para realizar alguna accion con el objeto multimedia.
		Por ejemplo, recortarla.
		*/
	}

	public function crearDirectorio($nombreDir)
	{
		$CI = &get_instance();
		if(!is_dir($nombreDir)){ 
		    mkdir($nombreDir, 0777, true);
		} 
	}

}

	/**
	* 
	*/
class ImagenMultimedia extends Multimedia
{
	/*
	Recibe en $datos
		- x, integer coordenada del eje x a partir del cual comenzar el recorte de la imagen
		- y, integer coordenada del eje y a partir del cual comenzar el recorte de la imagen
		- altoRecortar, integer valor de alto para recortar la imagen (<= al alto de la imagen original)
		- anchoRecortar, integer valor de ancho para recortar la imagen (<= al ancho de la imagen original)
		- imagen, por ahora solo jpg
	*/
	var $x;
	var $y;
	var $altoRecortar;
	var $anchoRecortar;
	var $imagen_fuente;
	var $calidad = 100;

	function __construct($datos)
	{
		$this->x = $datos->coordenadas->x;
		$this->y = $datos->coordenadas->y;
		$this->altoRecortar = $datos->coordenadas->alto;
		$this->anchoRecortar = $datos->coordenadas->ancho;
		$this->imagen_fuente = $datos->imagen;
	}

	protected function accion()
	{
		$CI = &get_instance();
		$CI->utiles->debugger($CI->config->item('upload_path'));

		// Path configurado application/config/config.php (upload_path)
		$directorio = $CI->config->item('upload_path').'/'.'TipoFalla';
		if(!is_dir($directorio)){ 
		    mkdir($directorio, 0777, true);
		} 
		$directorio = $directorio.'/'.$this->id;
		// Se crea el directorio para guardar la imagen
		mkdir($directorio, 0777, true);
		// 
		$ancho_fuente = getimagesize($this->imagen_fuente)[0];
		$alto_fuente = getimagesize($this->imagen_fuente)[1];
		// 
		$ancho_destino = $this->anchoRecortar * $ancho_fuente;
		$alto_destino = $this->altoRecortar * $alto_fuente;
		$x = $this->x * $ancho_fuente;
		$y = $this->y * $alto_fuente;
		$to_crop_array = array( 'x' => $x,
								'y' => $y, 
								'width' => $ancho_destino,
								'height' => $alto_destino);
		// $CI->utiles->debugger($this->imagen_fuente);
		// preg_split -> Utilizado para separar informacion del string de la imagen
		$info_imagen = preg_split("/[\s,]+/", $this->imagen_fuente);
		// $CI->utiles->debugger($info_imagen);
		$imagen_fuente_r = imagecreatefromstring(base64_decode($info_imagen[1]));
		// Se recorta la imagen
		$imagen_destino_r = imagecrop($imagen_fuente_r, $to_crop_array);
		
		// Path configurado config.php (upload_path)
		$nombreArchivo = $directorio.'/'.$this->nombreArchivo.'.jpeg';
		imagejpeg($imagen_destino_r, $nombreArchivo, $this->calidad);
		$this->nombreArchivo = $nombreArchivo;
		$CI->MultimediaModelo->update($this);
	}

	public function setNombreArchivo($nombre)
	{
		$this->nombreArchivo = $nombre;
	}

	public function save()
	{
		$CI = &get_instance();
		$this->id = $CI->MultimediaModelo->save($this);
		$this->accion();
		return $this->id;
	}

}

/**
* 
*/
class Imagen extends Multimedia
{
	var $extension;

	function __construct()
	{

	}

	protected function accion()
	{
		$CI = &get_instance();
		$nombreDir = getcwd() . '/' . $this->destino . '/' . $this->idBache;
		$anterior = umask();
        umask(0);
		if(!is_dir($nombreDir)){ 
		    if(!mkdir($nombreDir, 0777, true)) {
		        $CI->utiles->debugger('Fallo al crear las carpetas...');
		    }
		}
		umask($anterior);
		move_uploaded_file($this->fuente, $nombreDir . '/' . $this->nombreArchivo);
		$this->nombreArchivo = $this->destino . '/' . $this->idBache. '/' .$this->nombreArchivo;
		return $idBache;
	}

	public function inicializar($idBache, $nombre, $fuente, $destino)
	{
		$this->fuente = $fuente;
		$this->nombreArchivo = $nombre;
		$this->idBache = $idBache;
		$this->destino = $destino;
	}

	public function setType($type)
	{
		$this->extension = $type;
	}

	public function save()
	{
		$CI = &get_instance();
		$this->accion();
		$this->id = $CI->MultimediaModelo->save($this);
		// asociar_con_falla
		$CI->FallaMultimediaModelo->save2($this);
		return $this->id;
	}

	static public function getAll($falla)
	{
		$imagenes = array();
		$CI = &get_instance();
		try {
			$fallaMultimedia = $CI->FallaMultimedia::getAll($falla->getId());
			foreach ($fallaMultimedia as $value){
				$multim = Multimedia::get($value->idMultimedia);
				if (preg_match('/png|PNG|jpeg|JPEG|gif|GIF|jpg|JPG/', $multim->extension, $matches)) {
					array_push($imagenes, $multim);
				}
			}
		} catch (MY_BdExcepcion $e) {
			return array();
		}
		return $imagenes;
	}
}
