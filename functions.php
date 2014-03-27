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
function iwu_startMysql() {
	require("config.php");
	$mysqli = new mysqli($sql_host, $sql_username, $sql_password, $sql_database);
	
	/* check connection */
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	return $mysqli;
}

function iwu_stopMysql($mysqli) {
	mysqli_close($mysqli);
}

function iwu_getRow($query, $mysqli) {
	$result = $mysqli->query($query);
	if ($result != '') {
		$row = mysqli_fetch_assoc($result);
		$result->close();
	}
	else {
		$row = false;
	}
	return $row;
}

function iwu_getResults($query, $mysqli) {
	$result = $mysqli->query($query);
	$sendList = array();
	while($row = mysqli_fetch_array($result)) {
		array_push($sendList, $row );
	}
	$result->close();
	return $sendList;
}

?>