<?php 

session_start(); // Start the session.

$page_title = '| home';
include ('includes/header.html');
require('mysqli_connect.php');
?>

<!--<h1 id="mainhead">test</h1>
<p></p>

<h2>test</h2>
<p></p>-->

 <!-- content -->
  
        
                    <?php  
                    if (isset($_SESSION['customer_id'])) {

     $q='SELECT * FROM `customer` WHERE `customer_id`='.$_SESSION['customer_id'];
   $r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<h2>Customer does not exist.</h2>';
//include ('includes/footer.html'); 
  //exit();
  // Get the user's information:
}  else {
  $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
   $q3='SELECT `category_id`,`category_name` FROM `category`, `customer_favourite_category` WHERE `category_id`=`categoryId` AND `customerId`='.$_SESSION['customer_id'];
   $r3 = @mysqli_query ($dbc, $q3);

  while ($row3 = mysqli_fetch_array ($r3, MYSQLI_ASSOC)){
     $category[]=$row3['category_name'];
  }
         $q4='SELECT `dish_id`,`dish_name` FROM `dish`, `customer_favourite_dish` WHERE `dish_id`=`dishId` AND `customerId`='.$_SESSION['customer_id'];
   $r4 = @mysqli_query ($dbc, $q4);

  while ($row4 = mysqli_fetch_array ($r4, MYSQLI_ASSOC)){
     $dish[]=$row4['dish_name'];
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
                       echo '<div class="row">';
                      echo '<div class="col-md-4">';
                      require_once ('includes/delete_review.php');
  echo '<h2>'.$row['customer_name'].'</h2>';
   echo '<h3>'.$row['customer_email'].'</h3>';
   echo '<h3>Address: '.$row['customer_address'].'</h3>';
   echo '<h3>Favourite category: ';
 
   foreach ($category as $cat){
    echo $cat.', ';
}
   echo '</h3>';
         echo '<h3>Favourite dish: ';
           if (!empty($dish)){
   foreach ($dish as $di){
    echo $di.', ';
}
}
   echo '</h3>';
      if (isset($_SESSION['admin'])){
  echo '<h3>Site Administrator</h3>';
 }
 
     echo '</div>';
   require_once('includes/customer_reviews_feed.php');
     echo '</div>
                     </div>
                  </div>
               </div>
               <div class="left-bot-corner">
                <div class="right-bot-corner">
                    <div class="border-bot"></div>
                  </div>
               </div>
            </div>';
}
                    } else if (isset($_SESSION['restaurant_id'])) {
    $q='SELECT * FROM `restaurant` WHERE `restaurant_id`='.$_SESSION['restaurant_id'];
   $r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<h2>Restaurant does not exist.</h2>';
//include ('includes/footer.html'); 
  //exit();
  // Get the user's information:
}  else {
  $errors=array();
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
                       echo '<div class="row">';
                      echo '<div class="col-md-4">';
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
    echo '</div>';
    if ($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['submitted'])&&isset($_POST['rvid'])&&isset($_POST['replytext'])) {
      require_once('includes/test_input.php');
  if (test_input($_POST['replytext'])!="") {
      require_once('includes/test_input.php');
  $reply=test_input($_POST['replytext']);
  $rvid=$_POST['rvid'];

} else {
  $errors[]='Reply text cannot be empty';
   
}
   if (empty($errors)) {
     $q5 = "INSERT INTO `reply` (`text`,  `reviewId`) VALUES ('$reply', '$rvid')";     
      $r5 = @mysqli_query ($dbc, $q5);
     if ($r5){
       echo '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Reply posted successfully</strong> </div>';
     }else{
      $errors[]="Cannot post reply.";
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
   
if (isset($_POST['reviewid'])){
   require_once('includes/reply_form.php');
}
   require_once('includes/restaurant_customer_reviews.php');
     echo '</div>
                     </div>
                  </div>
               </div>
               <div class="left-bot-corner">
                <div class="right-bot-corner">
                    <div class="border-bot"></div>
                  </div>
               </div>
            </div>';
}
                    } else {
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
               <div class="border-left">
<<<<<<< HEAD
                <div class="border-right">
                    <div class="inner">
                      <div class="wrapper"><p>Not a registered customer? <a href="./customer_register_page.php">Register</a> now!</p>
                        <p>Not a registered restaurant? <a href="./restaurant_register_page.php">Register</a> now!</p>                        <p><a href="index.php">Home</a>, <a href="about.php">About us</a>, <a href="browse_menu.php">Menu</a>, <a href="contact.php">Contact us</a>.
=======
               	<div class="border-right">
                  	<div class="inner">
                   	  <div class="wrapper">
        
                        <p>Not a registered customer? <a href="./customer_register_page.php">Register</a> now!</p>
                        <p>Not a registered restaurant? <a href="./restaurant_register_page.php">Register</a> now!</p>                                               
                        <p><a href="index.php">Home</a>, <a href="about.php">About us</a>, <a href="browse_menu.php">Menu</a>, <a href="contact.php">Contact us</a>.
>>>>>>> origin/master
                      </div>
                     </div>
                  </div>
               </div>
               <div class="left-bot-corner">
                <div class="right-bot-corner">
                    <div class="border-bot"></div>
                  </div>
               </div>
            </div>';
                        } 
                        ?>                                               

            <!-- box end -->
<!--Recent articles list start-->		
<?php


echo '
<!--Recent articles list ends -->	 
 </div>
      </div>
   </div>
   <!-- footer -->';


include ('includes/footer.html');
?>