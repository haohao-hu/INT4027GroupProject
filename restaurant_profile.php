<?php 

//session_start(); // Start the session.
//$page_title = '| home';
   require_once ('includes/login_functions.inc.php');
   require_once ('mysqli_connect.php');
   ?>
  
 
<?php  
session_start(); 
/*if (!isset($_SESSION['restaurant_id'])&&!isset($_SESSION['customer_id'])) {

   $url = absolute_url('index.php');
   header("Location: $url");
   exit();     
} else*/
if (!isset($_GET['restaurantid'])&&isset($_SESSION['restaurant_id'])) {
     $q='SELECT * FROM `restaurant` WHERE `restaurant_id`='.$_SESSION['restaurant_id'];
   $r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<h2>Restaurant does not exist.</h2>';
//include ('includes/footer.html'); 
  //exit();
  // Get the user's information:
}  else {
  $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
   $q3='SELECT `category_id`,`category_name` FROM `category`, `restaurant_belongs_to_category` WHERE `category_id`=`categoryId` AND `restaurantId`='.$_SESSION['restaurant_id'];
   $r3 = @mysqli_query ($dbc, $q3);

  while ($row3 = mysqli_fetch_array ($r3, MYSQLI_ASSOC)){
     $category[]=$row3['category_name'];
  }
     echo '<div id="content">
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
                      <div class="wrapper">';
  echo '<h2>'.$row['restaurant_name'].'</h2>';
  echo '<h3>Address: '.$row['address'].'</h3>';
  echo '<h3>Dsitrict: '.$row['district'].'</h3>';
   echo '<h3>'.$row['email'].'</h3>';
   echo '<h3>Taste rating: '.$row['taste'].'</h3>';
   echo '<h3>Environment rating: '.$row['environment'].'</h3>';
   echo '<h3>Service rating: '.$row['service'].'</h3>';
   echo '<h3>Restaurant Category: ';
   foreach ($category as $cat){
   	echo $cat.', ';
}
   echo '</h3>';
}
 } else if (isset($_SESSION['restaurant_id'])&&$_GET['restaurantid']!=$_SESSION['restaurant_id']) {
 	 echo '<h2>This page has been accessed in error</h2>'; 
 	} else {
    //session_start();
 		  $q='SELECT * FROM `restaurant` WHERE `restaurant_id`='.$_GET['restaurantid'];
   $r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<h2>Restaurant does not exist.</h2>';
//include ('includes/footer.html'); 
  //exit();
  // Get the user's information:
}  else {
  $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
   $q3='SELECT `category_id`,`category_name` FROM `category`, `restaurant_belongs_to_category` WHERE `category_id`=`categoryId` AND `restaurantId`='.$_GET['restaurantid'];
   $r3 = @mysqli_query ($dbc, $q3);

  while ($row3 = mysqli_fetch_array ($r3, MYSQLI_ASSOC)){
     $category[]=$row3['category_name'];
  }
  $page_title = '| home';
include ('includes/header.html');
  echo ' <div id="content">
      <div class="container">
         <div class="inside">
            <!-- box begin -->
            <div class="box alt">
              <div class="left-top-corner">
                <div class="right-top-corner">
                    <div class="border-top"></div>
                  </div>
               </div>
               <div class="row">
               <div class="col-md-4">';
 echo '<h2>'.$row['restaurant_name'].'</h2>';
  echo '<h4>Address: '.$row['address'].'</h4>';
  echo '<h4>Dsitrict: '.$row['district'].'</h4>';
   echo '<h4>'.$row['email'].'</h4>';
   echo '<h4>Taste rating: '.$row['taste'].'</h4>';
   echo '<h4>Environment rating: '.$row['environment'].'</h4>';
   echo '<h4>Service rating: '.$row['service'].'</h4>';
   echo '<h4>Restaurant Category: ';
   foreach ($category as $cat){
   	echo $cat.', ';
    }
   echo '</h4><br/>'; 

if(isset($_SESSION['customer_id'])) {
  //echo '<div class="col-md-6">';

    if ($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['submitted'])&&isset($_POST['restaurantid'])&&isset($_POST['numberofcustomers'])&&isset($_POST['reservationtime'])) {
        $errors=array();
      require_once('includes/test_input.php');
  if (test_input($_POST['numberofcustomers'])!="") {
      //require_once('includes/test_input.php');
  $noc=test_input($_POST['numberofcustomers']);
} else {
  $errors[]='Number of customers has not been set';
   
}
  if (test_input($_POST['reservationtime'])!="") {
      //require_once('includes/test_input.php');
  $rvt=test_input($_POST['reservationtime']);
  $rid=$_POST['restaurantid'];

} else {
  $errors[]='Booking time has not been set';   
}
   if (empty($errors)) {
    $cid=$_SESSION['customer_id'];
     $q5 = "INSERT INTO `reservation` (`customerId`,  `restaurantId`, `number_of_customers`, `r_date_and_time`) VALUES ('$cid','$rid','$noc', '$rvt')";     
      $r5 = @mysqli_query ($dbc, $q5);
     if ($r5){
       echo '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Booking posted successfully</strong> </div>';
     }else{
      $errors[]="Cannot book a table due to technical problems.";
     }
   }
}
  if (!empty($errors)) {
    echo '<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>The following errors occur:</strong><br/> ';
    echo "";
    foreach ($errors as $msg){
      echo $msg."<br/>";
    }
    echo '</div>';
  }

  require_once('includes/reservation_form.php');
   require_once('review_form_validate.php');
  require_once ('review_form.php');
  //echo '</div>';
}
 echo '</div>';

require_once('includes/restaurant_customer_reviews.php');
echo '</div>
               <div class="left-bot-corner">
                <div class="right-bot-corner">
                    <div class="border-bot"></div>
                  </div>
               </div>
            </div>';
            echo '
<!--Recent articles list ends -->  
 </div>
      </div>
   </div>
   <!-- footer -->';
include ('includes/footer.html');
 	}

 }
?>
 </div>
                     </div>
                  </div>
               </div>
               <div class="left-bot-corner">
                <div class="right-bot-corner">
                    <div class="border-bot"></div>
                  </div>
               </div>
            </div>