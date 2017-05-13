<?php 
 session_start();
   require_once ('includes/login_functions.inc.php');
   require_once ('mysqli_connect.php');

if (!isset($_SESSION['restaurant_id'])) {

   $url = absolute_url('restaurantlogin.php');
   header("Location: $url");
   exit();     
}

   $q='SELECT * FROM `restaurant` WHERE `restaurant_id`='.$_SESSION['restaurant_id'];
   $r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<p class="error">Restaurant does not exist.</p>';
include ('includes/footer.html'); 
  exit();
  // Get the user's information:
}  else {
  $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
   $q3='SELECT * FROM `restaurant_belongs_to_category` WHERE `restaurantId`='.$_SESSION['restaurant_id'];
   $r3 = @mysqli_query ($dbc, $q3);

  while ($row3 = mysqli_fetch_array ($r3, MYSQLI_ASSOC)){
     $previouscategory[]=$row3['categoryId'];
  }

}

// This page prints any errors associated with registration
// and it creates the entire Register page, including the form.

// Include the header:
$page_title = '| Edit Restaurant profile';

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
      $q = "UPDATE `restaurant` SET `restaurant_name`='".$name."',  `address`='".$address."', `district`='".$district."', `email`='".$email."',`password`=SHA1('".$password."') WHERE `restaurant_id`=".$_SESSION['restaurant_id'];     
      $r = @mysqli_query ($dbc, $q); 
  //print_r($category);
            if ($r) { // If it ran OK. Delete previous restaurant-category association 
               $q4 = "DELETE FROM `restaurant_belongs_to_category` WHERE restaurantId=".$_SESSION['restaurant_id']; 
       $r4 = @mysqli_query($dbc, $q4)
        Or die ("Cannot delete previous restaurant-category association.");
              //$restaurantid = mysqli_insert_id($dbc);
    foreach($category as $cat){//Add new restaurant-category association
       $q2 = "INSERT INTO restaurant_belongs_to_category (restaurantId, categoryId) VALUES (".$_SESSION['restaurant_id'].", ".$cat.")"; 
       $r2 = @mysqli_query($dbc, $q2)
        Or die ("Cannot add restaurant-category association.");    
      }
      
    
         // Print a message:
         echo '<h1>Done!</h1>
      <p>Edit has been saved. </p>';
      
      // Redirect:
      $url = absolute_url ();
      header("Location: $url");
      exit(); 
      
      } else { // If it did not run OK.
         
         // Public message:
         echo '<h1>System Error</h1>
         <p class="error"><h3>Your profile could not updated due to a system error. We apologize for any inconvenience.</h3></p>'; 
         
         // Debugging message:
         echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                  
      }

 }//else {echo "<h2>System error</h2>";}

}
  require_once ('includes/header.html');
?>
<?php         // Print any error messages, if they exist:
if (!empty($errors)) {
  echo '<h1>Error!</h1>
  <p class="error">The following error(s) occurred:<br />';
  foreach ($errors as $msg) {
    echo " - $msg<br />\n";
  }
  echo '</p><p>Please try again.</p>';
}?>
<h2>Edit restaurant profile</h2>
<form role="form" id="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   <div class="form-group field"><label>Name:</label><input class="form-control" type="text" name="name" value="<?php  echo $row['restaurant_name'] ?>"/><span class="error">* <?php echo $nameErr;?></span></div>
   <div class="form-group field"><label>Address:</label><input  class="form-control" type="text" name="address" value="<?php  echo $row['address'] ?>"/><span class="error">* <?php echo $addressErr;?></span></div>
   <div class="form-group field"><label>District:</label><select  class="form-control" name="district">
   <option value=""></option>
<?php 
$districtlist=array("Islands",
"Kwai Tsing",
"North",
"Sai Kung",
"Sha Tin",
"Tai Po",
"Tsuen Wan",
"Tuen Mun",
"Yuen Long",
 "Kowloon City",
 "Kwun Tong",
 "Sham Shui Po",
 "Wong Tai Sin",
 "Yau Tsim Mong",
 "Central & Western",
 "Eastern",
 "Southern",
 "Wan Chai");
foreach ($districtlist as $districtname){
  echo '<option value="'.$districtname.'"';
  if ($districtname==$row['district']) {
    echo ' selected ';
  }
  echo '>'.$districtname.'</option>';
}
   ?>

</select><span class="error">* <?php echo $districtErr;?></span></div>
  
  <div class="form-group field"> <label>Category: (Select one or more)</label><span class="error">* <?php echo $categoryErr;?></span><br/><table>
    <?php 
require_once ('mysqli_connect.php');
    $q2='SELECT * FROM `category`';
     $r2 = @mysqli_query ($dbc, $q2);
while ($row2 = mysqli_fetch_array ($r2, MYSQLI_ASSOC)) {

  // Display each record:
  echo "\t<tr><td><input type =\"checkbox\" name =\"category[]\" value =\"".$row2['category_id']."\"";
  foreach($previouscategory as $pcategory) {
    if ($pcategory==$row2['category_id']) {
      echo 'checked' ;
    }
  }
  echo ">{$row2['category_name']}</td></tr>";

}
    ?>
  </table> </div></form>
    <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="add-category-form"><div class="form-group field"><label>Could not find the category you want? Add it here:</label><input  class="form-control" form="add-category-form" type="text" name="newcategory" value=""/><span class="error">* <?php echo $newcategoryErr;?></span></div><div class="alignright"><input form="add-category-form" type="submit" name="submit" value="Add category" /><input form="add-category-form" type="hidden" name="newcategorysubmitted" value="TRUE" /></div></form>
  <div class="form-group field"><label>Email:</label> <input  class="form-control" type="text" name="email" value="<?php  echo $row['email'] ?>" form="register-form"/><span class="error">* <?php echo $emailErr;?></span></div>
  <div class="form-group field"><label>Password:</label><input  class="form-control" type="password" name="pass" value="" form="register-form"/><span class="error">* <?php echo $passwordErr;?></span></div>
   <div class="form-group"><label>Password Confirmation:</label><input  class="form-control" type="password" name="pass2" value="" form="register-form"/><span class="error">* </span></div>
<div class="form-group"><input form="register-form" type="hidden" name="submitted" value="TRUE" /><input form="register-form" type="submit" name="submit" value="Update profile!" /></div>
<?php // Include the footer:
include ('includes/footer.html');
 mysqli_close($dbc);
?>
