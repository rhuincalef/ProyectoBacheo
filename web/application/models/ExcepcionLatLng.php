<?php
 
	class ExcepcionLatLng extends \Exception
	{
	    public function __construct($msg, $code = 100)
	    {
	        parent::__construct($msg, $code);
	    }
	}


?>