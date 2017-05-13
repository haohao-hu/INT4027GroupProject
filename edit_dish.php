<?php #
	session_start();
$page_title = '| Edit dish';

include 'includes/test_input.php';
require_once ('mysqli_connect.php');
   require_once ('includes/login_functions.inc.php');

if (!isset($_SESSION['restaurant_id'])) {

   $url = absolute_url('restaurantlogin.php');
   header("Location: $url");
   exit();     
}
// Check for a valid dish ID, through GET or POST:
if ( (isset($_GET['dishid'])) && (is_numeric($_GET['dishid'])) ) { 
	$dishid = $_GET['dishid'];
} elseif ( (isset($_POST['dishid'])) && (is_numeric($_POST['dishid'])) ) { // Form submission.
	$dishid = $_POST['dishid'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes/footer.html'); 
	exit();
}
   $q='SELECT * FROM `dish` WHERE `dish_id`='.$dishid;
   $r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 0) { // Valid dish ID, show the form.
echo '<p class="error">Dish does not exist.</p>';
include ('includes/footer.html'); 
	exit();
	// Get the user's information:
}  else {
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
  if ($row['restaurantId']!=$_SESSION['restaurant_id']) {
   $url = absolute_url('restaurantlogin.php');
   header("Location: $url");
   exit(); 
  } 

}
if (isset($_POST['submitted'])) { // Handle the form.
	
	// Validate the incoming data...
	$errors = array();

	// Check for a dish name:
	if (!empty($_POST['dish_name'])) {
		$dn = test_input($_POST['dish_name']);
	} else {
		$errors[] = 'Please enter the dish\'s name!';
	}
	
	// Check for an image:
	if (is_uploaded_file ($_FILES['image']['tmp_name'])) {
	   if ((($_FILES["image"]["type"] == "image/gif")
|| ($_FILES["image"]["type"] == "image/jpeg")
|| ($_FILES["image"]["type"] == "image/pjpeg")
	   	|| ($_FILES["image"]["type"] == "image/png"))
) { 
    if ($_FILES["image"]["size"] < 2000000) {
		// Create a temporary file name: 
		$temp = 'uploads/' . md5($_FILES['image']['name']);
	
		// Move the file over:
		if (move_uploaded_file($_FILES['image']['tmp_name'], $temp)) {
	
			echo '<p>The file has been uploaded!</p>';
			
			// Set the $i variable to the image's name:
			$i = $_FILES['image']['name'];
	
		} else { // Couldn't move the file over.
			$errors[] = 'The file could not be moved.';
			$temp = $_FILES['image']['tmp_name'];
		}
	    } else {
	    	$errors[]= "Image larger than 2MB.";
	    }
       } else {
       	$errors[]= "Invalid file. Require jpg, png or gif format";
       }
	} else { // No uploaded file.
		$i=$row['image_name'];
		$temp = NULL;
	}
	
	// Check for a size (not required):
	//$s = (!empty($_POST['size'])) ? trim($_POST['size']) : NULL;
	
	// Check for a price:
	if (is_numeric($_POST['price'])) {
		$p = (float) $_POST['price'];
	} else {
		$errors[] = 'Please enter the dish\'s price!';
	}
	
	// Check for a description (not required):
	$d = (!empty($_POST['description'])) ? test_input($_POST['description']) : NULL;
	
	

	
	if (empty($errors)) { // If everything's OK.
	    $rid=$_SESSION['restaurant_id'];
		// Add the dish to the database:
		$q = 'UPDATE `dish` SET `dish_name`=?,`price`=?,`image_name`=?,`description`=? WHERE `dish_id`=?';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'sdssi', $dn, $p, $i, $d, $dishid);
		mysqli_stmt_execute($stmt);
		//$q = "INSERT INTO `dish`( `dish_name`, `price`, `image_name`, `description`, `restaurantId`) VALUES ('$dn', '$p', '$i','$d','$rid')";
		    //$r = @mysqli_query ($dbc, $q); 

            if (mysqli_stmt_affected_rows($stmt) == 1) { // If it ran OK.
		// Print a message:
			
			echo '<p>The dish has been updated.</p>';
			if ($temp != NULL) {
				// Delete the previous image if it still exists:
			$imagename="./uploads/".$dishid;
	if ( isset($imagename) && file_exists ($imagename) && is_file($imagename) ) {
		unlink ($imagename);
	}
			// Rename the image:
			//$id = mysqli_stmt_insert_id($stmt); // Get the print ID.
			rename ($temp, "./uploads/$dishid");
		}
			//$q2 = "UPDATE `dish` SET `image_name`='".$id."' WHERE `dish_name`='".$dn."',`image_name`='".$i."',`restaurantId`=".$rid.",`price`=".$p.",`description`='".$d."'";
		    //$r = @mysqli_query ($dbc, $q2) 
		    //Or die ('cannot rename image name'); 
      // Redirect:
      $url = absolute_url ('browse_menu.php');
      header("Location: $url");
      			// Clear $_POST:
			$_POST = array();
      exit(); 
      
      } else { // If it did not run OK.
         
         // Public message:
         echo '<p style="font-weight: bold; color: #C00">Your submission could not be processed due to a system error.</p>';  
         
         // Debugging message:
         echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                  
      }
				mysqli_stmt_close($stmt);		
	} // End of $errors IF.
	
	// Delete the uploaded file if it still exists:
	if ( isset($temp) && file_exists ($temp) && is_file($temp) ) {
		unlink ($temp);
	}
	mysqli_close($dbc);
} // End of the submission IF.


// Display the form...
require_once ('includes/header.html');
?>
<?php                 	// Check for any errors and print them:
if ( !empty($errors) && is_array($errors) ) {
	echo '<h1>Error!</h1>
	<p style="font-weight: bold; color: #C00">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo 'Please reselect the dish image and try again.</p>';
}
?>
<h2>Edit Dish: <?php echo $row['dish_name'] ?></h2> <br />
<form enctype="multipart/form-data" action="edit_dish.php" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
	
	<p><b>Dish Name:</b> <input type="text" name="dish_name" size="30" maxlength="60" value="<?php  echo $row['dish_name'] ?>" />*</p>
	
	<p><b>New Image: (optional) (max: 2MB)</b> <input type="file" name="image" /></p>
	

	
	<p><b>Price:$</b> <input type="text" name="price" size="10" maxlength="10" value="<?php echo $row['price']; ?>" /> <small>* Do not include the dollar sign or commas.</small></p>
		
	<p><b>Description :</b> <textarea name="description" cols="40" rows="5"><?php echo $row['description']; ?></textarea> (optional)</p>
	
	</fieldset>
		
	<div align="center"><input type="submit" name="submit" value="Update" /></div>
	<input type="hidden" name="dishid" value="<?php echo $dishid ?>" />
	<input type="hidden" name="submitted" value="TRUE" />

</form>
<?php include ('includes/footer.html');
?>