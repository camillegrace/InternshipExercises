<?php

namespace Netzwelt\Controllers;


use Respect\Validation\Validator as v;

class PersonController extends basecontroller{


	public function getCreateperson($request, $response){
		if ($_SESSION['loggedin'] == true){
			return $this->view->render($response, 'createperson.twig');
		}
		else {
			return $response->withRedirect('/');
		}
	}


	public function postCreateperson($request, $response){
		require_once __DIR__ . '../connect.php';

		$username = $request->getParam('username');
		$password = $request->getParam('password');
		$userErr = "";
		$passErr = "";
		$userValidator = v::email()->length(5,200);
		$passValidator = v::alnum()->length(7,11)->noWhitespace();

		try 
		{
  			$userValidator->check($username);
		} 
		catch(ValidationException $exception) 
		{
   			$userErr = $exception->getMainMessage();
		}

		try {
		    $passValidator->assert($password);
		} catch(NestedValidationException $exception) {
		    $errors = $exception->findMessages([
		    'alnum' => 'Password must contain only letters and digits. ',
		    'length' => 'Password must have length of 7 to 11 characters.'
			]);
			$passErr = $errors['alnum'] . $errors['length'];
		}

/*
		$email = $username;
		$split = explode('@',$email);
		$name = $split[0];
		$this->flash->addMessage('username', $name);
		$this->flash->addMessage('passErr', $passErr);
		$this->flash->addMessage('userErr', $userErr);
*/


		if($userErr == "" && $passErr == ""){

			$_SESSION['username'] = $name;
			$_SESSION['loggedin'] = true;
			

			$lastname = $_POST['lastname'];
			$firstname = $_POST['firstname'];
			$username = $_POST['username'];
			$password = $_POST['password']; 

			if($newuser->createperson($lastname, $firstname, $username, $password))
			{
				return $response->withRedirect($this->router->pathFor('home'));

			}
			else
			{
				//flash na username already exist
				return $response->withRedirect($this->router->pathFor('createperson'));

			} 

		}
		else{
			//may error fill up mabuti
			return $response->withRedirect('/');

		}

	}
}

?>