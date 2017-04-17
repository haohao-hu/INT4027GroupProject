<?php 

session_start(); // Start the session.

$page_title = '| search results';
include ('includes/header.html');
require('mysqli_connect.php');
require('includes/test_input.php');
?>

<!--<h1 id="mainhead">test</h1>
<p></p>

<h2>test</h2>
<p></p>-->

 <!-- content -->
  
        
                    <?php  
                       echo '<div class="row">';
                      echo '<div class="col-md-12">';
      if (isset($_GET['sname'])) {
                      $errors=array();
if (test_input($_GET['sname'])=="") {
  $errors[]="Search text cannot be empty";
} else {
  $search=test_input($_GET['sname']);
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
  } else {
     $q='SELECT `dish_id`,`dish_name`,`description`,`restaurant_id`,`restaurant_name`,`image_name`,`price` FROM `dish` d,`restaurant` r WHERE d.`restaurantId`= r.`restaurant_id` AND `dish_name` LIKE "%'.$search.'%"';
   $r = @mysqli_query ($dbc, $q)
   Or die ('Data cannot be retrieved');
if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<h2>Dish does not exist.</h2>';
//include ('includes/footer.html'); 
  //exit();
  // Get the user's inform    echo "<h3>Search results</h3>";ation:
}  else {
      echo "<h3>Search results</h3>";
      echo '<table class="table-striped" border="0" width="100%" cellspacing="3" cellpadding="3" align="center">
  <tr>
   <td align="left" width="10%"><b>Restaurant name</b></td>
   <td align="left" width="25%"><b>Image</b></td>
    <td align="left" width="10%"><b>Dish name</b></td>
      <td align="left" width="35%"><b>Description</b></td>
    <td align="left" width="10%"><b>Price</b></td>';
  while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)){

  echo "\t<tr>
   <td align=\"left\"><a href=\"restaurant_profile.php?restaurantid={$row['restaurant_id']}\">{$row['restaurant_name']}</a></td>
   <td align=\"left\"><img src=\"./uploads/{$row['dish_id']}\"  alt=\"{$row['image_name']}\" height=\"100 px\" /></td>
    <td align=\"left\">{$row['dish_name']}</td>
      <td align=\"left\">{$row['description']}</td>
    <td align=\"left\">\${$row['price']}</td>";
      if (isset($_SESSION['restaurant_id'])&&((isset($_GET['rid']) && is_numeric($_GET['rid']) &&$_SESSION['restaurant_id']==$rid)||!isset($_GET['rid']))) {
     echo '<td align="left" width="10%"><b><a href="delete_dish.php?dishid='.$row['dish_id'].'">Delete</a></b></td>';
     echo '<td align="left" width="10%"><b><a href="edit_dish.php?dishid='.$row['dish_id'].'">Edit</a></b></td>';
} elseif (isset($_SESSION['customer_id'])) {
    echo '<td align="left" width="10%"><b><form enctype="multipart/form-data" action="add_cart.php" method="post" role="form" ><input type="text" name="quantity" value="';
    if (isset($_SESSION[$row['dish_id']]['quantity'])) echo $_SESSION[$row['dish_id']]['quantity']; 
    echo '" /><input type="hidden" name="dishid" value="'.$row['dish_id'].'" /><input type="submit" name="submit" value="Add to cart" /></form></b></td>';
    echo '<td align="left" width="10%"><b><form enctype="multipart/form-data" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" role="form" ><input type="hidden" name="dishid2" value="'.$row['dish_id'].'" /><input type="hidden" name="addingfavourite" value="True" /><input type="submit" name="submit" value="Add to my favourite" /></form></b></td>';
}      
  echo "</tr>\n";
  }
  echo "</table>";
}
    
                     echo ' 
     </div>
               </div>
            ';
                         


echo '
<!--Recent articles list ends -->	 

   <!-- footer -->';
}
}

include ('includes/footer.html');
?>