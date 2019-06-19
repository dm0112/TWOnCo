<?php

include_once "db.php";
$db= new database();
$conn=$db->returnConn();
if($conn == false)
{
    die("db error" . mysqli_connect_error());
}
$first =$_REQUEST['addFirstName'];
$last = $_REQUEST['addLastName'];
$address = $_REQUEST['addAddress'];
$birthday = $_REQUEST['addDate'];
$phone = $_REQUEST['addNumber'];
$email = $_REQUEST['addEmail'];
$description = $_REQUEST['addDescription'];
$webAddress = $_REQUEST['addWebAddress'];
$userGroup = $_REQUEST['addUserGroup'];

$Image = $_FILES['addPic']['name'];
        $Type = $_FILES['addPic']['type'];
        $Temp = $_FILES['addPic']['tmp_name'];
        $size = $_FILES['addPic']['size'];


$ImageExt = explode('.',$Image);
        $ImgCorrectExt = strtolower(end($ImageExt));
        $Allow = array('jpg','jpeg','png');
        $target = "img/".$Image;




if(isset($_COOKIE["token"]))
if($db->verifyToken($_COOKIE["token"])){
$id=$db->getIdFromToken($_COOKIE["token"]);

if(in_array($ImgCorrectExt, $Allow))
{
    if($size<1000000){
$insert="insert into contacts(IDContact, Nume, Prenume, Address, Birthday, Phone, Email,
    Description, WebAddress, UserGroup,Pic)
    values ('$id','$first','$last','$address','$birthday','$phone','$email','$description','$webAddress','$userGroup','$Image')";

    if(mysqli_query($conn,$insert))
    {
        echo "succes";
        move_uploaded_file($Temp, $target);
       
        
    }
    else {
        echo "failure inserting";
    }
    $location="index2.php";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';

} else {
    echo 'size is too big';
}
}
else {
    echo 'you cannot upload image';
}
}



else {
     $location="index2.php";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}











// if(isset($_COOKIE["token"]))
// if($db->verifyToken($_COOKIE["token"])){
// $id=$db->getIdFromToken($_COOKIE["token"]);
// $insert="insert into contacts(IDContact, Nume, Prenume, Address, Birthday, Phone, Email,
//     Description, WebAddress, UserGroup)
//     values ('$id','$first','$last','$address','$birthday','$phone','$email','$description','$webAddress','$userGroup')";

//     if(mysqli_query($conn,$insert))
//     {
//         //echo "succes";
       
        
//     }
//     else {
//         echo "failure inserting";
//     }
//     $location="index2.php";
//     echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
// }else {
//      $location="index2.php";
//     echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
// }


?>
