<?php
#namespace Netzwelt\Controllers;

#use PDO;

  $host = "localhost";
  $user = "root";
  $pass = "";
  $name = "netzwelt";

  try
  {
      $db_con = new PDO("mysql:host={$host};dbname={$name}",$user,$pass);
      $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(PDOException $e)
  {
       echo 'Message' .$e->getMessage();
  }


  include_once __DIR__ . '../UserController.php';
  $newuser = new USER($db_con);
