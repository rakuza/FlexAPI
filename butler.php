<?php
session_start();
require("autoloader.php");
// decode request and turn it into a URL object
$url = array_filter(explode('/',$_SERVER['REQUEST_URI'] ), 'strlen');
$badmethod = false;
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
	break;
	
	case "POST":
	$badmethod = true;
	break;
	
	case "PUT":
	$badmethod = true;
	break;
	
	case "DELETE":
	$badmethod = true;
	break;
}
$_PAGE = array();
$_PAGE['URL'] = new core_url(
									$_SERVER['REQUEST_METHOD'], //method
									$url[2], //component
									$url[3], //identifier
									array()//parameters
									);
if($badmethod)
{
	header ("HTTP/1.0 405 Method Not Allowed");
	header('Content-Type: application/json');
	echo	'{"Component":"'.$_PAGE['URL']->component.'",
			  "Identifier":"'.$_PAGE['URL']->identifier.'",
			  "Method":"'.$_PAGE['URL']->method.'",
			  "Error":{"Type":"Method Not Allowed","Reason":"This is just for static content only"}}';
	exit;
}
//all component folders must be given increasing levels of permission to become visible to unauthenicated users
$unsecured = array('login');
$authenicated = array('common');

if(!in_array($_PAGE['URL']->component,$unsecured))
{
core_security::CheckSecurityLevel(false,true);
}
if(!in_array($_PAGE['URL']->component,$authenicated) && !in_array($_PAGE['URL']->component,$unsecured))
{
core_security::CheckSecurityLevel(true,true);
}


$fileuri = $_SERVER['DOCUMENT_ROOT'] .'/static/'.$_PAGE['URL']->component .'/'.$_PAGE['URL']->identifier;
if(!file_exists($fileuri))
{
	header ("HTTP/1.0 404 File not found");
	header('Content-Type: application/json');
	echo	
'{"Component":"'.$_PAGE['URL']->component.'",
"Identifier":"'.$_PAGE['URL']->identifier.'",
"Method":"'.$_PAGE['URL']->method.'",
"Error":{"Type":"File not found","Reason":"We searched every where but we just couldnt find it","Debug":"'.$fileuri.'"}}';
	exit;
}

header("X-Sendfile: {$fileuri}");		