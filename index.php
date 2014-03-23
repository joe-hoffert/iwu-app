<?php
$hide = false;
$send_error = '';
$page_title = 'IWU APP | Check Points';
if (isset($_POST['submit']) || $_COOKIE["user"]!=""){
	$hide = true;
	$mealSwipes = 'error';
	$points = 'error';
	$idNumber = $_POST['idNumber'];
	if ($_COOKIE["user"]!="") {
		$idNumber = $_COOKIE["user"];
	}
	
	//$userID = 2107517; eventually make a hash of the user id to get a unique id
	
	require("config.php");// get SQL Database login credentials
	$mysqli = new mysqli($sql_host, $sql_username, $sql_password, $sql_database);
	
	/* check connection */
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	if ($result = $mysqli->query("	SELECT firstName, lastName, mealswipes, points 
									FROM Student, Account 
									WHERE Student.studentIDNum = Account.studentIDNum 
									AND Account.studentIDNum = ".mysql_real_escape_string($idNumber))
									) {
		if ($result->num_rows==0){
			$send_error = "Incorrect Username or Password";
			$hide = false;
		}
		while($row = mysqli_fetch_array($result))
		  {
		  $userID = $row['firstName'].' '.$row['lastName'];
		  $mealSwipes = $row['mealswipes'];
		  $points = $row['points'];
		  }
	
	    /* free result set */
	    $result->close();
	}
	else {
		$send_error = "Incorrect Username or Password";
		$hide = false;
	}
	
	if ($send_error == '') {
		$cookieUserId = $_POST['idNumber'];
		if (!isset($_COOKIE["user"])){
			setcookie("user", $cookieUserId, time()+3600);
		}
		$page_title = 'Account Information';
		require("header.php");
		
		
	
		
		
		//check the username against the database
		//$_POST['idNumber']
		//check the password against the database
		//$_POST['password']
		mysqli_close($mysqli);
		
		$date = "3/14/14";
		$time = "9:34PM";
		$location = "Wildcat";
		
		// US2:1,2,3 Implemented a fully working system. Displays account information to the user
		?>
		
		<div class="row">
			<div class="large-4 columns large-centered text-center medium-6 medium-centered last">
				<h2>Account Information</h2><hr>
				<h3><?php echo $userID?></h3>
				<ul class="pricing-table">
				  <li class="title">Meal Swipes</li>
				  <li class="price"><?php echo $mealSwipes?></li>
				  <li class="bullet-item">Last Used: <?php echo $date.' '.$time.' at '.$location;?></li><!-- future feature for mockup purposes-->
				  <li class="cta-button"><a class="button tiny radius" href="accountHistory.php?type=mealSwipes">Full History</a></li>
				</ul>
				<ul class="pricing-table">
				  <li class="title">Points</li>
				  <li class="price"><?php echo $points?></li>
				  <li class="bullet-item">Last Used: <?php echo $date.' '.$time.' at '.$location;?></li><!-- future feature for mockup purposes-->
				  <li class="cta-button"><a class="button tiny radius" href="accountHistory.php?type=points">Full History</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="large-4 columns large-centered text-center medium-6 medium-centered last">
				<h5><a href="/logout.php" class="button secondary">Logout</a></h5>
			</div>
		</div>
	<?php
	}
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