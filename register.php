<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <!--REQUIRED FOR HEADER-->
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>$(function(){
  $("#header").load("header.html"); });

   //form validation
   function validateForm() {
    
     var inputs = ["email", "username", "password", "firstname", "lastname", "area", "phone"];
     var ctr = 0;     
     for (i = 0; i < inputs.length; i++) {

	var value = document.forms["myform"][inputs[i]].value;
	if (value == "" || value == null) {
         	ctr++;
		if(inputs[i] == "area") {
                	document.getElementById("phone").innerHTML = " Input Required";
                	document.getElementById("phone").style.color = "red";
            	}
            	else {
               		document.getElementById(inputs[i]).innerHTML = " Input Required";
               		document.getElementById(inputs[i]).style.color = "red";
		}

	}
        else if(inputs[i] == "email") {
		var atpos = value.indexOf("@");
     		var dotpos = value.lastIndexOf(".");
		var confemval = document.forms["myform"]["confemail"].value;
		if(atpos<1 || dotpos<atpos+2 || dotpos+2>=value.length) {
			ctr++;
			document.getElementById(inputs[i]).innerHTML = " Invalid Email Address.";
                	document.getElementById(inputs[i]).style.color = "red";
		}
		else if(value != confemval) {
			ctr++;
			document.getElementById(inputs[i]).innerHTML = " Email doesn't match.";
			document.getElementById(inputs[i]).style.color = "red";
		}
		else {
			document.getElementById(inputs[i]).innerHTML = "";
		}
	}
	else if (inputs[i] == "password"){
		var confpassval = document.forms["myform"]["confpass"].value;
		if(value != confpassval) {
			ctr++;
			document.getElementById(inputs[i]).innerHTML = " Password doesn't match.";
			document.getElementById(inputs[i]).style.color = "red";
		}
		else {
			 document.getElementById(inputs[i]).innerHTML = "";
		}
		
	}
	else if(inputs[i] == "area" && value.length != 3) {
           ctr++;
           document.getElementById(inputs[i]).innerHTML = "Invalid 3 digit Area Code.";
           document.getElementById(inputs[i]).style.color = "red";
        }
        else if(inputs[i] == "phone" && value.length != 7) {
            ctr++;
            document.getElementById(inputs[i]).innerHTML = "Invalid phone Number.";
            document.getElementById(inputs[i]).style.color = "red"; 
        }
	else {
		document.getElementById(inputs[i]).innerHTML = "";
        }
    }
    if (ctr > 0) {
      return false;
        }   
    }

   </script>
</head>
<body>
 <!--REQUIRED FOR HEADER-->
 <div id="header"></div>
<div class="registerbox">
 <h1>Register</h1> 
 <form name="myform" action="register.php" method="post" onsubmit="return validateForm()">
  
  <hr>
    <div class="rows">
       <label id="icon"><i class="icon-user"></i></label>
       <input type="text" name="firstname" placeholder="First Name">
    </div>
    <div class="rows">
       <label id="icon"><i class="icon-user"></i></label>
       <input type="text" name="lastname" placeholder="Last Name"><br>
    </div>
    <div class="rows">
       <p id="firstname"></p>
    </div>
    <div class="rows">
       <p id="lastname"></p>
    </div>
     <br>
   
    <!-- <label>Account Information</label>
     <hr>--> 
    <div class="rows">
       <label id="icon"><i class="icon-user"></i></label>
       <input type="text" name="username" placeholder="Username">
    </div>
    <div class="rows">
    <p id="username"></p>
    </div>
    <br>
    <div class="rows">
       <label id="icon"><i class="icon-key"></i></label>  
       <input type="password" name="password" placeholder="Password"><br>
    </div>
    <div class="rows">
       <label id="icon"><i class="icon-shield"></i></label>
       <input type="password" name="confpass" placeholder="Retype Password">
    </div>
    <div class="rows">
       <p  id="password"></p>
    </div>
    <br>
    <br>
    <label id="shift">Contact</label>
    <hr>
    <div class="rows">
       <label id="icon"><i class="icon-envelope"></i></label>
       <input type="text" name="email" placeholder="Email">
    </div>
    <div class="rows">
       <label id="icon"><i class="icon-shield"></i></label>
       <input type="text" name="confemail" placeholder="Retype Email"><br>
    </div>
    <div class="rows">
       <p id="email"></p>
    </div>
    <br>
    <div class="rows">
       <label id="icon"><i class="icon-phone"></i></label>
        <input type="text" name="area" placeholder="###" size="3" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
    - <input type="text" id="phoneshift" name="phone" placeholder="#######"size="7" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    </div>
    <div class="rows">
       <p id="area"></p>
    </div>
    <div class="rows">
       <p id="phone">
    </div>
    <br>
    <br>
    <input id="shift" type="submit" value="Submit">
  </fieldset>
 </form>
 </div>
</body>
</html>
