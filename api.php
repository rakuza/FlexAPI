<?php
session_start();
require("autoloader.php");

// decode request and turn it into a URL object
$url = array_filter(explode('/',$_SERVER['REQUEST_URI'] ), 'strlen');
$parameters;
switch($_SERVER['REQUEST_METHOD'])
{
	/*
	Style Guide:
	-----------------
	GET: ONLY for retrieval of data
	POST: new entry of data
	PUT: update data 
	DELETE: Remove data
	*/
	
	case "GET":
	$parameters = array_slice($url,3);
	break;
	
	case "POST":
	$parameters = json_decode(file_get_contents("php://input"));
	break;
	
	case "PUT":
	$parameters = json_decode(file_get_contents("php://input"));
	break;
	
	case "DELETE":
	$parameters = json_decode(file_get_contents("php://input"));
	break;
}

$_PAGE = array();
$_PAGE['URL'] = new core_url(
									$_SERVER['REQUEST_METHOD'], //method
									$url[2], //component
									$url[3], //identifier
									$parameters //parameters
									);
$class = &$_PAGE['URL']->component;
if(!class_exists($class))
{
	header ("HTTP/1.0 404 Component not found");
	header('Content-Type: application/json');
	echo	
'{"Component":"'.$_PAGE['URL']->component.'",
"Identifier":"'.$_PAGE['URL']->identifier.'",
"Method":"'.$_PAGE['URL']->method.'",
"Error":{"Type":"Non Existent Component","Reason":"Component is not loadable or not found"}}';
	exit;
}				
$pageController = new $class();
if(!$pageController->CheckPermission($_PAGE['URL']->method))
{
die("AUTHENTICATION FAILURE");
}

switch($_PAGE['URL']->method)
{
	case "GET":
	$pageController->Render();
	break;
	
	case "POST":
	$pageController->Create();
	break;
	
	case "PUT":
	$pageController->UpdateOrCreate();
	break;
	
	case "DELETE":
	$pageController->Delete();
	break;
}


?>