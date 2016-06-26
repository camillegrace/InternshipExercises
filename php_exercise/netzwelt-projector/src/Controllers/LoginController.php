<?php

namespace Netzwelt\Controllers;


class LoginController extends basecontroller{

	public function getLogin($request, $response)
	{
		return $this->view->render($response, 'login.twig');
	}


	public function postLogin($request, $response)
	{

		require_once __DIR__ . '../connect.php';

		$username = $_POST['username'];
		$password = $_POST['password'];

		if($newuser->login($username,$password))
		{
			return $response->withRedirect($this->router->pathFor('home'));

		}
		else
		{
			$this->flash->addMessage('notice','Username and Password did not match');
			return $response->withRedirect($this->router->pathFor('login'));
		} 
	}

	public function logout($request, $response)
  	{
    	session_start();
    	session_unset();
    	session_destroy();
    	return $response->withRedirect('/');
  }
}