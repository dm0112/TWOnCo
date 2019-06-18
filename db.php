<?php
class database{
private $dbServerName = "localhost";
private $dbUserName = "root";
private $dbPassword = "";
private $dbName = "onlinecontacts";
private $conn; 
private $iduser;

function __construct(){

$this->dbServerName = "localhost";
$this->dbUserName = "root";
$this->dbPassword = "";
$this->dbName = "onlinecontacts";
$this->conn = mysqli_connect($this->dbServerName,$this->dbUserName, $this->dbPassword,$this->dbName);

}
public function returnConn(){
	return $this->conn;

}
public function verifyLogin($email,$pass){

	$sql = "SELECT * FROM user WHERE (email='$email' and password='$pass')";	
	$result = mysqli_query($this->conn,$sql) or die("Bad query $sql");
	$resultCheck = mysqli_num_rows($result);
	$conn=$email.$pass."secretcode";

	if($row = mysqli_fetch_assoc($result))
	$iduser=$row["IDUser"];
	$this->iduser=$iduser;
	if($resultCheck>0){
		$this->addToken(md5($conn),$iduser);
		return md5($conn);
		
		}
	else return "";

}
public function verifyToken($token){
	$check = false;
	$stmt = mysqli_prepare($this->conn, "SELECT * from tokens where token=?"); 
	mysqli_stmt_bind_param($stmt, 's', $token);
	mysqli_stmt_execute($stmt);
	$stmt->store_result();
	if($stmt -> num_rows > 0)
	$check=true;
return $check;


}
public function getSortedContacts($id){
$all=[];
$i=0;
if(isset($_REQUEST["sortFirstName"]) && !empty($_REQUEST["sortFirstName"])){
$tickets=$this->selectColumn("Nume",$_REQUEST["sortFirstName"],$id);
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);
$i++;
}
if(isset($_REQUEST["sortLastName"]) && !empty($_REQUEST["sortLastName"])){
$tickets=$this->selectColumn("Prenume",$_REQUEST["sortLastName"],$id);
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}
if(isset($_REQUEST["Description"]) && !empty($_REQUEST["Description"])){
$tickets=$this->searchIn($_REQUEST["Description"],$id,"Description");
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}

if(isset($_REQUEST["Address"]) && !empty($_REQUEST["Address"])){
$tickets=$this->searchIn($_REQUEST["Address"],$id,"Address");
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}
if((isset($_REQUEST["BirthdayMin"]) && !empty($_REQUEST["BirthdayMin"]) &&isset($_REQUEST["BirthdayMax"]) && !empty($_REQUEST["BirthdayMax"])) ||
	isset($_REQUEST["BirthdayMin"]) && !empty($_REQUEST["BirthdayMin"]) ||
	isset($_REQUEST["BirthdayMax"]) && !empty($_REQUEST["BirthdayMax"]))

{
$tickets=$this->selectBirthdaySort($id,$_REQUEST["BirthdayMin"],$_REQUEST["BirthdayMax"]);
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}

if(isset($_REQUEST["Phone"]) && !empty($_REQUEST["Phone"])){
$tickets=$this->searchIn($_REQUEST["Phone"],$id,"Phone");
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}
if(isset($_REQUEST["Email"]) && !empty($_REQUEST["Email"])){
$tickets=$this->selectColumn("Email",$_REQUEST["Email"],$id);
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}
if(isset($_REQUEST["WebAddress"]) && !empty($_REQUEST["WebAddress"])){
$tickets=$this->searchIn($_REQUEST["WebAddress"],$id,"WebAddress");
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}
if(isset($_REQUEST["UserGroup"]) && !empty($_REQUEST["UserGroup"])){
$tickets=$this->selectColumn("UserGroup",$_REQUEST["UserGroup"],$id);
for($j=0;$j<sizeof($tickets);$j++)
	array_push($all,$tickets[$j]);

$i++;
}


$finalarray=[];
for($a=0;$a<sizeof($all);$a++)
	if(array_count_values($all)[$all[$a]]==$i){
		if(!in_array($all[$a], $finalarray))
		array_push($finalarray,$all[$a]);
	}
	
return $finalarray;


}
public function selectBirthdaySort($id,$birthdayMin,$birthdayMax){
$contactsid=[];
if(isset($_REQUEST["BirthdayMin"]) && !empty($_REQUEST["BirthdayMin"]) &&isset($_REQUEST["BirthdayMax"]) && !empty($_REQUEST["BirthdayMax"])){
$sql = "select * from contacts where Birthday>='$birthdayMin' and Birthday<='$birthdayMax' and IDContact='$id'";}
else if(isset($_REQUEST["BirthdayMin"]) && !empty($_REQUEST["BirthdayMin"]))
{$sql = "select * from contacts where Birthday>='$birthdayMin' and IDContact='$id'";}
else if(isset($_REQUEST["BirthdayMax"]) && !empty($_REQUEST["BirthdayMax"]))
{$sql = "select * from contacts where Birthday<='$birthdayMax' and IDContact='$id'";}
$result=mysqli_query($this->conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck>0)
	while($row = mysqli_fetch_assoc($result)){
			array_push($contactsid,$row["id"]);
	}
	return $contactsid;
}

