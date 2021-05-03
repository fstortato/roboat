<?php

	// Include database parameters
	include("connection.php");

	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);
	
	$sqlGetLastMeasure = "SELECT * FROM measures ORDER BY id_measure DESC LIMIT 1";

	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {				
		// Execute query
		$result = $conn->query($sqlGetLastMeasure);
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else {				
			$result = $result->fetch_assoc();
			$return['measureTime'] = $result['measure_time'];
			$return['voltageC1'] = $result['voltage_cel1'];
			$return['voltageC2'] = $result['voltage_cel2'];
			$return['voltageC3'] = $result['voltage_cel3'];
			$return['voltageM1'] = $result['voltage_m1'];
			$return['voltageM2'] = $result['voltage_m2'];
			$return['currentM1'] = $result['current_m1'];
			$return['currentM2'] = $result['current_m2'];
			$return['tempC1'] = $result['temp_c1'];
			$return['tempC2'] = $result['temp_c2'];
			$return['tempM1'] = $result['temp_m1'];
			$return['tempM2'] = $result['temp_m2'];
			$return['waterLevel'] = $result['water_level'];
			$return['incX'] = $result['inc_x'];
			$return['incY'] = $result['inc_y'];
			$return['waterFlow'] = $result['water_flow'];

			echo json_encode($return);
		}
	}
	$conn->close(); // Close connection
?>