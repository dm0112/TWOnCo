<?php

include_once 'db.php';
$db= new database();
$conn=$db->returnConn();
$first = $_REQUEST['registerName'];
$last = $_REQUEST['registerLastName'];
$pass = $_REQUEST['registerPassword'];
$phone = $_REQUEST['registerPhone'];
$email = $_REQUEST['registerEmail'];

$currentEmail = $db->getEmailFromToken($_COOKIE["token"]);
if($db->verifyEmail($email) || $currentEmail == $email){
$id=$db->getIdFromToken($_COOKIE["token"]);
$update = "update user set Nume='$last', Prenume='$first', Password='$pass',Email='$email',Phone='$phone' where iduser='$id'";

if(mysqli_query($conn,$update))
{
   // echo "succes";
}
else {
    echo "failure updating";
}
$db->deleteToken($id);
setcookie("token",$db->verifyLogin($email,$pass),time() + (86400 * 30),"/");
header("Location:/index2.php");
}
else header("Location:/index2.php?message=email is already used");




?>