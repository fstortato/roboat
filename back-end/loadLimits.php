<?php

	// Include database parameters
	include("connection.php");

	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);
	
	$sqlGetLimits = "SELECT * FROM limits";

	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {				
		// Execute query
		$result = $conn->query($sqlGetLimits);
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else {				
			$result = $result->fetch_assoc();
			$return['voltageCells'] = $result['voltage_cells'];
			$return['currentMotors'] = $result['current_ms'];
			$return['temperatureControllers'] = $result['temp_cs'];
			$return['temperatureMotors'] = $result['temp_ms'];
			$return['waterFlow'] = $result['water_flow'];
			$return['waterLevel'] = $result['water_level'];

			echo json_encode($return);
		}
	}
	$conn->close(); // Close connection
?>