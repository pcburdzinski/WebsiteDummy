<?php 
include 'tabform.php'
?>

<!DOCTYPE HTML>
<head>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="https://www.google.com/jsapi"></script>
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script src="../js/ger_dpicker.js"></script>
	<link rel="shortcut icon" href="../images/egg_v1.png">
	<link rel="stylesheet" type="text/css" href="../css/styles.css" />
 
 
	<script>
// ----------------------------------- DATEPICKER -----------------------------------
 // Create the datepickers
$(function() {
	// Settings for both datepickers
	<?php date_default_timezone_set('Europe/Berlin');?>
	$( "#datepicker" ).datepicker( {required: true, 
									dpDate: true,
									maxDate: new Date ( (new Date()).getTime()), 
									onClose: chkdates,
									dateFormat: 'yy-mm-dd' });
	$( "#datepicker2" ).datepicker( {required: true,
									dpDate: true, 
									maxDate: new Date ( (new Date()).getTime()),
									onClose: chkdates,
									dateFormat: 'yy-mm-dd' });

// If start- and enddate were set, get the dates and show it. If not: date = today
	var startdate = "<?php 
		if (isset($_POST['startdate']))
			{echo  $_POST['startdate'];} 
		else {echo date("Y-m-d",time());} ?>";

	var enddate = "<?php   
		if (isset($_POST['enddate']))
			{echo $_POST['enddate'];} 
		else {echo date("Y-m-d",time());}?>";
// set the dates		
		$ ( "#datepicker").datepicker('setDate', startdate);
	
		$ ( "#datepicker2").datepicker('setDate', enddate);

//check the dates
		function chkdates(){
			var dateStart = $("#datepicker").datepicker("getDate");
			var dateEnd = $("#datepicker2").datepicker("getDate");
			var submit = document.getElementById("submit");
			// miliseconds
			var difference = (dateEnd - dateStart) / (86400 * 1000 *7);

// startdate > enddate
			if (difference < 0){
				alert("Das Anfangsdatum muss vor dem Enddatum liegen!");
				submit.disabled = true;
			}
// enddate - startdate > 7 days
			if (difference > 1){
				alert("Der Zeitraum darf maximal 7 Tage betragen!");
				submit.disabled = true;
			}
			if (difference >= 0 && difference <= 1){
				submit.disabled = false;
			}
		}	
}
)
;
	</script> 
