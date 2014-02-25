<?php 
/*
if(!isset($_COOKIE)) { // check if there's a cookie
	echo "no cookie for us? NO BOSTÄDER FOR YOU!";
} else {
	$lan = $_COOKIE['lan'];
}
*/
?>

<!DOCTYPE html>
<html>
<head>
	<title>bostäder</title>
	<link rel="stylesheet" href="./jquery.tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="./jquery.tablesorter/jquery.tablesorter.js"></script>

	<script type="text/javascript">
    $(document).ready(function() { 
    	// sort table on the fifth column, ascending.
        $("#myTable").tablesorter( {sortList: [[5,0]]} ); 
    } 
    );
    </script>
</head>
<body>
	<h2>Mattias och Bratt fixar fastigheter</h2>
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
			// check if we have all the parameters from the form
            if(isset($_POST['lan']) && isset($_POST['objekttyp']) && isset($_POST['rum_min']) && isset($_POST['rum_max']) && 
            	isset($_POST['area_min']) && isset($_POST['area_max']) && isset($_POST['pris_min']) && isset($_POST['pris_max']) && 
            	isset($_POST['avgift_min']) && isset($_POST['avgift_max'])) {
            	// premade statement
                $query="SELECT * FROM bostader WHERE lan='$_POST[lan]' AND objekttyp='$_POST[objekttyp]' AND rum>=$_POST[rum_min] AND rum<=$_POST[rum_max] AND 
                area>=$_POST[area_min] AND area<=$_POST[area_max] AND pris>=$_POST[pris_min] AND pris<=$_POST[pris_max] AND avgift>=$_POST[avgift_min] AND avgift<=$_POST[avgift_max]";
                // establish link to database
                $link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
                /* check connection */
				if (mysqli_connect_errno()) {
				    printf("Connect failed: %s\n", mysqli_connect_error());
				    exit();
				}
                // get data from db
                $result=$link->query($query) or trigger_error($mysqli->error." [$query]");;
                while ($row = $result->fetch_array()) {
                	// construct a table row from the db result
    	            echo "<tr><td>", $row["lan"], "</td><td>", $row["objekttyp"], "</td><td>", 
    	            $row["adress"], "</td><td>", $row["area"], "</td><td>", $row["rum"], "</td><td>", 
    	            $row["pris"], "</td><td>", $row["avgift"], "</td></tr>\n";
        	    }
        	    /* free result set */
				$result->free();
				/* close connection */
                mysqli_close($link);
            }
            ?>
		</tbody>
</body>
</html>