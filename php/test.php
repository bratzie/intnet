<?php
session_start();
srand(time());
$random = (rand()%9);
echo "whats the difference?!";
print "A random number between 0-9 is: $random";

$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	
 die('Could not connect: ' . mysql_error());
}

$sql='SELECT * FROM bostader';

$rs=$link->query($sql);

$rs->data_seek(0);
while($row = $rs->fetch_row()){
    echo $row[0] . '<br>';
}

?>
