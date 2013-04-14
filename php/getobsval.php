<?php

/* Create a JSON object with all observation values 
 * Variables:
 * numargs - The Number of arguments (offering id)
 * rows - All Results of the db-query
 * row - one Result of the db-query
 * cols - column-information for the json-object
 * timestamp - Array with all time_stamps
 * ttime - one time_stamp of timestamp
 * i,j,k - index for timestamp, row and rows
 * obs1, obs2, obs3, obs4, obs5 - offering_ids
 * table - the whole json object
*/

include_once 'dbconnector.php';

/* Get the values from the database and put it into a json object */
function getValues(){
	if (isset($_POST['foi']) AND isset($_POST['startdate']) AND isset($_POST['enddate']) AND isset($_POST['outliers'])){
	// If argument is set, use it (temperature or humidity
	$numarg = func_num_args();
	if ($numarg == 1){
		$obs = array(func_get_arg(0));
	} else {
		// else use the observation
		if (isset($_POST['observation'])){
			$obs = $_POST['observation'];
			//If no checkboxes (except: PM10) are checked, obs = 0
		} else { $obs = 0; }
	}
// number of arguments (offering_ids)
$numargs = count($obs);
// rows - temp-array (db-results)
$rows = array();
// cols - column informaton for the json object
$cols = array();
// Get all time_stamps of all observations of one foi between start- and enddate
$timestamp = getTimeStamp($_POST['foi'], $_POST['startdate'], $_POST['enddate']);

if ($_POST['outliers'] == 'yes'){
	
//1, 2, 3, 4 additional parameters?
switch ($numargs) {
	// 1 additional parameter - obs1
	case 1:
		$obs1 = $obs ['0'];
		// Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1);
		// Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1),'type' => 'number'));
		
		// required for $rows - see below
		$j = 0;

		//if available insert the values
		for($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);
			
			if ($j < count($rows)){
				$row = $rows[$j];
// case 1 - all observation values				
					if ($row['time_stamp'] == $ttime['time_stamp']){
						if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
							$temp[] = array('v' => $row['numeric_value']);
						} else {
							$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
						}
						$j++;	
						}
					// row['time_stamp'] != ttime['time_stamp']
					else {
						$temp[] = array('v' => null);
					}
										
				}
				// j >= count($rows)
				else {
					$temp[] = array('v' => null);
				}
			// save the result to $trows and delete $temp
			$trows[] = array('c' => $temp);
			unset($temp);
		
		}
		//to JSON and return $table			
		$table = arrayToJSON($cols, $trows);
		echo $table;
		break;
		
	// 2 additional parameter - obs1, obs2	
	case 2:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];
		//Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2);
		
		//Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1), 'type' => 'number'),
				array('label' => gerColNames($obs2), 'type' => 'number'));
		
		//required for $rows - see below
		$j = 0;
		$k = 0;
		
		//if available insert the values
		for ($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);		
				
			if ($j < count($rows)){
				$row = $rows[$j];
				
// case 2 - obs1						
				if ($row['offering_id'] == $obs1){
					if ($ttime['time_stamp'] == $row['time_stamp']){
						// Calc ppm-Values, if Station is set to Geist or Weseler
						if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
							$temp[] = array('v' => $row['numeric_value']);
						} else {
							$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
							}
							$j++;
						
							if ($j < count($rows)){
								$row = $rows[$j];
							}
						}
						//if ttime ['time_stamp'] != $rowY['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					// If row['offering'] != obs1
					else {
						$temp[] = array('v' => null);
					}
// case 2 - obs2						
				if ($row['offering_id'] == $obs2){
					if ($ttime['time_stamp'] == $row['time_stamp']){
						// Calc ppm-Values, if Station is set to Geist or Weseler
						if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
							$temp[] = array('v' => $row['numeric_value']);
						} else {
							$temp[] = array('v' => calcToPPM($obs2,$row['numeric_value']));
						}
						$j++;
					}
					//if ttime ['time_stamp'] != $row['time_stamp]
					else {
						$temp[] = array('v' => null);
					}
				}
				//If row['offering'] != obs2
				else {
					$temp[] = array('v' => null);
				}
		}
		//if j > count($rows)
		else {
			$temp[] = array('v' => null);
			$temp[] = array('v' => null);
			}
							
			//save the result to $trows and delete $temp
			$trows[] = array('c' => $temp);
			unset($temp);
			}
		//to JSON and return table
		$table = arrayToJSON($cols, $trows);
		echo $table;
		break;

	// 3 additional parameters - obs1, obs2, obs3
	case 3:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];
		$obs3 = $obs['2'];
		//Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2, $obs3);
		//Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1), 'type' => 'number'),
				array('label' => gerColNames($obs2), 'type' => 'number'),
				array('label' => gerColNames($obs3), 'type' => 'number'));
	
		//required for $rows - see below
		$j = 0;
		$k = 0;
		//if available insert the values
		for ($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);
				
			if ($j < count($rows)){
				$row = $rows[$j];
	
//case 3 - obs1
					if ($row['offering_id'] == $obs1 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
							}
							$j++;
	
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
	
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					//If row['offering_id'] != obs1
					else {
						$temp[] = array('v' => null);
					}
//case 3 - obs2
					if ($row['offering_id'] == $obs2 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs2,$row['numeric_value']));
							}
							$j++;
	
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
	
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					//If row['offering_id'] != obs2
					else {
						$temp[] = array('v' => null);
					}
