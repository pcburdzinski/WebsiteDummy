<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SkyEagle</title>
<link rel="shortcut icon" href="../images/egg_v1.png">
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="stylesheet" type="text/css" href="../css/styles.css" />
<script type="text/javascript" src="../js/accordion.js"></script>
</head>

<body onload="accord_loader()">
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
				 <li><a href="SOS.php">SOS</a></li>
				 <li class="current"><a href="Hilfe.php">Hilfe & FAQ</a></li>
				 <li><a href="Impressum.php">Impressum</a></li>
				 <li><a href="../mobile/homemobile.php">Mobile Ansicht</a></li>
				</ul>
		</div>
        <div id="contentwrap">
			<div id="content"> <!-- Der Content der Seite (Akkordion), bisher nur Platzhalter-->
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Was ist ein Air Quality Egg?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Ein Air Quality Egg (kurz: AQE) ist ein über Kick-Starter finanziertes Projekt. Gestartet wurde es von der Gruppierung Sensmakers. Das Air Quality Egg soll eine günstige und möglichst weltweit verteiltes Luftqualitätssensornetzwerk werden. Mithilfe dieses Netzwerks soll dann für jedermann eine erste gute Anlaufstelle zu dem Thema Luftqualität realisiert werden. Die gesammelten Daten dieses Sensornetzwerkes werden auf cosm.com hoch geladen und können von dort weiter verarbeitet werden.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Was ist eine Lanuv-Station?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Lanuv ist das "Landesamt für Natur, Umwelt und Verbraucherschutz NRW". Die Lanuv-Stationen, die auf unserer Seite dargestellt werden, sind Luftqualitätsmessstationen. Weitere Informationen gibt es auf der Lanuv Website.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Was ist cosm?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Cosm ist eine Plattform um gesammelte Daten online zur Verfügung und zur Weiterverarbeitung bereit zu stellen.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Warum wird die Karte nicht angezeigt?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Damit die Karte angezeigt wird muss Javascript im Browser aktiviert sein. Dies ist in den Browsereinstellungen möglich.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Warum werden in den Popups teilweise keine Werte angezeigt?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Das kann dadurch passieren, dass noch keine aktuellen Werte vorliegen. Sobald es passende Werte gibt, werden sie sofort auf der Karte in Skyeagle angezeigt.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Wo bekomme ich weitere Informationen über die gemessenen Werte?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Wenn auf der Karte eine Messstation ausgewählt wird, so öffnet sich ein kleines Popup. Klickt man innerhalb dessen auf einen Messparameter, so öffnet sich automatisch ein weiteres Fenster zu einem Wikipediaartikel des jeweiligen Messwertes.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Warum haben manche Air Quality Eggs keine Werte?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Die Air Quality Eggs sind noch ein junges Projekt und besitzen noch einige "Kinderkrankheiten". Es wird ständig daran gearbeitet Fehler zu beheben. Ebenso können AQEs ohne Werte nicht mehr am Netz sein und so keine Werte mehr liefern.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Wieso werden in meinem Zeitintervall keine Werte in der Tabelle angezeigt?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Falls keine Werte angezeigt werden, liegt es daran, dass für diesen Zeitpunkt keine Werte in der Datenbank vorliegen.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Wieso werden in den Diagrammen zum Teil Lücken angezeigt?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Sollte es von einer Messstation zu dem Zeitpunkt keine Daten geben, so kann zu diesem Zeitpunkt kein Wert angezeigt werden.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Wie werden die Daten validiert?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Die Datenvalidierung erfolgt mithilfe einer zweiseitigen "moving window" Validierung. Die validierten Daten kann man sowohl im Diagramm, als auch in der Tabellenansicht betrachten, wenn man auf "Bereinigte Daten" klickt.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Wie kommen Ausreißer zu Stande?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Ausreißer können viele Gründe haben, wie beispielsweise Messfehler oder unnatürliche Einflüsse. Eine erste Ausreißererkennung haben wir mit Skyeagle realisiert.
				</div>
			</div></div></div><br>
			<div class="accordionSlider"><div class="accordionSliderHead">
				<h3>Kann ich auch mitmachen?</h3>
				</div><div class="accordionSliderBody"><div class="accordionSliderInBody">
				<div><br>Mitmachen kann jeder der Interesse daran hat sein eigenes Air Quality Egg aufzustellen. Dabei geht es ganz einfach: AQE kaufen, aufstellen und bei cosm.com mit #muensteregg taggen und dein AQE erscheint automatisch nach ungefähr einer Stunde nach dem hochladen auf Skyeagle.
				</div>
			</div></div></div><br>
			</div>
		</div>
    </div>
</body>
</html>