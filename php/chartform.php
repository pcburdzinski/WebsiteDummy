<?php 
/* CHART MODE */

require_once ('dbconnector.php');

/* Creates a option list with all fois */
function createOptionList(){
	echo '<select id = "foi"
			name = "foi" onchange ="changeForm(this.value)">';
	$rows = getFoi();
	for ($i = 0; $i < count($rows); $i++){
		$row = $rows[$i];
		if (!isset($_POST['foi'])){
			echo '<option value = "'.$row['feature_of_interest_id'].'">'.$row['feature_of_interest_name'].'</option>';
		}
		else {
			if($_POST['foi'] == $row['feature_of_interest_id']){
				echo '<option value = "'.$row['feature_of_interest_id'].'" selected = "selected">'.$row['feature_of_interest_name'].'</option>';
			}
			else {
				echo '<option value = "'.$row['feature_of_interest_id'].'">'.$row['feature_of_interest_name'].'</option>';
			}
		}
	}
	echo'</select>';
}

/* Creates two Radio Buttons */
function createRadioButtons(){
	if(isset($_POST['outliers'])){
		if($_POST['outliers'] == "yes"){
			echo '<input type="radio" name="outliers" value="yes" checked> unbereinigte Werte</input>
										<input type="radio" name="outliers" value="no"> bereinigte Werte</input>';
		}
		else {
			echo '<input type="radio" name="outliers" value="yes"> unbereinigte Werte</input>
									<input type="radio" name="outliers" value="no" checked> bereinigte Werte</input>';
		}
	}
	else {
		echo '<input type="radio" name="outliers" value="yes" checked> unbereinigte Werte</input>
									<input type="radio" name="outliers" value="no"> bereinigte Werte</input>';
	}
	
}

/* Creates checkboxes */
function createCheckboxes(){
	echo' 				<input type = "checkbox"
							id = "chkCO"
							value = "CO_CONCENTRATION"
							name = "observation[]"';
							 	  if (isset($_POST['observation'])){
							 			if (in_array("CO_CONCENTRATION", $_POST['observation'])){
											echo 'checked ="checked"';
										}
									}
									if (isset($_POST['foi'])){
										if (($_POST['foi'] == "Geist") OR ($_POST['foi'] == "Weseler")){
											echo 'disabled';
										}
									}
	echo						'/>
						<label for = "chkCO">CO</label>

						<input type = "checkbox"
							id="chkNO"
							value = "NO_CONCENTRATION"
							name= "observation[]"';
							  		if (isset($_POST['observation'])){
							 			if (in_array("NO_CONCENTRATION", $_POST['observation'])){
											echo 'checked ="checked"';
											}
							 		}
									if (isset($_POST['foi'])){
										if (($_POST['foi'] != "Geist") OR ($_POST['foi'] != "Weseler")){
											echo 'disabled';
										}
									}						
	echo						'/>
						<label for = "chkNO">NO</label>
						
						<input type = "checkbox"
							id = "chkNO2"
							value = "NO2_CONCENTRATION"
							name = "observation[]"';
							 		if (isset($_POST['observation'])){
							 			if (in_array("NO2_CONCENTRATION", $_POST['observation'])){
											echo 'checked ="checked"';
										}
									}							
	echo						'/>
						<label for = "chkNO2">NO2</label>
						
						<input type = "checkbox"
							id = "chkO3"
							value = "O3_CONCENTRATION"
							name = "observation[]"';
							 		if (isset($_POST['observation'])){
							 			if (in_array("O3_CONCENTRATION", $_POST['observation'])){
											echo 'checked ="checked"';
										}
									}						
	echo						'/>
						<label for = "chkO3">O3</label>

						<input type = "checkbox"
							id = "chkPM10"
							value = "PM10_CONCENTRATION"
							name = "observation[]"';
							 		if (isset($_POST['observation'])){
							 			if (in_array("PM10_CONCENTRATION", $_POST['observation'])){
											echo 'checked ="checked"';
										}
									}								
									if (isset($_POST['foi'])){
										if (($_POST['foi'] != "Geist") OR ($_POST['foi'] != "Weseler")){
											echo 'disabled';
										}
									}							
	echo							'/>
						<label for = "chkPM10">PM10</label>	
						
						<input type = "checkbox"
							id = "chkSO2"
							value = "SO2_CONCENTRATION"
							name = "observation[]"';
							 		if (isset($_POST['observation'])){
							 			if (in_array("SO2_CONCENTRATION", $_POST['observation'])){
											echo 'checked ="checked"';
										}
									}
									if (isset($_POST['foi'])){
										if (($_POST['foi'] != "Geist") OR ($_POST['foi'] != "Weseler")){
											echo 'disabled';
										}
									}						
	echo						'/>
						<label for = "chkSO2">SO2</label>';

}

?>