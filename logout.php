<?php
include_once "db.php";
$db = new database();
$id=$db->getIdFromToken($_COOKIE["token"]);
setcookie("token",$db->verifyLogin($a,$b),time() - (86400 * 30),"/");
$db->deleteToken($id);
header("Location:/index.php");



?>