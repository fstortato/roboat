<?php

	// Include database parameters
	include("connection.php");

	// Connect
	$conn = new mysqli($serverName, $userName, $password, $dbName);
	
	$sqlGetCompetitions = "SELECT * FROM competitions";

	// Check connection
	if ($conn->connect_error) echo ("Error - Connection failed: " . $conn->connect_error);
	else {				
		// Execute query
		$resultOne = $conn->query($sqlGetCompetitions);
		if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
		else {
			$i = 0;
			while($rowOne = $resultOne->fetch_assoc()) {
													
				$return[$i]['competitionId'] = $rowOne['competition_id'];
				$return[$i]['competitionName'] = $rowOne['competition_name'];
				$return[$i]['competitionYear'] = $rowOne['competition_year'];
				$return[$i]['competitionRank'] = $rowOne['competition_rank'];
				$return[$i]['competitionNTeams'] = $rowOne['competition_nteams'];
				$return[$i]['competitionCity'] = $rowOne['competition_city'];
				$return[$i]['competitionState'] = $rowOne['competition_state'];
				$return[$i]['competitionCaptain'] = $rowOne['competition_captain'];
				$return[$i]['competitionLieutenant'] = $rowOne['competition_lieutenant'];
				$return[$i]['competitionAdvisor'] = $rowOne['competition_advisor'];
				$return[$i]['competitionComments'] = $rowOne['competition_comments'];

				$sqlGetCompetitionMembers = "SELECT * FROM competition_members WHERE competition_id = " . $return[$i]['competitionId'];
				$resultTwo = $conn->query($sqlGetCompetitionMembers);
				if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
				else {
					$j = 0;
					while($rowTwo = $resultTwo->fetch_assoc()) {
						$return[$i]['competitionMembers'][$j] = $rowTwo['competition_member'];
						$j = $j + 1;
					}
				}
				$sqlGetCompetitionEvents = "SELECT * FROM competition_events WHERE competition_id = " . $return[$i]['competitionId'];
				$resultThree = $conn->query($sqlGetCompetitionEvents);
				if ($conn->error) echo "Error - Server error while updating database: " . $conn->error;
				else {
					$k = 0;
					while($rowThree = $resultThree->fetch_assoc()) {
						$return[$i]['competitionEvents'][$k] = $rowThree['competition_event'];
						$return[$i]['competitionEventRanks'][$k] = $rowThree['competition_event_rank'];
						$k = $k + 1;
					}
				}

				$i = $i + 1;
			}
			echo json_encode($return);
		}
	}
	$conn->close(); // Close connection
?>