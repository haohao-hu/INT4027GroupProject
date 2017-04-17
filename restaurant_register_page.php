<?php 
 session_start();
   require_once ('includes/login_functions.inc.php');
   require_once ('mysqli_connect.php');

if (isset($_SESSION['restaurant_id'])) {

   $url = absolute_url('restaurantlogin.php');
   header("Location: $url");
   exit();     
}
// This page prints any errors associated with registration
// and it creates the entire Register page, including the form.

// Include the header:
$page_title = '| Restaurant Sign up';
include ('includes/header.html');



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
$categoryErr="";
$newcategoryErr =""; 
if ($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['newcategorysubmitted'])) {
   if (empty($_POST["newcategory"])) {
    $newcategoryErr = "New category adding is empty!";
  } else {
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

      if (empty($_POST["category"])) {
    $categoryErr= "At least one category is required";
  } else {
    $category = $_POST["category"];
  }

  if (empty($_POST["pass"])) {
    $passwordErr = "Password is required";
  } else if ($_POST['pass'] != $_POST['pass2']){
       $passwordErr = 'Your password did not match the confirmed password.';}
       else {
    $password = test_input($_POST["pass"]);

  }

 
 if ($nameErr==""&&$emailErr==""&&$addressErr==""&&$districtErr==""&&$passwordErr==""&&$categoryErr==""){
      $q = "INSERT INTO restaurant (restaurant_name,  address, district, email,password) VALUES ('$name', '$address', '$district', '$email', SHA1('$password'))";     
      $r = @mysqli_query ($dbc, $q); 
  //print_r($category);
            if ($r) { // If it ran OK.
              $restaurantid = mysqli_insert_id($dbc);
    foreach($category as $cat){
       $q2 = "INSERT INTO restaurant_belongs_to_category (restaurantId, categoryId) VALUES (".$restaurantid.", ".$cat.")"; 
       $r2 = @mysqli_query($dbc, $q2)
        Or die ("Cannot add restaurant-category association.");    
      }
      
    
         // Print a message:
         echo '<h1>Thank you!</h1>
      <p>You are now registered. </p>';
      session_start();
      list ($check, $data) = check_login($dbc, 'restaurant',$email, $password);
      $_SESSION['restaurant_id'] = $data['restaurant_id'];
      $_SESSION['restaurant_name'] = $name;
      
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

 }//else {echo "<h2>System error</h2>";}

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
           <?php         // Print any error messages, if they exist:
if (!empty($errors)) {
  echo '<h1>Error!</h1>
  <p class="error">The following error(s) occurred:<br />';
  foreach ($errors as $msg) {
    echo " - $msg<br />\n";
  }
  echo '</p><p>Please try again.</p>';
}?>
<h2>Restaurant sign up</h2>
<form role="form" id="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   <div class="form-group"><label>Name:</label><input class="form-control"  type="text" name="name" value=""/><span class="error">* <?php echo $nameErr;?></span></div>
   <div class="form-group"><label>Address:</label><input class="form-control"  type="text" name="address" value=""/><span class="error">* <?php echo $addressErr;?></span></div>
   <div class="form-group"><label>District:</label><select class="form-control"  name="district">
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
  
  <div class="form-group"> <label>Category: (Select one or more)</label><span class="error">* <?php echo $categoryErr;?></span><br/><table>
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
    <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="add-category-form"><div class="form-group"><label>Could not find the category you want? Add it here:</label><input class="form-control"  form="add-category-form" type="text" name="newcategory" value=""/><span class="error">* <?php echo $newcategoryErr;?></span></div><div class="alignright"><input form="add-category-form" type="submit" name="submit" value="Add" /><input form="add-category-form" type="hidden" name="newcategorysubmitted" value="TRUE" /></div></form>
  <div class="form-group"><label>Email:</label><input class="form-control"  type="text" name="email" value="" form="register-form"/><span class="error">* <?php echo $emailErr;?></span></div>
  <div class="form-group"><label>Password:</label><input class="form-control"  type="password" name="pass" value="" form="register-form"/><span class="error">* <?php echo $passwordErr;?></span></div>
   <div class="form-group"><label>Password Confirmation:</label><input class="form-control"  type="password" name="pass2" value="" form="register-form"/><span class="error">* </span></div>
  <p></p>
<div class="form-group"><input form="register-form" type="hidden" name="submitted" value="TRUE" /><input form="register-form" type="submit" name="submit" value="Register!" /></div>

  


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
