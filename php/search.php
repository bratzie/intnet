<?php
session_start();

$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	
 die('Could not connect: ' . mysql_error());
}
?>

<html>
<head><title>Folke och Bratzies Hus</title>
</head>
<body>

<form name="Välj Bostad">
<table>
	<tr>
		<td>
			Antal rum
		</td>
		<td>
<input type=number name="rum_min" min=1 max=10>
	</td>
	<td>
<input type=number name="rum_max" min=1 max=10>
	</td>
</tr>
	<tr>
		<td>
			Bostads Areas
		</td>
		<td>
<input type=number name="area_min" min=1 max=1000>
	</td>
	<td>
<input type=number name="area_max" min=1 max=1000>
	</td>
</tr>
	<tr>
		<td>
			Pris
		</td>
		<td>
<input type=number name="pris_min" min=1 max=1000000000>
	</td>
	<td>
<input type=number name="pris_max" min=1 max=1000000000>
	</td>
</tr>
	<tr>
		<td>
			Avgift
		</td>
		<td>
<input type=number name="avgift_min" min=1 max=100000>
	</td>
	<td>
<input type=number name="avgift_max" min=1 max=100000> 
	</td>
</tr>
<tr>
<td>
Län</td>
<td><select name = "lan">
<?php

$sqlPopulateLan='SELECT lan FROM bostader group by lan';

$rs=$link->query($sqlPopulateLan);
	while($row = $rs->fetch_row()){
		$lan = $row[0];
   echo <<<EOL
<option>$lan</option>
EOL;
}
?> 

</select></td></tr>

<tr>
<td>
Object Typ</td>
<td><select>
<?php

$sqlPopulateobjekttyp='SELECT objekttyp FROM bostader group by objekttyp';

$rs=$link->query($sqlPopulateobjekttyp);
	while($row = $rs->fetch_row()){
		$objekttyp = $row[0];
   echo <<<EOL
<option>$objekttyp</option>
EOL;
}
?> 

</select></td></tr>

</table>
<input type=submit value="Sök">
</form>
</body>
</html>
