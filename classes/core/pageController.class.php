<?php 

abstract class core_pageControllerTemplate{
	
	private static function Success ($data)
	{
		header ("HTTP/1.0 200 Success");
		header('Content-Type: application/json');
		echo	'{"Component":"'.$_PAGE['URL']->component.'",
				  "Identifier":"'.$_PAGE['URL']->identifier.'",
				  "Method":"'.$_PAGE['URL']->method.'",
				  "Payload":'.$data.'}';
	
	}
	
	private static function MethodNotAllowed()
	{
		header ("HTTP/1.0 405 Method Not Allowed");
		header('Content-Type: application/json');
		echo	'{"Component":"'.$_PAGE['URL']->component.'",
				  "Identifier":"'.$_PAGE['URL']->identifier.'",
				  "Method":"'.$_PAGE['URL']->method.'",
				  "Error":{"Type":"Method Not Allowed","Reason":"This section of api does not support this method"}}';
		exit;
	
	}
	
	private static function NotImplemented()
	{
		header ("HTTP/1.0 501 Not Implemented");
		header('Content-Type: application/json');
		echo	'{"Component":"'.$_PAGE['URL']->component.'",
				  "Identifier":"'.$_PAGE['URL']->identifier.'",
				  "Method":"'.$_PAGE['URL']->method.'",
				  "Error":{"Type":"Not Implemented","Reason":"The Api will support transaction in the future but currently does not"}}';
		exit;
	
	}

}