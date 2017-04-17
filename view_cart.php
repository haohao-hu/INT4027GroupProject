<?php # 


session_start(); // Start the session.

if (!isset($_SESSION['customer_id'])) {

   $url = absolute_url('login.php');
   header("Location: $url");
   exit();     
}
// Set the page title and include the HTML header:
$page_title = '| View Your Shopping Cart';
include ('./includes/header.html');

// Check if the form has been submitted (to update the cart):
if (isset($_POST['submitted'])) {

	// Change any quantities:
	foreach ($_POST['qty'] as $k => $v) {

		// Must be integers!
		$dishid = (int) $k;
		$qty = (int) $v;
		
		if ( $qty == 0 ) { // Delete.
			unset ($_SESSION['cart'][$dishid]);
		} elseif ( $qty > 0 ) { // Change quantity.
			$_SESSION['cart'][$dishid]['quantity'] = $qty;
		}
		
	} // End of FOREACH.
} // End of SUBMITTED IF.

// Display the cart if it's not empty...
if (!empty($_SESSION['cart'])) {

	// Retrieve all of the information for the prints in the cart:
	require_once ('./mysqli_connect.php');
	$q = "SELECT * FROM dish, restaurant WHERE restaurant.restaurant_id = dish.restaurantId AND dish.dish_id IN (";
	foreach ($_SESSION['cart'] as $dishid => $value) {
		$q .= $dishid . ',';
	}
	$q = substr($q, 0, -1) . ') ORDER BY dish.dish_name ASC';
	$r = mysqli_query ($dbc, $q);
	
	// Create a form and a table:
	echo '<!-- content -->
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
                   ';
	echo '<form action="view_cart.php" method="post">
<table class="table-striped" border="0" width="100%" cellspacing="3" cellpadding="3" align="center">
	<tr>
		<td align="left" width="30%"><b>Restaurant</b></td>
		<td align="left" width="30%"><b>Dish Name</b></td>
		<td align="right" width="10%"><b>Price</b></td>
		<td align="center" width="10%"><b>Qty</b></td>
		<td align="right" width="10%"><b>Total Price</b></td>
	</tr>
';

	// Print each item...
	$total = 0; // Total cost of the order.
	while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {
		
		// Calculate the total and sub-totals.
		$subtotal = $_SESSION['cart'][$row['dish_id']]['quantity'] * $_SESSION['cart'][$row['dish_id']]['price'];
		$total += $subtotal;
		
		// Print the row.
		echo "\t<tr>
		<td align=\"left\">{$row['restaurant_name']}</td>
		<td align=\"left\">{$row['dish_name']}</td>
		<td align=\"right\">\${$_SESSION['cart'][$row['dish_id']]['price']}</td>
		<td align=\"center\"><input type=\"text\" size=\"3\" name=\"qty[{$row['dish_id']}]\" value=\"{$_SESSION['cart'][$row['dish_id']]['quantity']}\" /></td>
		<td align=\"right\">$" . number_format ($subtotal, 2) . "</td>
	</tr>\n";
	
	} // End of the WHILE loop.
	
	mysqli_close($dbc); // Close the database connection.

	// Print the footer, close the table, and the form.
	echo '
	   
   
					<tr>
		<td colspan="4" align="right"><b>Total:</b></td>
		<td align="right">$' . number_format ($total, 2) . '</td>
	</tr>
	</table>
	<div align="center"><input type="submit" name="submit" value="Update My Cart" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	</form><p align="center">Enter a quantity of 0 to remove an item.
	<br /><br /><form action="checkout.php" method="post"><div align="center"><input type="submit" name="submit" value="Checkout" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="totalcost" value="'.$total.'" />
	</form></p>';

} else {
	echo '
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
                  	<div class="inner"> <p><h4>Your cart is currently empty.</h4></p>
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
         </div>
      </div>
   </div>';
}
 echo '						</div>
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
   </div>';
			
include ('./includes/footer.html');
?>
