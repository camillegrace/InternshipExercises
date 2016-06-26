<?php
namespace Netzwelt\Controllers;

class basecontroller
{

	protected $container;

	public function __construct($container)
	{
		$this->container = $container ;
		$this->flash = $container['flash'];
	}

	public function __get($property)
	{
		if($this->container->{$property})
		{
			return $this->container->{$property};
		}
	}
	
}