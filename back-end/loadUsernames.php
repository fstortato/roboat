<?php

	// Include database parameters
	include("connection.php");

	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);
	
	$sqlGetUsernames = "SELECT user_access_name FROM users";

	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {				
		// Execute query
		$result = $conn->query($sqlGetUsernames);
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$return[$i] = $row['user_access_name'];
				$i = $i + 1;
			}
			echo json_encode($return);
		}
	}
	$conn->close(); // Close connection
?>