<?php 

// Set the page title and include the HTML header:
session_start(); // Start the session.

if (!isset($_SESSION['customer_id'])) {

   $url = absolute_url('login.php');
   header("Location: $url");
   exit();     
}
$page_title = 'Add to Cart';
include ('includes/header.html');
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

	

if (isset($_POST['dishid']) && is_numeric($_POST['dishid']) && isset($_POST['quantity']) && is_numeric($_POST['quantity'])) { // Check for a print ID.

	$dishid = (int) $_POST['dishid'];
	$quantity = (int) $_POST['quantity'];

	// Check if the cart already contains one of these prints;
	// If so, increment the quantity:
	if (isset($_SESSION['cart'][$dishid])) {
	
		$_SESSION['cart'][$dishid]['quantity']+=$quantity; // Add another.

		// Display a message.
		echo '<p>The food has been added to your order.</p>';
		
	} else { // New product to the cart.

		// Get the print's price from the database:
		require_once ('./mysqli_connect.php');
		$q = "SELECT price FROM dish WHERE dish.dish_id = ".$dishid;
		$r = mysqli_query ($dbc, $q);		
		if (mysqli_num_rows($r) == 1) { // Valid print ID.
		
			// Fetch the information.
			list($price) = mysqli_fetch_array ($r, MYSQLI_NUM);
			
			// Add to the cart:
			$_SESSION['cart'][$dishid] = array ('quantity' => $quantity, 'price' => $price);

			// Display a message:
			echo '<p>Your order have been submitted.</p>';

		} else { // Not a valid print ID.
			echo '<div align="center">This page has been accessed in error!</div>';
		}
		
		mysqli_close($dbc);

	} // End of isset($_SESSION['cart'][$pid] conditional.

} else { // No print ID.
	echo '<div align="center">This page has been accessed in error!</div>';
}
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
include ('includes/footer.html');
?>
