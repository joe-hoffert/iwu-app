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

$page_title = '';
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
		$page_title = 'Meal Swipe History';
		$sql = "SELECT lastUsed, totalMealswipes, location
				FROM Student_Account, Mealswipe_History, Locations
				WHERE Student_Account.StudentID = ".mysql_real_escape_string($idNumber)." AND
				    Student_Account.id = Mealswipe_History.Student_Account_id AND
				    Mealswipe_History.Locations_id = Locations.id 
				ORDER BY lastUsed DESC";
		$Full_list = iwu_getResults($sql, $mysqli);
		
		$loop_total = 'totalMealswipes';
		$loop_cost = 'location';
	}
	else if ($_GET["type"]== "points") {
		//display history for points
		$page_type = "Points";
		$page_title = 'Point History';
		$sql = "SELECT lastUsed, pointsSpent, totalPoints, location
				FROM Student_Account, Point_History, Locations
				WHERE Student_Account.StudentID = ".mysql_real_escape_string($idNumber)." AND
				    Student_Account.id = Point_History.Student_Account_id AND
				    Point_History.Locations_id = Locations.id 
				ORDER BY lastUsed DESC";
		$Full_list = iwu_getResults($sql, $mysqli);
		
		$loop_cost = 'pointsSpent';
		$loop_total = 'totalPoints';
	}
	iwu_stopMysql($mysqli);
	
	//display template page below
	require("header.php");
	
?>
<div class="row">
	<div class="large-5 columns large-centered text-center medium-6 medium-centered last">
		<h4 class="show-for-small"><a href="<?php echo $site_url?>" class="button tiny left">Back</a>Account History<a href="/logout.php" class="button secondary tiny right">Logout</a></h4>
		<h3 class="hide-for-small"><a href="<?php echo $site_url?>" class="button tiny left">Back</a>Account History<a href="/logout.php" class="button secondary tiny right">Logout</a></h3>
		<hr>
		
		<h3><?php echo $userID?></h3>
		<ul class="pricing-table">
		  <li class="title"><?php echo $page_type?></li>
		  <li class="price"><?php
		  if ($page_type == "Points") {
			  echo number_format($Full_list[0][$loop_total], 2, '.', '');
		  }
		  else {
			  echo $Full_list[0][$loop_total];
		  }
		  ?></li>
		  <!--<li class="description">as of [current time]</li>
		  <li class="bullet-item">Last Used: <?php echo $date.' '.$time.' at '.$location;?></li> future feature for mockup purposes-->
		</ul>
		<table>
		  <thead>
		    <tr>
		      <th width="350">Date</th>
		      <th>Location</th>
		      <?php if ($page_type == "Points") {
			      echo '<th width="75" class="text-center">Cost</th>';
		      }?>
		      <th width="75" class="text-center">Total</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php
		  
		  foreach ($Full_list as $list) {
			  echo '<tr>';
			  echo '<td>'.date('F d, Y h:mA', strtotime($list['lastUsed'])).'</td>';
			  echo '<td>'.$list['location'].'</td>';
			  if ($page_type == "Points") {
			      echo '<td>'.number_format($list[$loop_cost], 2, '.', '').'</td>';
			      echo '<td>'.number_format($list[$loop_total], 2, '.', '').'</td>';
		      }
			  else {
				  echo '<td>'.$list[$loop_total].'</td>';
			  }
			  echo '</tr>';
		  }
		  ?>
		  </tbody>
		</table>
	</div>
</div>
<?php


require('footer.php');
?>