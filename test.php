<?php 

include_once "db.php";
$db= new database();
//$iduser=$db->getIdFromToken($_COOKIE["token"]);
$db->deleteContact(12);

 ?>