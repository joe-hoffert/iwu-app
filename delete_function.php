<?php
require("config.php");// get SQL Database login credentials
require("functions.php");
$mysqli = iwu_startMysql();

$sql = 'DELETE FROM Student_Account
		WHERE studentID = 1234567';
       $mysqli->query($sql);
       
$sql = 'DELETE FROM Mealswipe_History
		ORDER BY id DESC LIMIT 1';
       $mysqli->query($sql);
       
$sql = 'DELETE FROM Point_History
		ORDER BY id DESC LIMIT 1';
       $mysqli->query($sql);
iwu_stopMysql($mysqli);
?>