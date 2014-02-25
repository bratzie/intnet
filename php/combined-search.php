<?php
session_start();

$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	
   die('Could not connect: ' . mysql_error());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Folke och Bratzies Hus</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./jquery.tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="./jquery.tablesorter/jquery.tablesorter.js"></script>

    <script>
        function updateTable(form) {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById("theTable").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("post","combined-result.php",true);
            xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xmlhttp.send("rum_min="+form.rum_min.value+"&rum_max="+form.rum_max.value+"&area_min="+form.area_min.value+"&area_max="+form.area_max.value+"&pris_min="+form.pris_min.value+"&pris_max="+form.pris_max.value+"&avgift_min="+form.avgift_min.value+"&avgift_max="+form.avgift_max.value+"&lan="+form.lan.value+"&objekttyp="+form.objekttyp.value);
        }
    </script>

    </head>
    <body>

    <script language="javascript">
        function setCookie(form) {

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

    <!-- Display form -->
    <h2>Mattias och Bratt - Bostadshaff</h2>
    <form method="post" name="Välj Bostad" onsubmit="updateTable(this)">
    <table>
        <tr>
            <td>Rum</td>
            <td>
                <input type=number name="rum_min" min=1 max=10 value=<?php 
                echo (isset($_COOKIE['rum_min']) ? $_COOKIE['rum_min'] : "1"); ?>>
            </td>
            <td>
                <input type=number name="rum_max" min=1 max=10 value=<?php 
                echo (isset($_COOKIE['rum_max']) ? $_COOKIE['rum_max'] : "10"); ?>>
            </td>
        </tr>
        <tr>
            <td>Area</td>
            <td>
                <input type=number name="area_min" min=1 max=1000 value=<?php 
                echo (isset($_COOKIE['area_min']) ? $_COOKIE['area_min'] : "1"); ?>>
            </td>
            <td>
                <input type=number name="area_max" min=1 max=1000 value=<?php 
                echo (isset($_COOKIE['area_max']) ? $_COOKIE['area_max'] : "1000"); ?>>
            </td>
        </tr>
        <tr>
            <td>Pris</td>
            <td>
                <input type=number name="pris_min" min=1 max=1000000000 value=<?php 
                echo (isset($_COOKIE['pris_min']) ? $_COOKIE['pris_min'] : "1"); ?>>
            </td>
            <td>
                <input type=number name="pris_max" min=1 max=1000000000 value=<?php 
                echo (isset($_COOKIE['pris_max']) ? $_COOKIE['pris_max'] : "1000000000"); ?>>
            </td>
        </tr>
        <tr>
            <td>Avgift</td>
            <td>
                <input type=number name="avgift_min" min=1 max=100000 value=<?php 
                echo (isset($_COOKIE['avgift_min']) ? $_COOKIE['avgift_min'] : "1"); ?>>
            </td>
            <td>
                <input type=number name="avgift_max" min=1 max=100000 value=<?php 
                echo (isset($_COOKIE['avgift_max']) ? $_COOKIE['avgift_max'] : "100000"); ?>>
            </td>
        </tr>
        <tr>
            <td>L&#228;n</td>
            <td>
                <select name = "lan">
                <?php
                $sqlPopulateLan='SELECT lan FROM bostader group by lan';
                $cookieValue = 'null';
                if(isset($_COOKIE['lan'])) {
                    $cookieValue = $_COOKIE['lan'];
                }	

                $rs=$link->query($sqlPopulateLan);
                while($row = $rs->fetch_row()) {
                    $lan = $row[0];
                    if($lan == $cookieValue) {
                        echo <<<EOL
<option selected="selected">$lan</option>
EOL;
                    } else {
                        echo <<<EOL
<option>$lan</option>
EOL;
                    }
                }
                ?>
                </select>
            </td>
        <tr>
            <td>Typ</td>
            <td>
                <select name = "objekttyp">
                <?php
                $sqlPopulateobjekttyp='SELECT objekttyp FROM bostader group by objekttyp';
                $cookieValue = 'null';
                if(isset($_COOKIE['objekttyp'])) {
                    $cookieValue = $_COOKIE['objekttyp'];
                }
                $rs=$link->query($sqlPopulateobjekttyp);
                while($row = $rs->fetch_row()) {
                    $objekttyp = $row[0];
                    if($objekttyp == $cookieValue) {
                        echo <<<EOL
<option selected="selected">$objekttyp</option>
EOL;
                    } else {
                        echo <<<EOL
<option>$objekttyp</option>
EOL;
                    }
                }
                ?>
                </select>
            </td>
        </tr>
    </table>
    <input type=submit value="S&#246;k">
    </form>

    <!-- Display results -->
    <h2>Results</h2>
    <div id="theTable">Search to see results.</div>
</body>
</html>
