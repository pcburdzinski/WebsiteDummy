<?php 

/*Chart Options for Google Chart */

/* Chart Options for AQEs */
function AQEChartOptions(){
	if (isset($_POST['observation']) AND isset($_POST['outliers'])){
		if ($_POST['outliers'] == 'yes'){ echo '
          chart.draw(data, 	{curveType: "function",
							width: 900, height: 400,
							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
							hAxis:{title: "Datum", slantedText:false},
							chartArea:{width: "50%"}});
          chart2.draw(data2, {curveType: "function",
							 width: 900, height: 400,
							 vAxis:{title: "Temperatur in °C"},
							 hAxis:{slantedText:false},
							 chartArea:{width: "50%"}});
          chart3.draw(data3, {curveType: "function",
							 width: 900, height: 400,
							 vAxis:{title:"rel. Luftfeuchtigkeit in %", viewWindow:{min: 0}},
							 hAxis:{slantedText:false},
							 chartArea:{width: "50%"}});';
		}
		else {
			$numoff = count($_POST['observation']);
			switch($numoff){
				case 1: echo 'chart.draw(data, {curveType: "function",
    							width: 900, height: 400,
    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
    							hAxis:{title: "Datum", slantedText:false},
    							chartArea:{width: "50%"},
								series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});';
	
				break;
					
				case 2: echo 'chart.draw(data, {curveType: "function",
    							width: 900, height: 400,
    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
    							hAxis:{title: "Datum", slantedText:false},
    							chartArea:{width: "50%"},
								series:{2:{color:"red", lineWidth: 0, pointSize: 5}, 3:{color:"red", lineWidth: 0, pointSize: 5}}});';
				break;
					
				case 3: echo 'chart.draw(data, {curveType: "function",
    							width: 900, height: 400,
    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
    							hAxis:{title: "Datum", slantedText:false},
    							chartArea:{width: "50%"},
								series:{3:{color:"red", lineWidth: 0, pointSize: 5}, 4:{color:"red", lineWidth: 0, pointSize: 5}, 5:{color:"red", lineWidth: 0, pointSize: 5}}});';
				break;
			}
			echo '	chart2.draw(data2, {curveType: "function",
    							width: 900, height: 400,
    							vAxis:{title: "Temperatur in °C"},
    							hAxis:{slantedText:false},
    							chartArea:{width: "50%"},
								series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});
          						chart3.draw(data3, {curveType: "function",
    							width: 900, height: 400,
    							vAxis:{title:"rel. Luftfeuchtigkeit in %", viewWindow:{min: 0}},
    							hAxis:{slantedText:false},
    							chartArea:{width: "50%"},
								series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});';
		}
	}
}

/*Chart Options for LANUV */
function lanuvChartOptions(){
if (isset($_POST['observation']) AND isset($_POST['outliers'])){
	$numoff = count($_POST['observation']);
	if ($_POST['outliers'] == 'yes'){
		switch($numoff){
			case 1: echo 'chart.draw(data, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"}});';
		
			break;
		
			case 2: echo 'chart.draw(data, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"}});
			
							chart2.draw(data2, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"}});';
			break;
		
			case 3: echo 'chart.draw(data, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"}});
							chart2.draw(data2, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"}});
							chart3.draw(data3, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"}});';
			break;
		
		}
	if(isset($_POST['PM10'])){ if($_POST['PM10'] == "PM10_CONCENTRATION"){ echo '
										chart3.draw(data3, {curveType: "function",
    									width: 900, height: 400,
    									vAxis:{title: "Werte in µg/m³"},
    									hAxis:{slantedText:false},
    									chartArea:{width: "50%"}});'; }}
	}
	else {
		switch($numoff){
			case 1: echo 'chart.draw(data, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"},
        									series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});';

			break;

			case 2: echo 'chart.draw(data, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"},
        									series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});
					
							chart2.draw(data2, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"},
        									series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});';
			break;

			case 3: echo 'chart.draw(data, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"},
        									series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});
							chart2.draw(data2, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"},
        									series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});
							chart3.draw(data3, {curveType: "function",
        	    							width: 900, height: 400,
        	    							vAxis:{title: "Werte in ppm", viewWindow:{min: 0}},
        	    							hAxis:{title: "Datum", slantedText:false},
        	    							chartArea:{width: "50%"},
        									series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});';
			break;

			}
			if(isset($_POST['PM10'])){ if($_POST['PM10'] == "PM10_CONCENTRATION"){
			echo 'chart3.draw(data3, {curveType: "function",
    							width: 900, height: 400,
    							vAxis:{title: "Werte in µg/m³"},
    							hAxis:{slantedText:false},
    							chartArea:{width: "50%"},
								series:{1:{color:"red", lineWidth: 0, pointSize: 5}}});';}}
		}
	}
}



?>