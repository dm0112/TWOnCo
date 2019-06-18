<?php
include_once "db.php";
$db = new database();
$iduser=$db->getIdFromToken($_COOKIE["token"]);
if(isset($_REQUEST["idcontact"]))
$idcontact=$_REQUEST["idcontact"];
if($db->verifyContact($idcontact,$iduser)){
$db->displayContactJson($idcontact);

}




?>