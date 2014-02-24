<?php
session_start();

$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	
 die('Could not connect: ' . mysql_error());
}
?>


<html>
<head><title>Folke och Bratzies Hus</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>


<script language="javascript">
function setCookie(form){
	var rum_min = form.rum_min.value;
	var rum_max = form.rum_max.value;
	var area_min = form.area_min.value;
	var area_max = form.area_max.value;
	var pris_min = form.pris_min.value;
	var pris_max = form.pris_max.value;
	var avgift_min = form.avgift_min.value;
	var avgift_max = form.avgift_max.value;
	var lan = form.lan.value;
	var objekttyp = form.objekttyp.value;
	
	document.cookie= "rum_min = "+rum_min+ ";";
	document.cookie= "rum_max = "+rum_max+" ;";
	document.cookie= "area_min = "+area_min+" ;";
	document.cookie= "area_max = "+area_max+" ;";
	document.cookie= "pris_min = "+pris_min+" ;";
	document.cookie= "pris_max = "+pris_max+" ;";
	document.cookie= "avgift_min = "+avgift_min+" ;";
	document.cookie= "avgift_max = "+avgift_max+" ;";
	document.cookie= "lan = "+lan+" ;";
	document.cookie= "objekttyp = "+objekttyp+" ;";
	
	alert(dokument.cookie);
	
 return true;
}
</script>	
	

<form method="post" name="Välj Bostad" action="result.php" onsubmit="return setCookie(this)">
<table>
	<tr>
		<td>
			Antal rum
		</td>
		<td>
<input type=number name="rum_min" min=1 max=10 value=1>
	</td>
	<td>
<input type=number name="rum_max" min=1 max=10 value=10>
	</td>
</tr>
	<tr>
		<td>
			Bostads Areas
		</td>
		<td>
<input type=number name="area_min" min=1 max=1000 value=1>
	</td>
	<td>
<input type=number name="area_max" min=1 max=1000 value=1000>
	</td>
</tr>
	<tr>
		<td>
			Pris
		</td>
		<td>
<input type=number name="pris_min" min=1 max=1000000000 value=1>
	</td>
	<td>
<input type=number name="pris_max" min=1 max=1000000000 value=1000000000>
	</td>
</tr>
	<tr>
		<td>
			Avgift
		</td>
		<td>
<input type=number name="avgift_min" min=1 max=100000 value=1>
	</td>
	<td>
<input type=number name="avgift_max" min=1 max=100000 value=100000> 
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

<tr>
<td>
Object Typ</td>
<td><select name = "objekttyp">
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

</select></td></tr>
<?php
if(!isset($_COOKIE)) { // check if there's a cookie
	print_r('no cookie for us? NO BOSTÄDER FOR YOU!');
} else {
	print_r($_COOKIE);
}
?> 
</body>
</html>
