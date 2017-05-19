<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TipoReparacion
{
	
	var $id;
	var $nombre;
	var $descripcion;
	var $costo;
	
	function __construct()
	{
		
	}

	private function inicializar($datos)
	{
		$this->id = $datos->id;
		$this->nombre = $datos->nombre;
		$this->descripcion = $datos->descripcion;
		$this->costo = $datos->costo;
	}

	static public function getInstancia($id)
	{
		$CI = &get_instance();
		$tipoReparacion = new TipoReparacion();
		$datos = $CI->TipoReparacionModelo->get($id);
		$tipoReparacion->inicializar($datos);		
		return $tipoReparacion;
	}

	// Utilizarlo en caso de ser necesario ahorrar costo.
	static public function get($id)
	{
		$CI = &get_instance();
		$datos = $CI->TipoReparacionModelo->get($id);
		$tipoFalla = new TipoReparacion();
		$tipoFalla->inicializar($datos);
		return $tipoFalla;
	}

	static public function getTipoDeReparacion($id)
	{
		CustomLogger::log('En getTipoDeReparacion() con id: ');
		CustomLogger::log($id);
		$CI = &get_instance();
		$datos = $CI->TipoReparacionModelo->get($id);
		$tipoReparacion = new TipoReparacion();
		$tipoReparacion->inicializar($datos);
		return $tipoReparacion;
	}

	static public function getTipoReparacionPorNombre($nombre)
	{
		$CI = &get_instance();
		$CI->utiles->debugger($nombre);
		$datos = $CI->TipoReparacionModelo->getTipoDeReparacionPorNombre($nombre);
		$tipoReparacion = new TipoReparacion();
		$tipoReparacion->inicializar($datos);
		return $tipoReparacion;
	}

	static public function getAll()
	{
		$CI = &get_instance();
		$tiposReparacion = array();
		try {
			$datos = $CI->TipoReparacionModelo->get_all();
			foreach ($datos as $row)
			{
				$tipoReparacion = new TipoReparacion();
				$tipoReparacion->inicializar($row);
				array_push($tiposReparacion, $tipoReparacion);
			}
		}	
		catch (MY_BdExcepcion $e) {
			echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
		}
		return $tiposReparacion;
	}

	public function save()
	{
		$CI = &get_instance();
		return $CI->TipoReparacionModelo->save($this);
	}

	public function getCosto()
	{
		return $this->costo;
	}

	static public function crear($datos)
	{
		$CI = &get_instance();
		$CI->utiles->debugger($datos);
		$tipoReparacion = new TipoReparacion();
		$tipoReparacion->nombre = $datos->nombre;
		$tipoReparacion->costo = $datos->costo;
		$tipoReparacion->descripcion = $datos->descripcion;
		$tipoReparacion->id = $tipoReparacion->save();
		$CI->utiles->debugger($tipoReparacion);
		return $tipoReparacion;
	}

	public function asociar($idTipoFalla)
	{
		$CI = &get_instance();
		$CI->TipoReparacionModelo->asociar($this->id, $idTipoFalla);
	}

	static public function validarDatos($datos)
	{
		// Creando arbol para TipoReparacion
		$terminal1 = new StringTerminalExpression("nombre", '([a-zA-Z]+)', "true");
		$terminal2 = new NumericTerminalExpression("costo", "double", "true");
		$terminal3 = new StringTerminalExpression("descripcion", "([a-zA-Z]+)", "true");

		$noTerminalTipoReparacion = new AndExpression(array($terminal1, $terminal2, $terminal3), "datos");
		return $noTerminalTipoReparacion->interpret($datos);
	}

	static public function getReparacionesPorTipoFalla($idTipoFalla)
	{
		$CI = &get_instance();
		$arrayReparacionesId =  $CI->TipoReparacionModelo->getReparacionesPorTipoFalla($idTipoFalla);
		$arrayReparaciones = array();
		foreach ($arrayReparacionesId as $key => $value) {
			array_push($arrayReparaciones, $value->idTipoReparacion);
		}
		return $arrayReparaciones;
	}

}