<?php

namespace Netzwelt\Controllers;

class HomeController extends basecontroller{
	public function template($request, $response){
		if ($_SESSION['loggedin'] == true)
		{
			return $this->view->render($response, 'projects.twig');
		}
		
		else 
		{
			return $response->withRedirect('/');
		}
	}
}