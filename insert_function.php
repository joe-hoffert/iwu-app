<?php
require("config.php");// get SQL Database login credentials
require("functions.php");
$mysqli = iwu_startMysql();

$sql = 'INSERT INTO Student_Account
       (studentID, firstName, lastName, password) 
       VALUES (1234567, "Jim", "Smith", "password")';
       $mysqli->query($sql);
       
$sql = 'INSERT INTO Mealswipe_History
	(lastUsed, Locations_id, Student_Account_id, totalMealswipes)
	VALUES (NOW(), 1, 2, 45)';
       $mysqli->query($sql);
       
$sql = 'INSERT INTO Point_History
		(lastUsed, Locations_id, Student_Account_id, totalPoints, pointsSpent)
		VALUES (NOW(), 5, 2, 123.12, 2.33)';
       $mysqli->query($sql);
iwu_stopMysql($mysqli);
?>