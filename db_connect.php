<?php
//connection varibles
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "text_adventure";
//connect to server and select database
$conn = mysqli_connect($hostname, $username, $password);
  mysqli_select_db($conn, $database) or die(mysqli_error($conn)); // Connect to database if unable display error message
?>
 