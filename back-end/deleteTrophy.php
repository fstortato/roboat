<?php

	// Include database parameters
	include("connection.php");

	// Read post data
	$data = json_decode(file_get_contents("php://input"));
	
	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);

	// SQL query used to insert a new user with the parameters passed in the post request
	$sqlDeleteCompetition = "DELETE FROM competitions WHERE competition_id = '$data->competitionId'";
	$sqlDeleteCompetitionMembers = "DELETE FROM competition_events WHERE competition_id = '$data->competitionId'";
	$sqlDeleteCompetitionEvents = "DELETE FROM competition_members WHERE competition_id = '$data->competitionId'";
	
	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {		
		// Execute query
		$conn->query($sqlDeleteCompetition) AND $conn->query($sqlDeleteCompetitionMembers) AND $conn->query($sqlDeleteCompetitionEvents);
		// Check connection
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else echo "Deletion Successful!";	
	}
	$conn->close(); // Close connection
?>