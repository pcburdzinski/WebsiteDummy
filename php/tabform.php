<?php 
/* CHART MODE */

require_once ('dbconnector.php');

/* Creates a option list with all fois */
function createOptionList(){
	echo '<select id = "foi"
			name = "foi">';
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
	if(isset($_POST['Ausreisser'])){
		if($_POST['Ausreisser'] == "unbereinigt"){
			echo '<input type="radio" name="Ausreisser" value="unbereinigt" checked> unbereinigte Werte</input>
										<input type="radio" name="Ausreisser" value="bereinigt"> bereinigte Werte</input>';
		}
		else {
			echo '<input type="radio" name="Ausreisser" value="unbereinigt"> unbereinigte Werte</input>
									<input type="radio" name="Ausreisser" value="bereinigt" checked> bereinigte Werte</input>';
		}
	}
	else {
		echo '<input type="radio" name="Ausreisser" value="unbereinigt" checked> unbereinigte Werte</input>
									<input type="radio" name="Ausreisser" value="bereinigt"> bereinigte Werte</input>';
	}
	
}

?>