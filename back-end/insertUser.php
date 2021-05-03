<?php

	// Include database parameters
	include("connection.php");

	// Read post data
	$data = json_decode(file_get_contents("php://input"));
	
	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);

	// SQL query used to insert a new user with the parameters passed in the post request
	$sqlAddUser = "INSERT INTO users (`user_first_name`, `user_access_name`, `user_type`, `user_password`, `user_token`)
		VALUES ('$data->name', '$data->username', $data->type, 'a63ad5ca5dc1a98c0c7716398593b2dcc02f9f14', '')";
	
	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {		
		// Execute query
		$conn->query($sqlAddUser);
		// Check connection
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else echo "Insertion Successful!";	
	}
	$conn->close(); // Close connection
?>