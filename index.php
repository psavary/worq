<?php
//Dbpdo::getInstance();

// Holds data like $baseUrl etc
// include 'config.php';
include_once 'bootstrap.php';

//new database();

$requestUrl = $_SERVER['HTTP_HOST'];

$requestString = $_SERVER['REQUEST_URI'];

$urlParams = explode('/', $requestString);

$uriPartIgnore = array( '', 'index.php', null );

foreach($urlParams as $key => $value)
{
	if(in_array($value, $uriPartIgnore))
	{
		unset($urlParams[$key]);
	}
}

$name = array_shift($urlParams);

$controllerName = ucfirst($name).'Controller';

$actionName = strtolower(array_shift($urlParams)).'Action';

// Here you should probably gather the rest as params
// Call the action
//every Controller gets its dependent View diretly injected
$template  = new PHPTAL('./view/' . $name . '.xhtml');

$controller = new $controllerName($template);

//only execute Action if Action is given
if (function_exists($actionName))
{
	$controller->$actionName();
}


?>
