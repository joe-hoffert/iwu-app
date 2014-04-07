<?php
/************************************************************************** 
* Copyright 2014 Nikki Lehman, Erik Vanlandingham, Brent Zerbe            * 
*																		  * 
* Licensed under the Apache License, Version 2.0 (the "License");         * 
* you may not use this file except in compliance with the License.        * 
* You may obtain a copy of the License at                                 * 
*																		  * 
* http://www.apache.org/licenses/LICENSE-2.0 							  * 
*																		  * 
* Unless required by applicable law or agreed to in writing, software     * 
* distributed under the License is distributed on an "AS IS" BASIS,       * 
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.* 
* See the License for the specific language governing permissions and     * 
* limitations under the License. 									  	  * 
**************************************************************************/
$hide = false;
//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);

function dateDiffDay ($d1, $d2) {
// Return the number of days between the two dates:

  return round(abs(strtotime($d1)-strtotime($d2))/(60*60*24));

}  // end function dateDiff

function dateDiffWeek ($d1, $d2) {
// Return the number of days between the two dates:

  return round(abs(strtotime($d1)-strtotime($d2))/(60*60*24*7));

}  // end function dateDiff

$send_error = '';
$page_title = 'IWU APP | Check Points';
if (isset($_POST['submit']) || $_COOKIE["user"]!=""){
	$hide = true;
	$mealSwipes = 'error';
	$points = 'error';
	
	
	//get the date
	$today = getdate();
	$d = $today['mday'];
	$m = $today['mon'];
	$y = $today['year'];
	$datetime1 = "$y-$m-$d";
	
	
	require("config.php");// get SQL Database login credentials
	require("functions.php");
	$mysqli = iwu_startMysql();
	
	if ($_COOKIE["user"]!="") {
		$idNumber = $_COOKIE["user"];
		$sql = "SELECT firstName, lastName
				FROM Student_Account
				WHERE studentID = ".mysql_real_escape_string($idNumber);
		$row = iwu_getRow($sql, $mysqli);
	}
	else {
		//check if they are in the database
		$idNumber = $_POST['idNumber'];
		$password = $_POST['password'];
		$sql = "SELECT firstName, lastName
				FROM Student_Account
				WHERE studentID = ".mysql_real_escape_string($idNumber)."
				AND password = '".mysql_real_escape_string($password)."'";
		$row = iwu_getRow($sql, $mysqli);
	}
	if ($row!=null || $row!=false) {
		$userID = $row['firstName'].' '.$row['lastName'];
		$cookieUserId = mysql_real_escape_string($_POST['idNumber']);
		if (!isset($_COOKIE["user"])){
			setcookie("user", $cookieUserId, time()+3600);
			//$_COOKIE["user"]=$cookieUserId;
		}
	}
	else {
		$send_error = "Incorrect Username or Password";
		$hide = false;
	}
	
	
	if ($send_error == '') {
		
		
		//get Amount of Mealswipes
		$sql = "SELECT lastUsed, totalMealswipes, location
				FROM Student_Account, Mealswipe_History, Locations
				WHERE Student_Account.StudentID = ".mysql_real_escape_string($idNumber)." AND
				    Student_Account.id = Mealswipe_History.Student_Account_id AND
				    Mealswipe_History.Locations_id = Locations.id 
				ORDER BY lastUsed DESC LIMIT 1";
		$allMeals = iwu_getRow($sql, $mysqli);
		$mealSwipes = $allMeals['totalMealswipes'];
		$mealLocation = $allMeals['location'];
		$mealTime = $allMeals['lastUsed'];
		
		//get Amount of Points
		$sql = "SELECT lastUsed, pointsSpent, totalPoints, location
				FROM Student_Account, Point_History, Locations
				WHERE Student_Account.StudentID = ".mysql_real_escape_string($idNumber)." AND
				    Student_Account.id = Point_History.Student_Account_id AND
				    Point_History.Locations_id = Locations.id 
				ORDER BY lastUsed DESC LIMIT 1";
		$allPoints = iwu_getRow($sql, $mysqli);
		$points = $allPoints['totalPoints'];
		$pointsLocation = $allPoints['location'];
		$pointsTime = $allPoints['lastUsed'];
		
		$datetime2 = '2014-04-23';//initial implementation of US4:7,8
		$page_title = 'Account Information';
		require("header.php");
		
		
		// US2:1,2,3 Implemented a fully working system. Displays account information to the user
		?>
		
		<div class="row">
			<div class="large-5 columns large-centered text-center medium-6 medium-centered last">
				<h2>Account Information</h2><hr>
				<h3><?php echo $userID?></h3>
				<ul class="pricing-table">
				  <li class="title">Meal Swipes</li>
				  <li class="price"><?php echo $mealSwipes?></li>
				  <li class="bullet-item">Average left per day: <?php
					$interval = dateDiffDay($datetime1, $datetime2);
					echo number_format($mealSwipes/$interval, 2, '.', '');?></li>
				  <li class="bullet-item">Last Used: <?php echo date('F d, Y h:mA', strtotime($mealTime)).' at '.$mealLocation;?></li><!-- future feature for mockup purposes-->
				  <li class="cta-button"><a class="button tiny radius" href="accountHistory.php?type=mealSwipes">Full History</a></li>
				</ul>
				<ul class="pricing-table">
				  <li class="title">Points</li>
				  <li class="price"><?php echo number_format($points, 2, '.', '');?></li>
				  <li class="bullet-item">Average left per week: <?php
					$interval = dateDiffWeek($datetime1, $datetime2);
					echo number_format($points/$interval, 2, '.', '');?></li>
				  <li class="bullet-item">Last Used: <?php echo date('F d, Y h:mA', strtotime($pointsTime)).' at '.$pointsLocation;?></li>
				  <li class="cta-button"><a class="button tiny radius" href="accountHistory.php?type=points">Full History</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="large-5 columns large-centered text-center medium-6 medium-centered last">
				<h5><a href="/logout.php" class="button secondary">Logout</a></h5>
			</div>
		</div>
	<?php
	}
	iwu_stopMysql($mysqli);
}



