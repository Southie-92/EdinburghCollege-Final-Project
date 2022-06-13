<?php

//game functions

// go() move to next scenario
function go($dest, $conn){
    $sql="UPDATE totalprogress SET scenarioID = $dest WHERE cID = $_SESSION[cID] and active = 1";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
// roll check
//check if a player successfully completes a roll check for specific choice and sending player to alternitive scenario upon fail
function rollCheck($value,$dest,$altDest){
    $roll=rand(1,20);
    if($roll >= $value){
        return $dest;
    }
    else{
        return $altDest;
    }
}
// take() take item and add to inventory
function take($item, $conn){
    $sql="INSERT INTO inventory VALUES ('$_SESSION[cID]', $item, NULL, NULL)";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
// give() remove item from inventory
function give($item, $conn){
    
    $sql="DELETE FROM inventory WHERE uID = $_SESSION[cID] AND itemID = $item";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
    
}
//save the chosen scenario to update after a duel has been finished
function saveLoc($dest){
     $_SESSION['destination']=$dest;
    return true;
}
//resume game
function resume($dest, $conn){
    $sql="UPDATE totoalprgress SET scenarioID = $dest WHERE cID = $_SESSION[cID] ";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
//lost duel 
function lost($conn){
    $sql="SELECT cHealth FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $health=$row['cHealth'];
    $newHealth=$health/2;
    $sql="UPDATE charater SET cHealth = $newHealth WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
//encounter
function encounter($id,$value,$conn){
    $sql="SELECT * FROM rival WHERE rID= $id AND cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $tHealth=$row['tHealth'];
    $encounter=$row['encounters'];
    $ATK=$row['ATK'];
    $DEF=$row['DEF'];
    //increase encounter to make it more likely this rival will be met again
    $newEncounter=$encounter+$value;
    //increase all rival stats
    $newATK=$ATK+1;
    $newDEF=$DEF+1;
    $newHealth=ceil($tHealth*1.05);
    //update database
    $sql="UPDATE rival SET tHealth = $newHealth, cHealth = $newHealth, ATK = $newATK, DEF = $newDEF, encounters = $newEncounter WHERE rID= $id AND cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}

function deathRival($id,$conn){
    $sql="DELETE FROM rival WHERE rID= $id AND cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
//raiseATK
function raiseATK($value,$conn){
    $sql="SELECT ATK FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $ATK=$row['ATK'];
    $newATK=$ATK+$value;
    $sql="UPDATE charater SET ATK= $newATK WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
//raiseDEF
function raiseDEF($value,$conn){
    $sql="SELECT DEF FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $DEF=$row['DEF'];
    $newDEF=$DEF+$value;
    $sql="UPDATE charater SET DEF= $newDEF WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
//raiseHealth
function raiseHealth($value,$conn){
    $sql="SELECT tHealth FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $health=$row['tHealth'];
    $newHealth=$health+($health/$value);
    $sql="UPDATE charater SET tHealth= $newHealth WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
//fullHealth
function fullHealth($conn){
    $sql="SELECT tHealth FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $health=$row['tHealth'];
    $sql="UPDATE charater SET cHealth = $health WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}
function changeQuest($storyID, $conn){
    //update active progress from total progress
}
//change game state so the page will write buttons to send the player to the duel screen
function gameState($x){
    switch ($x){
        case "1":
            $_SESSION['gameState']="story";
        break;
        case "2":
            $_SESSION['gameState']="duel";
        break;
    }

}
//equip a weapon
function equipWeapon($x, $conn){
    $id=$x;
    //get current weapon id
    $sql="SELECT cID, weaponID FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //if there is already a weapon equipped
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $oldID=$row['weaponID'];
        //update to new weapon id
        $sql="UPDATE charater SET weaponID = $id WHERE cID= $_SESSION[cID]";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        //save old weapon into inventory
        $sql="INSERT INTO inventory VALUES('$_SESSION[cID]', NULL, NULL, $oldID)";    
    }
    else
    {
        $sql="UPDATE charater SET weaponID = $id WHERE cID = $_SESSION[cID]";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
    
        
        
    
}
// use() use item update inventory perform item function


//item functions

//health() heal player if amount is a positive and takes health if amount is negative
function health($amount, $conn){
    $sql="SELECT cHealth, tHealth FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $totalHealth=$row['tHealth'];
    $currentHealth=$row['cHealth'];
    $newHealth=$currentHealth+$amount;
    if($newHealth>$totalHealth){
        $newHealth=$totalHealth;
    }
    $sql="UPDATE charater SET cHealth = $newHealth WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    return $result;
}

?>