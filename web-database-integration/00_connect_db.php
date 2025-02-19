<?php
$dbhost = "localhost";
$dbuser= "root";
$dbpass = "cs3319";
$dbname = "assign2db";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//check connection
if (!$connection) {
     die("database connection failed:" . mysqli_connect_error());
    }
?>