<?php
define('BASEURL', dirname($_SERVER['PHP_SELF']));
define ('DS', DIRECTORY_SEPARATOR);
define ('HOME', dirname(__FILE__));
define('SYSTEM_ERROR_MESSAGE', 'error_message');
define('SYSTEM_INFO_MESSAGE', 'info_message');

ini_set ('display_errors', 1);

require_once HOME . DS . 'utilities' . DS . 'database' . DS . "dbconfig.php";
require_once HOME . DS . 'utilities' . DS . 'bootstrap.php';

function  __autoload($class){
	if (file_exists(HOME . DS . 'utilities' . DS . strtolower($class) . '.php'))
	{
		require_once HOME . DS . 'utilities' . DS . strtolower($class) . '.php';
	}
	else if (file_exists(HOME . DS . 'services' . DS . strtolower($class) . '.php'))
	{
		require_once HOME . DS . 'services' . DS . strtolower($class) . '.php';
	}
	else if (file_exists(HOME . DS . 'controllers' . DS . strtolower($class) . '.php'))
	{
		require_once HOME . DS . 'controllers' . DS . strtolower($class) . '.php';
	}
	else if (file_exists(HOME . DS . 'model' . DS . strtolower($class) . '.php'))
	{
		require_once HOME . DS . 'model' . DS . strtolower($class) . '.php';
	}
}


?>