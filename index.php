<?php
include_once "db.php";
$db=new database();
if(isset($_COOKIE["token"])){
if($db->verifyToken($_COOKIE["token"]))
    header("Location:index2.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Contacts</title>
    <link rel="stylesheet" href="Style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="Style2.css">
</head>
<body>
    <header>
    <div>
    <p id="card-title">Online Contacts <sup id="card-beta">BETA</sup></p>
    </div>
</header>
    
    
    <div class="card-login-register">

            <div class="card-form">
            
                <div class="card-form-register" id="card-form-register">
            <form action="register.php" method="POST">
                
            <div>
                <label for="registerName">First name* </label> 
                <input type="text" required id="registerName" name ="registerName" placeholder="First name...">
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
                <input type="email" required id="registerEmail" name="registerEmail" placeholder="Email...">
            </div>
            <div>    
                    <label for="registerPhone">Phone*</label>
                    <input type="tel" required id="registerPhone" name="registerPhone" placeholder="Phone...">
             </div>
             <div>
                 <label for="registerTerms" id="card-reg-terms">I have read and accepted the Terms & Conditions</label>
                 <input type="checkbox" value="terms" required id="registerTerms">
             </div>
             <button type="submit">Register</button> 
             <p class="card-message"> Already Registered? <a onclick="hideRegister()" href="#">Login</a></p>
            </form>
        
        
            </div>
        
            <div class="card-form-login" id="card-form-login">
            <form action="login.php" method="POST">
                <div>    
                <label for="registeredEmail">Email*</label>
                <input type="text"  name="email" id="registeredEmail" placeholder="Email...">
            </div>
            <div>    
                <label for="registeredPassword">Password*</label>
                <input type="password" required name="pass" id="registeredPassword" placeholder="Password...">
            </div>
            <button type="submit">Login</button>
            <p class="card-message">Not Registered? <a  onclick="hideLogin()" href="#">Register</a></p>    
        </form>
        </div>
      </div>
     </div>
     
        
        
    <!-- <script src="path/to/vanilla.js"> -->
     <!-- <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script> -->
    <script>
    
    // $('.card-message a').click(function(e){
    //     e.preventDefault();
    //     $('.card-form-login,.card-form-register').toggle(500);
    // } );
   function hideLogin() {
       
    var x=document.getElementById("card-form-login"); // block
       var y=document.getElementById("card-form-register"); // none
       if(y.style.display == "" || y.style.display == "none" ){
        x.style.display = "none";
        y.style.display= "block";
        
       }
   }
   function hideRegister(){
    var x=document.getElementById("card-form-login");
       var y=document.getElementById("card-form-register");
       if(x.style.display == "none" || x.style.display == "" ){
           x.style.display = "block";
           y.style.display= "none";
       }


   }
 

   
   var err=window.location.search.substr(1);
   // if(err=="message=invalid%20data")
   //  window.alert("invalid data");
   if(err.length>0){
    switch(err){
    case "message=invalid%20data": alert("invalid data");
    break;
    case "message=email%20is%20already%20used": alert("email is already used");
    break;
    default: 
   }}
    </script>

<footer class="card-footer1">
        Copyright &copy; 
     </footer>
</body>
</html>