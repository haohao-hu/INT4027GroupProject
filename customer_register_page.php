<?php 
 session_start();
   require_once ('includes/login_functions.inc.php');
if (isset($_SESSION['customer_id'])) {

   $url = absolute_url('index.php');
   header("Location: $url");
   exit();     
}
// This page prints any errors associated with registration
// and it creates the entire Register page, including the form.

// Include the header:
$page_title = '| Customer registration';
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
$password="";
$nameErr="";
$emailErr="";
$addressErr="";
$passwordErr="";

if ($_SERVER["REQUEST_METHOD"]=="POST") {
  /* $name=test_input($_POST["name"]);
$email=test_input($_POST["email"]);
$address=test_input($_POST["address"]);
$password=test_input($_POST["pass"]);*/
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

  if (empty($_POST["pass"])) {
    $passwordErr = "Password is required";
  } else if ($_POST['pass'] != $_POST['pass2']){
       $passwordErr = 'Your password did not match the confirmed password.';}
       else {
    $password = test_input($_POST["pass"]);

  }

 
 if ($nameErr==""&&$emailErr==""&&$addressErr==""&&$passwordErr==""){
      $q = "INSERT INTO customer (customer_name,  customer_address, customer_email,customer_password) VALUES ('$name', '$address', '$email', SHA1('$password'))";     
      $r = @mysqli_query ($dbc, $q); 
            if ($r) { // If it ran OK.

         // Print a message:
         echo '<h1>Thank you!</h1>
      <p>You are now registered. </p>';
      session_start();
      list ($check, $data) = check_login($dbc, 'customer',$email, $password);
      $_SESSION['customer_id'] = $data['customer_id'];
      $_SESSION['customer_name'] = $name;
      
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
<h2>Customer registration</h2>
<form id="contacts-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   <div class="field"><label>Name:</label><input type="text" name="name" value=""/><span class="error">* <?php echo $nameErr;?></span></div>
   <div class="field"><label>Address:</label><input type="text" name="address" value=""/><span class="error">* <?php echo $addressErr;?></span></div>
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
