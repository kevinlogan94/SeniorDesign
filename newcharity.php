<?php
include 'databaselogin.php';
unset($username);
$secret_word = 'the horse raced past the barn fell';
if ($_COOKIE['login']) {
    list($c_username,$cookie_hash) = split(',',$_COOKIE['login']);
    if (md5($c_username.$secret_word) == $cookie_hash) {
        $username = $c_username;
    } else {
        print "You have sent a bad cookie.";
    }
}

if (!$username) {
    header('location:login.php');
}

$db_handle = mysql_connect($server, $db_username, $db_password);
if (!$db_handle) {
   die(mysql_error());
}
$db_found = mysql_select_db($database, $db_handle);
$data = mysql_query("SELECT * FROM Tag");
?>

<head>
 <link rel="stylesheet" type="text/css" href="style.css">
 <title>Register Charity/Event/Program</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 <!--REQUIRED FOR HEADER-->
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script>
//insert header
 $(function(){
   $("#header").load("header.html"); });
  
    /*
	validateForm function
	Purpose: Allow a user to submit their information or not based on whether the information is filled 
			out correctly. If not they will be notified on the screen what needs to be filled out.
	Parameters: None
	Return:True if the submit can pass otherwise false.
    */
    function validateForm() {
    var inputs = ["Name", "Address", "City", "Description", "Zip Code", "area", "phone"];
    var str = "";
    var ctr = 0;

    //Goes through the values of all inputs. Print a input error if it doesn't meet requirements
     for(i = 0; i < inputs.length; i++){
	var value = document.forms["myform"][inputs[i]].value;
 
	if(value == null || value == "") {
	   ctr++;
	   if(inputs[i] == "area") {
                document.getElementById("phone").innerHTML = " Input Required.";
		document.getElementById("phone").style.color = "red";
            }
            else {
		document.getElementById(inputs[i]).innerHTML = " Input Required.";
                document.getElementById(inputs[i]).style.color = "red";
            }
	}
        else if(inputs[i] == "Zip Code" && value.length != 5)
        {
	   ctr++;
           document.getElementById(inputs[i]).innerHTML = "  Enter a valid 5 digit Zip Code.";
           document.getElementById(inputs[i]).style.color = "red";
	}
        else if(inputs[i] == "area" && value.length != 3)
        {
           ctr++;
           document.getElementById(inputs[i]).innerHTML = "  Enter a valid 3 digit Area Code.";
           document.getElementById(inputs[i]).style.color = "red";
	}
        else if(inputs[i] == "phone" && value.length != 7)
        {
	    ctr++;
            document.getElementById(inputs[i]).innerHTML = " Enter a valid phone Number.";
           document.getElementById(inputs[i]).style.color = "red" 
        }
	else
	{
	    document.getElementById(inputs[i]).innerHTML = "";
	}
     }
     //if it's checked
      if ($("input[type='checkbox']").is(":checked"))
      {
         document.getElementById("check").innerHTML = "";
      }
      else
      {
	ctr++;
	document.getElementById("check").innerHTML = "You must click a checkbox.";
	document.getElementById("check").style.color = "red"
      }

     //if there was in input error cancel the submit.
     if(ctr > 0)
     {
	return false;
     }
  }
</script>


</head>
<body>
 <!--REQUIRED FOR HEADER-->
 <div id="header"></div>
<div class="newcharitybox">
<form action="processcharity.php" method="post" name="myform" onsubmit="return validateForm()">
  <fieldset>
    <h1>Register Your Charity/Event/Program</h1>
    <hr>
    Event Type:<br>
    <select id="dropdowntextarea" name="type">
	<option value="1">Charity</option>
	<option value="2">Program</option>
	<option value="3">Event</option>
    </select><br>
    Name:<p style="display:inline" id="Name"></p><br>
    <input type="text" name="Name" size="50"><br>
    Date(if applicable):<br>
    <input type="text" name="Program Date" size="10"><br>
    Address:<p style="display:inline" id="Address"></p><br>
    <input type="text" name="Address" size="50"><br>
    City: <p style="display:inline" id="City"></p><br>
    <input type="text" name="City" size="20"><br>
    State:<br>
    <select id="dropdowntextarea" name = "type">
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
    </select><br>
    Zip Code: <p style="display:inline" id="Zip Code"></p><br>
    <input type="text" name="Zip Code"  size="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Contact Phone Number: <p style="display:inline" id="phone"></p><p style="display:inline" id="area"></p><br> 
    <input type="text" name="area" placeholder="###" size="2" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
    - <input type="text" id="phoneshift" name="phone" placeholder="#######"size="7" onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Description: <p style="display:inline" id="Description"></p><br>
    <textarea id="dropdowntextarea" name="Description" cols="100" rows="5" maxlength="500"></textarea><br><br>

    <p  id="check"></p>
    <?php include 'checks.php';?>
    
    <br>
    <input type="hidden" name="owner" value="<?php echo $username; ?>">
    <input type="submit" value="Submit">
  </fieldset>
</div>
</form>
</body>
