<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>SkyEagle</title>
<link rel="shortcut icon" href="../images/egg_v1.png">
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="stylesheet" type="text/css" href="../css/styles.css" />
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
				<li><a href="Tabelle.php">Tabelle</a></li>
				<li class="current"><a href="SOS.php">SOS</a></li>
				<li><a href="Hilfe.php">Hilfe & FAQ</a></li>
				<li><a href="Impressum.php">Impressum</a></li>
				<li><a href="../mobile/homemobile.php">Mobile Ansicht</a></li>
				</ul>
		</div>
        <div id="contentwrap">
			<div id="content">
			SOS steht für Sensore Observation Service und ermöglicht es mit Abfragen Informationen aus der Datenbank zu erhalten.<br><br>
			SkyEagle implementiert einen solchen im Core Profile und stellt somit folgenden Operationen bereit:<br><br>
				<div id="contentpoints">GetCapabilities: </div><br>
				<div id="contentsos">Mit dieser Anfrage lassen sich allgemeine Informationen über den SOS abrufen.<br><br>
					<a href="http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&REQUEST=GetCapabilities" target="_blank">http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&REQUEST=GetCapabilities</a>
				</div><br><br>
				<div id="contentpoints">GetObservation: </div><br>
				<div id="contentsos">Mit dieser Abfrage lassen sich gemessene Werte ohne Qualitätinformationen abrufen.<br><br>
					<a href="http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&REQUEST=GetObservation&VERSION=1.0.0&OFFERING=CO_CONCENTRATION&OBSERVEDPROPERTY=urn:x-ogc:def:phenomenon:OGC:CarbonDioxide:uom:ppm&FEATUREOFINTEREST=75842&RESPONSEFORMAT=text/xml;subtype=%22om/1.0.0%22" target="_blank">http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&REQUEST=GetObservation&VERSION=1.0.0&OFFERING=CO_CONCENTRATION&OBSERVEDPROPERTY=urn:x-ogc:def:phenomenon:OGC:CarbonDioxide:uom:ppm&FEATUREOFINTEREST=75842&RESPONSEFORMAT=text/xml;subtype=%22om/1.0.0%22</a>
				</div><br>
				<div id="contentsos">Mit dieser Abfrage lassen sich gemessene Werte mit Qualitätinformationen abrufen.<br><br>
					<a href="http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&REQUEST=GetObservation&VERSION=1.0.0&OFFERING=CO_CONCENTRATION&OBSERVEDPROPERTY=urn:x-ogc:def:phenomenon:OGC:CarbonDioxide:uom:ppm&FEATUREOFINTEREST=75842&RESULTMODEL=om:Measurement&RESPONSEFORMAT=text/xml;subtype=%22om/1.0.0%22" target="_blank">http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&REQUEST=GetObservation&VERSION=1.0.0&OFFERING=CO_CONCENTRATION&OBSERVEDPROPERTY=urn:x-ogc:def:phenomenon:OGC:CarbonDioxide:uom:ppm&FEATUREOFINTEREST=75842&RESULTMODEL=om:Measurement&RESPONSEFORMAT=text/xml;subtype=%22om/1.0.0%22</a>
				</div><br><br>
				<div id="contentpoints">DescribeSensor: </div><br>
				<div id="contentsos">Über diese Funktion lassen sich weitere Informationen über die einzelnen Sensoren innerhalb des Netzwerks abrufen.<br><br>
					<a href="http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&VERSION=1.0.0&REQUEST=DescribeSensor&PROCEDURE=urn:ogc:def:procedure:aqe-o3-sensor&OUTPUTFORMAT=text/xml;subtype=%22sensorML/1.0.1%22" target="_blank">http://giv-geosoft2e.uni-muenster.de:8080/skyeaglesos/sos?SERVICE=SOS&VERSION=1.0.0&REQUEST=DescribeSensor&PROCEDURE=urn:ogc:def:procedure:aqe-o3-sensor&OUTPUTFORMAT=text/xml;subtype=%22sensorML/1.0.1%22</a>
				</div><br><br>
				<div id="contentpoints">Weitere Informationen über den SOS können unter folgendem Link abgerufen werden: </div><br>
				<div id="contentsos">
					<a href="http://de.wikipedia.org/wiki/Sensor_Observation_Service" target="_blank">http://de.wikipedia.org/wiki/Sensor_Observation_Service</a>
				</div><br><br>
			</div>
		</div>
	</div>
</div>
</body>
</html>