//case 3 - obs3
					if ($row['offering_id'] == $obs3 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs3,$row['numeric_value']));
							}
							$j++;
					}
					//if ttime ['time_stamp'] != $row['time_stamp]
					else {
						$temp[] = array('v' => null);
					}
				}
				//If row['offering'] != obs3
				else {
					$temp[] = array('v' => null);
				}
			}
			//if j > count($rows)
			else {
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
			}
			//save the result to $trows and delete $temp
			$trows[] = array('c' => $temp);
			unset($temp);
		}
	
		//to JSON and return table
		$table = arrayToJSON($cols, $trows);
		echo $table;
		break;
				
	// 4 additional parameters - obs1, obs2, obs3, obs4	
	case 4:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];
		$obs3 = $obs['2'];
		$obs4 = $obs['3'];
		//Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2, $obs3, $obs4);
		//Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1), 'type' => 'number'),
				array('label' => gerColNames($obs2), 'type' => 'number'),
				array('label' => gerColNames($obs3), 'type' => 'number'),
				array('label' => gerColNames($obs4), 'type' => 'number'));

		//required for $rows - see below
		$j = 0;
		//if available insert the values
		for ($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);
			
			if ($j < count($rows)){			
				$row = $rows[$j];
				
//case 4 - obs1			
					if ($row['offering_id'] == $obs1 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
							}
							$j++;
						
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
						
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);	
					}
//case 4 - obs2					
					if ($row['offering_id'] == $obs2 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs2,$row['numeric_value']));
							}
							$j++;
						
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
						
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);
					}
					
//case 4 - obs3
					if ($row['offering_id'] == $obs3 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs3,$row['numeric_value']));
							}
							$j++;
					
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
					
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);
					}					

//case 4 - obs4					
					if ($row['offering_id'] == $obs4 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs4,$row['numeric_value']));
							}
							$j++;
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);
					}	
			}
			//if j > count($rows)			
			else {
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				}
								
			//save the result to $trows and delete $temp					
			$trows[] = array('c' => $temp);
			unset($temp);
			}
			
		//to JSON and return table		
		$table = arrayToJSON($cols, $trows);
		echo $table;		
		break;
	}
}


