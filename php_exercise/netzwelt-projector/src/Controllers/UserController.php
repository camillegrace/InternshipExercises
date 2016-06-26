<?php
class USER
{
  private $db;

  function __construct($db_con)
  {
    $this->db = $db_con;
  }

  public function createperson($lastname, $firstname, $username, $password)
    {
      try
      {
        $stmt = $this->db->prepare("SELECT * FROM `netzwelt`.`users`  WHERE username=:username LIMIT 1"); 
        $stmt->execute(array(':username'=>$username));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() > 0)
        {
          return false;
        }

        else
        {
          $stmt = $this->db->prepare("INSERT INTO `netzwelt`.`users` (`lastname`, `firstname`, `username`, `password`)
                                             VALUES(:lastname, :firstname, :username, :password)");

          $stmt->bindparam(":lastname", $lastname);
          $stmt->bindparam(":firstname", $firstname);
          $stmt->bindparam(":username", $username);
          $stmt->bindparam(":password", $password);            
          $stmt->execute(); 

          return $stmt; 
        }
      }

      catch(PDOException $e)
      {
        echo $e->getMessage();
      }    
    }

  public function login($username,$password)
  {
    try
    {
      $stmt = $this->db->prepare("SELECT * FROM `netzwelt`.`users`  WHERE username=:username LIMIT 1"); 
      $stmt->execute(array(':username'=>$username));
      $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

      $input = $userRow['password'];

      if($stmt->rowCount() == 1)
      {
        if(strcmp($password, $input) == 0)
        {
          $_SESSION['user_session'] = $userRow['id'];
          $_SESSION['loggedin'] = true;
          return true;
        }
        else
        {
          return false;
        }
      }
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }


  public function is_loggedin()
  {
    if(isset($_SESSION['user_session']))
    {
      return true;
    }
  }

  public function logout($request, $response)
  {
    session_start();
    session_unset();
    session_destroy();
    return $response->withRedirect('/');
  }

  public function createproject($code, $name, $budget, $remarks)
    {
      try
      {
  
        $stmt = $this->db->prepare("SELECT * FROM `netzwelt`.`projects`  WHERE code=:code LIMIT 1"); 
        $stmt->execute(array(':code'=>$code));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() > 0)
        {
          return false;
        }

        else
        {
          $stmt = $this->db->prepare("INSERT INTO `netzwelt`.`projects` (`code`, `name`, `budget`, `remarks`)
                                             VALUES(:code, :name, :budget, :remarks)");

          $stmt->bindparam(":code", $code);
          $stmt->bindparam(":name", $name);
          $stmt->bindparam(":budget", $budget);
          $stmt->bindparam(":remarks", $remarks);            
          $stmt->execute(); 

          return $stmt; 
        }
      }

      catch(PDOException $e)
      {
        echo $e->getMessage();
      }    
    }
}

?>