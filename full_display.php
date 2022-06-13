<?php
session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");
include_once("game_function.php");


session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");
include_once("game_function.php");
//checks to see if a choice id has been sent and set variable
if (isset($_POST['choice'])) {
    $id=$_POST['choice'];
    gameState(1);
    // find the chosen choice in database
    $sql="SELECT * FROM choice where choiceID = $id";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    //set variables
    $dest=$row['targetID'];
    $altDest=$row['altTargetID'];
    $item=$row['itemID'];
    $function=$row['function'];
    $value=$row['value'];
    // check and performs required choice action
    switch ($function) {
        case "go":
            go($dest, $conn);
            break;
        case "resume":
            $dest=$_SESSION['destination'];
            unset($_SESSION['destination']);
            go($dest, $conn);
            break;
        case "take":
            take($item, $conn);
            go($dest, $conn);
            break;
        case "give":
            give($item, $conn);
            go($dest, $conn);
            break;
        case "equipWeapon":
            equipWeapon($value, $conn);
            go($dest, $conn);
            break;
        case "saveLoc":
            saveLoc($dest);
            gameState($value);
            break;
        case "rollCheck":
            $dest=rollCheck($value, $dest, $altDest);
            go($dest, $conn);
            break;
        case "raiseATK":
            raiseATK($value,$conn);
            go($dest,$conn);
            break;
        case "raiseDEF":
            raiseDEF($value,$conn);
            go($dest,$conn);
            break;
        case "raiseHealth":
            raiseHealth($value,$conn);
            go($dest,$conn);
            break;
    }
    //load new scenario
    $sql="SELECT * FROM scenario WHERE scenarioID = $dest";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    //apply any effects from scenario
    $function=$row['function'];
    $value=$row['value'];
    $description = $row['description'];
    if ($function!="NULL") {
        switch ($function) {
           case "take":
               take($item, $conn);
               go($dest, $conn);
               break;
           case "give":
               give($item, $conn);
               go($dest, $conn);
               break;
           case "health":
               health($value, $conn);
               break;
            case "lost":
                lost($conn);
                encounter($_SESSION['rivalID'],$value,$conn);
                unset($_SESSION['rivalID']);
                break;
            case "encounter":
                encounter($_SESSION['rivalID'],$value,$conn);
                unset($_SESSION['rivalID']);
                break;
            case "deathRival":
                deathRival($_SESSION['rivalID'],$conn);
                unset($_SESSION['rivalID']);
                break;
            
        }
    }
     
    //load choices
    $sql="SELECT choiceID, text, class FROM choice where scenarioID = $dest";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $choices="";
    while ($row = mysqli_fetch_array($result)) {
        $choices.="<button id=\"$row[choiceID]\" class=\"$row[class]\" >$row[text]</button>";
    }

    //display player stats
    $sql="SELECT avatar, playerName, tHealth, cHealth, ATK, DEF, SPD, SKL, STR, CHA FROM charater WHERE cID = $_SESSION[cID]";
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
    if ($currentHealth<($totalHealth*0.2)) {
        $player_image="images/skull.jpg";
    //$player_image="not healthy";
    } else {
        $player_image=$avatar;
        //$player_image="healthy";
    }
    
    // load current inventory
    $sql="SELECT inventory.cID, inventory.itemID, item.name FROM inventory INNER JOIN item ON inventory.itemID=item.itemID WHERE cID =  $_SESSION[cID] ";
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
       
    //display new scenario and choices
    //insert code for display scenario and choices here
    $display_block= <<< _END
        <div id="player-actions" >
            <div id="left-panel">
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
            <div class="mid-panel-border">
                <div id="mid-panel">
                    <script>choice(); </script>
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
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
_END;
}

echo $display_block
?>