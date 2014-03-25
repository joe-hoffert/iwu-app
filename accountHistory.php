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
$home = "http://iwu:8888/";
	if ($_GET["type"]== "mealSwipes") {
		//display history for mealswipes
		$page_type = "Meal Swipes";
		$page_title = 'Meal Swipe History';
		$loop_date = '3/14/14';
		$loop_cost = '1';
		$loop_location = 'Wildcat';
		$loop_other = 34;
	}
	else if ($_GET["type"]== "points") {
		//display history for points
		$page_type = "Points";
		$page_title = 'Point History';
		$loop_date = '3/14/14';
		$loop_cost = '1.00';
		$loop_location = 'Wildcat';
		$loop_other = 34.00;
	}
	
	//display template page below
	
	require("header.php");
	
	$mealSwipes = 34;
	
?>
<div class="row">
	<div class="large-5 columns large-centered text-center medium-6 medium-centered last">
		<h4 class="show-for-small"><a href="<?php echo $home?>" class="button tiny left">Back</a>Account History<a href="/logout.php" class="button secondary tiny right">Logout</a></h4>
		<h3 class="hide-for-small"><a href="<?php echo $home?>" class="button tiny left">Back</a>Account History<a href="/logout.php" class="button secondary tiny right">Logout</a></h3>
		<hr>
		
		<h3><?php echo $userID?></h3>
		<ul class="pricing-table">
		  <li class="title"><?php echo $page_type?></li>
		  <li class="price"><?php echo $mealSwipes?></li>
		  <li class="description">as of [current time]</li>
		  <!--<li class="bullet-item">Last Used: <?php echo $date.' '.$time.' at '.$location;?></li> future feature for mockup purposes-->
		</ul>
		<table>
		  <thead>
		    <tr>
		      <th width="200">Date</th>
		      <th>Cost</th>
		      <th width="150">Location</th>
		      <th width="150">Total</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php
		  
		  for($i=0;$i<30;$i++) {
			  echo '<tr>';
			  echo '<td>'.$loop_date.'</td>';
			  echo '<td>'.$loop_cost.'</td>';
			  echo '<td>'.$loop_location.'</td>';
			  echo '<td>'.($loop_other+$i).'</td>';
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