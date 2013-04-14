<script>
// enable or disable the checkboxes
function changeForm(name){
	var checkboxCO = document.getElementById("chkCO"),
		checkboxO3 = document.getElementById("chkO3"),
		checkboxSO2 = document.getElementById("chkSO2"),
		checkboxPM10 = document.getElementById("chkPM10");
		checkboxNO = document.getElementById("chkNO");
		checkboxNO2 = document.getElementById("chkNO2");
// If Lanuv-station Geist is set, disable CO-Checkbox and enable O3, SO2, PM10 and NO
	if (name == "Geist"){
		checkboxCO.disabled = true;
		checkboxCO.checked = false;
		
		checkboxO3.disabled = false;
		checkboxSO2.disabled = false;
		checkboxPM10.disabled = false;
		checkboxNO.disabled = false;
		<?php 
			if (isset($_POST['observation']) AND isset($_POST['foi'])){
				if ($_POST['foi'] == "Geist"){
					if (in_array('NO_CONCENTRATION', $_POST['observation'])){
						echo 'checkboxNO.checked = true;';
					}
					else {
						echo 'checkboxNO.checked = false;';
					}
					if (in_array('NO2_CONCENTRATION', $_POST['observation'])){
						echo 'checkboxNO2.checked = true;';
					}
					else {
						echo 'checkboxNO2.checked = false;';
					}
					if (in_array('O3_CONCENTRATION', $_POST['observation'])){
						echo 'checkboxO3.checked = true;';
					}
					else {
						echo 'checkboxO3.checked = false;';
					}
					if (isset($_POST['PM10'])){
						if ($_POST['PM10'] == "PM10_CONCENTRATION"){
							echo 'checkboxPM10.checked = true;';
						}
						else {
						echo 'checkboxPM10.checked = false;';
					}
					}
					else {
						echo 'checkboxPM10.checked = false;';
					}
					if (in_array('SO2_CONCENTRATION', $_POST['observation'])){
						echo 'checkboxSO2.checked = true;';
					}
					else {
						echo 'checkboxSO2.checked = false;';
					}
				} else { echo 'checkboxNO.checked = true;
					checkboxNO2.checked = true;
					checkboxO3.checked = true;
					checkboxPM10.checked = true;
					checkboxSO2.checked = true;';
				}	
		}
		else { echo 'checkboxNO.checked = true;
					checkboxNO2.checked = true;
					checkboxO3.checked = true;
					checkboxPM10.checked = true;
					checkboxSO2.checked = true;';
		}
	?>
	}
// If Lanuv-Station Weseler is set, disable CO, O3 and SO2-Checkbox and enable PM10 and NO
	else { if (name == "Weseler") {
		checkboxCO.disabled = true;
		checkboxCO.checked = false;
		checkboxO3.disabled = true;
		checkboxO3.checked = false;
		checkboxSO2.disabled = true;
		checkboxSO2.checked = false;
		
		checkboxPM10.disabled = false;
		checkboxNO.disabled = false;
		<?php 
			if (isset($_POST['observation']) AND isset($_POST['foi'])){
				if ($_POST['foi'] == "Weseler"){
					if (in_array('NO_CONCENTRATION', $_POST['observation'])){
						echo 'checkboxNO.checked = true;';
					}
					else {
						echo 'checkboxNO.checked = false;';
					}
					if (in_array('NO2_CONCENTRATION', $_POST['observation'])){
						echo 'checkboxNO2.checked = true;';
					}
					else {
						echo 'checkboxNO2.checked = false;';
					}
					if (isset($_POST['PM10'])){
						if ($_POST['PM10'] == "PM10_CONCENTRATION"){
							echo 'checkboxPM10.checked = true;';
						}
						else {
						echo 'checkboxPM10.checked = false;';
					}
					}
					else {
						echo 'checkboxPM10.checked = false;';
					}
				} else {'checkboxNO.checked = true;
				checkboxNO2.checked = true;
				checkboxPM10.checked = true;';
				}
			}
		else {
			echo 'checkboxNO.checked = true;
				checkboxNO2.checked = true;
				checkboxPM10.checked = true;';
		}
	?>
		
	}
// else AQE is set
	else {
		checkboxCO.disabled = false;
		checkboxCO.checked = true;
		checkboxO3.disabled = false;
		checkboxO3.checked = true;
		checkboxNO2.checked = true;
		
		checkboxSO2.disabled = true;
		checkboxSO2.checked = false;
		checkboxPM10.disabled = true;
		checkboxPM10.checked = false;
		checkboxNO.disabled = true;
		checkboxNO.checked = false;
		<?php 
		if (isset($_POST['observation']) AND isset($_POST['foi'])){
			if ($_POST['foi'] != "Geist" AND $_POST['foi'] != "Weseler"){
				if (in_array('CO_CONCENTRATION', $_POST['observation'])){
					echo 'checkboxCO.checked = true;';
				}
				else {
					echo 'checkboxCO.checked = false;';
				}
				if (in_array('NO2_CONCENTRATION', $_POST['observation'])){
					echo 'checkboxNO2.checked = true;';
				}
				else {
					echo 'checkboxNO2.checked = false;';
				}
				if (in_array('O3_CONCENTRATION', $_POST['observation'])){
					echo 'checkboxO3.checked = true;';
				}
				else {
					echo 'checkboxO3.checked = false;';
				}
			} else {echo 'checkboxCO.checked = true;
				checkboxNO2.checked = true;
				checkboxO3.checked = true;';
			}
		}
		else {
			echo 'checkboxCO.checked = true;
				checkboxNO2.checked = true;
				checkboxO3.checked = true;';
		}		
		
		?>
	}
	}
}
	</script>