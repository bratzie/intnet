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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="./jquery.tablesorter/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>

    <style type="text/css">
        body {
        background-color: #cccccc;
        background-image: url(pixel_weave.png);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Open Sans Condensed', sans-serif;
            color: #363636;
            padding-left: 5px;
            padding-top: 10px;
        }
    </style>

    <script>

    $(document).ready(function() {
        $("form").submit(function(event) {
            updateTable();
            event.preventDefault();
        });
    });

    function updateTable() {
        var data = $("form").serialize();

        $.ajax({
            type: "POST",
            url: "combined-result.php",
            data: data,
            success: function (returned_data) {
                $('#theTable').html(returned_data);
                setCookie($("form").serializeArray()); // only set cookie when we get a legit response

            },
            error: function (returned_data) {
                console.log(returned_data);
            },
            complete: function () {
                $("#myTable").tablesorter();
            }
        });
    }

    function setCookie(cookieData) {
        // highly experimental, only use in production
        $.each(cookieData, function(index, data) {
            $.cookie(data.name, data.value);
        });
       
        /*
        // set cookie depending on what you put into the form.
        for (var i = 0; i < cookieData.length; i++) {
            $.cookie(cookieData[i].name, cookieData[i].value)

            console.log("key: "+cookieData[i].name+" value: "+cookieData[i].value)
        };
        */
    }

    </script>

    </head>
    <body>
        <!-- Display form -->
        <h2>Mattias och Bratt - Bostadshaff</h2>
        <form>
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
                        <select name = "lan"><?php
                            $sqlPopulateLan='SELECT lan FROM bostader group by lan';
                            $cookieValue = (isset($_COOKIE['lan']) ? $_COOKIE['lan'] : 'null');
                            $rs=$link->query($sqlPopulateLan);
                            while($row = $rs->fetch_row()) {
                                $lan = $row[0];
                                echo ($lan == $cookieValue ? "<option selected='selected'>$lan</option>" : "<option>$lan</option>");
                            }?>
                        </select>
                    </td>
                <tr>
                    <td>Typ</td>
                    <td>
                        <select name = "objekttyp"><?php
                            $sqlPopulateobjekttyp='SELECT objekttyp FROM bostader group by objekttyp';
                            $cookieValue = (isset($_COOKIE['objekttyp']) ? $_COOKIE['objekttyp'] : 'null');
                            $rs=$link->query($sqlPopulateobjekttyp);
                            while($row = $rs->fetch_row()) {
                                $objekttyp = $row[0];
                                echo ($objekttyp == $cookieValue ? "<option selected='selected'>$objekttyp</option>" : "<option>$objekttyp</option>");
                            }
                        ?>
                        </select>
                    </td>
                </tr>
            </table>
            <input id="btnSubmit" type=submit value="S&#246;k">
        </form>

        <!-- Display results -->
        <h2>Resultat</h2>
        <div style="width: 50%">
            <div id="theTable">G&#246;r en s&#246;kning f&#246;r att se resultatet.</div>
        </div>
    </body>
</html>