</head>
<body>
	<div id="wrapper">
		<div id="headerwrap">
			<div id="header">
				<img class="logo" src="../images/egg_logo.png" width=70 height=55 align="left">
				<p>SkyEagle<p>
			</div>
        </div>
		<div id="navigationwrap">
            <ul id="menu-bar">
				<li><a href="Home.php">Home</a></li>
				<li><a href="Karte.php">Karte</a></li>
				<li><a href="Diagramme.php">Diagramme</a></li>
				<li class="current"><a href="Tabelle.php">Tabelle</a></li>
				<li><a href="SOS.php">SOS</a></li>
				<li><a href="Hilfe.php">Hilfe & FAQ</a></li>
				<li><a href="Impressum.php">Impressum</a></li>
				<li><a href="../mobile/homemobile.php">Mobile Ansicht</a></li>
			</ul>
		</div>
		<div id="contentwrap">
			<div id="content">
				<form action = "#" method ="post" name="form">
					<fieldset>
						<legend>Bitte w&auml;hlen Sie eine Messstation:</legend>
						<p>
							<label>Messstation</label>
							<?php
								createOptionList();
							?>
						</p>
					</fieldset>
					<fieldset>
						<legend>Bitte w&auml;hlen Sie ein Zeitintervall:</legend>
						<p>
							<label for = "datepicker">von:</label>
							<input type = "text" 
								id="datepicker"
								name = "startdate"
							/>	
							<label for = "datepicker2">bis:</label>
							<input type = "text"
								id="datepicker2"
								name = "enddate"
							/>	
						</p>
					</fieldset>
					<fieldset>
						<legend>Bitte w&auml;hlen Sie, ob in der Tabelle potentielle Ausrei&szlig;er markiert werden sollen:<br><br>
						<p>Rot markierte Werte sind potentielle Ausrei&szlig;er, die m&ouml;glicherweise durch Messfehler zu Stande gekommen sind.<br><br>
						Blau markierte Werte wurden noch nicht getestet.</p></legend>
						<p>
							<input type = "radio"
								name = "Ausreisser"
								value = "Unbereinigt"
								checked = 'checked'
							/>
							unbereinigte Werte
							<input type = "radio"
								name = "Ausreisser"
								value = "Bereinigt"
							/>
							bereinigte Werte
						</p>
					</fieldset>
					<fieldset>
						<p>
						<input class = "searchButton" type = "submit" value = "Tabelle anzeigen"/>
						</p>
					</fieldset>
				</form>
				<table border="0" cellspacing="10" cellpadding="0">
					<?php
						ini_set( "display_errors", 0);
						include_once 'dbconnector.php';
						
						/* Part for the checked and unchecked table. It will be checked if a feature of interest, a start date, an end date and a
							radio button is chosen */
							
						if (isset($_POST['foi']) AND isset($_POST['startdate']) AND isset($_POST['enddate']) AND isset($_POST["Ausreisser"])){
							$selected_radio = $_POST['Ausreisser'];
							
								
							/* Part for the table without outlier detection. At first a few variables are defined and set to values from the database:
								$start: the chosen start date
								$end: the chosen end date
								$foi: the chosen measuring station */
							
							if ($selected_radio == 'Unbereinigt'){
								$start = $_POST['startdate'];
								$end = $_POST['enddate'];
								$foi = $_POST['foi'];
								$num = getTableNumRows($foi,$start,$end);			// variable to get the exact table size
								$result1 = getTableTimeStamp($foi,$start,$end);
								
								
								/* Exclude some combinations, because some measuring values are only limited to some measuring stations. 
									SO2 for example is only available at the Lanuv station 'Geist' */
									
								if ($foi != 'Weseler' AND $foi != 'Geist'){$result2 = getTableOffering($foi,$start,$end, 'TEMPERATURE');}
								if ($foi != 'Weseler' AND $foi != 'Geist'){$result3 = getTableOffering($foi,$start,$end, 'AIR_HUMIDITY');}
								if ($foi != 'Weseler' AND $foi != 'Geist'){$result4 = getTableOffering($foi,$start,$end, 'CO_CONCENTRATION');}
								$result5 = getTableOffering($foi,$start,$end, 'NO2_CONCENTRATION');
								if ($foi != 'Weseler'){$result6 = getTableOffering($foi,$start,$end, 'O3_CONCENTRATION');}
								if ($foi == 'Weseler' OR $foi == 'Geist'){$result7 = getTableOffering($foi,$start,$end, 'NO_CONCENTRATION');}
								if ($foi == 'Geist'){$result8 = getTableOffering($foi,$start,$end, 'SO2_CONCENTRATION');}
								if ($foi == 'Weseler' OR $foi == 'Geist'){$result9 = getTableOffering($foi,$start,$end, 'PM10_CONCENTRATION');}
								
								/* Table for the Air Quality Eggs */
								
								if ($foi != 'Weseler' AND $foi != 'Geist'){	
					?>
					<tr>
						<th>Zeit</th>
						<th>Temperatur in &deg;C</th>
						<th>Luftfeuchte in %</th>
						<th>CO in ppm</th>
						<th>NO2 in ppm</th>
						<th>O3 in ppm</th>
					</tr>
					<?php
					
					/* The data is read line by line and is written to the created table.
						It is possible, that some values are missing at some stations. Therefore it is checked, if the actual time stamp is
						equal to the time stamp of the actual measuring value. This is the reason why there are 'offS...' variables. 
						They are used as a counter for the measurement parameters. 
						To avoid that some values are bypassed or shifted, the actual $i value is subtracted from the value of the counter.
						In this way the time_stamp query is always in the right line.
						If there is no value a "-" is written in the table. */
						
											
									$i = 0;
									$offStemp = 0;
									$offShum = 0;
									$offSco = 0;
									$offSno2 = 0;
									$offSo3 = 0;
									while($i < $num){
										$time_stamp=pg_result($result1,$i,"time_stamp");
										if (pg_result($result2,$i-$offStemp,"time_stamp") == $time_stamp) {$temperature = pg_result($result2,$i-$offStemp,"numeric_value");}
											else {$temperature = "-"; $offStemp++;}
										if (pg_result($result3,$i-$offShum,"time_stamp") == $time_stamp) {$humidity = pg_result($result3,$i-$offShum,"numeric_value");}
											else {$humidity = "-"; $offShum++;}
										if (pg_result($result4,$i-$offSco,"time_stamp") == $time_stamp) {$co = pg_result($result4,$i-$offSco,"numeric_value");}
											else {$co = "-"; $offSco++;}
										if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value");}
											else {$no2 = "-"; $offSno2++;}
										if (pg_result($result6,$i-$offSo3,"time_stamp") == $time_stamp) {$o3 = pg_result($result6,$i-$offSo3,"numeric_value");}
											else {$o3 = "-"; $offSo3++;}
					?>
					
					<tr>
						<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
						<td><?php echo $temperature; ?></td>
						<td><?php echo $humidity; ?></td>
						<td><?php echo $co; ?></td>
						<td><?php echo $no2; ?></td>
						<td><?php echo $o3; ?></td>
					</tr>
					
					<?php
							$i++;
									}
								}

						/* Part analog for the Lanuv-station at the Weseler Straße.
							This station measures NO, NO2 and PM10. Therefore it needs an own table. */
							
									if ($foi == 'Weseler'){
					?>
					
					<tr>
						<th>Zeit</th>
						<th>NO in ppm</th>
						<th>NO2 in ppm</th>
						<th>PM10 in &micro;g/m&sup3;</th>
					</tr>
					
					<?php
									$i = 0;
									$offSno = 0;
									$offSno2 = 0;
									$offSpm10 = 0;
									while($i < $num){
										$time_stamp = pg_result($result1,$i,"time_stamp");
										if (pg_result($result7,$i-$offSno,"time_stamp") == $time_stamp) {$no = pg_result($result7,$i-$offSno,"numeric_value"); $no = round(($no / 1.23),4);}
											else {$no = "-"; $offSno++;}
										if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value"); $no2 = round(($no2 * 0.000532),4);}
											else {$no2 = "-"; $offSno2++;}
										if (pg_result($result9,$i-$offSpm10,"time_stamp") == $time_stamp) {$pm10 = pg_result($result9,$i-$offSpm10,"numeric_value"); $pm10 = round($pm10,4);}
											else {$pm10 = "-"; $offSpm10++;}
					?>
					
					<tr>
						<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
						<td><?php echo $no; ?></td>
						<td><?php echo $no2; ?></td>
						<td><?php echo $pm10; ?></td>
					</tr>
					
					<?php
									$i++;
									}
								}
								
						/* Part analog for the Lanuv-station in the 'Geistviertel'.
							This station measures NO, NO2, SO2, O3 and PM10. Therefore it needs an own table. */
							
									if ($foi == 'Geist'){
					?>
					
					<tr>
						<th>Zeit</th>
						<th>NO in ppm</th>
						<th>NO2 in ppm</th>
						<th>PM10 in &micro;g/m&sup3;</th>
						<th>SO2 in ppm</th>
						<th>O3 in ppm</th>
					</tr>
					
					<?php
									$i = 0;
									$offSno = 0;
									$offSno2 = 0;
									$offSpm10 = 0;
									$offSso2 = 0;
									$offSo3 = 0;
									while($i < $num){
										$time_stamp = pg_result($result1,$i,"time_stamp");
										if (pg_result($result7,$i-$offSno,"time_stamp") == $time_stamp) {$no = pg_result($result7,$i-$offSno,"numeric_value"); $no = round(($no / 1.23),4);}
											else {$no = "-"; $offSno++;}
										if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value"); $no2 = round(($no2 * 0.000532),4);}
											else {$no2 = "-"; $offSno2++;}
										if (pg_result($result9,$i-$offSpm10,"time_stamp") == $time_stamp) {$pm10 = pg_result($result9,$i-$offSpm10,"numeric_value"); $pm10 = round($pm10,4);}
											else {$pm10 = "-"; $offSpm10++;}
										if (pg_result($result8,$i-$offSso2,"time_stamp") == $time_stamp) {$so2 = pg_result($result8,$i-$offSso2,"numeric_value"); $so2 = round(($so2 / 2.86),4);}
											else {$so2 = "-"; $offSso2++;}
										if (pg_result($result6,$i-$offSo3,"time_stamp") == $time_stamp) {$o3 = pg_result($result6,$i-$offSo3,"numeric_value"); $o3 = round(($o3 * 2 / 1000),4);}
											else {$o3 = "-"; $offSo3++;}
					?>
					
					<tr>
						<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
						<td><?php echo $no; ?></td>
						<td><?php echo $no2; ?></td>
						<td><?php echo $pm10; ?></td>
						<td><?php echo $so2; ?></td>
						<td><?php echo $o3; ?></td>
					</tr>
					
					<?php
									$i++;
									}
									}
							}
							
						/* This part is for the table with outlier detection, if the radio button "bereinigt" is picked.
							Basically it is the same approach as above, but different functions are used to identify the outliers
							in the database. */
						
							if ($selected_radio == 'Bereinigt'){
								$start = $_POST['startdate'];
								$end = $_POST['enddate'];
								$foi = $_POST['foi'];
								$num = getTableBerNumRows($foi,$start,$end);
								$result1 = getTableBerTimeStamp($foi,$start,$end);
								if ($foi != 'Weseler' AND $foi != 'Geist'){$result2 = getTableBerOffering($foi,$start,$end, 'TEMPERATURE');}
								if ($foi != 'Weseler' AND $foi != 'Geist'){$result3 = getTableBerOffering($foi,$start,$end, 'AIR_HUMIDITY');}
								if ($foi != 'Weseler' AND $foi != 'Geist'){$result4 = getTableBerOffering($foi,$start,$end, 'CO_CONCENTRATION');}
								$result5 = getTableBerOffering($foi,$start,$end, 'NO2_CONCENTRATION');
								if ($foi != 'Weseler'){$result6 = getTableBerOffering($foi,$start,$end, 'O3_CONCENTRATION');}
								if ($foi == 'Weseler' OR $foi == 'Geist'){$result7 = getTableLanuvBerOffering($foi,$start,$end, 'NO_CONCENTRATION');}
								if ($foi == 'Geist'){$result8 = getTableLanuvBerOffering($foi,$start,$end, 'SO2_CONCENTRATION');}
								if ($foi == 'Weseler' OR $foi == 'Geist'){$result9 = getTableLanuvBerOffering($foi,$start,$end, 'PM10_CONCENTRATION');}
								
								if ($foi != 'Weseler' AND $foi != 'Geist'){
					?>
					<tr>
						<th>Zeit</th>
						<th>Temperatur in &deg;C</th>
						<th>Luftfeuchte in %</th>
						<th>CO in ppm</th>
						<th>NO2 in ppm</th>
						<th>O3 in ppm</th>
					</tr>
					<?php
					

						/* Additional checks are needed, because we need to know whether the value is an outlier or it is simply not tested yet.
							Outlier are marked red in the table, not tested values blue. */
							
									$i = 0;
									$offStemp = 0;
									$offShum = 0;
									$offSco = 0;
									$offSno2 = 0;
									$offSo3 = 0;
									while($i < $num){
										$time_stamp = pg_result($result1,$i,"time_stamp");
										if (pg_result($result2,$i-$offStemp,"time_stamp") == $time_stamp) {$temperature = pg_result($result2,$i-$offStemp,"numeric_value");
											$tempout = pg_result($result2,$i-$offStemp,"quality_value");}
												else {$temperature = "-"; $tempout = 'no'; $offStemp++;}
										if (pg_result($result3,$i-$offShum,"time_stamp") == $time_stamp) {$humidity = pg_result($result3,$i-$offShum,"numeric_value");
											$humout = pg_result($result3,$i-$offShum,"quality_value");}
												else {$humidity = "-"; $humout = 'no'; $offShum++;}
										if (pg_result($result4,$i-$offSco,"time_stamp") == $time_stamp) {$co = pg_result($result4,$i-$offSco,"numeric_value");
											$coout = pg_result($result4,$i-$offSco,"quality_value");}
												else {$co = "-"; $coout = 'no'; $offSco++;}
										if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value");
											$no2out = pg_result($result5,$i-$offSno2,"quality_value");}
												else {$no2 = "-"; $no2out = 'no'; $offSno2++;}
										if (pg_result($result6,$i-$offSo3,"time_stamp") == $time_stamp) {$o3 = pg_result($result6,$i-$offSo3,"numeric_value");
											$o3out = pg_result($result6,$i-$offSo3,"quality_value");}
												else {$o3 = "-"; $o3out = 'no'; $offSo3++;}
					?>
					<tr>
						<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
						<td><?php if ($tempout == 'no') echo $temperature;
									elseif ($tempout == 'yes') echo '<span style="color:#FF0000">'.$temperature.'</span>';
										else echo '<span style="color:#0000CC">'.$temperature.'</span>'?></td>
						<td><?php if ($humout == 'no') echo $humidity; 
									elseif ($humout == 'yes') echo '<span style="color:#FF0000">'.$humidity.'</span>';
										else echo '<span style="color:#0000CC">'.$humidity.'</span>'?></td>
						<td><?php if ($coout == 'no') echo $co;
									elseif ($coout == 'yes') echo '<span style="color:#FF0000">'.$co.'</span>';
										else echo '<span style="color:#0000CC">'.$co.'</span>'?></td>
						<td><?php if ($no2out == 'no') echo $no2;
									elseif ($no2out == 'yes') echo '<span style="color:#FF0000">'.$no2.'</span>';
										else echo '<span style="color:#0000CC">'.$no2.'</span>'?></td>
						<td><?php if ($o3out == 'no') echo $o3;
									elseif ($o3out == 'yes') echo '<span style="color:#FF0000">'.$o3.'</span>';
										else echo '<span style="color:#0000CC">'.$o3.'</span>'?></td>
					</tr>
					
					<?php
									$i++;
									}
								}
								
							/* Part for the station at the Weseler Straße */
							
									if ($foi == 'Weseler'){
					?>
					
					<tr>
						<th>Zeit</th>
						<th>NO in ppm</th>
						<th>NO2 in ppm</th>
						<th>PM10 in &micro;g/m&sup3;</th>
					</tr>
					
					<?php
										$i = 0;
										$offSno = 0;
										$offSno2 = 0;
										$offSpm10 = 0;
										while($i < $num){
										$time_stamp = pg_result($result1,$i,"time_stamp");
										if (pg_result($result7,$i-$offSno,"time_stamp") == $time_stamp) {$no = pg_result($result7,$i-$offSno,"numeric_value"); $no = round(($no / 1.23),4);
											$noout = pg_result($result7,$i-$offSno,"quality_value");}
											else {$no = "-"; $noout = 'no'; $offSno++;}
										if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value"); $no2 = round(($no2 * 0.000532),4);
											$no2out = pg_result($result5,$i-$offSno2,"quality_value");}
											else {$no2 = "-"; $no2out = 'no'; $offSno2++;}	
										if (pg_result($result9,$i-$offSpm10,"time_stamp") == $time_stamp) {$pm10 = pg_result($result9,$i-$offSpm10,"numeric_value"); $pm10 = round($pm10,4);
											$pm10out = pg_result($result9,$i-$offSpm10,"quality_value");}
											else {$pm10 = "-"; $pm10out = 'no'; $offSpm10++;}
					?>
					
					<tr>
						<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
						<td><?php if ($noout == 'no') echo $no;
									elseif ($noout == 'yes') echo '<span style="color:#FF0000">'.$no.'</span>';
										else echo '<span style="color:#0000CC">'.$no.'</span>'?></td>
						<td><?php if ($no2out == 'no') echo $no2;
									elseif ($no2out == 'yes') echo '<span style="color:#FF0000">'.$no2.'</span>';
										else echo '<span style="color:#0000CC">'.$no2.'</span>'?></td>
						<td><?php if ($pm10out == 'no') echo $pm10;
									elseif ($pm10out == 'yes') echo '<span style="color:#FF0000">'.$pm10.'</span>';
										else echo '<span style="color:#0000CC">'.$pm10.'</span>'?></td>
					</tr>
					
					<?php
									$i++;
										}
									}
									
							/* Part for the station in the 'Geistviertel' */
							
									if ($foi == 'Geist'){
					?>
					
					<tr>
						<th>Zeit</th>
						<th>NO in ppm</th>
						<th>NO2 in ppm</th>
						<th>PM10 in &micro;g/m&sup3;</th>
						<th>SO2 in ppm</th>
						<th>O3 in ppm</th>
					</tr>
					
					<?php
										$offSno = 0;
										$offSno2 = 0;
										$offSpm10 = 0;
										$offSso2 = 0;
										$offSo3 = 0;
										$i = 0;
										while($i < $num){
										$time_stamp = pg_result($result1,$i,"time_stamp");
										if (pg_result($result7,$i-$offSno,"time_stamp") == $time_stamp) {$no = pg_result($result7,$i-$offSno,"numeric_value"); $no = round(($no / 1.23),4);
											$noout = pg_result($result7,$i-$offSno,"quality_value");}
											else {$no = "-"; $noout = 'no'; $offSno++;}
										if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value"); $no2 = round(($no2 * 0.000532),4);
											$no2out = pg_result($result5,$i-$offSno2,"quality_value");}
											else {$no2 = "-"; $no2out = 'no'; $offSno2++;}	
										if (pg_result($result9,$i-$offSpm10,"time_stamp") == $time_stamp) {$pm10 = pg_result($result9,$i-$offSpm10,"numeric_value"); $pm10 = round($pm10,4);
											$pm10out = pg_result($result9,$i-$offSpm10,"quality_value");}
											else {$pm10 = "-"; $pm10out = 'no'; $offSpm10++;}
										if (pg_result($result8,$i-$offSso2,"time_stamp") == $time_stamp) {$so2 = pg_result($result8,$i-$offSso2,"numeric_value"); $so2 = round(($so2 / 2.86),4);
											$so2out = pg_result($result8,$i-$offSso2,"quality_value");}
											else {$so2 = "-"; $so2out = 'no'; $offSso2++;}
										if (pg_result($result6,$i-$offSo3,"time_stamp") == $time_stamp) {$o3 = pg_result($result6,$i-$offSo3,"numeric_value"); $o3 = round(($o3 * 2 / 1000),4);
											$o3out = pg_result($result6,$i-$offSo3,"quality_value");}
											else {$o3 = "-"; $o3out = 'no'; $offSo3++;}

					?>
					
					<tr>
						<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
						<td><?php if ($noout == 'no') echo $no;
									elseif ($noout == 'yes') echo '<span style="color:#FF0000">'.$no.'</span>';
										else echo '<span style="color:#0000CC">'.$no.'</span>'?></td>
						<td><?php if ($no2out == 'no') echo $no2;
									elseif ($no2out == 'yes') echo '<span style="color:#FF0000">'.$no2.'</span>';
										else echo '<span style="color:#0000CC">'.$no2.'</span>'?></td>
						<td><?php if ($pm10out == 'no') echo $pm10;
									elseif ($pm10out == 'yes') echo '<span style="color:#FF0000">'.$pm10.'</span>';
										else echo '<span style="color:#0000CC">'.$pm10.'</span>'?></td>
						<td><?php if ($so2out == 'no') echo $so2;
									elseif ($so2out == 'yes') echo '<span style="color:#FF0000">'.$so2.'</span>';
										else echo '<span style="color:#0000CC">'.$so2.'</span>'?></td>
						<td><?php if ($o3out == 'no') echo $o3;
									elseif ($o3out == 'yes') echo '<span style="color:#FF0000">'.$o3.'</span>';
										else echo '<span style="color:#0000CC">'.$o3.'</span>'?></td>
					</tr>
					
					<?php
										$i++;
										}
									}
							}
						}
						else {
						
		
							/* Part for the redirection from the map page.
								If the user clicks on the "Tabellen" link inside a popup, $_GET variables are sent via the URL.
								A table is automatically filled with data of today and past 2 days.
								The approach is analogue to the tables above. */
							
							$start = $_GET["starting"];
							$end = $_GET["ending"];
							$foi = $_GET["foiid"];
							$num = getTableNumRows($foi,$start,$end);			
							$result1 = getTableTimeStamp($foi,$start,$end);
							if ($foi != 'Weseler' AND $foi != 'Geist'){$result2 = getTableOffering($foi,$start,$end, 'TEMPERATURE');}
							if ($foi != 'Weseler' AND $foi != 'Geist'){$result3 = getTableOffering($foi,$start,$end, 'AIR_HUMIDITY');}
							if ($foi != 'Weseler' AND $foi != 'Geist'){$result4 = getTableOffering($foi,$start,$end, 'CO_CONCENTRATION');}
							$result5 = getTableOffering($foi,$start,$end, 'NO2_CONCENTRATION');
							if ($foi != 'Weseler'){$result6 = getTableOffering($foi,$start,$end, 'O3_CONCENTRATION');}
							if ($foi == 'Weseler' OR $foi == 'Geist'){$result7 = getTableOffering($foi,$start,$end, 'NO_CONCENTRATION');}
							if ($foi == 'Geist'){$result8 = getTableOffering($foi,$start,$end, 'SO2_CONCENTRATION');}
							if ($foi == 'Weseler' OR $foi == 'Geist'){$result9 = getTableOffering($foi,$start,$end, 'PM10_CONCENTRATION');}
								
							if ($foi != 'Weseler' AND $foi != 'Geist'){
					?>
								<tr>
									<th>Zeit</th>
									<th>Temperatur in &deg;C</th>
									<th>Luftfeuchte in %</th>
									<th>CO in ppm</th>
									<th>NO2 in ppm</th>
									<th>O3 in ppm</th>
								</tr>
					<?php
					
					/* Line for line is read and then written into the table */
					
								$i = 0;
								$offStemp = 0;
								$offShum = 0;
								$offSco = 0;
								$offSno2 = 0;
								$offSo3 = 0;
								while($i < $num){
									$time_stamp=pg_result($result1,$i,"time_stamp");
									if (pg_result($result2,$i-$offStemp,"time_stamp") == $time_stamp) {$temperature = pg_result($result2,$i-$offStemp,"numeric_value");}
										else {$temperature = "-"; $offStemp++;}
									if (pg_result($result3,$i-$offShum,"time_stamp") == $time_stamp) {$humidity = pg_result($result3,$i-$offShum,"numeric_value");}
										else {$humidity = "-"; $offShum++;}
									if (pg_result($result4,$i-$offSco,"time_stamp") == $time_stamp) {$co = pg_result($result4,$i-$offSco,"numeric_value");}
										else {$co = "-"; $offSco++;}
									if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value");}
										else {$no2 = "-"; $offSno2++;}
									if (pg_result($result6,$i-$offSo3,"time_stamp") == $time_stamp) {$o3 = pg_result($result6,$i-$offSo3,"numeric_value");}
										else {$o3 = "-"; $offSo3++;}
					?>
					
								<tr>
									<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
									<td><?php echo $temperature; ?></td>
									<td><?php echo $humidity; ?></td>
									<td><?php echo $co; ?></td>
									<td><?php echo $no2; ?></td>
									<td><?php echo $o3; ?></td>
								</tr>
					<?php
									$i++;
								}
							}
							
							if ($foi == 'Weseler'){
					?>
								<tr>
									<th>Zeit</th>
									<th>NO in ppm</th>
									<th>NO2 in ppm</th>
									<th>PM10 in &micro;g/m&sup3;</th>
								</tr>
					<?php
					
					/* Line for line is read and written into the table */
					
								$i = 0;
								$offSno = 0;
								$offSno2 = 0;
								$offSpm10 = 0;
								while($i < $num){
									$time_stamp = pg_result($result1,$i,"time_stamp");
									if (pg_result($result7,$i-$offSno,"time_stamp") == $time_stamp) {$no = pg_result($result7,$i-$offSno,"numeric_value"); $no = round(($no / 1.23),4);}
										else {$no = "-"; $offSno++;}
									if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value"); $no2 = round(($no2 * 0.000532),4);}
										else {$no2 = "-"; $offSno2++;}
									if (pg_result($result9,$i-$offSpm10,"time_stamp") == $time_stamp) {$pm10 = pg_result($result9,$i-$offSpm10,"numeric_value");$pm10 = round($pm10,4);}
										else {$pm10 = "-"; $offSpm10++;}
					?>
					
								<tr>
									<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
									<td><?php echo $no; ?></td>
									<td><?php echo $no2; ?></td>
									<td><?php echo $pm10; ?></td>
								</tr>
					<?php
									$i++;
								}
							}
							
							if ($foi == 'Geist'){
					?>
								<tr>
									<th>Zeit</th>
									<th>NO in ppm</th>
									<th>NO2 in ppm</th>
									<th>PM10 in &micro;g/m&sup3;</th>
									<th>SO2 in ppm</th>
									<th>O3 in ppm</th>
								</tr>
					<?php
					
					/* Line for line is read and written into the table */
					
								$i = 0;
								$offSno = 0;
								$offSno2 = 0;
								$offSpm10 = 0;
								$offSso2 = 0;
								$offSo3 = 0;
								while($i < $num){
									$time_stamp = pg_result($result1,$i,"time_stamp");
									if (pg_result($result7,$i-$offSno,"time_stamp") == $time_stamp) {$no = pg_result($result7,$i-$offSno,"numeric_value"); $no = round(($no / 1.23),4);}
										else {$no = "-"; $offSno++;}
									if (pg_result($result5,$i-$offSno2,"time_stamp") == $time_stamp) {$no2 = pg_result($result5,$i-$offSno2,"numeric_value"); $no2 = round(($no2 * 0.000532),4);}
										else {$no2 = "-"; $offSno2++;}
									if (pg_result($result9,$i-$offSpm10,"time_stamp") == $time_stamp) {$pm10 = pg_result($result9,$i-$offSpm10,"numeric_value"); $pm10 = round($pm10,4);}
										else {$pm10 = "-"; $offSpm10++;}
									if (pg_result($result8,$i-$offSso2,"time_stamp") == $time_stamp) {$so2 = pg_result($result8,$i-$offSso2,"numeric_value"); $so2 = round(($so2 / 2.86),4);}
										else {$so2 = "-"; $offSso2++;}
									if (pg_result($result6,$i-$offSo3,"time_stamp") == $time_stamp) {$o3 = pg_result($result6,$i-$offSo3,"numeric_value"); $o3 = round(($o3 * 2 / 1000),4);}
										else {$o3 = "-"; $offSo3++;}
					?>
					
								<tr>
									<td><?php echo date_format(date_create($time_stamp), 'd.m.Y H:i:s'); ?></td>
									<td><?php echo $no; ?></td>
									<td><?php echo $no2; ?></td>
									<td><?php echo $pm10; ?></td>
									<td><?php echo $so2; ?></td>
									<td><?php echo $o3; ?></td>
								</tr>
					<?php
									$i++;
								}
							}
						}
					?>
				
				</table>
			</div>
		</div>
	</div>
</body>