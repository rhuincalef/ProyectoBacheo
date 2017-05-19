<?php

		require_once('ChromePhp.php');
class CustomLogger
{
	public static function log($msg){
        ChromePhp::log($msg);
	}
}

?>