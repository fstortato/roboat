<?php

	// Include database parameters
	include("connection.php");

	// Read post data
	$data = json_decode(file_get_contents("php://input"));
	
	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);

	// SQL query used to insert a new user with the parameters passed in the post request
	$sqlDeleteUser = "DELETE FROM users WHERE user_access_name = '$data->username'";
	
	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {		
		// Execute query
		$conn->query($sqlDeleteUser);
		// Check connection
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else echo "Deletion Successful!";	
	}
	$conn->close(); // Close connection
?>