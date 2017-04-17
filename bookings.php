<?php 

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['customer_id'])) {
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url("login.php");
	header("Location: $url");
	exit();		
}
$page_title = '| View all the bookings';
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
                     	<div class="wrapper">
<h3>My bookings</h3>';

require_once ('./mysqli_connect.php');
      
        if (isset($_POST['submitted'])&&isset($_POST['reservationid'])) {
        	//echo '<button onclick="deleteconfirm()" clicked>Delete2</button>';
       	 
    	$q2 = "DELETE FROM reservation WHERE `reservation_id`=".$_POST['reservationid'];     
      $r2 = @mysqli_query ($dbc, $q2)
      Or die ("Error! Cannot delete booking"); 
      if ($r2) {
       echo '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Booking deleted successfully</strong> </div>';
      }

}
        
// Number of records to show per page:
$display = 5;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.

	$pages = $_GET['p'];

} else { // Need to determine.

 	// Count the number of records:
	$q = "SELECT COUNT(*) FROM `reservation` WHERE `customerId`=".$_SESSION['customer_id'];
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];

	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
	
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}
		
// Make the query:
//$q = "SELECT last_name, first_name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY registration_date ASC LIMIT $start, $display";		
//$q = "SELECT CONCAT (last_name, ', ', first_name) AS name, email, pass, title, DATE_FORMAT(date_created,'%M %d, %Y') AS dr, employee_id FROM employees ORDER BY date_Created ASC LIMIT $start, $display";	
$q = "SELECT * FROM `reservation`,`restaurant`  WHERE `restaurant_id`=`restaurantId` AND `customerId`=".$_SESSION['customer_id']." ORDER BY `r_date_and_time` ASC LIMIT ".$start.", ".$display;		

$r = @mysqli_query ($dbc, $q)
Or die ("Cannot retrieve booking data!");

// Table header:
echo '<table class="table-striped" align="center" cellspacing="2" cellpadding="10" width="100%">
<tr>

	<td align="left"><b>Restaurant</b></td>
	<td align="left"><b>Address</b></td>
	<td align="left"><b>Number of customers</b></td>
	<td align="left"><b>Booking date and time</b></td>
	</tr>

';
echo '<p></p>';
// Fetch and print all the records....

$bg = '#eeeeee'; // Set the initial background color.

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

	//$bg = ($bg=='#eeeeee' ? '#F0950D' : '#eeeeee'); // Switch the background color.
	
	echo '<tr>
	
		
		<td align="left"><a href="restaurant_profile.php?restaurantid=' . $row['restaurant_id'] . '">' . $row['restaurant_name'] .' </a></td>
		<td align="left">' . $row['address'] . ' </td>
		<td align="left">' . $row['number_of_customers'] . '</td>
		<td align="left">' . $row['r_date_and_time'] . '</td>';
if ($row['Confirmed']==1) {
       echo '<td align="left"><b>Confirmed</b></td>';
	} else {
		 echo '<td align="left"><b>Not confirmed yet</b></td>';
	}
		echo '<td align="left"><b><form role="form" enctype="multipart/form-data" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" role="form" ><input type="hidden" name="reservationid" value="'.$row['reservation_id'].'" /><input type="hidden" name="submitted" value="True" /><input type="submit" name="submit" value="Delete"  /></form></b></td>';

	//<td align="right"><a href="view_message.php?id=' . $row['contactus_id'] . '">view </a></td>'
} // End of WHILE loop.

echo '</table>';
//} else {
//	echo '<h4>You have no bookings right now</h4>';
//}
mysqli_free_result ($r);
mysqli_close($dbc);

// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	// Add some spacing and start a paragraph:
	echo '<br /><p>';
	
	// Determine what page the script is on:	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="bookings.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="bookings.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="bookings.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.
?>

<?php 
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
