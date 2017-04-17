<?php 

//session_start(); // Start the session.
//$page_title = '| home';
   require_once ('includes/login_functions.inc.php');
   require_once ('mysqli_connect.php');
   ?>
  
 
<?php  
session_start(); 
if (!isset($_SESSION['customer_id'])) {

   $url = absolute_url('login.php');
   header("Location: $url");
   exit();     
} elseif (!isset($_GET['cid'])) {
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
  echo '<h2>'.$row['customer_name'].'</h2>';
   echo '<h3>'.$row['customer_email'].'</h3>';
   echo '<h3>Address: '.$row['customer_address'].'</h3>';
   echo '<h3>Favourite category: ';
   foreach ($category as $cat){
   	echo $cat.', ';
}
   echo '</h3>';
      echo '<h3>Favourite dish: ';
   foreach ($dish as $di){
    echo $di.', ';
}
   echo '</h3>';
    	if (isset($_SESSION['admin'])){
 	echo '<h3>Site Administrator</h3>';
 }
}
 } else if (!isset($_SESSION['admin'])&&$_GET['cid']!=$_SESSION['customer_id']) {
 	 echo '<h2>This page has been accessed in error</h2>'; 
 	} else {
    //session_start();
 		  $q='SELECT * FROM `customer` WHERE `customer_id`='.$_GET['cid'];
   $r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<h2>Customer does not exist.</h2>';
//include ('includes/footer.html'); 
  //exit();
  // Get the user's information:
}  else {
  $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
   $q3='SELECT `category_id`,`category_name` FROM `category`, `customer_favourite_category` WHERE `category_id`=`categoryId` AND `customerId`='.$_GET['cid'];
   $r3 = @mysqli_query ($dbc, $q3);

  while ($row3 = mysqli_fetch_array ($r3, MYSQLI_ASSOC)){
     $category[]=$row3['category_name'];
  }
       $q4='SELECT `dish_id`,`dish_name` FROM `dish`, `customer_favourite_dish` WHERE `dish_id`=`dishId` AND `customerId`='.$_SESSION['customer_id'];
   $r4 = @mysqli_query ($dbc, $q4);

  while ($row4 = mysqli_fetch_array ($r4, MYSQLI_ASSOC)){
     $dish[]=$row4['dish_name'];
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
               <div class="border-left">
                <div class="border-right">
                    <div class="inner">
                      <div class="wrapper">';
  echo '<h2>'.$row['customer_name'].'</h2>';
   echo '<h3>'.$row['customer_email'].'</h3>';
   echo '<h3>Address: '.$row['customer_address'].'</h3>';
   echo '<h3>Favourite category: ';
   if (!empty($category)){
   foreach ($category as $cat){
   	echo $cat.', ';
    }
  }
   echo '</h3>'; 
         echo '<h3>Favourite dish: ';
         if (!empty($dish)) {
   foreach ($dish as $di){
    echo $di.', ';
}
}
   echo '</h3>';
   	if ($row['admin']==1){
 	echo '<h3>Site Administrator</h3>';
 }
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