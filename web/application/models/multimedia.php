<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Multimedia
	{
		
		// var $falla;
		var $id;
		var $nombreArchivo;
		
		function __construct()
		{

		}

		private function inicializar($datos)
		{
			// $this->falla = Falla::getInstacia($datos->idFalla);;
			$this->id = $datos->id;
			$this->nombreArchivo = $datos->nombreArchivo;
		}

		static public function getInstacia($datos)
		{
			$multimedia = new Multimedia();
			$multimedia->inicializar($datos);
			return $multimedia;
		}

		static public function getAll($idFalla)
		{
			$CI = &get_instance();
			$multimedias = array();
			$datos = $CI->MultimediaModelo->getAll($idFalla[0]);
			$multimedias = array_map(function($obj){ return Multimedia::getInstacia($obj); },$datos);
			return $multimedias;
		}

		public function save()
		{
			$CI = &get_instance();
			$this->id = $CI->MultimediaModelo->save($this);
			$this->accion();
			return $this->id;
		}

		// private function accion()
		// {
			
		// 	Utilizado para realizar alguna accion con el objeto multimedia.
		// 	Por ejemplo, recortarla.
			
		// }
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

			// Path configurado config.php (upload_path)
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
			$imagen_fuente_r = imagecreatefromjpeg($this->imagen_fuente);
			// Se recorta la imagen
			$imagen_destino_r = imagecrop($imagen_fuente_r, $to_crop_array);
			
			// Path configurado config.php (upload_path)
			$nombreArchivo = $directorio.'/'.$this->nombreArchivo.'.jpeg';
			imagejpeg($imagen_destino_r, $nombreArchivo, $this->calidad);
		}

		public function setNombreArchivo($nombre)
		{
			$this->nombreArchivo = $nombre;
		}

	}
?>