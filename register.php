<?php
include_once "db.php";
$db=new database();
if(isset($_REQUEST["registerName"])
&& !empty($_REQUEST["registerName"]) 
&& isset($_REQUEST["registerLastName"])
&& !empty($_REQUEST["registerLastName"]) 
&& isset($_REQUEST["registerPassword"])
&& !empty($_REQUEST["registerPassword"]) 
&& isset($_REQUEST["registerEmail"])
&& !empty($_REQUEST["registerEmail"]) 
&& isset($_REQUEST["registerPhone"])
&& !empty($_REQUEST["registerPhone"]) 
){

if($db->register($_REQUEST["registerName"],$_REQUEST["registerLastName"],$_REQUEST["registerPassword"],$_REQUEST["registerEmail"],$_REQUEST["registerPhone"])){
	$a=$_REQUEST["registerEmail"];
	$b=$_REQUEST["registerPassword"];
if(strlen($db->verifyLogin($a,$b))>0){
	setcookie("token",$db->verifyLogin($a,$b),time() + (86400 * 30),"/");
	header("Location:/index2.php");
}

}else  header("Location:/index.php?message=email is already used");

}else header("Location:/index.php?message=invalid data");



?>