<?php // Validate the artist...
		if (isset($_POST['artist']) && ($_POST['artist'] == 'new') ) {
		// If it's a new artist, add the artist to the database...
		
		// Validate the first and middle names (neither required):
		$fn = (!empty($_POST['first_name'])) ? trim($_POST['first_name']) : NULL;
		$mn = (!empty($_POST['middle_name'])) ? trim($_POST['middle_name']) : NULL;

		// Check for a last_name...
		if (!empty($_POST['last_name'])) {
			
			$ln = trim($_POST['last_name']);
			
			// Add the artist to the database:
			$q = 'INSERT INTO artists (first_name, middle_name, last_name) VALUES (?, ?, ?)';
			$stmt = mysqli_prepare($dbc, $q);
			mysqli_stmt_bind_param($stmt, 'sss', $fn, $mn, $ln);
			mysqli_stmt_execute($stmt);
			
			// Check the results....
			if (mysqli_stmt_affected_rows($stmt) == 1) {
				echo '<p>The artist has been added.</p>';
				$a = mysqli_stmt_insert_id($stmt); // Get the artist ID.
			} else { // Error!
				$errors[] = 'The new artist could not be added to the database!';
			}
			
			// Close this prepared statement:
			mysqli_stmt_close($stmt);
			
		} else { // No last name value.
			$errors[] = 'Please enter the artist\'s name!';
		}
		
	} elseif ( isset($_POST['artist']) && ($_POST['artist'] == 'existing') && ($_POST['existing'] > 0) ) { // Existing artist.
		$a = (int) $_POST['existing'];
	} else { // No artist selected.
		$errors[] = 'Please enter or select the print\'s artist!';
	}
	?>
	<div><b>Food:</b> 
	<p><input type="radio" name="artist" value="existing" <?php if (isset($_POST['artist']) && ($_POST['artist'] == 'existing') ) echo ' checked="checked"'; ?>/> Existing =>
	<select name="existing"><option>Select One</option>
	<?php // Retrieve all the artists and add to the pull-down menu.
	$q = "SELECT artist_id, CONCAT_WS(' ', first_name, middle_name, last_name) FROM artists ORDER BY last_name, first_name ASC";		
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) > 0) {
		while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\"";
			// Check for stickyness:
			if (isset($_POST['existing']) && ($_POST['existing'] == $row[0]) ) echo ' selected="selected"';
			echo ">$row[1]</option>\n";
		}
	} else {
		echo '<option>Please add a new artist.</option>';
	}
	mysqli_close($dbc); // Close the database connection.
	?>
	</select></p>
	
	<p><input type="radio" name="artist" value="new" <?php if (isset($_POST['artist']) && ($_POST['artist'] == 'new') ) echo ' checked="checked"'; ?>/> New =>
	First Name: <input type="text" name="first_name" size="10" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" />
	Food Type: <input type="text" name="middle_name" size="10" maxlength="20" value="<?php if (isset($_POST['middle_name'])) echo $_POST['middle_name']; ?>" />
	Info: <input type="text" name="last_name" size="10" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
	</div>