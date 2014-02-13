<?php
$hide = false;
if (isset($_POST['submit'])){
	
	//check the username against the database
	
	//check the password against the database
	echo "New Page";
	$hide = true;
}


if ($hide != true){
require("header.php");
?>
		<!-- U.S. 2,3,4: Sets up the home page with two text boxes and if errors exist alerts the user. 
			Scales the page to fit web and mobile -->
		<div class="row">
			<div class="large-4 columns large-centered text-center medium-6 medium-centered">
				<h2>Check Points</h2>
				<h2 class="subheader"><small>Enter your ID Number and Password</small></h2>
				<form name="login" action="index.php" method="post" onsubmit="return checkAll()">
					<input type="tel" name="idNumber" placeholder="ID Number" autofocus required maxlength="7" title="Seven digit ID#" onblur="checkForm(this)">
					<small class="error" style="display:none">Seven digit ID# is required</small>
					<input type="password" name="password" placeholder="Password" maxlength="20" required onblur="checkPass(this)">
					<small class="error" style="display:none">Password is required.</small>
					<input type="submit" name="submit" class="button">
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
require('footer.php');
}
?>