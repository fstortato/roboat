<?php

	// Include database parameters
	include("connection.php");

	// Create first connection
	$conn = new mysqli($serverName, $userName, $password);

	// Check connection
	if ($conn->connect_error) {
		echo("Connection failed: " . $conn->connect_error);
	} 

	// Queries

	// Database creation query
	$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS " . $dbName;

	// Table "users" creation query
	$sqlCreateUsersTable = "CREATE TABLE IF NOT EXISTS users (
		user_id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		user_first_name VARCHAR(15) NOT NULL,
		user_access_name VARCHAR(15) NOT NULL,
		user_type TINYINT UNSIGNED,
		user_password VARCHAR(40) NOT NULL,
		user_token VARCHAR(60) NULL
	)";

	// Table "competitions" creation query
	$sqlCreateCompetitionsTable = "CREATE TABLE IF NOT EXISTS competitions (
		competition_id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		competition_name VARCHAR(45) NOT NULL,
		competition_year SMALLINT UNSIGNED NOT NULL,
		competition_rank TINYINT UNSIGNED NOT NULL,
		competition_nteams TINYINT UNSIGNED NOT NULL,
		competition_city VARCHAR(45) NOT NULL,
		competition_state VARCHAR(2) NOT NULL,
		competition_captain VARCHAR(45) NOT NULL,
		competition_lieutenant VARCHAR(45) NOT NULL,
		competition_advisor VARCHAR(45) NOT NULL,
		competition_comments VARCHAR(300) NOT NULL
	)";

	// Table "competition_members" creation query
	$sqlCreateCompetitionMembersTable = "CREATE TABLE IF NOT EXISTS competition_members (
		competition_member_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		competition_id TINYINT UNSIGNED,
		competition_member VARCHAR(45) NOT NULL
	)";

	// Table "competition_events" creation query
	$sqlCreateCompetitionEventsTable = "CREATE TABLE IF NOT EXISTS competition_events (
		competition_event_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		competition_id TINYINT UNSIGNED,
		competition_event VARCHAR(45) NOT NULL,
		competition_event_rank TINYINT UNSIGNED NOT NULL
	)";

	// Table "measures" creation query
	$sqlCreateMeasuresTable = "CREATE TABLE IF NOT EXISTS measures (
		id_measure INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		measure_time TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
		voltage_cel1 REAL,
		voltage_cel2 REAL,
		voltage_cel3 REAL,
		voltage_m1 REAL,
		voltage_m2 REAL,
		current_m1 REAL,
		current_m2 REAL,
		temp_c1 REAL,
		temp_c2 REAL,
		temp_m1 REAL,
		temp_m2 REAL,
		water_level REAL,
		inc_x REAL,
		inc_y REAL,
		water_flow REAL
	)";

	// Table "limits" creation query
	$sqlCreateLimitsTable = "CREATE TABLE IF NOT EXISTS limits (
		voltage_cells REAL,
		current_ms REAL,
		temp_cs REAL,
		temp_ms REAL,
		water_flow REAL,
		water_level REAL
	)";

	// Table "commands" creation query
	$sqlCreateControllerTable = "CREATE TABLE IF NOT EXISTS controller (
		valid BIT,
		vertical_control TINYINT,
		horizontal_control TINYINT,
		luminosity TINYINT UNSIGNED,
		custom_control1 BIT,
		custom_control2 BIT,
		custom_control3 BIT,
		custom_control4 BIT
	)";

	// Admin user insertion query
	$sqlAddAdminUser = "INSERT INTO users (`user_first_name`, `user_access_name`, `user_type`, `user_password`, `user_token`)
		VALUES ('Felipe', 'fetortato', 0, '061ad3fa917f47c7425eb51daa5521ae2f8cdb3e', '')";

	// Default limit values insertion
	$sqlAddDefaultLimits = "INSERT INTO limits (`voltage_cells`, `current_ms`, `temp_cs`, `temp_ms`, `water_flow`, `water_level`) 
		VALUES (3, 40, 80, 80, 0, 0)";

	// Default control values insertion
	$sqlUnsetControllers = "INSERT INTO controller (`valid`, `vertical_control`, `horizontal_control`, `luminosity`, `custom_control1`, `custom_control2`, `custom_control3`, `custom_control4`) 
		VALUES (0, 0, 0, 0, 0, 0, 0, 0)";

	// Execution and tests

	// Execute query
	$conn->query($sqlCreateDatabase);

	// Check connection
	if ($conn->error) echo "Error - Server error while creating the database: " . $conn->error;
	else {
		// Close first connection
		$conn->close();
	}

	// Open connection using the database roboat
	$conn = new mysqli($serverName, $userName, $password, $dbName);

	// Test connection
	if ($conn->connect_error) {
		echo("Connection failed: " . $conn->connect_error);
	} 
	else {
		// Execute queries
		$conn->query($sqlCreateUsersTable) AND $conn->query($sqlCreateCompetitionsTable) AND $conn->query($sqlCreateCompetitionMembersTable) AND $conn->query($sqlCreateCompetitionEventsTable) AND $conn->query($sqlCreateMeasuresTable) AND $conn->query($sqlCreateLimitsTable) AND $conn->query($sqlCreateControllerTable);
		// Check connection
		if (!$conn->error) {
			// Execute queries
			$conn->query($sqlAddAdminUser) AND $conn->query($sqlAddDefaultLimits) AND $conn->query($sqlUnsetControllers);
			// Check connection
			if (!$conn->error) echo("Insertion Successful"); 
			else echo("Insertion Error: " . $conn->error);
		}
		else echo("Configuration Error: " . $conn->error);
	}

	$conn->close(); // Close connection

?>