<?php
	// Include database parameters
	include("connection.php");
	
	// Read post data
	$data = json_decode(file_get_contents("php://input"));
	$token = $data->token;

	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);

	// Check connection
	if ($conn->connect_error) echo ("Authentication error - Connection failed: " . $conn->connect_error);
	else {
		// SQL query used to check if there is a user with that token
		$sqlGetUser = "SELECT user_first_name FROM users WHERE user_token='$token'";
		// Execute query
		$result = $conn->query($sqlGetUser);
		// Check connection
		if ($conn->error) echo "Authentication error - Server error while consulting database: " . $conn->error;
		else {
			$resultsFound = $result->num_rows;
			// Check if there is one and only one user
			if ($resultsFound == 1) {
				$result = $result->fetch_assoc();
				$return['name'] = $result['user_first_name'];
				echo json_encode($return);
			}
			else {
				echo "Authentication error - User not found";
			}
		}
	}
	$conn->close(); // Close connection
?>