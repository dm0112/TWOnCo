<?php
include_once 'db.php';
$db= new database();
$idUser= $db->getIdFromToken($_COOKIE["token"]);
if(isset($_POST["csvexport"]))
{
$db= mysqli_connect("localhost", "root", "","onlinecontacts");

    $output = fopen("lista_contacte_csv.csv", "w");  
    fputcsv($output, array('IDContact', 'Nume', 'Prenume','Address','Birthday','Phone', 'Email', 'Description','Web Address','UserGroup','Pictures','ID'));  
    $query = "SELECT * from contacts where idContact='$idUser' ORDER BY IDContact ASC";  
    $result = mysqli_query($db, $query);  
    while($row = mysqli_fetch_assoc($result))  
    {  
         fputcsv($output, $row);  
    }  
    fclose($output); 
   
}



if(isset($_POST["vcardexport"]))
{
    $idContact=$_REQUEST['idContact'];
    if($idContact !=null)
    conctactChecked($idContact);
}



function conctactChecked($idContact)
{
    $query = "SELECT * from contacts where id='$idContact' ";
    $result = mysqli_query($conn,$query);
    $conIDContact        =  $result['IDContact'];  
     $conNume       =  $result['Nume'];  
     $conPrenume       =  $result['Prenume'];  
     $conAddress       = $result['Address'];  
     $conBirthday       = $result['Birthday'];  
     $conPhone       =  $result['Phone'];
     $conEmail        =  $result['Email'];  
     $conDescription       =  $result['Description'];    
     $conWebAddress      =  $result['WebAddress'];  
     $conUserGroup      =  $result['UserGroup'];  
     $conPic       =  $result['Pic'];  
     $conid        =  $result['id'];  

     include("vcard_library/vcardexp.inc.php");

    $vcard = new vcardexp;
    $vcard->setValue("IDContact",$conIDContact);
    $vcard->setValue("Nume",$conNume);
    $vcard->setValue("Prenume",$conPrenume);
    $vcard->setValue("Address",$conAddress);
    $vcard->setValue("Birthday",$conBirthday);
    $vcard->setValue("Phone",$conPhone);
    $vcard->setValue("Email",$conEmail);
    $vcard->setValue("Description",$conDescription);
    $vcard->setValue("WebAddress",$conWebAddress);
    $vcard->setValue("UserGroup",$conUserGroup);
    $vcard->setValue("Pic",$conPic);
    $vcard->setValue("id",$conid);

    $vcard->getCard();
}


if(isset($_POST["atomexport"]))
{
    $db = mysqli_connect("localhost", "root", "","onlinecontacts");
    $query = "SELECT * from contacts where idContact='$idUser' ORDER BY IDContact ASC";
    $auxarray= array();
    if ($result = mysqli_query($db,$query)) {
        
        while ($row = $result->fetch_assoc()) {
           array_push($auxarray, $row);
        }
      
        if(count($auxarray)){
             createXMLfile($auxarray);
         }
        
        $result->free();
    }

}
function createXMLFile($auxarray)
{
    $filePath = 'lista_contacte_xml.xml';
   $dom     = new DOMDocument('1.0', 'utf-8'); 
   $root      = $dom->createElement('contacts'); 
   for($i=0; $i<count($auxarray); $i++){
     
     $conIDContact        =  $auxarray[$i]['IDContact'];  
     $conNume       =  $auxarray[$i]['Nume'];  
     $conPrenume       =  $auxarray[$i]['Prenume'];  
     $conAddress       =  $auxarray[$i]['Address'];  
     $conBirthday       =  $auxarray[$i]['Birthday'];  
     $conPhone       =  $auxarray[$i]['Phone'];
     $conEmail        =  $auxarray[$i]['Email'];  
     $conDescription       =  $auxarray[$i]['Description'];    
     $conWebAddress      =  $auxarray[$i]['WebAddress'];  
     $conUserGroup      =  $auxarray[$i]['UserGroup'];  
     $conPic       =  $auxarray[$i]['Pic'];  
     $conid        =  $auxarray[$i]['id'];  


     $contact = $dom->createElement('contact');
     $contact->setAttribute('IDContact', $conIDContact);
     $Nume     = $dom->createElement('Nume', $conNume); 
     $contact->appendChild($Nume); 
     $Prenume   = $dom->createElement('Prenume', $conPrenume); 
     $contact->appendChild($Prenume); 
     $Address    = $dom->createElement('Address', $conAddress); 
     $contact->appendChild($Address); 
     $Birthday     = $dom->createElement('Birthday', $conBirthday); 
     $contact->appendChild($Birthday); 
     $Phone = $dom->createElement('Phone', $conPhone); 
     $contact->appendChild($Phone);
     $Email = $dom->createElement('Email', $conEmail); 
     $contact->appendChild($Email);
     $Description = $dom->createElement('Description', $conDescription); 
     $contact->appendChild($Description);
     $WebAddress = $dom->createElement('WebAddress', $conWebAddress); 
     $contact->appendChild($WebAddress);
     $UserGroup = $dom->createElement('UserGroup', $conUserGroup); 
     $contact->appendChild($UserGroup);
     $Pic = $dom->createElement('Pic', $conPic); 
     $contact->appendChild($Pic);
     $id = $dom->createElement('id', $conid); 
     $contact->appendChild($id);

     $root->appendChild($contact);
   }
   $dom->appendChild($root); 
   $dom->save($filePath); 
 } 

header('Location:/index2.php');
?>
