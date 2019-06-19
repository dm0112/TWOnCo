<?php
include_once "db.php";
global $db;
$db=new database();

if(isset($_COOKIE["token"])){

if($db->verifyToken($_COOKIE["token"]))
echo "";
else header("Location:/index.php");

}
else header("Location:/index.php");
global $iduser;
$iduser=$db->getIdFromToken($_COOKIE["token"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Contacts</title>
    <link rel="stylesheet" href="Style2.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    
</head>
<body>
    <header>
        <div>
                <p id="card-title">Online Contacts <sup id="card-beta">BETA</sup></p>
                </div>
            </header>
            <aside class="userMenu">
               <button type="submit" class="userEditbtn" onclick="showUserEdit()">User</button>
               <a class="logoutbtn" href="logout.php">logout</a>
           </aside>
        <div class="card-contacts-left-right">
        
                <div class="card-contacts-left">
                
                    <div class="card-search">
                            <div class="dropdown" >
                                    <button class="dropbtn">Sort
                                    </button>
                                    <div class="dropdown-content">
                                <button type="submit" ><a style="text-decoration: none; color: black;" href ="/index2.php?cond=ascname">Ascendent First Name</a></button>
                                      <button type="submit"> <a style="text-decoration: none; color: black;" href="/index2.php?cond=descname"> Descendent First Name</a></button>
                                     <button type="submit">  <a style="text-decoration: none; color: black;" href="/index2.php?cond=asclname"> Ascendent Last Name</a></button>
                                     <button type="submit"> <a style="text-decoration: none; color: black;" href="/index2.php?cond=desclname"> Descendent Last Name</a></button>
                                     <button type="submit">  <a style="text-decoration: none; color: black;" href="/index2.php?cond=ascbirt"> Ascendent BirthDay</a></button>
                                     <button type="submit">  <a style="text-decoration: none; color: black;" href="/index2.php?cond=descbirt"> Descendent BirthDay</a></button>
                                    </div>
                                  </div> 
                        <input type="search" placeholder="Search.." onkeyup="mySearchFunction()" id="searchSimplu">
                        
                    </div>
                  
                
                    
                    <div class="card-contacts-list">
                        <ul id="card-contacts-scroll">

                          <?php
                          $cond="";
                          if(isset($_GET["cond"]))
                          $cond=$_GET["cond"]; 
                            if(isset($_POST["submitAdvancedSort"]))
                           {
                           
                            $contacts=$db->getSortedContacts($iduser);
                            for($i=0;$i<sizeof($contacts);$i++){
                              echo $db->displayContact($contacts[$i]);
                            }
                              if(sizeof($contacts)==0){
                                if($db->verifyAVForm()==true)
                                $db->viewContacts($iduser,$cond);
                            else  {echo "------------no data-----------";
                                echo '<a style="text-decoration: none; color: red;" href=/index2.php> Go Back (click me)</a>';

                                }
                              }
                           }
                            else
                            {
                          $db->viewContacts($iduser,$cond);
                            }
                          
                          ?>
                           
                       
                        
                            <!-- <li >bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li>
                            <li>bip</li>
                            <li> bop</li> -->
                            </ul>
        
                    </div>
                    <div class="card-contacts-left-buttons">
                        <button type="button" id="card-new-contact-btn"  onclick="showNewContact()">New Contact</button>
                        <button type="button" id="card-advanced-sort" onclick="showAdvancedSort()">Advanced Sort</button>
                        <form method="POST" action="export.php" class="card-export">
                            <h3>Export</h3>
                            <button name="csvexport" type="submit" onclick="expCSV()">CSV</button>
                            <button name="vcardexport" type="submit" onclick="expvCard()">vCard</button>
                            <button name="atomexport" type="submit" onclick="expAtom()">Atom</button>
                        </form>
                    </div>
                </div>
                
                <div class="contact-on" id="contact-on">
                <aside class="card-contacts-right">
                    <form action="insertContact.php" method="POST" id="card-contacts-right-show" enctype="multipart/form-data">
                              
                        <div>
                                    <label for="addFirstName">First Name</label>
                                    <input type="text" id="addFirstName" required name="addFirstName" placeholder="  First Name...">
                                 </div>
                                 <div>
                                     <label for="addLastName">Last Name</label>
                                     <input type="text" id="addLastName" required name="addLastName" placeholder="  Last Name...">
                                 </div>
                                 <div>
                                     <label for="addAddress">Address</label>
                                     <input type="text" id="addAddress" name="addAddress" placeholder="  Address...">
                                  </div>
                                  <div>
                                     <label for="addDate">Birthday</label>
                                     <input type="date" id="addDate" name="addDate"  >
                                 </div>
                                 <div>
                                     <label for="addNumber">Phone</label>
                                     <input type="text" id="addNumber" required name="addNumber" placeholder="  Phone...">
                                 </div>
                                 <div>
                                     <label for="addEmail">Email</label>
                                     <input type="email" id="addEmail" name="addEmail" placeholder="  Email...">
                                 </div>
                                 <div>
                                      <label for="addDescription">Description</label>
                                      <input type="text" id="addDescription" name="addDescription" placeholder="  Description...">
                                 </div>
                                 <div>
                                     <label for="addPic" class="btn-pictures">Choose Photos</label>
                                     <input type="file" id="addPic" name="addPic" accept="image/*">
                                 </div>
                                 <div>
                                     <label for="addWebAddress">Web address</label>
                                     <input type="url" id="addWebAddress" name="addWebAddress" placeholder="  link...">
                                 </div>
                                 <div>
                                     <label for="addUserGroup">User group</label>
                                     <input type="text" id="addUserGroup" name="addUserGroup" placeholder="  User Group">
                                 </div>
                        <button type="submit" name="saveContact">Save Contact</button>
                    
                        
                        
                        
                    </form>
        

                  </aside>
                  </div>


                <div id="card-contacts-right-show-edit" style="display: none;" class="card-contacts-right">
                    <form action="editContact.php" method="POST"  enctype="multipart/form-data">
                              
                        <div>
                                    <label for="addFirstName">First Name</label>
                                    <input type="text" id="addFirstNamee" name="addFirstName" placeholder="  First Name...">
                                 </div>
                                 <div>
                                     <label for="addLastName">Last Name</label>
                                     <input type="text" id="addLastNamee" name="addLastName" placeholder="  Last Name...">
                                 </div>
                                 <div>
                                     <label for="addAddress">Address</label>
                                     <input type="text" id="addAddresse" name="addAddress" placeholder="  Address...">
                                  </div>
                                  <div>
                                     <label for="addDate">Birthday</label>
                                     <input type="date" id="addDatee" name="addDate"  >
                                 </div>
                                 <div>
                                     <label for="addNumber">Phone</label>
                                     <input type="text" id="addNumbere" required name="addNumber" placeholder="  Phone...">
                                 </div>
                                 <div>
                                     <label for="addEmail">Email</label>
                                     <input type="email" id="addEmaile" name="addEmail" placeholder="  Email...">
                                 </div>
                                 <div>
                                      <label for="addDescription">Description</label>
                                      <input type="text" id="addDescriptione" name="addDescription" placeholder="  Description...">
                                 </div>
                                 <div>
                                     <label for="addPic" class="btn-pictures">Choose Photos</label>
                                     <input type="file" id="addPice" name="addPic" accept="image/*">
                                 </div>
                                 <div>
                                     <label for="addWebAddress">Web address</label>
                                     <input type="url" id="addWebAddresse" name="addWebAddress" placeholder="  link...">
                                 </div>
                                 <div>
                                     <label for="addUserGroup">User group</label>
                                     <input type="text" id="addUserGroupe" name="addUserGroup" placeholder="  User Group">
                                 </div>
                             
                                <input type="text" style="display: none;" id="idContact" name ="idContact">
                        <button type="submit" name="saveContact" >Save Contact</button>
                        <button type="submit" name="deleteContact">Delete Contact</button>
                    

                        
                      
                        
                    </form>

  </div>


                  <div>    
                    <form action="index2.php" method="POST" id="AdvancedSort" class="card-contacts-right">
                        <div>
                            <label for="sortFirstName">First Name</label>
                            <input type="text"  name="sortFirstName" id="sortFirstName" placeholder="  First Name...">
                        </div>
                        <div>
                            <label for="sortLastName">Last Name</label>
                            <input type="text"  name="sortLastName" id="sortLastName" placeholder="  Last Name...">
                        </div>
                        
                        <div>
                                <label for="Address"> Address </label>
                                <input type="text" id="Address" name="Address" placeholder=" Address..." >
                        </div>
                        <div>
                                <label for="Birthday">Birthday</label>
                                <input type="date" id="Birthday" name="BirthdayMin"  >

                                <input type="date" name="BirthdayMax"  >
                            </div>
                        <div>
                                     <label for="Phone">Phone</label>
                                     <input type="text" id="Phone" name="Phone" placeholder="  Phone...">
                          </div>

                          <div>
                                <label for="Email">Email</label>
                                <input type="email" id="Email" name="Email" placeholder="  Email...">
                     </div>
                     <div>
                            <label for="Description">Description</label>
                            <input type="text" id="Description" name="Description" placeholder="  Description...">
                 </div>

                 <div>
                        <label for="WebAddress">WebAddress</label>
                        <input type="url" id="WebAddress" name="WebAddress" placeholder="  WebAddress...">
             </div>
             <div>
                    <label for="UserGroup">UserGroup</label>
                    <input type="text" id="UserGroup" name="UserGroup" placeholder="  UserGroup...">
         </div>

                        <button type="submit" name="submitAdvancedSort">Search/Back</button>
                   

                    </form>
                  </div>




                  <div>
                    <form action="UserEdit.php" method="POST" id="UserEdit" class="card-contacts-right"> 
                          <h2>User Edit</h2>
                          <div>
                                <label for="registerName">First name* </label> 
                                <input type="text" required name="registerName" id="registerName" placeholder="First name...">
                            </div>
                            
                            <div>
                                <label for="registerLastName">Last name*</label>
                                <input type="text" required id="registerLastName" name="registerLastName" placeholder="Last name...">
                            </div>  
                            <div>   
                                <label for="registerPassword">Password*</label>
                                <input type="password" required id="registerPassword" name="registerPassword" placeholder="Password...">
                            </div>
                            <div>    
                                <label for="registerEmail">Email*</label>
                                <input type="email" required name="registerEmail" id="registerEmail" placeholder="Email...">
                            </div>
                            <div>    
                                    <label for="registerPhone">Phone*</label>
                                    <input type="tel" required name="registerPhone" id="registerPhone" placeholder="Phone...">
                             </div>
                             <button type="submit">Save</button>
                        </form>
                 </div>
        </div>
                 
                  <script>
                  
                    function expCSV(){
                        alert("Exported in CSV format");
                    }
                    function expvCard(){
                        alert("Exported in vCard format");
                    }
                    function expAtom(){
                        alert("Exported in Atom format");
                    }

                    
                    var y = document.getElementById("contact-on");
                            var x = document.getElementById("AdvancedSort");
                            var z = document.getElementById("UserEdit");
                            var w = document.getElementById("card-contacts-right-show-edit");

                    function showNewContact() {
                            
                            
                            document.getElementById("addFirstName").value = "";
                 document.getElementById("addLastName").value = "";
                 document.getElementById("addAddress").value = "";
                 document.getElementById("addEmail").value = "";
                 document.getElementById("addNumber").value = "";
                 document.getElementById("addDate").value = "";
                 document.getElementById("addDescription").value = "";
                 document.getElementById("addWebAddress").value = "";
                 document.getElementById("addUserGroup").value = "";
                 document.getElementById("addPic").value = "";
                            if (y.style.display == "none" || y.style.display == "") {
                                y.style.display = "block";
                                x.style.display = "none";
                                z.style.display = "none";
                                w.style.display = "none";

                            }
                            else {
                                y.style.display="none";
                                // x.style.display = "block";
                            }
                                }

                    function showContactEdit() {
                            
                            
                            document.getElementById("addFirstNamee").value = "";
                 document.getElementById("addLastNamee").value = "";
                 document.getElementById("addAddresse").value = "";
                 document.getElementById("addNumbere").value = "";
                    document.getElementById("addEmaile").value = "";
                 document.getElementById("addDatee").value = "";
                 document.getElementById("addDescriptione").value = "";
                 document.getElementById("addWebAddresse").value = "";
                 document.getElementById("addUserGroupe").value = "";
                 document.getElementById("addPice").value = "";
                            if (w.style.display == "none" || w.style.display == "") {
                                y.style.display = "none";
                                x.style.display = "none";
                                z.style.display = "none";
                                w.style.display = "flex";
                            }
                            else {
                               // w.style.display="none";
                                // x.style.display = "block";
                            }
                                }

                    function showAdvancedSort(){

                        if(x.style.display == "none" || x.style.display == "")
                        {
                            y.style.display = "none";
                            x.style.display = "flex";
                            z.style.display = "none";
                            w.style.display = "none";

                            
                        }
                        else {
                            // y.style.display = "block";
                            x.style.display = "none";
                        }
                    }
                    
                    function showUserEdit(){
                        
                        if(z.style.display == "none" || z.style.display == "")
                        {
                            y.style.display = "none";
                            z.style.display = "flex";
                            x.style.display = "none";
                            w.style.display = "none";
                        }
                        else{
                            z.style.display = "none";
                        }
                    }
                    




                    function mySearchFunction() {
                        var input, filter, ul, li, a, i, txtValue;
                        input = document.getElementById("searchSimplu");
                        filter = input.value.toUpperCase();
                        ul = document.getElementById("card-contacts-scroll");
                        li = ul.getElementsByTagName("li");
                        for (i = 0; i < li.length; i++) {
                            txtValue = li[i].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                li[i].style.display = "";
                            } else {
                                li[i].style.display = "none";
                            }
                        }
                    }

              function onClick(x){
            //let value=document.getElementById("val").value;
            
              fetch("http://localhost:4000/endpoint.php?idcontact="+x) //da un promise 
              .then((resp)=>{
                return resp.json();
              })
              .then((jsonResp)=>{
               
                console.log(jsonResp);
                
               showContactEdit(); //adaugat e la fiecare camp (edit)
                 document.getElementById("addFirstNamee").value = jsonResp.nume;
                 document.getElementById("addLastNamee").value = jsonResp.Prenume;
                 document.getElementById("addAddresse").value = jsonResp.Address;
                 document.getElementById("addNumbere").value = jsonResp.Phone;
                 document.getElementById("addEmaile").value = jsonResp.Email;
                 document.getElementById("addDatee").value = jsonResp.Birthday;
                 document.getElementById("addDescriptione").value = jsonResp.Description;
                 document.getElementById("addWebAddresse").value = jsonResp.WebAddress;
                 document.getElementById("addUserGroupe").value = jsonResp.UserGroup;
                 document.getElementById("addPice").value = jsonResp.Pic;
                 document.getElementById("idContact").value = jsonResp.id;
                 

              })
              .catch(onError)


            function onError(err){
              console.log(err);

            }
          
          }
            var err=window.location.search.substr(1);
                    if(err.length>0){
                switch(err){
                case "message=invalid%20data": alert("invalid data");
                break;
                case "message=email%20is%20already%20used": alert("email is already used");
                break;
                default: 
               }}

                </script>

            <footer class="card-footer2">
                    Copyright &copy; 
                 </footer>
</body>
</html>

