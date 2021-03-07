<?php
require '../config/database.php';
$request_method = $_SERVER["REQUEST_METHOD"];

  switch($request_method)
  {
    case 'GET':
      
      getEtudiants();
      
      break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }
  
  function getEtudiants()
  {
$db = Database::connect();
$q = "SELECT * FROM etudiants";

if(!empty($_GET["id"])) {
        $id = intval($_GET["id"]);
        $q = $q." WHERE id='".$id."'";
}
if(!empty($_GET["level"])) {
    $level = intval($_GET["level"]);
    $q = $q." WHERE niveau='LICENCE ".$level."'";
}
    
    $query = $db->prepare($q);
    $query->execute();
 
    $response = array();
 
    
    while($row = $query->fetch(PDO::FETCH_ASSOC))
    {
      $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }

?>