<?php 

if (isset($_POST['submitted'])) {
require_once ('includes/test_input.php');
	require_once ('includes/login_functions.inc.php');
	require_once ('mysqli_connect.php');
	$table='restaurant';
	list ($check, $data) = check_login($dbc, $table, $_POST['email'], $_POST['pass']);
	
	if ($check) { // OK!
			
		// Set the session data:.
		session_start();
		$_SESSION['restaurant_id'] = $data['restaurant_id'];
		$_SESSION['restaurant_name'] = $data['restaurant_name'];
		//if ($data['admin']==1) {
		//$_SESSION['admin'] = $data['admin'];
		//}
		// Redirect:
		$url = absolute_url ('index.php');
		header("Location: $url");
		exit();
			
	} else { // Unsuccessful!
		$errors = $data;
	}
		
	mysqli_close($dbc);

} // End of the main submit conditional.

include ('includes/restaurantlogin_page.inc.php');
?>
