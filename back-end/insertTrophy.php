<?php

	// Include database parameters
	include("connection.php");

	// Read post data
	$data = json_decode(file_get_contents("php://input"));
	
	$membersToInsert = explode(",",$data->competitionMembers);
	
	$eventsAndRankStringArray = explode(",",$data->competitionEvents);
	
	$i = 0;
	while ($i < sizeof($eventsAndRankStringArray)) {
		$temp = explode("-", $eventsAndRankStringArray[$i]);
		$competitionEvents[$i] = $temp[0];
		$competitionEventRanks[$i] = $temp[1];
		$i = $i + 1;
	}
	
	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);

	// SQL queries used to insert a new competition with the parameters passed in the post request
	$sqlAddCompetition = "INSERT INTO competitions (`competition_name`, `competition_year`, `competition_rank`, `competition_nteams`,	`competition_city`, `competition_state`, `competition_captain`, `competition_lieutenant`, `competition_advisor`, `competition_comments`)
		VALUES ('$data->competitionName', '$data->competitionYear', '$data->competitionRank', '$data->competitionNTeams', '$data->competitionCity', '$data->competitionState', '$data->competitionCaptain', '$data->competitionLieutenant', '$data->competitionAdvisor', '$data->competitionComments')";
	
	$sqlGetCompetitionId = "SELECT competition_id FROM competitions ORDER BY competition_id DESC LIMIT 1";
	
	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {				
		// Execute query
		$conn->query($sqlAddCompetition);
		// Check connection
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else {
			// Execute query
			$result = $conn->query($sqlGetCompetitionId);
			if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
			else {				
				$result = $result->fetch_assoc();
				$competitionId = $result['competition_id'];
				$sqlAddCompetitionEvents = "INSERT INTO competition_events (`competition_id`, `competition_event`, `competition_event_rank`)
					VALUES ($competitionId, '$competitionEvent', '$competitionEventRank')";

				// Check if there are members to be added to the competition_members table
				$i = 0;
				// Insert each member in the competition_members table
				while ($i < sizeof($membersToInsert)) {
					$sqlAddCompetitionMembers = "INSERT INTO competition_members (`competition_id`, `competition_member`)
						VALUES ($competitionId, '$membersToInsert[$i]')";		
					$conn->query($sqlAddCompetitionMembers);
					if ($conn->error) echo "Error - Server error while updating database: [" . $i . "]". $conn->error;
					$i = $i + 1;
				}

				// Check if there are events to be added to the competition_events table
				$i = 0;
				// Insert each event in the competition_events table
				while ($i < sizeof($eventsAndRankStringArray)) {
					$sqlAddCompetitionEvents = "INSERT INTO competition_events (`competition_id`, `competition_event`, `competition_event_rank`)
						VALUES ($competitionId, '$competitionEvents[$i]', '$competitionEventRanks[$i]')";
					$conn->query($sqlAddCompetitionEvents);
					if ($conn->error) echo "Error - Server error while updating database: [" . $i . "]". $conn->error;
					$i = $i + 1;
				}
			}
		}
	}
	$conn->close(); // Close connection
?>