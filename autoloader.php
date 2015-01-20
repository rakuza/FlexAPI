<?php 
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  
spl_autoload_register(null,false);
spl_autoload_extensions('.mdo.php .ddo.php .hc.php .php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

function CoreClassLoader ($class)
{	
	$class = str_replace('core_','',$class);
	$file = $_SERVER['DOCUMENT_ROOT'].'/classes/core/'.$class.'.class.php';
	if(!file_exists($file))
	{
		return false;
	}
	include_once($file);
}

function IdenticarClassLoader($class)
{
	$class = str_replace('id_','',$class);
	$file = $_SERVER['DOCUMENT_ROOT'].'/classes/id/'.$class.'.class.php';
	if(!file_exists($file))
	{
		return false;
	}
	include_once($file);

}

function IdenticarInterfaceLoader($interface)
{
	$interface = str_replace('id_','',$interface);
	$file = $_SERVER['DOCUMENT_ROOT'].'/classes/id/'.$interface.'.iface.php';
	if(!file_exists($file))
	{
		return false;
	}
	include_once($file);

}

function CoreInterfaceLoader($interface)
{
	$interface = str_replace('core_','',$interface);
	$file = $_SERVER['DOCUMENT_ROOT'].'/classes/id/'.$interface.'.iface.php';
	if(!file_exists($file))
	{
		return false;
	}
	include_once($file);

}

spl_autoload_register('CoreClassLoader');
spl_autoload_register('CoreInterfaceLoader');
spl_autoload_register('IdenticarClassLoader');
spl_autoload_register('IdenticarInterfaceLoader');


?>