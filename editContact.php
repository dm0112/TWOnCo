<?php

include_once "db.php";
$db= new database();
$conn=$db->returnConn();
if($conn == false)
{
    die("db error" . mysqli_connect_error());
}


if(isset($_POST['deleteContact'])){
$db->deleteContact($_REQUEST["idContact"]);
$location="index2.php";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}
 else{


$first =$_REQUEST['addFirstName'];
$last = $_REQUEST['addLastName'];
$address = $_REQUEST['addAddress'];
$birthday = $_REQUEST['addDate'];
$phone = $_REQUEST['addNumber'];
$email = $_REQUEST['addEmail'];
$description = $_REQUEST['addDescription'];
$webAddress = $_REQUEST['addWebAddress'];
$userGroup = $_REQUEST['addUserGroup'];
$idContact = $_REQUEST['idContact'];


if(isset($_COOKIE["token"]))
if($db->verifyToken($_COOKIE["token"])){
$id=$db->getIdFromToken($_COOKIE["token"]);
$db->deleteContact($idContact); // delete old contact
$insert="insert into contacts(IDContact, Nume, Prenume, Address, Birthday, Phone, Email,
    Description, WebAddress, UserGroup)
    values ('$id','$first','$last','$address','$birthday','$phone','$email','$description','$webAddress','$userGroup')";

    if(mysqli_query($conn,$insert))
    {
        //echo "succes";
       
        
    }
    else {
        echo "failure inserting";
    }
    $location="index2.php";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}else {
     $location="index2.php";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}
}
?>
