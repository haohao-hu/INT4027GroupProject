<?php 
//session_start();
//include('includes/header.html');
if ($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['submitted'])) {
  /* $name=test_input($_POST["name"]);
$email=test_input($_POST["email"]);
$address=test_input($_POST["address"]);
$password=test_input($_POST["pass"]);*/
   //require_once ('mysqli_connect.php');
include 'includes/test_input.php';
  if (empty(test_input($_POST["tasterate"]))) {
    $errors[] = "Taste rating is required";
  } else {
    $tasterate = test_input($_POST["tasterate"]);
  }

  if (empty(test_input($_POST["envrate"]))) {
    $errors[] = "Environment rating is required";
  } else {
    $envrate = test_input($_POST["envrate"]);
  }

  if (empty(test_input($_POST["servicerate"]))) {
    $errors[] = "Service rating is required";
  } else {
    $servicerate = test_input($_POST["servicerate"]);
  }

        if (empty(test_input($_POST["reviewtext"]))) {
    $errors[] = "Review text is required";
  } else {
    $reviewtext = test_input($_POST["reviewtext"]);
  }

  if (empty($_POST["restaurantid"])) {
    $errors[] = "Restaurant's Id is required";
  } else {
    $restaurantid = test_input($_POST["restaurantid"]);

  }
if (!empty($errors)) {
  echo '<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong>
  The following error(s) occurred:<br />';
  foreach ($errors as $msg) {
    echo " - $msg<br />\n";
  }
  echo '<p>Please try again.</p></div>';
}
 
 if (empty($errors)){
  require_once ('./mysqli_connect.php');
      $q = "INSERT INTO `review` (`taste`,`environment`,`service`,`text`,`customerId`,`restaurantId`) VALUES ('$tasterate', '$envrate', '$servicerate', '$reviewtext','".$_SESSION['customer_id']."','$restaurantid')";     
      $r = @mysqli_query ($dbc, $q); 
            if ($r) { // If it ran OK.
              //$customerid = mysqli_insert_id($dbc);
              $q2 = "SELECT AVG(`taste`) AS `avgtaste`, AVG(`environment`) AS `avgenvironment`, AVG(`service`) AS `avgservice` FROM `review`  WHERE `restaurantId`=".$restaurantid." GROUP BY `restaurantId` ";     
      $r2 = @mysqli_query ($dbc, $q2)
      OR die ("Cannot calculate average ratings of reviews of the restaurant"); 
      $row = mysqli_fetch_array ($r2, MYSQLI_ASSOC);
            //$number=$row['number'];
      

      $q3 = "UPDATE `restaurant` SET `taste`=".$row['avgtaste'].",`environment`=".$row['avgenvironment'].",`service`=".$row['avgservice']." WHERE `restaurant_id`=".$restaurantid;     
      $r3 = @mysqli_query ($dbc, $q3)
      OR die ("Cannot update average ratings of the restaurant"); 
         // Print a message:
         echo '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Thank you!</strong>
      Your precious comment has been posted. </div>';
      /*session_start();
      list ($check, $data) = check_login($dbc, 'customer',$email, $password);
      $_SESSION['customer_id'] = $data['customer_id'];
      $_SESSION['customer_name'] = $name;
      
      // Redirect:
      $url = absolute_url ();
      header("Location: $url");
      exit(); */
      
      } else { // If it did not run OK.
         
         // Public message:
         echo '<h1>System Error</h1>
         <p class="error">Your comment could not be posted due to a system error. We apologize for any inconvenience.</p>'; 
         
         // Debugging message:
         echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                  
      }

 }

}
//include('includes/footer.html');
?>