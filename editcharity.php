<!--
Prolog: newcharity.php

Purpose: Page that allows a user to create a new event/program/charity.	
Preconditions: Input a name, date(if applicable), address, city, zip code, description, state, contact phone number,
	and tags associated with this. 
Postconditions: Users new event/program/charity is put into the database. Page transition to the dashboard page.
-->
<?php
 include 'databaselogin.php';
$id = $_GET['id'];
 $db_handle = mysql_connect($server, $db_username, $db_password);
 if (!$db_handle) {
    die(mysql_error());
 }
$db_found = mysql_select_db($database, $db_handle);
 
$charity = mysql_query("SELECT * FROM Charities WHERE (charity_id = '$id')");

if ($charity && mysql_num_rows($charity) > 0)
    {
	$charity = mysql_fetch_assoc($charity);
	$time = strtotime($charity['start_date']);
	if (date('y', $time) != -1) {
	    $year = date('Y', $time);
            $month = date('m', $time);
            $day  = date('d', $time);
	} else {
	    $year = "0000";
            $month = "00";
            $day = "00";
        }
    }
else
    {
        header('location:dashboard.php');
    }
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

if ($username != $charity['charity_owner']) {
   header('location:dashboard.php');
}


 $data = mysql_query("SELECT * FROM Tag");
 ?>

