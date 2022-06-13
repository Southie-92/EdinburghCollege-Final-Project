<?php
session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");

//check if person is logged in
if(!isset($_SESSION['uID']))
{
    header("Location: index.php");
}
//set character id if coming from character select
if(isset($_POST['continue']))
{
    $_SESSION['cID']=$_POST['continue'];
    
}

if(!isset($_SESSION['gameState'])){
    $_SESSION['gameState']="story";
}


//display content depending on game state.

//display player stats
$sql="SELECT * FROM charater WHERE cID = $_SESSION[cID]";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);
$totalHealth=$row['tHealth'];
$currentHealth=$row['cHealth'];
$avatar=$row['avatar'];
$playerName=$row['playerName'];
$ATK=$row['ATK'];
$DEF=$row['DEF'];
$SPD=$row['SPD'];
$STR=$row['STR'];
$SKL=$row['SKL'];
$CHA=$row['CHA'];

$display_health ="<progress class=\"health-bar\" title=\"$currentHealth:$totalHealth\" value=\"$currentHealth\" max=\"$totalHealth\"></progress>";

//check player health and display correct image
if($currentHealth<($totalHealth*0.2)){

    $player_image="images/skull.jpg";
//$player_image="not healthy";
}
else{
$player_image="$avatar";
//$player_image="healthy";
}
//


    // load current inventory
    $sql="SELECT inventory.cID, inventory.itemID, item.name FROM inventory INNER JOIN item ON inventory.itemID=item.itemID WHERE cID =$_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) == 0) {
        $display_inventory="<p>Your bag is empty<p>";
    } else {
        $display_inventory="<ul>";
        while ($row = mysqli_fetch_array($result)) {
            $display_inventory.="<li><button id=\"$row[itemID]\" class=\"invent\" >$row[name]</button></li>";
        }
        $display_inventory.="</ul>";
    }
    $sql="SELECT charater.cID, charater.weaponID, weapon.weaponName, weapon.image FROM charater INNER JOIN weapon ON charater.weaponID=weapon.weaponID WHERE cID =$_SESSION[cID]";
    
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) == 0) {
        $display_weapons="<p>You have no weapons equipped<p>";
    } else {
        $display_weapons="<ul>";
        while ($row = mysqli_fetch_array($result)) {
            $display_weapons.="<li><button id=\"$row[weaponID]\" class=\"weapon-invent\" ><div class=\"invent-weapon\"><img class=\"images\" src=\"$row[image]\" alt=\"$row[weaponName]\"></div></button></li>";
        }
        $display_weapons.="</ul>";
    }

    

    //search for most recent played scenario and set it to display
    $sql="SELECT scenarioID FROM totalprogress WHERE cID =$_SESSION[cID] and active =1";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $dest = $row['scenarioID'];

    // load story name for display
    if(!isset($_SESSION['storyTitle'])){
        $sql="SELECT story.name, story.storyID, totalprogress.storyID FROM story INNER JOIN totalprogress ON story.storyID=totalprogress.storyID WHERE cID =$_SESSION[cID] AND active =1";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);
        $_SESSION['storyTitle']=$row['name'];
    }
    
    


    //load scenario and choices
    $sql="SELECT description FROM scenario WHERE scenarioID = $dest";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $description = $row['description'];

    $sql="SELECT choiceID, class, text FROM choice WHERE scenarioID = $dest";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $choices="";
    while ($row = mysqli_fetch_array($result)) {
        $choices.="<button id=\"$row[choiceID]\" class=\"$row[class]\" >$row[text]</button>";
    }
    //display new scenario and choices
    //insert code for display scenario and choices here

    //if game state is duel and player refreshed page change display to show continue duel button
    if($_SESSION['gameState']=="story"){
        $midPanel=<<<_END
        <div class="mid-panel-border">
            <div id="mid-panel">
                <script>choice(); duelStart();</script>
                <h2>$_SESSION[storyTitle]</h2>
                <div id="description" class="content">
                    <div class="prompt">
                            <p>
                                $description
                            </p>
                    </div>
                    $choices
                </div>
            </div>
        </div>
_END;
    }
    elseif($_SESSION['gameState']=="duel"){
    $midPanel=<<<_END
    <div class="mid-panel-border">
        <div id="mid-panel">
            <script>choice(); duelStart();</script>
            <h2>$_SESSION[storyTitle]</h2>
            <div id="description" class="prompt">
            <p>You have began a duel with your rival you can not keep them waiting.</p>
                <button class="duelStart">Continue Duel</button>
            </div>
        </div>
    </div>
_END;
    }

    $display_block=<<<_END
    <div id="player-actions" >                
        <div id="left-panel">
            <div class="player-border">
                <script>inventory();</script>
                <h2>$playerName</h2>
                <div class="player-stats">
                    <div class="game-avatar">
                        <img class="images" src="$player_image" title="character" alt="player image wah">
                    </div>
                    <div class="stats">
                        $display_health
                        <p>ATK: $ATK DEF: $DEF <br>SPD: $SPD SKL: $SKL STR: $STR CHA: $CHA </p>
                    </div>
                </div>
                <div class="inventory">
                    <div>
                        $display_weapons
                    </div>  
                    <div>
                        $display_inventory
                    </div>   
                </div>
            </div>
        </div>
        $midPanel
    </div>

    <div class="encyclopedia">
        <div class="drop-container">
            <input class="menu-btn" type="checkbox" id="menu-btn">
            <label class="menu-icon" for="menu-btn">
                <span class="nav-icon"></span>
            </label>
            <div class="dropdown">
                <div id="right-panel">
                    <div class="ency-head">
                        <script>
                            wiki();
                            searchEncyc();    
                        </script>
                        <h2>Encyclopedia</h2>
                        <div class="searchbar-container">
                            <form class="searchbar-form" action="search_display.php" method="post">
                                <input type="text" class="searchbar" name="searchbar" id="search"  placeholder="search"  aria-label="search"><br>
                                <input type="submit" id="searchEncyc" name="search" value="Search Item">
                            </form>
                        </div>
                        <div class="ency-nav">
                            <button id="home" class="encyc" >Home</button>
                            <button id="map" class="encyc" >Map</button>
                            <button id="quest" class="encyc" >Quest</button>
                            <button id="books" class="encyc" >Books</button>
                        </div>
                    </div>
                    <div class="ency-border-main">
                        <div class="ency-content">
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>
                            <p>In game encyclopedia </p>

                            
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
_END;



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tir Na Darach</title>
    <link rel="stylesheet" href="CSS.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="functions.js"></script>
</head>
<body>
    <header>
    
    <h1>Tír Na Dá Darrach</h1>
    
    <div class="nav-list">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li>
                    <div class="title-symbol"><p>Tree here</p></div>
                </li>
                <li><a href="logout.php" >Logout</a></li>
            </ul>
        </nav>
        </div>
    <div class="new-game">
        <form method="POST" action="reset.php">
            <input type="submit" name="new" value="New Game">
        </form>
    </div>
    <!-- Image loader -->
<div id='loader'>
  <img src='images/loading.gif' alt="loading" width='32px' height='32px'>
</div>
    </header>
    <div class="wrapper">
        <div id="game-board">
            <?php
           
                echo $display_block; 
            
            ?>
        </div>
    </div>
    <footer>
    
    </footer>
</body>
</html>