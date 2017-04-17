<?php 
session_start();

// Set the page title and include the HTML header:
$page_title = '| Browse the menus';
include ('includes/header.html');

require_once ('./mysqli_connect.php');
 
// Default query for this page:
$q='SELECT `restaurant_name`,`restaurant_id`,`dish_id`,`dish_name`,`price`,`restaurantId`,`image_name`,`description` FROM `dish`,`restaurant` WHERE `restaurant_id`= `restaurantId`';

if (isset($_SESSION['restaurant_id'])) {
$q='SELECT `restaurant_name`,`restaurant_id`,`dish_id`,`dish_name`,`price`,`restaurantId`,`image_name`,`description` FROM `dish`,`restaurant` WHERE `restaurant_id`= `restaurantId` AND `restaurant_id`= '.$_SESSION['restaurant_id'];
}
//$q = "SELECT artists.artist_id, CONCAT_WS(' ', first_name, middle_name, last_name) AS artist, print_name, price, description, print_id FROM artists, prints WHERE artists.artist_id = prints.artist_id ORDER BY artists.last_name ASC, prints.print_name ASC";

// Are we looking at a particular restaurant?
if (isset($_GET['rid']) && is_numeric($_GET['rid']) ) {
	$rid = (int) $_GET['rid'];
	if ($rid > 0) { // Overwrite the query:
		$q='SELECT `restaurant_name`,`address`,`restaurant_id`,`dish_id`,`dish_name`,`price`,`restaurantId`,`image_name`,`description` FROM `dish`,`restaurant` WHERE `restaurant_id`= '.$rid.' AND `restaurantId`='.$rid;
	}
}

// Create the table head:
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
                        //if (isset($_SESSION['restaurant_id'])) {
//echo '<h2>Menu of '.$_SESSION['restaurant_name'].'</h2>';
//}
                      if (isset($_POST['dishid2'])&&$_POST['addingfavourite']) {
                        $q7="SELECT * FROM `customer_favourite_dish` WHERE  `customerId`=".$_SESSION['customer_id']." AND `dishId`=".$_POST['dishid2'];
                        $r7 = @mysqli_query ($dbc, $q7);
                        if ($r7==0){
                        $q6="INSERT INTO customer_favourite_dish (customerId, dishId) VALUES (".$_SESSION['customer_id'].", ".$_POST['dishid2'].")";
                        $r6 = @mysqli_query ($dbc, $q6)
                         Or die ("Cannot add favourite. Sorry");
                        if ($r6) {
                          echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Favourite dish added!</strong>
</div>';
                        }
                      }
                      }
						echo '<table class="table-striped" border="0" width="100%" cellspacing="3" cellpadding="3" align="center">
	<tr>
   <td align="left" width="10%"><b>Restaurant name</b></td>
   <td align="left" width="25%"><b>Image</b></td>
		<td align="left" width="10%"><b>Dish name</b></td>
      <td align="left" width="35%"><b>Description</b></td>
		<td align="left" width="10%"><b>Price</b></td>';
      if (isset($_SESSION['customer_id'])) {
     echo '<td align="left" width="10%"><b>Quantity (>=1)(Add to Cart)</b></td>';
     echo '<td align="left" width="10%"><b>Add to favourite</b></td>';
} 
      
      echo '</tr>';

// Display all the prints, linked to URLs:
$r = mysqli_query ($dbc, $q);
while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

	// Display each record:
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

} // End of while loop.

echo '</table>'
;
echo '                        	<dl class="special fright">
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
            <!-- box end -->
	
<!--Recent articles list ends -->	 
 </div>
      </div>
   </div>
';	
mysqli_close($dbc);

include ('includes/footer.html');
?>
