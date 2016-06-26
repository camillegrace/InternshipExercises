<?php

namespace Netzwelt\Controllers;

use Respect\Validation\Validator as v;
use PDO;

class ProjectController extends basecontroller{


	public function getproject($request, $response){
		if ($_SESSION['loggedin'] == true)
		{
			return $this->view->render($response, 'createproject.twig');
		}
		else 
		{
			return $response->withRedirect('/');
		}
	}

	
	public function postproject($request, $response)
	{

		$code = $request->getParam('code');
		$name = $request->getParam('name');
		$budget = $request->getParam('budget');
		$remarks = $request->getParam('remarks');

		echo $code . $name . $budget . $remarks; 
		require_once __DIR__ . '../connect.php';

		$codeErr = "";
		$nameErr = "";
		$budgetErr = "";
		$remarksErr = "";
		$codeValidator = v::notEmpty();
		$nameValidator = v::notEmpty();
		$budgetValidator = v::notEmpty()->positive();
		$remarksValidator = v::notEmpty();

		try {
  			$codeValidator->check($code);
		} 
		catch(ValidationException $exception) {
   			$codeErr = $exception->getMainMessage();
		}


		try {
		    $nameValidator->check($name);
		} 
		catch(NestedValidationException $exception) {
		    $nameErr = $exception->getMainMessage();
		}

		try {
		    $budgetValidator->check($budget);
		} 
		catch(NestedValidationException $exception) {
		    $budgetErr = $exception->getMainMessage();
		}

		try {
		    $remarksValidator->check($remarks);
		} 
		catch(NestedValidationException $exception) {
		    $remarksErr = $exception->getMainMessage();
		}

		if($codeErr == "" && $nameErr == "" && $budgetErr == "" && $remarksErr == ""){

			$_SESSION['loggedin'] = true;
			

			$code = $_POST['code'];
			$name = $_POST['name'];
			$budget = $_POST['budget'];
			$remarks = $_POST['remarks']; 

			if($newuser->createproject($code, $name, $budget, $remarks))
			{
				return $response->withRedirect($this->router->pathFor('home'));

			}
			else
			{
				//flash na username already exist
				return $response->withRedirect($this->router->pathFor('createproject'));

			} 

		}
		else{
			//may error fill up mabuti
			return $response->withRedirect('/');

		}
	}

	public function projects($request, $response)
	{

    $servername = 'localhost';
    $username = 'root';
    $password = "";
    $dbname = 'netzwelt';
    $empty= "";


    try {
        $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $e)
        {
        echo $e->getMessage();
        }


    $result = $conn->prepare("SELECT name, budget, project_id FROM projects");
    $result->execute();
    $output = $result;

    foreach($output as $row){
      $results[] = $row;
    }

    
    if(empty($results))
    {
      $this->view->render($response, 'projects.twig');
     }

    else
    {
      $this->view->render($response, 'projects.twig', array('projects' => $results));
     }

    return $response;
  }

	public function assign_project($request, $response)
	{
		$servername = 'localhost';
	    $username = 'root';
	    $password = "";
	    $dbname = 'netzwelt';
	    $empty= "";

	    try {
        $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
   		catch(PDOException $e)
        {
        echo $e->getMessage();
        }


		$idnow = $_GET["projects_id"];

		$query = $conn->prepare("SELECT * from users where $idnow=users.project_id");
		$query->execute();
		$result = $query;
		$query1 = $conn->prepare("SELECT user_id, lastname, firstname from users where $idnow!=project_id OR project_id IS NULL");
		$query1->execute();
		$result1 = $query1;
		$results =[];
		$results1 = [];
	
		foreach($result1 as $row1){
		$results1[] = $row1;
		}

		$this->view->render($response, 'assignment.twig', array('nonmembers'=>$results1));
	}



	public function mems($request, $response)
	{
		$servername = 'localhost';
	    $username = 'root';
	    $password = "";
	    $dbname = 'netzwelt';
	    $empty= "";

	    try {
        $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
   		catch(PDOException $e)
        {
        echo $e->getMessage();
        }


		$idnow = $_GET["projects_id"];

		$query = $conn->prepare("SELECT * from users where $idnow=users.project_id");
		$query->execute();
		$result = $query;
		$query1 = $conn->prepare("SELECT user_id, lastname, firstname from users where $idnow!=project_id OR project_id IS NULL");
		$query1->execute();
		$result1 = $query1;
		$results =[];
		$results1 = [];

		foreach($result as $row){
		$results[] = $row;				//Current members
		}

	
		foreach($result1 as $row1){
		$results1[] = $row1;			//Nonmembers
		}

		echo json_encode($results);
		}


		public function add_member($request, $response)
		{
			$servername = 'localhost';
		    $username = 'root';
		    $password = "";
		    $dbname = 'netzwelt';
		    $empty= "";

		    try {
	        $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	        // set the PDO error mode to exception
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        }
	   		catch(PDOException $e)
	        {
	        echo $e->getMessage();
	        }


		    $mem_id = $_POST['name'];
		    $proj_id = $_POST['project_id'];
		    $conn->exec("UPDATE users set project_id= $proj_id where user_id=$mem_id");

		    $query = $conn->prepare("SELECT users.user_id, users.lastname, users.firstname from users where users.user_id = $mem_id");
		    $query->execute();
		    $result = $query;

		    foreach($result as $row){
		    	$results[]=$row;
		    }
			echo json_encode($results);


		}
/*
		public function remove_member($request, $response){
			$settings = $this->settings; //$settings[servername] 
			$servername = $settings['servername'];
			$username = $settings['username'];
			$password = $settings['password'];
			$dbname = $settings['dbname'];

			try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
			catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }

		    $mem_id = $_POST['name'];
			$conn->exec("UPDATE persons set project_id= 0 where person_id=$mem_id");
			
			$query = $conn->prepare("SELECT persons.person_id, persons.Lastname, persons.Firstname from persons where persons.person_id = $mem_id");
		    $query->execute();
		    $result = $query;

		    foreach($result as $row){
		    	$results[]=$row;
		    }
			echo json_encode($results);

		}
		*/
	
}