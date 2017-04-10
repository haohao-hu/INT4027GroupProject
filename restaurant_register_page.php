<?php 
 session_start();
   require_once ('includes/login_functions.inc.php');
if (isset($_SESSION['restaurant_id'])) {

   $url = absolute_url('index.php');
   header("Location: $url");
   exit();     
}
// This page prints any errors associated with registration
// and it creates the entire Register page, including the form.

// Include the header:
$page_title = '| Restaurant registration';
include ('includes/header.html');

// Print any error messages, if they exist:
if (!empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
?>
<?php
$name="";
$email="";
$address="";
$district="";
$password="";
$nameErr="";
$emailErr="";
$addressErr="";
$districtErr="";
$passwordErr="";

if ($_SERVER["REQUEST_METHOD"]=="POST") {

   require_once ('mysqli_connect.php');
include 'includes/test_input.php';
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
  $nameErr = "Only letters and white space allowed"; 
   }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $emailErr = "Invalid email format"; 
    }
  }

  if (empty($_POST["address"])) {
    $addressErr = "Address is required";
  } else {
    $address = test_input($_POST["address"]);
  }
  
    if (empty($_POST["district"])) {
    $districtErr = "District is required";
  } else {
    $district = test_input($_POST["district"]);
  }

  if (empty($_POST["pass"])) {
    $passwordErr = "Password is required";
  } else if ($_POST['pass'] != $_POST['pass2']){
       $passwordErr = 'Your password did not match the confirmed password.';}
       else {
    $password = test_input($_POST["pass"]);

  }

 
 if ($nameErr==""&&$emailErr==""&&$addressErr==""&&$districtErr==""&&$passwordErr==""){
      $q = "INSERT INTO restaurant (restaurant_name,  address, district, email,password) VALUES ('$name', '$address', '$district', '$email', SHA1('$password'))";     
      $r = @mysqli_query ($dbc, $q); 
            if ($r) { // If it ran OK.

         // Print a message:
         echo '<h1>Thank you!</h1>
      <p>You are now registered. </p>';
      session_start();
      list ($check, $data) = check_login($dbc, 'restaurant',$email, $password);
      $_SESSION['restaurant_id'] = $data['restaurant_id'];
      $_SESSION['restaurant_name'] = $name;
      
      // Redirect:
      $url = absolute_url ('restaurant.php');
      header("Location: $url");
      exit(); 
      
      } else { // If it did not run OK.
         
         // Public message:
         echo '<h1>System Error</h1>
         <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
         
         // Debugging message:
         echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                  
      }

 }
 mysqli_close($dbc);
}
  
?>
<!-- content -->
   <div id="content">
      <div class="container">
         <div class="inside">
            <!-- box begin -->
            <div class="box alt">
            	<div class="left-top-corner">
               	<div class="right-top-corner">
                  	<div class="border-top"></div>
                  </div>
               </div>
               <div class="border-left">
               	<div class="border-right">
                  	<div class="inner">
<h2>Restaurant registration</h2>
<form id="contacts-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   <div class="field"><label>Name:</label><input type="text" name="name" value=""/><span class="error">* <?php echo $nameErr;?></span></div>
   <div class="field"><label>Address:</label><input type="text" name="address" value=""/><span class="error">* <?php echo $addressErr;?></span></div>
   <div class="field"><label>District:</label><select name="district">
   <option value=""></option>
<option value="Islands">Islands</option>
<option value="Kwai Tsing">Kwai Tsing</option>
<option value="North">North</option>
<option value="Sai Kung">Sai Kung</option>
<option value="Sha Tin">Sha Tin</option>
<option value="Tai Po">Tai Po</option>
<option value="Tsuen Wan">Tsuen Wan</option>
<option value="Tuen Mun">Tuen Mun</option>
<option value="Yuen Long">Yuen Long</option>
<option value="Kowloon City">Kowloon City</option>
<option value="Kwun Tong">Kwun Tong</option>
<option value="Sham Shui Po">Sham Shui Po</option>
<option value="Wong Tai Sin">Wong Tai Sin</option>
<option value="Yau Tsim Mong">Yau Tsim Mong</option>
<option value="Central & Western">Central & Western</option>
<option value="Eastern">Eastern</option>
<option value="Southern">Southern</option>
<option value="Wan Chai">Wan Chai</option>
</select><span class="error">* <?php echo $districtErr;?></span></div>
	<div class="field"><label>Email:</label><input type="text" name="email" value=""/><span class="error">* <?php echo $emailErr;?></span></div>
	<div class="field"><label>Password:</label><input type="password" name="pass" value=""/><span class="error">* <?php echo $passwordErr;?></span></div>
   <div class="field"><label>Password Confirmation:</label><input type="password" name="pass2" value=""/><span class="error">* </span></div>
	<p></p>
<div class="alignright"><input type="submit" name="submit" value="Register!" /></a></div>

	<input type="hidden" name="submitted" value="TRUE" />
</form>

    </div>
               </div>
               <div class="left-bot-corner">
               	<div class="right-bot-corner">
                  	<div class="border-bot"></div>
                  </div>
               </div>
            </div>
            <!-- box end -->
         </div>
      </div>
   </div>
<?php // Include the footer:
echo '
<!--Recent articles list ends -->    
 </div>
      </div>
   </div>
   <!-- footer -->';
include ('includes/footer.html');
?>
