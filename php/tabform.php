<?php 

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
?>