if ($hide != true){
require("header.php");
?>
		<!-- U.S. 2,3,4: Sets up the home page with two text boxes and if errors exist alerts the user. 
			Scales the page to fit web and mobile -->
		<div class="row">
			<div class="large-4 columns large-centered text-center medium-6 medium-centered">
				<h2>Check Points</h2><hr>
				<h2 class="subheader"><small>Enter your ID Number and Password</small></h2>
				<form name="login" method="post" onsubmit="return checkAll()">
					<input type="tel" name="idNumber" placeholder="ID Number" autofocus required maxlength="7" title="Seven digit ID#" onblur="checkForm(this)" pattern="[0-9]{7}">
					<small class="error" style="display:none">Seven digit ID# is required</small>
					<input type="password" name="password" placeholder="Password" maxlength="20" required onblur="checkPass(this)">
					<small class="error" style="display:none">Password is required.</small>
					<?php if ($send_error != '') {
						echo '<h5 style="color:red">'.$send_error.'<h5>';
					}
					?>
					<input type="submit" name="submit" class="button" value="Submit">
				</form>
			</div>
		</div>

		<script>
			//checks if the variable is a number
			function isNumeric(obj) {
				"use strict";
				return obj - parseFloat(obj) >= 0;
			}
			
			//U.S. 5: checks that a studentID is entered and it's 7 digits. 
			function checkForm(user)
			{
				"use strict";
				var usernameLength = 7;
				if (user.value.length !== usernameLength || isNumeric(user.value) === false)
				{
					user.style.borderColor = "red";
					user.nextSibling.nextSibling.style.display = "block";
					return false;
				}
				user.style.borderColor = "green";
				user.nextSibling.nextSibling.style.display = "none";
				return true;
			}
			
			//U.S. 6: checks that a password is entered and that it's at least 6 characters or more. 
			function checkPass(passwrd)
			{
				"use strict";
				if (passwrd !== null)
				{
					var passwordLength = 5;
					if (passwrd.value.length < passwordLength)
					{
						passwrd.style.borderColor = "red";
						passwrd.nextSibling.nextSibling.style.display = "block";
						return false;
					}
					passwrd.style.borderColor = "green";
					passwrd.nextSibling.nextSibling.style.display = "none";
					return true;
				}
				passwrd.style.borderColor = "red";
				passwrd.nextSibling.nextSibling.style.display = "block";
				return false;
			}
			
			//double checks the idNumber and Password on submit
			function checkAll()
			{
				"use strict";
				if (checkForm(document.getElementsByName('idNumber')[0]) && checkPass(document.getElementsByName('password')[0]))
				{
					return true;
				}
				return false;
			}
		</script>
<?php 
}
require('footer.php');
?>