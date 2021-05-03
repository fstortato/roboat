<?php
	// Include database parameters
	include("connection.php");

	// Read post data
	$data = json_decode(file_get_contents("php://input"));
	
	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);
	
	// SQL query to update user credits in the users table
	$sqlUpdateController = "UPDATE controller SET 
	`valid` = $data->joy, `vertical_control` = $data->vert, `horizontal_control` = $data->horiz, `luminosity` = $data->light, 
	`custom_control1` = $data->c1, `custom_control2` = $data->c2, `custom_control3` = $data->c3, `custom_control4` = $data->c4";

	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {
		// Execute query
		$conn->query($sqlUpdateController);
		// Check connection
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else {
			echo "Update Successful!";	
		}
	}
	$conn->close(); // Close connection
?>