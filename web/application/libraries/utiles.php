<?php

	/**
	* 
	*/
	include 'ChromePhp.php';
	
	class Utiles
	{

		function Debugger($objeto)
		{
			ChromePhp::log($objeto);
			/*
			$firephp = FirePHP::getInstance(True);
			$firephp->log($objeto);
			*/
		}
		
	}

	/**
	* 
	*/	
	abstract class Expression
	{
		abstract public function interpret($datos);
	}

	/**
	* 
	*/
	class StringTerminalExpression extends Expression
	{
		private $nombre = null; /* Ejemplo: influencia*/
		private $requerido;
		private $tipo;
		private $regexp;

		function __construct($nombre, $regexp, $requerido=false)
		{
			$this->nombre = $nombre;
			$this->regexp = $regexp;
			$this->requerido = $requerido;
			$this->tipo = "string";
		}

		public function interpret($datos)
		{
			$nombre = $this->nombre;
			$interpretado = 1;

			if (!property_exists($datos, $nombre)) {
				return 0;
			}
			if (!(gettype($datos->$nombre)==$this->tipo)) {
				return 0;
			}
			if ($this->requerido) {
				// if (isset($datos->$nombre) && preg_match($this->regexp, $datos->$nombre))
				if (isset($datos->$nombre))
				{
					$interpretado = 1;
				}
				else
					$interpretado = 0;
			}
			return $interpretado;
		}
	}

	/**
	* 
	*/
	class NumericTerminalExpression extends Expression
	{
		private $nombre = null; /* Ejemplo: influencia*/
		private $requerido;
		private $tipo;  /* Ejemplo: influencia*/

		function __construct($nombre, $tipo, $requerido=false)
		{
			$this->nombre = $nombre;
			$this->tipo = $tipo;
			$this->requerido = $requerido;
		}

		public function interpret($datos)
		{
			$nombre = $this->nombre;
			if (!$this->requerido) {
				return true;
			}
			// La propiedad es requerida
			// Se verifica existe propiedad
			if (!property_exists($datos, $this->nombre)) {
				return 0;
			}
			// Se verifica que la propiedad tenga algún valor
			if (!isset($datos->$nombre)) {
				return 0;
			}
			// Trato de convertir
			// Se verifica que es del tipo de dato correcto
			ChromePhp::log('*************');
			ChromePhp::log('Tipo ingresado: '.gettype($datos->$nombre));
			ChromePhp::log('Valor: '.$datos->$nombre);
			$valor = $datos->$nombre;
			ChromePhp::log($this->tipo.'val');
			$datos->$nombre = call_user_func($this->tipo.'val', $valor);
			ChromePhp::log('Convertido en: '.gettype($datos->$nombre));
			return true;
		}
	}

	class IntegerTerminalExpression extends Expression
	{
		private $nombre = null; /* Ejemplo: influencia*/
		private $requerido;
		private $tipo;  /* Ejemplo: influencia*/

		function __construct($nombre, $requerido=false)
		{
			$this->nombre = $nombre;
			$this->requerido = $requerido;
		}

		public function interpret($datos)
		{
			$nombre = $this->nombre;
			if (!$this->requerido) {
				return true;
			}
			// La propiedad es requerida
			// Se verifica existe propiedad
			if (!property_exists($datos, $this->nombre)) {
				return 0;
			}
			// Se verifica que la propiedad tenga algún valor
			if (!isset($datos->$nombre)) {
				return 0;
			}
			// En algún momento debo verificar que sea valor entero
			$datos->$nombre = (integer)$datos->$nombre;
			return true;
		}
	}

	class AndExpression extends Expression
	{
		private $nombre;
		private $array_expressions = array();

		function __construct($expressions, $nombre)
		{
			$this->nombre = $nombre;
			foreach ($expressions as $key => $value)
			{
				array_push($this->array_expressions, $value);
			}
		}

		public function interpret($datos)
		{
			$nombre = $this->nombre;
			/*
				Se comprueba si en la variable $datos existe la propiedad $nombre 
				para seguir validando los datos en el árbol armado para validarlos.
			*/
			if (!property_exists($datos, $nombre)) {
				return 0;
			}
			$data = $datos->$nombre;

			$valores = array_map(function($expression) use($data)
			{
				/*
					Si en $datos se encuentra una colección de valores de un mismo objeto, se comprueba
					que todos ellos estén correctamentes armados.
				*/
				if (is_array($data)) {
					$valores = array_map(function($obj)use($expression){ return $expression->interpret($obj); }, $data);
					foreach ($valores as $key => $value) {
						if ($value==0) {
							return 0;
						}
					}
					return 1;
				}
				else
					return $expression->interpret($data);
			}, $this->array_expressions);
			foreach ($valores as $key => $value) {
				if ($value==0) {
					return 0;
				}
			}
			return true;
		}
	}

 ?>