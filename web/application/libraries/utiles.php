<?php 
	/**
	* 
	*/

	/**
	* 
	*/
	require_once('FirePHP.class.php');
	class Utiles{
		

		function Debugger($objeto){
			$firephp = FirePHP::getInstance(True);
			$firephp->log($objeto);
		}		
		
	}


 ?>