public function selectColumn($column,$var,$id){
$contactsid=[];
$sql = "select * from contacts where ".$column."='$var' and IDContact='$id'";
$result=mysqli_query($this->conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck>0)
	while($row = mysqli_fetch_assoc($result)){
			array_push($contactsid,$row["id"]);
	}
	return $contactsid;
}
public function searchIn($var,$id,$cat){ //substring in string
$contactsid=[];
$sql = "select * from contacts where IDContact='$id'";
$result=mysqli_query($this->conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck>0)
	while($row = mysqli_fetch_assoc($result)){
			if(strpos($row["$cat"],$var)!==false)
			array_push($contactsid,$row["id"]);
	}
	return $contactsid;

}


public function viewContacts($iduser,$cond){
	$buffer=" order by";
	switch($cond){
		case "ascname":
		$buffer=$buffer." Nume asc";
		break;
		case "descname":
		$buffer=$buffer." Nume desc";
		break;
		case "desclname":
		$buffer=$buffer." Prenume desc";
		break;
		case "asclname":
		$buffer=$buffer." Prenume asc";
		break;
		case "descbirt":
		$buffer=$buffer." Birthday desc";
		break;
		case "ascbirt":
		$buffer=$buffer." Birthday asc";
		break;
		default: $buffer="";

	}

	$sql = "select * from contacts where IDContact='$iduser' ".$buffer;
	$result=mysqli_query($this->conn,$sql);
	
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck>0)
	while($row = mysqli_fetch_assoc($result)){

		//echo $row["Nume"]."  ".$row["Prenume"]."</br>";
		if($row["Nume"] && $row["Prenume"])
		echo "<li onclick='onClick(".$row["id"].")' id='".$row["id"]."'>".$row["Nume"]." ".$row["Prenume"]."</li>";

		    
}


}
public function displayContact($id){
	$sql = "select * from contacts where id='$id'";
	$result=mysqli_query($this->conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck>0)
	while($row = mysqli_fetch_assoc($result)){
		if($row["Nume"] && $row["Prenume"])
			echo "<li onclick='onClick(".$row["id"].")' id='".$row["id"]."'>".$row["Nume"]." ".$row["Prenume"]."</li>";
	}



}
public function displayContactJson($id){
	$sql = "select * from contacts where id='$id'";
	$result=mysqli_query($this->conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck>0)
	while($row = mysqli_fetch_assoc($result)){
		
echo "{";
echo '"nume":"'.$row["Nume"].'",';
echo '"Prenume":"'.$row["Prenume"].'",';
echo '"Address":"'.$row["Address"].'",';
echo '"Phone":"'.$row["Phone"].'",';
echo '"Email":"'.$row["Email"].'",';
echo '"Birthday":"'.$row["Birthday"].'",';
echo '"Description":"'.$row["Description"].'",';
echo '"WebAddress":"'.$row["WebAddress"].'",';
echo '"UserGroup":"'.$row["UserGroup"].'",';
echo '"Pic":"'.$row["Pic"].'",';
echo '"id":"'.$row["id"].'"';
echo '}';

	}



}
public function getIdFromToken($token){
	$sql = "SELECT * FROM tokens WHERE token='$token'";	
	$result = mysqli_query($this->conn,$sql) or die("Bad query $sql");
	$resultCheck = mysqli_num_rows($result);
	if($row = mysqli_fetch_assoc($result)){
	$iduser=$row["iduser"];
	
}return $iduser;

}
public function getEmailFromToken($token){
	$id=$this->getIdFromToken($token);
	$sql = "SELECT * FROM user WHERE iduser='$id'";
	$result=mysqli_query($this->conn,$sql) or die ("Bad query $sql");
	$resultCheck = mysqli_num_rows($result);
	if($row = mysqli_fetch_assoc($result)){
	

		return $row["Email"];
	}
	
}

