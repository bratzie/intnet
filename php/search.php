<?php
session_start();

$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	
 die('Could not connect: ' . mysql_error());
}
?>


<html>
<head><title>Folke och Bratzies Hus</title>
<meta charset="utf-8"> 
</head>
<body>

<!-- Switch to php-setCookie??? 

if (isset($_COOKIE['count'])) {
    $count = $_COOKIE['count'] + 1;
} else {
    $count = 1;
}
setcookie('count', $count, time()+3600);
setcookie("Cart[$count]", $item, time()+3600);

-->
<script language="javascript">
function setCookie(form){
	
	document.cookie= "rum_min = "+form.rum_min.value+ ";";
	document.cookie= "rum_max = "+form.rum_max.value+" ;";
	document.cookie= "area_min = "+form.area_min.value+" ;";
	document.cookie= "area_max = "+form.area_max.value+" ;";
	document.cookie= "pris_min = "+form.pris_min.value+" ;";
	document.cookie= "pris_max = "+form.pris_max.value+" ;";
	document.cookie= "avgift_min = "+form.avgift_min.value+" ;";
	document.cookie= "avgift_max = "+form.avgift_max.value+" ;";
	document.cookie= "lan = "+form.lan.value+" ;";
	document.cookie= "objekttyp = "+form.objekttyp.value+" ;";
	
 return true;
}
</script>	
	

<form method="post" name="Välj Bostad" id="search_form" action="result.php" onsubmit="return setCookie(this)">
<table>
	<tr>
		<td>
			Antal rum
		</td>
		<td>
<input type=number id="rum_min" name="rum_min" min=1 max=10 value=1>
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
LÃ¤n</td>
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
<input type=submit value="S&#246;k">
</form>

</select></td></tr>
<?php
if(isset($_COOKIE["rum_min"])) { // check if there's a cookie
print_r($_COOKIE);
}
?> 
</body>
</html>
