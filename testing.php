<?php
session_start();
include_once("db_connect.php");
include_once("game_function.php");

// $sql="SELECT charater.playerName, charater.avatar, totalprogress.completed FROM charater INNER JOIN totalprogress ON charater.cID=totalprogress.cID WHERE completed = 1";
// $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
// $test="";
// while($row = mysqli_fetch_array($result)){
//     $test.="$row[playerName]$row[completed]<br>";
// }

// $sql="SELECT cID FROM charater";
//         $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//         $totalCharacters=mysqli_num_rows($result);
//         $characterArray=array();
//         while($row = mysqli_fetch_array($result)){
//             array_push($characterArray,$row['cID']);
//         }

// print_r($characterArray);

// echo $test; 

// $sql="SELECT scenarioID FROM totalprogress WHERE cID =$_SESSION[cID] and active =1";
// $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
// $row = mysqli_fetch_array($result);
// $dest = $row['scenarioID'];

// echo $dest;


// $sql="SELECT storyID, name, theme, description, finished FROM story";
// $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
// $playerStarted="";
// while ($row = mysqli_fetch_array($result)) {
//     if ($row['finished']=='yes') {
//         $playerStarted.=$row['name'] . "= finished<br>";
//     }
//     else{
//         $display_unfinished.=<<<_END
//             <div class="story">
//                 <h3>$row[name]</h3>
//                 <p>$row[theme]</p>
//                 <p>$row[description]</p>
//                 <button class="continue-story">Continue Story</button>
//                 <button class="delete-story">Delete Story</button>
//             </div>
// _END;
//     }
// }
// $display=$playerStarted ."<br>". $display_unfinished;
//  echo $display;
$sql="SELECT prompt FROM scenario WHERE scenarioID=20";
$results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
$row = mysqli_fetch_array($results);
$scenarioDesc=$row['prompt'];

$display=$scenarioDesc;
echo $display;
?>

