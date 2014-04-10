<?php
require("config.php");// get SQL Database login credentials
require("functions.php");
$mysqli = iwu_startMysql();
       
$sql = 'SELECT MIN(totalMealswipes) as total FROM Mealswipe_History WHERE Student_Account_id = 1';
		$total_meals = iwu_getRow($sql, $mysqli);
		$sql = 'INSERT INTO Mealswipe_History
		(lastUsed, Locations_id, Student_Account_id, totalMealswipes)
		VALUES (NOW(), 1, 1, '.($total_meals['total']-1).')';
		$mysqli->query($sql);
       
$sql = 'SELECT MIN(totalPoints) as total FROM Point_History WHERE Student_Account_id = 1';
		$total_points = iwu_getRow($sql, $mysqli);
		$sql = 'INSERT INTO Point_History
			(lastUsed, Locations_id, Student_Account_id, totalPoints, pointsSpent)
			VALUES (NOW(), 1, 1, '.($total_points['total']-2.5).', 2.50)';
		$mysqli->query($sql);
iwu_stopMysql($mysqli);
?>