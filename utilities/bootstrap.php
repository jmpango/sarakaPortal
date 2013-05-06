<?php
$controller = "login";
$action = "index";
$query = null;

if (isset($_GET['load']))
{
	$params = array();
	$params = explode("/", $_GET['load']);

	$controller = ucwords($params[0]);

	if (isset($params[1]) && !empty($params[1]))
	{
		$action = $params[1];
	}

	if (isset($params[2]) && !empty($params[2]))
	{
		$action = $params[2];
	}

	if (isset($params[3]) && !empty($params[3]))
	{
		$query = $params[3];
	}
}

$modelName = $controller;
$controller .= 'Controller';

if(class_exists(ucwords($controller))){
	$load = new $controller($modelName, $action);
	if (method_exists($load, $action))
	{
		$load->{$action}($query);
	}
	else
	{
		die('Invalid method. Please check the URL.');
	}
}else {
	die('Invalid path provided.');
}
?>