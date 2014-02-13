<?php
session_start();
srand(time());
$random = (rand()%9);
echo "whats the difference?!";
print "A random number between 0-9 is: $random";

$link = @mysqli_connect("mysql-vt2013.csc.kth.se:3306/stene","matfoladmin","FU0B1klD");
if (!$link) {
 die('Could not connect: ' . mysql_error());
}
$db_selected = @mysqli_select_db($link, "stene");
if (!$db_selected) {
 die ('Can\'t use selected database : ' . mysql_error());
}else{
echo "\nnnice!";
}
?>