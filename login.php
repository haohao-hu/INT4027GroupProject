<?php 

if (isset($_POST['submitted'])) {
require_once ('includes/test_input.php');
	require_once ('includes/login_functions.inc.php');
	require_once ('mysqli_connect.php');
	$table='customer';
	list ($check, $data) = check_login($dbc, $table, $_POST['email'], $_POST['pass']);
	
	if ($check) { // OK!
			
		// Set the session data:.
		session_start();
		$_SESSION['customer_id'] = $data['customer_id'];
		$_SESSION['customer_name'] = $data['customer_name'];
		
		// Redirect:
		$url = absolute_url ('index.php');
		header("Location: $url");
		exit();
			
	} else { // Unsuccessful!
		$errors = $data;
	}
		
	mysqli_close($dbc);

} // End of the main submit conditional.

include ('includes/login_page.inc.php');
?>
