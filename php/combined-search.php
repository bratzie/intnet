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
	

<form method="post" name="Välj Bostad" action="result.php" onsubmit="return setCookie(this)">
<table>
	<tr>
		<td>
			Antal rum
		</td>
		<td>
<input type=number name="rum_min" min=1 max=10 value=<?php 
        if(isset($_COOKIE['rum_min']))
        {
            echo $_COOKIE['rum_min'];
        } 
        else 
        {
            echo "1";
        }
    ?>>
	</td>
	<td>
<input type=number name="rum_max" min=1 max=10 value=<?php 
        if(isset($_COOKIE['rum_max']))
        {
            echo $_COOKIE['rum_max'];
        } 
        else 
        {
            echo "10";
        }
    ?>>
	</td>
</tr>
	<tr>
		<td>
			Bostads Areas
		</td>
		<td>
<input type=number name="area_min" min=1 max=1000 value=<?php 
        if(isset($_COOKIE['area_min']))
        {
            echo $_COOKIE['area_min'];
        } 
        else 
        {
            echo "1";
        }
    ?>>
	</td>
	<td>
<input type=number name="area_max" min=1 max=1000 value=<?php 
        if(isset($_COOKIE['area_max']))
        {
            echo $_COOKIE['area_max'];
        } 
        else 
        {
            echo "1000";
        }
    ?>>
	</td>
</tr>
	<tr>
		<td>
			Pris
		</td>
		<td>
<input type=number name="pris_min" min=1 max=1000000000 value=<?php 
        if(isset($_COOKIE['pris_min']))
        {
            echo $_COOKIE['pris_min'];
        } 
        else 
        {
            echo "1";
        }
    ?>>
	</td>
	<td>
<input type=number name="pris_max" min=1 max=1000000000 value=<?php 
        if(isset($_COOKIE['pris_max']))
        {
            echo $_COOKIE['pris_max'];
        } 
        else 
        {
            echo "1000000000";
        }
    ?>>
	</td>
</tr>
	<tr>
		<td>
			Avgift
		</td>
		<td>
<input type=number name="avgift_min" min=1 max=100000 value=<?php 
        if(isset($_COOKIE['avgift_min']))
        {
            echo $_COOKIE['avgift_min'];
        } 
        else 
        {
            echo "1";
        }
    ?>>
	</td>
	<td>
<input type=number name="avgift_max" min=1 max=100000 value=<?php 
        if(isset($_COOKIE['avgift_max']))
        {
            echo $_COOKIE['avgift_max'];
        } 
        else 
        {
            echo "100000";
        }
    ?>>
	</td>
</tr>
<tr>
<td>
L&#228;n</td>
<td><select name = "lan">
<?php
$sqlPopulateLan='SELECT lan FROM bostader group by lan';
$cookieValue = 'null';
if(isset($_COOKIE['lan'])){
	$cookieValue = $_COOKIE['lan'];
}	

$rs=$link->query($sqlPopulateLan);
	while($row = $rs->fetch_row()){
		$lan = $row[0];
		        if($lan == $cookieValue)
        {
			   echo <<<EOL
<option selected="selected">$lan</option>
EOL;
        } 
        else 
        {
			echo <<<EOL
<option>$lan</option>
EOL;
        }
}
?> 

<tr>
<td>
Object Typ</td>
<td><select name = "objekttyp">
<?php

$sqlPopulateobjekttyp='SELECT objekttyp FROM bostader group by objekttyp';
$cookieValue = 'null';
if(isset($_COOKIE['objekttyp'])){
	$cookieValue = $_COOKIE['objekttyp'];
}	

$rs=$link->query($sqlPopulateobjekttyp);
	while($row = $rs->fetch_row()){
		$objekttyp = $row[0];
		        if($objekttyp == $cookieValue)
        {
			   echo <<<EOL
<option selected="selected">$objekttyp</option>
EOL;
        } 
        else 
        {
			echo <<<EOL
<option>$objekttyp</option>
EOL;
        }
	}
?> 

</select></td></tr>

</table>
<input type=submit value="S&#246;k">
</form>

</select></td></tr>
</body>
</html>
