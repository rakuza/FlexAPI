<?php
class core_url {
	
	public $method;
	public $component;
	public $identifier;
	public $parameters;
	
	function __construct($method,$component,$identifier, array $parameters)
	{
		$this->method = $method;
		$this->component = $component;
		$this->identifier = $identifier;
		$this->parameters = $parameters;
	}
 
 }