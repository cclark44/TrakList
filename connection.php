<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traklistdb2";

$conn = mysqli_connect($servername, $username, $password, $dbname)
 or die("bad connection: ".mysqli_connect_error());

?>
