<?php
include_once 'db.php';
include_once "index2.html";
if(!session_id())
session_start();


$sql="select * from contacts where phone='2313'";
$conList = mysqli_query($conn,$sql);
$_SESSION["conList"]=$conList;
$_SESSION["sqlShit"]=$sql;
echo $_SESSION["sqlShit"];
$first = mysqli_real_escape_string($conn, $_REQUEST['sortFirstName']);
$last = mysqli_real_escape_string($conn, $_REQUEST['sortLastName']);
$address = mysqli_real_escape_string($conn, $_REQUEST['Address']);
$birthdayMin = mysqli_real_escape_string($conn, $_REQUEST['BirthdayMin']);
$birthdayMax = mysqli_real_escape_string($conn, $_REQUEST['BirthdayMax']);

$phone = mysqli_real_escape_string($conn, $_REQUEST['Phone']);
$email = mysqli_real_escape_string($conn, $_REQUEST['Email']);
$description = mysqli_real_escape_string($conn, $_REQUEST['Description']);
$webAddress = mysqli_real_escape_string($conn, $_REQUEST['WebAddress']);
$userGroup = mysqli_real_escape_string($conn, $_REQUEST['UserGroup']);



?>