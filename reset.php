<?php 
session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");


//reset game to level one if new game was pressed
if (isset($_POST['new'])) {
    $sql="UPDATE totalprogress SET scenarioID = 1 WHERE cID = $_SESSION[cID] AND active=1";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
}
header("Location: game.php");


?>