<?php
	// Include database parameters
	include("connection.php");

	// Read post data
	$data = json_decode(file_get_contents("php://input"));
	
	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);
	
	// SQL query to update user credits in the users table
	$sqlUpdateController = "UPDATE limits SET `voltage_cells` = $data->voltageCells, `current_ms` = $data->currentMotors,
	`temp_cs` = $data->temperatureControllers, `temp_ms` = $data->temperatureMotors, `water_flow` = $data->waterFlow, `water_level` = $data->waterLevel";

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