/* --------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/

if ($_POST['outliers'] == 'no'){

//1, 2, 3, 4 or 5 additional parameters?
switch ($numargs) {
	// 1 additional parameter - obs1
	case 1:
		$obs1 = $obs ['0'];
		// Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1);
		$rowsY = getObservationValuesYes($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1);
		// Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1),'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs1), 'type' => 'number'));
		
		// required for $rows - see below
		$j = 0;
		$k = 0;

		//if available insert the values
		for($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);
			
			if ($j < count($rows)){
				$row = $rows[$j];
// case 1 - all observation values				
					if ($row['time_stamp'] == $ttime['time_stamp']){
						// Calc ppm-Values, if Station is set to Geist or Weseler
						if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
							$temp[] = array('v' => $row['numeric_value']);
						} else {
							$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
						}
						$j++;	
						}
					// row['time_stamp'] != ttime['time_stamp']
					else {
						$temp[] = array('v' => null);
					}
										
				}
				// j >= count($rows)
				else {
					$temp[] = array('v' => null);
				}
				
			if ($k < count($rowsY)){
				$rowY = $rowsY[$k];
// case 1 - outliers only					
					if ($rowY['time_stamp'] == $ttime['time_stamp']){
						// Calc ppm-Values, if Station is set to Geist or Weseler
						if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
							$temp[] = array('v' => $rowY['numeric_value']);
						} else {
							
							$temp[] = array('v' => calcToPPM($obs1,$rowY['numeric_value']));
						}
						$k++;
					}
					// rowY['time_stamp'] != ttime['time_stamp']
					else {
						$temp[] = array('v' => null);
					}
			//j >= count($rows)		
			}
			else {
				$temp[] = array('v' => null);
			}
			// save the result to $trows and delete $temp
			$trows[] = array('c' => $temp);
			unset($temp);
		
		}
		//to JSON and return $table			
		$table = arrayToJSON($cols, $trows);
		echo $table;
		break;
		
	// 2 additional parameter - obs1, obs2	
	case 2:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];
		//Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2);
		$rowsY = getObservationValuesYes($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2);
		
		//Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1), 'type' => 'number'),
				array('label' => gerColNames($obs2), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs1), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs2), 'type' => 'number'));
		
		//required for $rows - see below
		$j = 0;
		$k = 0;
		
		//if available insert the values
		for ($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);		
				
			if ($j < count($rows)){
				$row = $rows[$j];
				
// case 2 - obs1						
				if ($row['offering_id'] == $obs1){
					if ($ttime['time_stamp'] == $row['time_stamp']){
						// Calc ppm-Values, if Station is set to Geist or Weseler
						if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
							$temp[] = array('v' => $row['numeric_value']);
						} else {
							$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
						}
							$j++;
						
							if ($j < count($rows)){
								$row = $rows[$j];
							}
						}
						//if ttime ['time_stamp'] != $rowY['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					// If row['offering'] != obs1
					else {
						$temp[] = array('v' => null);
					}
// case 2 - obs2						
				if ($row['offering_id'] == $obs2){
					if ($ttime['time_stamp'] == $row['time_stamp']){
						// Calc ppm-Values, if Station is set to Geist or Weseler
						if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
							$temp[] = array('v' => $row['numeric_value']);
						} else {
							$temp[] = array('v' => calcToPPM($obs2,$row['numeric_value']));
						}
						$j++;
					}
					//if ttime ['time_stamp'] != $row['time_stamp]
					else {
						$temp[] = array('v' => null);
					}
				}
				//If row['offering'] != obs2
				else {
					$temp[] = array('v' => null);
				}
		}
		//if j > count($rows)
		else {
			$temp[] = array('v' => null);
			$temp[] = array('v' => null);
			}
				
				if ($k < count($rowsY)){
					// Get next row
					$rowY = $rowsY[$k];
						
// case 2 - obs1 (outliers)						
						if ($rowY['offering_id'] == $obs1){
							if ($ttime['time_stamp'] == $rowY['time_stamp']){
								// Calc ppm-Values, if Station is set to Geist or Weseler
								if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
									$temp[] = array('v' => $rowY['numeric_value']);
								} else {
									$temp[] = array('v' => calcToPPM($obs1,$rowY['numeric_value']));
								}
								$k++;
						
								if ($k < count($rowsY)){
									$rowY = $rowsY[$k];
								}
							}
							//if ttime ['time_stamp'] != $rowY['time_stamp]
							else {
								$temp[] = array('v' => null);
							}
						}
						//If rowY['offering_id'] != obs1
						else {
							$temp[] = array('v' => null);
						}
// case 2 - obs2 (outliers)						
						if ($rowY['offering_id'] == $obs2){
							if ($ttime['time_stamp'] == $rowY['time_stamp']){	
								// Calc ppm-Values, if Station is set to Geist or Weseler
								if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
									$temp[] = array('v' => $rowY['numeric_value']);
								} else {
									$temp[] = array('v' => calcToPPM($obs2,$rowY['numeric_value']));
								}
								$k++;
							}
							//if ttime ['time_stamp'] != $rowY['time_stamp]
							else {
								$temp[] = array('v' => null);
							}
						}
						//If rowY['offering_id'] != obs2
						else {
							$temp[] = array('v' => null);
						}
				}
				//if k > count($rows)
				else {
					$temp[] = array('v' => null);
					$temp[] = array('v' => null);
				}
			
			//save the result to $trows and delete $temp
			$trows[] = array('c' => $temp);
			unset($temp);
			}
		//to JSON and return table
		$table = arrayToJSON($cols, $trows);
		echo $table;
		break;

	// 3 additional parameters - obs1, obs2, obs3
	case 3:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];
		$obs3 = $obs['2'];
		//Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2, $obs3);
		$rowsY = getObservationValuesYes($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2, $obs3);
		//Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1), 'type' => 'number'),
				array('label' => gerColNames($obs2), 'type' => 'number'),
				array('label' => gerColNames($obs3), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs1), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs2), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs3), 'type' => 'number'));
	
		//required for $rows - see below
		$j = 0;
		$k = 0;
		//if available insert the values
		for ($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);
				
			if ($j < count($rows)){
				$row = $rows[$j];
	
//case 3 - obs1
					if ($row['offering_id'] == $obs1 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
							}
							$j++;
	
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
	
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					//If row['offering_id'] != obs1
					else {
						$temp[] = array('v' => null);
					}
//case 3 - obs2
					if ($row['offering_id'] == $obs2 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs2,$row['numeric_value']));
							}
							$j++;
	
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
	
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					//If row['offering_id'] != obs2
					else {
						$temp[] = array('v' => null);
					}
//case 3 - obs3
					if ($row['offering_id'] == $obs3 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs3,$row['numeric_value']));
							}
							$j++;
					}
					//if ttime ['time_stamp'] != $row['time_stamp]
					else {
						$temp[] = array('v' => null);
					}
				}
				//If row['offering'] != obs3
				else {
					$temp[] = array('v' => null);
				}
			}
			//if j > count($rows)
			else {
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
			}
	
			if ($k < count($rowsY)){
				$rowY = $rowsY[$k];
	
//case 3 - obs1 (outliers)
					if ($rowY['offering_id'] == $obs1){
						if ($rowY['time_stamp'] == $ttime['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $rowY['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs1,$rowY['numeric_value']));
							}
							$k++;
	
							if ($k < count($rowsY)){
								// Get next row
								$rowY = $rowsY[$k];
							}
	
						}
						//if ttime ['time_stamp'] != $rowY['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					//If rowY['offering_id'] != obs1
					else {
						$temp[] = array('v' => null);
					}
					
//case 3 - obs2 (outliers)
					if ($rowY['offering_id'] == $obs2){
						if ($rowY['time_stamp'] == $ttime['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $rowY['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs2,$rowY['numeric_value']));
							}
							$k++;
	
							if ($k < count($rowsY)){
								// Get next row
								$rowY = $rowsY[$k];
							}
	
						}
						//if ttime ['time_stamp'] != $rowY['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					//If rowY['offering_id'] != obs2
					else {
						$temp[] = array('v' => null);
					}
					
//case 3 - obs3 (outliers)
					if ($rowY['offering_id'] == $obs3){
						if ($rowY['time_stamp'] == $ttime['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $rowY['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs3,$rowY['numeric_value']));
							}
							$k++;
	
						}
						//if ttime ['time_stamp'] != $rowY['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					//If rowY['offering_id'] != obs3
					else {
						$temp[] = array('v' => null);
					}
			}
			//if k > count($rows)
			else {
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
			}
	
			//save the result to $trows and delete $temp
			$trows[] = array('c' => $temp);
			unset($temp);
		}
	
		//to JSON and return table
		$table = arrayToJSON($cols, $trows);
		echo $table;
		break;
				
	// 4 additional parameters - obs1, obs2, obs3, obs4	
	case 4:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];
		$obs3 = $obs['2'];
		$obs4 = $obs['3'];
		//Get the observation values
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2, $obs3, $obs4);
		$rowsY = getObservationValuesYes($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2, $obs3, $obs4);
		//Set the columns
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => gerColNames($obs1), 'type' => 'number'),
				array('label' => gerColNames($obs2), 'type' => 'number'),
				array('label' => gerColNames($obs3), 'type' => 'number'),
				array('label' => gerColNames($obs4), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs1), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs2), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs3), 'type' => 'number'),
				array('label' => 'Ausreisser_'.shortOffName($obs4), 'type' => 'number'));

		//required for $rows - see below
		$j = 0;
		$k = 0;
		//if available insert the values
		for ($i = 0; $i < count($timestamp); $i++){
			$ttime = $timestamp[$i];
			$temp = array();
			$temp[] = array('v' => $ttime['time_stamp']);
			
			if ($j < count($rows)){			
				$row = $rows[$j];
				
//case 4 - obs1			
					if ($row['offering_id'] == $obs1 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs1,$row['numeric_value']));
							}
							$j++;
						
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
						
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);	
					}
//case 4 - obs2					
					if ($row['offering_id'] == $obs2 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs2,$row['numeric_value']));
							}	
							$j++;
						
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
						
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);
					}
					
//case 4 - obs3
					if ($row['offering_id'] == $obs3 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs3,$row['numeric_value']));
							}
							$j++;
					
							if ($j < count($rows)){
								// Get next row
								$row = $rows[$j];
							}
					
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);
					}					

//case 4 - obs4					
					if ($row['offering_id'] == $obs4 ){
						if ($ttime['time_stamp'] == $row['time_stamp']){
							// Calc ppm-Values, if Station is set to Geist or Weseler
							if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
								$temp[] = array('v' => $row['numeric_value']);
							} else {
								$temp[] = array('v' => calcToPPM($obs4,$row['numeric_value']));
							}
							$j++;
						}
						//if ttime ['time_stamp'] != $row['time_stamp]
						else {
							$temp[] = array('v' => null);
						}
					}
					else {
						$temp[] = array('v' => null);
					}	
			}
			//if j > count($rows)			
			else {
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				$temp[] = array('v' => null);
				}
				
				if ($k < count($rowsY)){
					$rowY = $rowsY[$k];
				
//case 4 - obs1 (outliers)
						if ($rowY['offering_id'] == $obs1){
							if ($rowY['time_stamp'] == $ttime['time_stamp']){
								// Calc ppm-Values, if Station is set to Geist or Weseler
								if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
									$temp[] = array('v' => $rowY['numeric_value']);
								} else {
									$temp[] = array('v' => calcToPPM($obs1,$rowY['numeric_value']));
								}
								$k++;
							
								if ($k < count($rowsY)){
									$rowY = $rowsY[$k];
								}
							
							}
							//if ttime ['time_stamp'] != $rowY['time_stamp]
							else {
								$temp[] = array('v' => null);
							}
						}
						else {
							$temp[] = array('v' => null);
						}
//case 4 - obs2 (outliers)						
						if ($rowY['offering_id'] == $obs2){
							if ($rowY['time_stamp'] == $ttime['time_stamp']){
								// Calc ppm-Values, if Station is set to Geist or Weseler
								if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
									$temp[] = array('v' => $rowY['numeric_value']);
								} else {
									$temp[] = array('v' => calcToPPM($obs2,$rowY['numeric_value']));
								}
								$k++;
							
								if ($k < count($rowsY)){
									$rowY = $rowsY[$k];
								}
							
							}
							else {
								//if ttime ['time_stamp'] != $rowY['time_stamp]
								$temp[] = array('v' => null);
							}
						}
						else {
							$temp[] = array('v' => null);
						}
						
//case 4 - obs3 (outliers)
						if ($rowY['offering_id'] == $obs3){
							if ($rowY['time_stamp'] == $ttime['time_stamp']){
								// Calc ppm-Values, if Station is set to Geist or Weseler
								if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
									$temp[] = array('v' => $rowY['numeric_value']);
								} else {
									$temp[] = array('v' => calcToPPM($obs3,$rowY['numeric_value']));
								}
								$k++;
								
								if ($k < count($rowsY)){
									$rowY = $rowsY[$k];
								}
								
							}
							else {
								//if ttime ['time_stamp'] != $rowY['time_stamp]
								$temp[] = array('v' => null);
							}
						}
						else {
							$temp[] = array('v' => null);
						}
						
						
//case 4 - obs4 (outliers)						
						if ($rowY['offering_id'] == $obs4){
							if ($rowY['time_stamp'] == $ttime['time_stamp']){
								// Calc ppm-Values, if Station is set to Geist or Weseler
								if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
									$temp[] = array('v' => $rowY['numeric_value']);
								} else {
									$temp[] = array('v' => calcToPPM($obs4,$rowY['numeric_value']));
								}
								$k++;
							
								if ($k < count($rowsY)){
									$rowY = $rowsY[$k];
								}
							
							}
							else {
								//if ttime ['time_stamp'] != $rowY['time_stamp]
								$temp[] = array('v' => null);
							}
						
						}
						else {
							$temp[] = array('v' => null);
						}
				}
				//if k > count($rows)
				else {
					$temp[] = array('v' => null);
					$temp[] = array('v' => null);
					$temp[] = array('v' => null);
					$temp[] = array('v' => null);
				}
				
			//save the result to $trows and delete $temp					
			$trows[] = array('c' => $temp);
			unset($temp);
			}
			
		//to JSON and return table		
		$table = arrayToJSON($cols, $trows);
		echo $table;		
		break;
	}
		
		
	}
// unset all vars
unset($cols);
unset($rows);
unset($table);
unset($row);
unset($trows);
unset($timestamp);
unset($ttime);
unset($obs);
unset($outliers);
unset($j);
unset($k);
	}
	else {
		// "" if no offering_ids are chosen
	echo '""';
	}
}


/* returns the german column name */
function gerColNames($offering){
	switch ($offering){
		case "CO_CONCENTRATION":
			return "Kohlenstoffmonoxid (CO)";
			break;
				
		case "NO_CONCENTRATION":
			return "Stickstoffmonoxid (NO)";
			break;

		case "NO2_CONCENTRATION":
			return "Stickstoffdioxid (NO2)";
			break;

		case "O3_CONCENTRATION":
			return "Ozon (O3)";
			break;

		case "PM10_CONCENTRATION":
			return "Feinstaub (PM10)";
			break;

		case "SO2_CONCENTRATION":
			return "Schwefeldioxid (SO2)";
			break;

		case "TEMPERATURE":
			return "Temperatur";
			break;
				
		case "AIR_HUMIDITY":
			return "rel. Luftfeuchtigkeit";
			break;
	}
}