<head>
 <link rel="stylesheet" type="text/css" href="style.css">
 <title>Register Charity/Event/Program</title>
 <!--MOBILE-->
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" type="text/css" href="style.css">
 <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
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
    var inputs = ["Name", "Address", "City", "Description", "ZipCode", "Area", "Phone"];
    var str = "";
    var ctr = 0;

    //Goes through the values of all inputs. Print a input error if it doesn't meet requirements
     for(i = 0; i < inputs.length; i++){
	var value = document.forms["myform"][inputs[i]].value;
 
	if(value == null || value == "") {
	   ctr++;
	   if(inputs[i] == "Area") {
                document.getElementById("Phone").innerHTML = " Input Required.";
		document.getElementById("Phone").style.color = "red";
            }
            else {
		document.getElementById(inputs[i]).innerHTML = " Input Required.";
                document.getElementById(inputs[i]).style.color = "red";
            }
	}
        else if(inputs[i] == "ZipCode" && value.length != 5)
        {
	   ctr++;
           document.getElementById(inputs[i]).innerHTML = "  Enter a valid 5 digit Zip Code.";
           document.getElementById(inputs[i]).style.color = "red";
	}
        else if(inputs[i] == "Area" && value.length != 3)
        {
           ctr++;
           document.getElementById(inputs[i]).innerHTML = "  Enter a valid 3 digit Area Code.";
           document.getElementById(inputs[i]).style.color = "red";
	}
        else if(inputs[i] == "Phone" && value.length != 7)
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
     //if a check box is checked or not. 
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
<form action="updatecharity.php" method="post" name="myform" onsubmit="return validateForm()">
  <fieldset>
    <h1>Edit Your Charity/Event/Program</h1>
    <hr>
    Event Type:<br>
    <select id="dropdowntextarea" name="type">
	<option value="1" <?php if($charity['charity_type'] == "1"){echo "SELECTED";}?>>Charity</option>
	<option value="2" <?php if($charity['charity_type'] == "2"){echo "SELECTED";}?>>Program</option>
	<option value="3" <?php if($charity['charity_type'] == "3"){echo "SELECTED";}?>>Event</option>
    </select><br>
    Name:<p style="display:inline" id="Name"></p><br>
    <input type="text" name="Name" size="50" value="<?php echo $charity['charity_name'];?>"><br>
    Date(if applicable):<br>
    <select id="dropdowntextarea" name="month" size="1">
        <option value="00" <?php if($month == "00"){echo "SELECTED";}?>>month</option>
	<option value="01" <?php if($month == "01"){echo "SELECTED";}?>>January</option>
    	<option value="02" <?php if($month == "02"){echo "SELECTED";}?>>February</option>
    	<option value="03" <?php if($month == "03"){echo "SELECTED";}?>>March</option>
    	<option value="04" <?php if($month == "04"){echo "SELECTED";}?>>April</option>
    	<option value="05" <?php if($month == "05"){echo "SELECTED";}?>>May</option>
    	<option value="06" <?php if($month == "06"){echo "SELECTED";}?>>June</option>
    	<option value="07" <?php if($month == "07"){echo "SELECTED";}?>>July</option>
   	<option value="08" <?php if($month == "08"){echo "SELECTED";}?>>August</option>
    	<option value="09" <?php if($month == "09"){echo "SELECTED";}?>>September</option>
    	<option value="10" <?php if($month == "10"){echo "SELECTED";}?>>October</option>
    	<option value="11" <?php if($month == "11"){echo "SELECTED";}?>>November</option>
    	<option value="12" <?php if($month == "12"){echo "SELECTED";}?>>December</option>
    </select> / 
    <select id="dropdowntextarea" style="margin-left: 0px;" name="day">
	<option value="00" <?php if($day == "00"){echo "SELECTED";}?>>dd</option>    
	<option value="01" <?php if($day == "01"){echo "SELECTED";}?>>01</option>
    	<option value="02" <?php if($day == "02"){echo "SELECTED";}?>>02</option>
    	<option value="03" <?php if($day == "03"){echo "SELECTED";}?>>03</option>
    	<option value="04" <?php if($day == "04"){echo "SELECTED";}?>>04</option>
    	<option value="05" <?php if($day == "05"){echo "SELECTED";}?>>05</option>
    	<option value="06" <?php if($day == "06"){echo "SELECTED";}?>>06</option>
    	<option value="07" <?php if($day == "07"){echo "SELECTED";}?>>07</option>
    	<option value="08" <?php if($day == "08"){echo "SELECTED";}?>>08</option>
    	<option value="09" <?php if($day == "09"){echo "SELECTED";}?>>09</option>
    	<option value="10" <?php if($day == "10"){echo "SELECTED";}?>>10</option>
    	<option value="11" <?php if($day == "11"){echo "SELECTED";}?>>11</option>
    	<option value="12" <?php if($day == "12"){echo "SELECTED";}?>>12</option>
    	<option value="13" <?php if($day == "13"){echo "SELECTED";}?>>13</option>
    	<option value="14" <?php if($day == "14"){echo "SELECTED";}?>>14</option>
    	<option value="15" <?php if($day == "15"){echo "SELECTED";}?>>15</option>
    	<option value="16" <?php if($day == "16"){echo "SELECTED";}?>>16</option>
    	<option value="17" <?php if($day == "17"){echo "SELECTED";}?>>17</option>
    	<option value="18" <?php if($day == "18"){echo "SELECTED";}?>>18</option>
    	<option value="19" <?php if($day == "19"){echo "SELECTED";}?>>19</option>
    	<option value="20" <?php if($day == "20"){echo "SELECTED";}?>>20</option>
    	<option value="21" <?php if($day == "21"){echo "SELECTED";}?>>21</option>
    	<option value="22" <?php if($day == "22"){echo "SELECTED";}?>>22</option>
    	<option value="23" <?php if($day == "23"){echo "SELECTED";}?>>23</option>
    	<option value="24" <?php if($day == "24"){echo "SELECTED";}?>>24</option>
    	<option value="25" <?php if($day == "25"){echo "SELECTED";}?>>25</option>
    	<option value="26" <?php if($day == "26"){echo "SELECTED";}?>>26</option>
    	<option value="27" <?php if($day == "27"){echo "SELECTED";}?>>27</option>
    	<option value="28" <?php if($day == "28"){echo "SELECTED";}?>>28</option>
    	<option value="29" <?php if($day == "29"){echo "SELECTED";}?>>29</option>
    	<option value="30" <?php if($day == "30"){echo "SELECTED";}?>>30</option>
    	<option value="31" <?php if($day == "31"){echo "SELECTED";}?>>31</option>
    </select> 
    <select id="dropdowntextarea" style="margin-left: 0px;" name="year">
	<option value="0000" <?php if($year == "0000"){echo "SELECTED";}?>>yyyy</option>
        <option value="2016" <?php if($year == "2016"){echo "SELECTED";}?>>2016</option>
	<option value="2017" <?php if($year == "2017"){echo "SELECTED";}?>>2017</option>
	<option value="2018" <?php if($year == "2018"){echo "SELECTED";}?>>2018</option>
	<option value="2019" <?php if($year == "2019"){echo "SELECTED";}?>>2019</option>
	<option value="2020" <?php if($year == "2020"){echo "SELECTED";}?>>2020</option>
	<option value="2021" <?php if($year == "2021"){echo "SELECTED";}?>>2021</option>
	<option value="2022" <?php if($year == "2022"){echo "SELECTED";}?>>2022</option>
	<option value="2023" <?php if($year == "2023"){echo "SELECTED";}?>>2023</option>
	<option value="2024" <?php if($year == "2024"){echo "SELECTED";}?>>2024</option>
	<option value="2025" <?php if($year == "2025"){echo "SELECTED";}?>>2025</option>
	<option value="2026" <?php if($year == "2026"){echo "SELECTED";}?>>2026</option> 
   </select>
    <br>
    Address:<p style="display:inline" id="Address" ></p><br>
    <input type="text" name="Address" size="50" value="<?php echo $charity['street_address'];?>"><br>
    City: <p style="display:inline" id="City"></p><br>
    <input type="text" name="City" size="20" value="<?php echo $charity['city_name'];?>"><br>
    State:<br>
    <select id="dropdowntextarea" name = "State">
	<option value="AL" <?php if($charity['state_abrev'] == "AL"){echo "SELECTED";}?>>Alabama</option>
	<option value="AK" <?php if($charity['state_abrev'] == "AK"){echo "SELECTED";}?>>Alaska</option>
	<option value="AZ" <?php if($charity['state_abrev'] == "AZ"){echo "SELECTED";}?>>Arizona</option>
	<option value="AR" <?php if($charity['state_abrev'] == "AR"){echo "SELECTED";}?>>Arkansas</option>
	<option value="CA" <?php if($charity['state_abrev'] == "CA"){echo "SELECTED";}?>>California</option>
	<option value="CO" <?php if($charity['state_abrev'] == "CO"){echo "SELECTED";}?>>Colorado</option>
	<option value="CT" <?php if($charity['state_abrev'] == "CT"){echo "SELECTED";}?>>Connecticut</option>
	<option value="DE" <?php if($charity['state_abrev'] == "DE"){echo "SELECTED";}?>>Delaware</option>
	<option value="DC" <?php if($charity['state_abrev'] == "DC"){echo "SELECTED";}?>>District Of Columbia</option>
	<option value="FL" <?php if($charity['state_abrev'] == "FL"){echo "SELECTED";}?>>Florida</option>
	<option value="GA" <?php if($charity['state_abrev'] == "GA"){echo "SELECTED";}?>>Georgia</option>
	<option value="HI" <?php if($charity['state_abrev'] == "HI"){echo "SELECTED";}?>>Hawaii</option>
	<option value="ID" <?php if($charity['state_abrev'] == "ID"){echo "SELECTED";}?>>Idaho</option>
	<option value="IL" <?php if($charity['state_abrev'] == "IL"){echo "SELECTED";}?>>Illinois</option>
	<option value="IN" <?php if($charity['state_abrev'] == "IN"){echo "SELECTED";}?>>Indiana</option>
	<option value="IA" <?php if($charity['state_abrev'] == "IA"){echo "SELECTED";}?>>Iowa</option>
	<option value="KS" <?php if($charity['state_abrev'] == "KA"){echo "SELECTED";}?>>Kansas</option>
	<option value="KY" <?php if($charity['state_abrev'] == "KY"){echo "SELECTED";}?>>Kentucky</option>
	<option value="LA" <?php if($charity['state_abrev'] == "LA"){echo "SELECTED";}?>>Louisiana</option>
	<option value="ME" <?php if($charity['state_abrev'] == "ME"){echo "SELECTED";}?>>Maine</option>
	<option value="MD" <?php if($charity['state_abrev'] == "MD"){echo "SELECTED";}?>>Maryland</option>
	<option value="MA" <?php if($charity['state_abrev'] == "MA"){echo "SELECTED";}?>>Massachusetts</option>
	<option value="MI" <?php if($charity['state_abrev'] == "MI"){echo "SELECTED";}?>>Michigan</option>
	<option value="MN" <?php if($charity['state_abrev'] == "MN"){echo "SELECTED";}?>>Minnesota</option>
	<option value="MS" <?php if($charity['state_abrev'] == "MS"){echo "SELECTED";}?>>Mississippi</option>
	<option value="MO" <?php if($charity['state_abrev'] == "MO"){echo "SELECTED";}?>>Missouri</option>
	<option value="MT" <?php if($charity['state_abrev'] == "MT"){echo "SELECTED";}?>>Montana</option>
	<option value="NE" <?php if($charity['state_abrev'] == "NE"){echo "SELECTED";}?>>Nebraska</option>
	<option value="NV" <?php if($charity['state_abrev'] == "NV"){echo "SELECTED";}?>>Nevada</option>
	<option value="NH" <?php if($charity['state_abrev'] == "NH"){echo "SELECTED";}?>>New Hampshire</option>
	<option value="NJ" <?php if($charity['state_abrev'] == "NJ"){echo "SELECTED";}?>>New Jersey</option>
	<option value="NM" <?php if($charity['state_abrev'] == "NM"){echo "SELECTED";}?>>New Mexico</option>
	<option value="NY" <?php if($charity['state_abrev'] == "NY"){echo "SELECTED";}?>>New York</option>
	<option value="NC" <?php if($charity['state_abrev'] == "NC"){echo "SELECTED";}?>>North Carolina</option>
	<option value="ND" <?php if($charity['state_abrev'] == "ND"){echo "SELECTED";}?>>North Dakota</option>
	<option value="OH" <?php if($charity['state_abrev'] == "OH"){echo "SELECTED";}?>>Ohio</option>
	<option value="OK" <?php if($charity['state_abrev'] == "OK"){echo "SELECTED";}?>>Oklahoma</option>
	<option value="OR" <?php if($charity['state_abrev'] == "OR"){echo "SELECTED";}?>>Oregon</option>
	<option value="PA" <?php if($charity['state_abrev'] == "PA"){echo "SELECTED";}?>>Pennsylvania</option>
	<option value="RI" <?php if($charity['state_abrev'] == "RI"){echo "SELECTED";}?>>Rhode Island</option>
	<option value="SC" <?php if($charity['state_abrev'] == "SC"){echo "SELECTED";}?>>South Carolina</option>
	<option value="SD" <?php if($charity['state_abrev'] == "SD"){echo "SELECTED";}?>>South Dakota</option>
	<option value="TN" <?php if($charity['state_abrev'] == "TN"){echo "SELECTED";}?>>Tennessee</option>
	<option value="TX" <?php if($charity['state_abrev'] == "TX"){echo "SELECTED";}?>>Texas</option>
	<option value="UT" <?php if($charity['state_abrev'] == "UT"){echo "SELECTED";}?>>Utah</option>
	<option value="VT" <?php if($charity['state_abrev'] == "VT"){echo "SELECTED";}?>>Vermont</option>
	<option value="VA" <?php if($charity['state_abrev'] == "VA"){echo "SELECTED";}?>>Virginia</option>
	<option value="WA" <?php if($charity['state_abrev'] == "WA"){echo "SELECTED";}?>>Washington</option>
	<option value="WV" <?php if($charity['state_abrev'] == "WV"){echo "SELECTED";}?>>West Virginia</option>
	<option value="WI" <?php if($charity['state_abrev'] == "WI"){echo "SELECTED";}?>>Wisconsin</option>
	<option value="WY" <?php if($charity['state_abrev'] == "WY"){echo "SELECTED";}?>>Wyoming</option>
    </select><br>
    Zip Code: <p style="display:inline" id="ZipCode"></p><br>
    <input type="text" name="ZipCode"  size="5" value="<?php echo $charity['zip_code'];?>" 
		onkeypress='return event.charCode >= 48 && event.charCode <= 57'><br>
    Contact Phone Number: <p style="display:inline" id="Phone"></p><p style="display:inline" id="Area"></p><br> 
    <input type="text" name="Area" placeholder="###" size="2" value="<?php echo $charity['phone_area'];?>" 
		onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
    - <input type="text" id="phoneshift" name="Phone" placeholder="#######"size="7" 
		value="<?php echo $charity['phone_main'];?>" onkeypress='return event.charCode >= 48 && 
		event.charCode <= 57'><br>
    Description: <p style="display:inline" id="Description"></p><br>
    <textarea id="dropdowntextarea" name="Description" cols="100" rows="5" maxlength="500"><?php echo $charity['charity_description'];?></textarea><br><br>

    Tags Related:<p style="display:inline" id="check"></p><br>
 <?php while($row = mysql_fetch_object($data))
      {
          $t2c = mysql_query("SELECT * FROM Tag2Charity WHERE (charity_id = $id) AND (tag_id = $row->tag_id)");
          if ($t2c && mysql_num_rows($t2c) > 0)
          {
	      $checked = 'checked';
          }
          else
          {
              $checked = '';
          }

        // echo "<div class=\"checkdiv\">
        //<input class=\"checkbox-custom\" type=\"checkbox\" id=\"in".$row['tag_name']."\" name=\"".$row['tag_name']."\"  />
        //<label class=\"checkbox-custom-label\" for=\"in".$row['tag_name']."\">".$row['tag_string']."</label>
//</div>";
          echo nl2br("<div class=\"checkdiv\">
	<input id=\"in$row->tag_name\" class=\"checkbox-custom\" type=\"checkbox\" name='$row->tag_name' $checked /><label class=\"checkbox-custom-label\" for=\"in$row->tag_name\"> $row->tag_string </label></div>");
          //echo nl2br("\n");
      }
?>
    <input type="hidden" name="id" value=<?php echo $id?>>
    <br>
    <input type="submit" value="Submit">
  </fieldset>
</div>
</form>
</body>
