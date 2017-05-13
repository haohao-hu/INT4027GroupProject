<?php 


session_start(); // Start the session.
// Check for a valid dish ID, through GET or POST :
if ( (isset($_GET['dishid'])) && (is_numeric($_GET['dishid'])) ) { 
	$dishid = $_GET['dishid'];
} elseif ( (isset($_POST['dishid'])) && (is_numeric($_POST['dishid'])) ) { // Form submission.
	$dishid = $_POST['dishid'];
} else { // No valid ID, kill the script.
	require_once ('includes/header.html');
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes/footer.html'); 
	exit();
}
// If no session value is present, redirect the user:
if (!isset($_SESSION['restaurant_id'])) {
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url('restaurantlogin.php');
	header("Location: $url");
	exit();		
}
$page_title = '| Delete a dish';

require_once ('./mysqli_connect.php');

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM dish WHERE dish_id=$dishid LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			// Delete the uploaded file if it still exists:
			$imagename="./uploads/".$dishid;
	if ( isset($imagename) && file_exists ($imagename) && is_file($imagename) ) {
		unlink ($imagename);
	}
			// Print a message:
	//require_once ('includes/header.html');
	require_once('includes/login_functions.inc.php');
	$url = absolute_url ('browse_menu.php');
		header("Location: $url");
		exit();	
			/*echo '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>The dish has been deleted.</strong>
</div>';*/	
		
		} else { // If the query did not run OK.
			echo '<p class="error">The dish could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		//echo '<p>The message has NOT been deleted.</p>';
		require_once ('includes/login_functions.inc.php');
// Redirect:
		$url = absolute_url ('browse_menu.php');
		header("Location: $url");
		exit();		
	}

} else { // Show the form.

	// Retrieve the dish's information:
	$q = "SELECT * FROM dish WHERE dish_id=".$dishid;
	$r = @mysqli_query ($dbc, $q)
	Or die ("no such dish in menu");
	
	if (mysqli_num_rows($r) == 1) { // Valid message ID, show the form.

		// Get the dish's information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
// If dish is not belong to the restaurant, redirect the user:
if ($row[5]!=$_SESSION['restaurant_id']) {
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url('restaurantlogin.php');
	header("Location: $url");
	exit();		
}		
require_once ('includes/header.html');
		// Create the form:
echo '<h3>Delete the dish</h3>';
		echo '<form action="delete_dish.php" method="post">
	<h3>Name: ' . $row[1] . '</h3>
	<p>Are you sure you want to delete this dish?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	<p><input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="dishid" value="' . $dishid . '" />
	</form>';
	
	} else { // Not a valid message ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);

		
include ('includes/footer.html');
?>
