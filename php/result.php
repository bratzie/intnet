<?php 
if(!empty($_COOKIE)) { // check if there's a cookie

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>bostäder</title>
	<link rel="stylesheet" href="./jquery.tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="./jquery.tablesorter/jquery.tablesorter.js"></script>
</head>
<body>
	<table id="myTable" class="tablesorter">
		<thead>
			<tr> <!-- 7 headers -->
				<th>Län</th>
				<th>Objekttyp</th>
				<th>Adress</th>
				<th>Area</th>
				<th>Rum</th>
				<th>Pris</th>
				<th>Avgift</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// adding rows and stuff with data
			?>
		</tbody>
</body>
</html>>

rum_min
rum_max
area_min
area_max
pris_min
pris_max
avgift_min
avgift_max