/* returns the shortcut of the offering */
function shortOffName($offering){
	switch($offering){
		case "CO_CONCENTRATION":
			return "CO";
			break;
			
		case "NO_CONCENTRATION":
			return "NO";
			break;
			
		case "NO2_CONCENTRATION":
			return "NO2";
			break;
			
		case "O3_CONCENTRATION":
			return "O3";
			break;
			
		case "PM10_CONCENTRATION":
			return "PM10";
			break;
			
		case "SO2_CONCENTRATION":
			return "SO2";
			break;
			
		case "TEMPERATURE":
			return "Temp.";
			break;
			
		case "AIR_HUMIDITY":
			return "rel. Luftfeucht.";
			break;
	}
	
}

function getSeriesOptions(){
	if (isset($_POST['observation']) AND (isset($_POST['outliers']))){
		if ($_POST['outliers'] == 'yes'){
			echo '""';
		} else {
			$numoff = count($_POST['observation']);

			switch($numoff){
				case 1:
					echo 'series: {1: {color:"red", lineWidth: 0, pointSize: 4}}';
					break;
						
				case 2:
					echo 'series: {2: {color:"red", lineWidth: 0, pointSize: 4}, {3:{color:"red", lineWidth: 0, pointSize: 4}}';
					break;
			}
		}
	} else {
		echo '""';
	}
}

/* Calculate the Lanuv-Values to ppm *
 */
function calcToPPM($offering_id,$value){
	switch($offering_id){
		case "NO_CONCENTRATION":
			return $result = ($value / 1.23);
			break;
			
		case "NO2_CONCENTRATION":
			return $result = ($value * 0.000532);
			break;
			
		case "O3_CONCENTRATION":
			return $result = ($value / 500);
			break;
			
		case "SO2_CONCENTRATION":
			return $result = ($value * 2.86);
			break;
			
			// don't calc, just show the value! <-- no ppm-calc!!
		case "PM10_CONCENTRATION":
			return $value;
			break;
		
	}
}

?>