public function addToken($token,$iduser){
	$check = $this->verifyToken($token);
    if(!$check){
$stmt = mysqli_prepare($this->conn, "INSERT INTO tokens (iduser,token) VALUES (?,?)"); 
        mysqli_stmt_bind_param($stmt, 'is', $iduser,$token);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);


}
}
public function verifyContact($idcontact,$iduser){
	$stmt=mysqli_prepare($this->conn,"select * from contacts where id=? and idcontact=?");
	mysqli_stmt_bind_param($stmt,'ss',$idcontact, $iduser);
	mysqli_stmt_execute($stmt);
	$stmt->store_result();
	if($stmt->num_rows>0)
		return true;
	return false;
}
public function verifyEmail($email){
	$stmt=mysqli_prepare($this->conn,"select * from user where email=?");
	mysqli_stmt_bind_param($stmt,'s',$email);
	mysqli_stmt_execute($stmt);
	$stmt->store_result();
	if($stmt->num_rows>0)
		return false;
	return true;
}
public function register($name,$lastname,$pass,$email,$phone){
	if($this->verifyEmail($email)){
	$stmt= mysqli_prepare($this->conn,"INSERT INTO user ( Nume, Prenume, Password, Email, Phone) VALUES (?,?,?,?,?) ");
	mysqli_stmt_bind_param($stmt, 'sssss', $name,$lastname,$pass,$email,$phone);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
return true;
}return false;
}

public function deleteToken($iduser){
	$stmt = mysqli_prepare($this->conn,"delete from tokens where iduser=?");
	mysqli_stmt_bind_param($stmt,'i',$iduser);
	mysqli_stmt_execute($stmt);
	return true;
}


public function deleteContact($idcontact){

	$stmt= mysqli_prepare($this->conn,"delete from contacts where id=?");
	mysqli_stmt_bind_param($stmt,'i',$idcontact);
	mysqli_stmt_execute($stmt);
	return true;
}


public function verifyAVForm(){

	if(isset($_REQUEST["sortFirstName"])
&& empty($_REQUEST["sortFirstName"]) 
&& isset($_REQUEST["sortLastName"])
&& empty($_REQUEST["sortLastName"]) 
&& isset($_REQUEST["Address"])
&& empty($_REQUEST["Address"]) 
&& isset($_REQUEST["BirthdayMin"])
&& empty($_REQUEST["BirthdayMin"]) 
&& isset($_REQUEST["BirthdayMax"])
&& empty($_REQUEST["BirthdayMax"])
&& isset($_REQUEST["Email"])
&& empty($_REQUEST["Email"]) 
&& isset($_REQUEST["Phone"])
&& empty($_REQUEST["Phone"]) 
&& isset($_REQUEST["Description"])
&& empty($_REQUEST["Description"]) 
&& isset($_REQUEST["WebAddress"])
&& empty($_REQUEST["WebAddress"])
&& isset($_REQUEST["UserGroup"])
&& empty($_REQUEST["UserGroup"]) 
)
		return true;
	return false;

}

}
        

                            
 ?>
