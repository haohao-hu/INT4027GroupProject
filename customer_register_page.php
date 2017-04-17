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

$categoryErr="";
$newcategoryErr =""; 
if ($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['newcategorysubmitted'])) {
   if (empty($_POST["newcategory"])) {
    $newcategoryErr = "New category adding is empty!";
  } else {
     require_once ('mysqli_connect.php');
    require_once ('includes/test_input.php');
    $newcategory = test_input($_POST["newcategory"]);
       $q = "INSERT INTO category (category_name) VALUES ('$newcategory')";     
      $r = @mysqli_query ($dbc, $q); 
            if ($r) { // If it ran OK.

         // Print a message:
         echo '<h1>Thank you!</h1>
      <p>New category has been added. </p>';
      } else { // If it did not run OK.
         
         // Public message:
         echo '<h1>System Error</h1>
         <p class="error">New category could not be added due to a system error. We apologize for any inconvenience.</p>'; 
         
         // Debugging message:
         echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                  
      }
  }

}
if ($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['submitted'])) {

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


        if (empty($_POST["category"])) {
    $categoryErr= "At least one category is required";
  } else {
    $category = $_POST["category"];
  }
$fdish=$_POST["favouritedish"];

  if (empty($_POST["pass"])) {
    $passwordErr = "Password is required";
  } else if ($_POST['pass'] != $_POST['pass2']){
       $passwordErr = 'Your password did not match the confirmed password.';}
       else {
    $password = test_input($_POST["pass"]);

  }

 

 if ($nameErr==""&&$emailErr==""&&$addressErr==""&&$passwordErr==""&&$categoryErr==""){
      $q = "INSERT INTO customer (customer_name,  customer_address, customer_email,customer_password) VALUES ('$name', '$address', '$email', SHA1('$password'))";     
      $r = @mysqli_query ($dbc, $q); 
            if ($r) { // If it ran OK.
              $customerid = mysqli_insert_id($dbc);
    foreach($category as $cat){
       $q2 = "INSERT INTO customer_favourite_category (customerId, categoryId) VALUES (".$customerid.", ".$cat.")"; 
       $r2 = @mysqli_query($dbc, $q2)
        Or die ("Cannot add customer-category association.");    
      }
          foreach($fdish as $fd){
       $q9 = "INSERT INTO customer_favourite_dish (customerId, dishId) VALUES (".$customerid.", ".$fd.")"; 
       $r9 = @mysqli_query($dbc, $q9)
        Or die ("Cannot add customer-dish association.");    
      }

         // Print a message:
         echo '<h1>Thank you!</h1>
      <p>You are now registered. </p>';
      session_start();
      list ($check, $data) = check_login($dbc, 'customer',$email, $password);
      $_SESSION['customer_id'] = $data['customer_id'];
      $_SESSION['customer_name'] = $name;
      
      // Redirect:

      $url = absolute_url ();

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

<form role="form" id="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   <div class="form-group"><label>Name:</label><input class="form-control"  type="text" name="name" value=""/><span class="error">* <?php echo $nameErr;?></span></div>
   <div class="form-group"><label>Address:</label><input class="form-control"  type="text" name="address" value=""/><span class="error">* <?php echo $addressErr;?></span></div>
    <div class="form-group"> <label>Your favourite category: (Select one or more)</label><span class="error">* <?php echo $categoryErr;?></span><br/><table>
    <?php 
require_once ('mysqli_connect.php');
    $q2='SELECT * FROM `category`';
     $r2 = @mysqli_query ($dbc, $q2);
while ($row = mysqli_fetch_array ($r2, MYSQLI_ASSOC)) {

  // Display each record:
  echo "\t<tr><td><input type =\"checkbox\" name =\"category[]\" value =\"".$row['category_id']."\">{$row['category_name']}</td></tr>";

}
    ?>
  </table> </div></form>
    <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="add-category-form"><div class="form-group"><label>Could not find the category you want? Add it here:</label><input  class="form-control" form="add-category-form" type="text" name="newcategory" value=""/><span class="error">* <?php echo $newcategoryErr;?></span></div><div class="form-group"><input form="add-category-form" type="submit" name="submit" value="Add" /><input form="add-category-form" type="hidden" name="newcategorysubmitted" value="TRUE" /></div></form>
    <div class="form-group"> <label>Your favourite dish: (optional)</label><br/><table>
    <?php 
//require_once ('mysqli_connect.php');
    $q6='SELECT * FROM `dish`, `restaurant` WHERE `restaurantId`=`restaurant_id`';
     $r6 = @mysqli_query ($dbc, $q6);
while ($row6 = mysqli_fetch_array ($r6, MYSQLI_ASSOC)) {

  // Display each record:
  echo "\t<tr><td><input form=\"register-form\" type =\"checkbox\" name =\"favouritedish[]\" value =\"".$row6['dish_id']."\"";
  if (!empty($previousfdish)){ 
 foreach($previousfdish as $pfdish) {
    if ($pfdish==$row6['dish_id']) {
      echo 'checked' ;
    }
  }
}
  echo ">{$row6['dish_name']} from <a href=\"restaurant_profile.php?restaurantid={$row6['restaurant_id']}\">{$row6['restaurant_name']}</a></td></tr>";

}
    ?>
  </table> </div>
	<div class="form-group"><label>Email:</label><input  class="form-control" type="text" name="email" value="" form="register-form" /><span class="error">* <?php echo $emailErr;?></span></div>
	<div class="form-group"><label>Password:</label><input class="form-control"  type="password" name="pass" value="" form="register-form" /><span class="error">* <?php echo $passwordErr;?></span></div>
   <div class="form-group"><label>Password Confirmation:</label><input class="form-control"  type="password" name="pass2" value="" form="register-form" /><span class="error">* </span></div>
	<p></p>
<div class="form-group"><input type="submit" name="submit" value="Register!" form="register-form" /></a></div>

	<input type="hidden" name="submitted" value="TRUE" form="register-form" />

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

 mysqli_close($dbc);

?>
