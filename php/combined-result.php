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
    $result=$link->query($query) or trigger_error($mysqli->error." [$query]");
    
    // print table headers
    echo '<table id="myTable" class="tablesorter">';
        echo "<thead>";
            echo "<tr> <!-- 7 headers -->";
                echo "<th>L&#228;n</th>";
                echo "<th>Objekttyp</th>";
                echo "<th>Adress</th>";
                echo "<th>Area</th>";
                echo "<th>Rum</th>";
                echo "<th>Pris</th>";
                echo "<th>Avgift</th>";
            echo "</tr>";
        echo "</thead>";
    echo "<tbody>";
    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        echo "<tr>";
        echo "<td>" . $row['lan'] . "</td>";
        echo "<td>" . $row['objekttyp'] . "</td>";
        echo "<td>" . $row['adress'] . "</td>";
        echo "<td>" . $row['area'] . "</td>";
        echo "<td>" . $row['rum'] . "</td>";
        echo "<td>" . $row['pris'] . "</td>";
        echo "<td>" . $row['avgift'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</thread>";
    /* free result set */
    $result->free();
    /* close connection */
    mysqli_close($link);

} else {
    echo "KRASHLOL";
}
?>