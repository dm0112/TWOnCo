<?php
include_once "db.php";
$db = new database();

$a=$_REQUEST["email"];
$b=$_REQUEST["pass"];



if(strlen($db->verifyLogin($a,$b))>0){
	setcookie("token",$db->verifyLogin($a,$b),time() + (86400 * 30),"/");
	header("Location:/index2.php");
}
else header("Location:/index.php?message=invalid data");




?>