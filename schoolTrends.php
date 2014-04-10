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

$page_title = 'School Trends';
$idNumber = '';
require("config.php");
require("functions.php");

$mysqli = iwu_startMysql();

if ($_COOKIE["user"]!="") {
	$idNumber = $_COOKIE["user"];
	$sql = "SELECT firstName, lastName
			FROM Student_Account
			WHERE studentID = ".mysql_real_escape_string($idNumber);
	$row = iwu_getRow($sql, $mysqli);
	$userID = $row['firstName'].' '.$row['lastName'];
}
else {
	header('Location: /');
	exit;
}

	if ($_GET["type"]== "mealSwipes") {
		//display history for mealswipes
		$page_type = "Meal Swipes";
		$page_title .= ' | Meal Swipe History';
		$page_type_mini = "MS";
		$sql = "SELECT DISTINCT location, count(location) AS CountOf 
				FROM Student_Account, Mealswipe_History, Locations 
				WHERE Student_Account.id = Mealswipe_History.Student_Account_id 
				AND Mealswipe_History.Locations_id = Locations.id 
				AND Mealswipe_History.lastUsed< DATE(NOW() - INTERVAL 1 DAY)
				GROUP BY location";
		$Full_list = iwu_getResults($sql, $mysqli);
	}
	else if ($_GET["type"]== "points") {
		//display history for points
		$page_type = "Points";
		$page_type_mini = "P";
		$page_title .= ' | Point History';
		$sql = "SELECT DISTINCT location, count(location) AS CountOf 
				FROM Student_Account, Point_History, Locations 
				WHERE Student_Account.id = Point_History.Student_Account_id 
				AND Point_History.Locations_id = Locations.id 
				AND Point_History.lastUsed< DATE(NOW() - INTERVAL 1 DAY)
				GROUP BY location";
		$Full_list = iwu_getResults($sql, $mysqli);
	}
	iwu_stopMysql($mysqli);
require("header.php");
?>
<div class="row">
	<div class="large-5 columns large-centered text-center medium-6 medium-centered last">
		<h4 class="show-for-small"><a href="<?php echo $site_url.'accountHistory.php?type='.$_GET["type"];?>" class="button tiny left">Back</a>School Trends<a href="/logout.php" class="button secondary tiny right">Logout</a></h4>
		<h3 class="hide-for-small"><a href="<?php echo $site_url.'accountHistory.php?type='.$_GET["type"];?>" class="button tiny left">Back</a>School Trends<a href="/logout.php" class="button secondary tiny right">Logout</a></h3>
		<hr>
		
		<h3><?php echo $page_type." per Location Today"?></h3>
		<canvas id="canvas" height="250" width="250"></canvas><br><br>
		<?php
		if ($Full_list != false) {
			$colors = array("F7464A","949FB1","FDB45C","4D5360");
			$location_list = array();
			$location_value = array();
			foreach ($Full_list as $list=>$key) {
				array_push($location_list, $key[0]);
				array_push($location_value, $key[1]);
			}
			
			$total = array_sum($location_value);
			for($i=0;$i<count($location_value);$i++) {
				if ($i % 2 == 0){
					echo '
					<div class="row">';
				}
				echo '
				<div class="large-6 small-6 columns">
					<a href="#" class="small button expand" style="background-color:#'.$colors[$i].'">'.$location_list[$i].'('.$location_value[$i].') '.number_format((($location_value[$i]/$total)*100)).'%</a>
				</div>';
				if ($i % 2 != 0 ){
					echo '
					</div>';
				}
			}
		}
		else {
			echo "No data was found";
		}
			?>
	</div>
</div>
<script src="js/Chart.min.js"></script>
<script>

		var doughnutData = [
				<?php
				for($i=0;$i<count($location_value);$i++) {
					echo "{";
					echo "value: $location_value[$i],";
					echo 'color:"#'.$colors[$i].'"';
					if ($i+1<count($location_value)){
						echo '},';
					}
					else {
						echo '}';
					}
				}?>
			
			];

	var myDoughnut = new Chart(document.getElementById("canvas").getContext("2d")).Doughnut(doughnutData,{animationEasing : "easeOutBounce",animateRotate : true,animateScale : false});
	
	</script>
<?php
require('footer.php');
?>