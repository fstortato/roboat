<?php

	// Include database parameters
	include("connection.php");

	// Include random generator function
	include("randomgenerator.php");

	// Read post data
	$data = json_decode(file_get_contents("php://input"));

	$userAccessName = $data->userName;
	
	// Convert the password to sha1 (hash function)
	$userPassword = sha1($data->password);
	
	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);

	// SQL query to load the user with registry number and access level passed as parameter in the post request
	$sqlCheckUser = "SELECT user_first_name, user_type FROM users WHERE user_access_name='$userAccessName' AND user_password='$userPassword'";

	// Check connection
	if ($conn->connect_error) echo("Authentication error - Connection failed: " . $conn->error);
	else {
		// Execute query
		$result = $conn->query($sqlCheckUser);
		$resultsFound = $result->num_rows;
		// Check if there is one and only one user for that registry number and password combination
		if ($resultsFound == 1) {
			$result = $result->fetch_assoc();
			$token = random(7) . $result["user_type"] . random(8) . " | " . $userAccessName;
			// SQL query to set a new token to the now logged user
			$sqlLogUserIn = "UPDATE users SET user_token='$token' WHERE user_access_name='$userAccessName'";
				// Execute query
			$conn->query($sqlLogUserIn);
			// Check connection
			if ($conn->error) echo "Authentication error - Server error while updating user: " . $conn->error;
			else echo $token;
		}
		else echo "Authentication error - User not found";
	}
	$conn->close();	// Close connection
?>