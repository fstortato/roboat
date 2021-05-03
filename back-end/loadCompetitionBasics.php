<?php

	// Include database parameters
	include("connection.php");

	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);
	
	$sqlGetCompetitions = "SELECT competition_id, competition_name, competition_year FROM competitions";

	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {				
		// Execute query
		$result = $conn->query($sqlGetCompetitions);
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$return[$i] = $row['competition_id'] . ' - ' . $row['competition_name'] . ' - ' . $row['competition_year'];
				$i = $i + 1;
			}
			echo json_encode($return);
		}
	}
	$conn->close(); // Close connection
?>