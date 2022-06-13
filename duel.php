<?php
session_start();

include_once("game_function.php");
//----------------------------
//if the fight has just began sql query for information and save results to session array if fight is continuing it will already be set
//determine player stats and rival stats
//sql query save to session array
if (!isset($_SESSION['player']) && !isset($_SESSION['rival'])) {
    //Connect to database through seperate page
    include_once("db_connect.php");
    //save information from the story to the sessions the player can progress after
    $id=$_POST['choice'];
    // find the chosen choice in database
        $sql="SELECT * FROM choice where choiceID = $id";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);
        //set variables
        $dest=$row['targetID'];
        $altDest=$row['altTargetID'];
        $function=$row['function'];
        $value=$row['value'];
        // check and performs required choice action
        switch ($function)
        {
            case "saveLoc":
                saveLoc($dest);
                gameState($value);
                break;
            
        }
    //set player details into the session 
    $sql="SELECT cID, avatar, playerName, tHealth, cHealth, ATK, DEF, SPD, SKL, STR, CHA, weaponID FROM charater WHERE cID = $_SESSION[cID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $_SESSION['player'] = array(
    "avatar" => "$row[avatar]", "name" => "$row[playerName]" ,"ttlHealth"=>"$row[tHealth]","crrHealth"=>"$row[cHealth]", "ATK"=>"$row[ATK]","DEF"=>"$row[DEF]","SPD"=>"$row[SPD]","SKL"=>"$row[SKL]", "STR"=>"$row[STR]", "CHA"=>"$row[CHA]"
    );
    
    //set player weapon into the session
    $sql="SELECT weaponName, type, dmg, cDmg, strike, feint, parry, block, image FROM weapon WHERE weaponID=$row[weaponID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $_SESSION['playerWeapon']=array("name"=>"$row[weaponName]", "type"=>"$row[type]","dmg" => "$row[dmg]", "cDmg" => "$row[cDmg]", "strike" => "$row[strike]", "feint" => "$row[feint]", "block" => "$row[block]", "parry" => "$row[parry]", "image" => "$row[image]");
    //set rival into the session
    //query for rival with highest encounters
    $sql="SELECT rID, cID, avatar, rivalName, tHealth, cHealth, ATK, DEF, SPD, SKL, STR, CHA, weaponID, encounters FROM rival WHERE cID = $_SESSION[cID] ORDER BY encounters DESC";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    //set rival id and into the session this will be used later to update the rival
    $_SESSION['rivalID']=$row['rID'];
    $_SESSION['rival'] = array(
        "avatar" => "$row[avatar]",  "name" => "$row[rivalName]" ,"ttlHealth"=>"$row[tHealth]","crrHealth"=>"$row[cHealth]", "ATK"=>"$row[ATK]","DEF"=>"$row[DEF]","SPD"=>"$row[SPD]","SKL"=>"$row[SKL]", "STR"=>"$row[STR]", "CHA"=>"$row[CHA]"
    );
    //set rival weapon into session
    $sql="SELECT weaponName, type, dmg, cDmg, strike, feint, parry, block, image FROM weapon WHERE weaponID=$row[weaponID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    $row = mysqli_fetch_array($result);
    $_SESSION['rivalWeapon']=array("name"=>"$row[weaponName]", "type"=>"$row[type]","dmg" => "$row[dmg]", "cDmg" => "$row[cDmg]", "strike" => "$row[strike]", "feint" => "$row[feint]", "block" => "$row[block]", "parry" => "$row[parry]", "image" => "$row[image]");
    //sql query roll checks from database amd save to array
    $sql = "SELECT * FROM checks";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $name=$row['name'];
    $value=$row['value'];
    $_SESSION['check']="";
    while($row = mysqli_fetch_array($result)){
    $_SESSION[$row['name']]=$row['value'];
    }
 }

// set variables from session this stop issues of array to string conversion when outputting messages
$p_name = $_SESSION['player']['name'];
$p_avatar = $_SESSION['player']['avatar'];
$r_name = $_SESSION['rival']['name'];
$r_avatar = $_SESSION['rival']['avatar'];
$p_crtHealth = $_SESSION['player']['crrHealth'];
$p_ttlHealth = $_SESSION['player']['ttlHealth'];
$r_crtHealth = $_SESSION['rival']['crrHealth'];
$r_ttlHealth = $_SESSION['rival']['ttlHealth'];
$p_CHA = $_SESSION['player']['CHA'];
$r_CHA = $_SESSION['rival']['CHA'];
$p_SPD = $_SESSION['player']['SPD'];
$r_SPD = $_SESSION['rival']['SPD'];
$p_SKL = $_SESSION['player']['SKL'];
$r_SKL = $_SESSION['rival']['SKL'];
$p_STR = $_SESSION['player']['STR'];
$r_STR = $_SESSION['rival']['STR'];
$p_DEF = $_SESSION['player']['DEF'];
$r_DEF = $_SESSION['rival']['DEF'];
$p_ATK = $_SESSION['player']['ATK'];
$r_ATK = $_SESSION['rival']['ATK'];

$p_weaponName = $_SESSION['playerWeapon']['name'];
$p_weaponType = $_SESSION['playerWeapon']['type'];
$p_weaponDmg = $_SESSION['playerWeapon']['dmg'];
$p_weaponCDmg = $_SESSION['playerWeapon']['cDmg'];
$p_weaponStrike = $_SESSION['playerWeapon']['strike'];
$p_weaponFeint = $_SESSION['playerWeapon']['feint'];
$p_weaponBlock = $_SESSION['playerWeapon']['block'];
$p_weaponParry = $_SESSION['playerWeapon']['parry'];
$p_weaponImage = $_SESSION['playerWeapon']['image'];

$r_weaponName = $_SESSION['rivalWeapon']['name'];
$r_weaponType = $_SESSION['rivalWeapon']['type'];
$r_weaponDmg = $_SESSION['rivalWeapon']['dmg'];
$r_weaponCDmg = $_SESSION['rivalWeapon']['cDmg'];
$r_weaponStrike = $_SESSION['rivalWeapon']['strike'];
$r_weaponFeint = $_SESSION['rivalWeapon']['feint'];
$r_weaponBlock = $_SESSION['rivalWeapon']['block'];
$r_weaponParry = $_SESSION['rivalWeapon']['parry'];
$r_weaponImage = $_SESSION['rivalWeapon']['image'];

$checkStrike=$_SESSION['strike'];
$checkFeint=$_SESSION['feint'];
$checkTaunt=$_SESSION['taunt'];
$checkBlock=$_SESSION['block'];
$checkDodge=$_SESSION['dodge'];
$checkParry=$_SESSION['parry'];

//open a div class of output for message
$output=""; 
//determine if choice was made and apply results to the table
if(isset($_POST['move'])){
    //set roll number
    $roll=rand(1,10)+rand(1,10);
    //set variable for move chosen
    $move = $_POST['move'];
    //have chosen move perform correct action
    switch ($move){
        case "strike":
            //check bonus from previous round are set
            //player bonus
            if(isset($_SESSION['playerBonus'])){
                $roll=$roll+$_SESSION['playerBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['playerBonus']);
            }
            //rival bonus
            if(isset($_SESSION['rivalBonus'])){
                $playerDEF=$_SESSION['player']['DEF']-$_SESSION['rivalBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['rivalBonus']);
            }
            else{
                $playerDEF=$_SESSION['player']['DEF'];
            }
            //check if player was successful or not and apply damage accordingly
            if(strike($_SESSION['strike'],$roll,$p_weaponStrike,$r_weaponBlock,$p_STR,$r_STR)==true){
                $damage=calcDamage($p_weaponDmg,$p_ATK,$r_DEF,1);
                // $output.="<p> Your roll was $roll.</p>";
                // $output.="<p> The damage was $damage.</p>";
                $output.="<p>You break through $r_name's guard and land your attack.</p>";
                //take health from rival
                $r_crtHealth=$r_crtHealth-$damage;
                $_SESSION['rival']['crrHealth'] = $r_crtHealth;
            }
            else{
                $output.="<p>$r_name's guard is too strong and fast. Your attack does no damage.</p>";
               
            }
        break;
        case "feint":
            //check bonus from previous round are set
            //player bonus
            if(isset($_SESSION['playerBonus'])){
                $roll=$roll+$_SESSION['playerBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['playerBonus']);
            }
            //rival bonus
            if(isset($_SESSION['rivalBonus']))
            {
                $playerDEF=$_SESSION['player']['DEF']-$_SESSION['rivalBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['rivalBonus']);
            }
            else
            {
                $playerDEF=$_SESSION['player']['DEF'];
            }
            //check if player was successful or not and apply damage accordingly
            if(feint($_SESSION['feint'],$roll,$p_weaponFeint,$r_weaponFeint,$p_SKL,$r_SKL)==true)
            {
                $damage=calcDamage($p_weaponDmg,$_SESSION['player']['ATK'],$r_DEF,$p_weaponCDmg);
                // $output.="<p> Your roll was $roll.</p>";
                // $output.="<p> The damage was $damage.</p>";
                $output.="<p>You feint an attack to the left. As $r_name moves to defend you quickly pull back and strike to the right landing a hit under their guard</p>";
                //take health from rival
                $r_crtHealth=$r_crtHealth-$damage;
                $_SESSION['rival']['crrHealth'] = $r_crtHealth;

            }
            else
            {
                $damage=calcDamage($r_weaponDmg,$_SESSION['rival']['ATK'],$playerDEF,$r_weaponCDmg);
                // $output.="<p> Your roll was $roll.</p>";
                // $output.="<p> The damage was $damage.</p>";
                $output.="<p>You feint an attack high but as you turn to attack $r_name low they are ready. Knocking away your attack and landing a counter on you. You take damage.</p>";
                //take health from player
                $p_crtHealth=$p_crtHealth-$damage;
                $_SESSION['player']['crrHealth'] = $p_crtHealth;
            }
        break;

        case "taunt":
            //check bonus from previous round are set
            //player bonus
            if(isset($_SESSION['playerBonus']))
            {
                $roll=$roll+$_SESSION['playerBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['playerBonus']);
            }
            //rival bonus
            if(isset($_SESSION['rivalBonus']))
            {
                $playerDEF=$_SESSION['player']['DEF']-$_SESSION['rivalBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['rivalBonus']);
            }
            else
            {
                $playerDEF=$_SESSION['player']['DEF'];
            }
            //check if player was successful or not create a bonus to add to a roll next round
            if(taunt($_SESSION['taunt'],$roll,$p_CHA,$r_CHA)==true)
            {
                $_SESSION['playerBonus']=rand(2,5);
                
                // $output.="<p> Your roll was $roll.</p>";
                $output.="<p> Your bonus next turn is $_SESSION[playerBonus].</p>";
                $output.="<p>Angered by your mean taunt $r_name lunges at you. They miss and and go off balance giving an advantage next turn.</p>";
                

            }
            else
            {
                
                $_SESSION['rivalBonus']=($_SESSION['player']['DEF'])*0.75;

                // $output.="<p> Your roll was $roll.</p>";
                $output.="<p> Your defence is lowered $_SESSION[rivalBonus].</p>";
                $output.="<p>Angered by you words $r_name comes at you with a series of heavy attacks. You hold of their attacks this time but your defence is lowered next turn.</p>";
                //on fail random 1/3 chance of taking damage
                $chance=rand(1,3);
                if($chance==1)
                {
                   //take health from player
                   $damage=calcDamage($r_weaponDmg,$_SESSION['player']['ATK'],$_SESSION['rival']['DEF'],1);
                    $p_crtHealth=$p_crtHealth-$damage;
                    $_SESSION['player']['crrHealth'] = $p_crtHealth; 
                    $output.="<p>You look down and notice $r_name must have landed a blow during the dodge. You take damage</p>";
                }
            }
        break;

        case "block":
            //check bonus from previous round are set
            //player bonus
            if(isset($_SESSION['playerBonus']))
            {
                $roll=$roll+$_SESSION['playerBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['playerBonus']);
            }
            //rival bonus
            if(isset($_SESSION['rivalBonus']))
            {
                $playerDEF=$_SESSION['player']['DEF']-$_SESSION['rivalBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['rivalBonus']);
            }
            else
            {
                $playerDEF=$_SESSION['player']['DEF'];
            }
            //check if player was successful or not and apply damage accordingly
            if(block($_SESSION['block'],$roll,$p_weaponBlock,$r_weaponStrike)==true)
            {
                // $output.="<p> Your roll was $roll.</p>";
                $output.="<p>$r_name steps forward and attacks. You raise your weapon to theirs and hold strong taking no damage</p>";
            }
            else
            {
                $damage=calcDamage($r_weaponDmg,$_SESSION['rival']['ATK'],$playerDEF,1);
                // $output.="<p> Your roll was $roll.</p>";
                // $output.="<p> The damage was $damage.</p>";
                $output.="<p>$r_name attacks quickly. you raise your weapon to defend but too late. The attack land and you take damage.</p>";
                //take health from player
                $p_crtHealth=$p_crtHealth-$damage;
                $_SESSION['player']['crrHealth'] = $p_crtHealth;
            }
        break;

        case "dodge":
            //check bonus from previous round are set
            //player bonus
            if(isset($_SESSION['playerBonus']))
            {
                $roll=$roll+$_SESSION['playerBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['playerBonus']);
            }
            //rival bonus
            if(isset($_SESSION['rivalBonus']))
            {
                $playerDEF=$_SESSION['player']['DEF']-$_SESSION['rivalBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['rivalBonus']);
            }
            else
            {
                $playerDEF=$_SESSION['player']['DEF'];
            }
            //check if player was successful or not and apply damage accordingly
            if(dodge($_SESSION['dodge'],$roll,$p_SPD,$r_SPD)==true)
            {
                $_SESSION['playerBonus']=rand(2,5);
                // $output.="<p> Your roll was $roll.</p>";
                $output.="<p> Your bonus next turn is $_SESSION[playerBonus].</p>";
                $output.="<p>$r_name swings at you. You step quickly to the right missing $r_name's blow receiving a bonus next round.</p>";
                

            }
            else
            {
                
                $_SESSION['rivalBonus']=($_SESSION['player']['DEF'])*0.75;
                // $output.="<p> Your roll was $roll.</p>";
                $output.="<p> You DEF is lowered $_SESSION[rivalBonus] next turn.</p>";
                $output.="<p>As $r_name moves towards you to attack you step to your left. $r_name quickly adjusts and hits you with the hilt of their weapon taking the wind ut of you. Your defence is lowered next turn.</p>";
                //on fail random 1/3 chance of taking damage
                $chance=rand(1,3);
                if($chance==1)
                {
                   //take health from player
                   $damage=calcDamage($r_weaponDmg,$_SESSION['player']['ATK'],$_SESSION['rival']['DEF'],1);
                    $p_crtHealth=$p_crtHealth-$damage;
                    $_SESSION['player']['crrHealth'] = $p_crtHealth;
                    $output.="<p>You look down and notice $r_name must have landed a blow during the dodge. You take damage</p>"; 
                }
            }
        break;

        case "parry":
            //check bonus from previous round are set
            //player bonus
            if(isset($_SESSION['playerBonus']))
            {
                $roll=$roll+$_SESSION['playerBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['playerBonus']);
            }
            //rival bonus
            if(isset($_SESSION['rivalBonus']))
            {
                $playerDEF=$_SESSION['player']['DEF']-$_SESSION['rivalBonus'];
                //unset the bonus so it wont affect future rounds
                unset($_SESSION['rivalBonus']);
            }
            else
            {
                $playerDEF=$_SESSION['player']['DEF'];
            }
            //check if player was successful or not and apply damage accordingly
            if(parry($_SESSION['parry'],$roll,$p_weaponParry,$r_weaponParry,$p_SKL,$r_SKL)==true)
            {
                $damage=calcDamage($p_weaponDmg,$_SESSION['player']['ATK'],$_SESSION['rival']['DEF'],$p_weaponCDmg);
                // $output.="<p> Your roll was $roll.</p>";
                // $output.="<p> The damage was $damage.</p>";
                $output.="
                    <p>$r_name strikes quickly at you but you are ready. You bring your weapon to meet theirs and deflect the blow. $r_name is left wide open and you quickly take advantage. Dealing massive damage. </p>
                    
                    ";
                //take health from rival
                $r_crtHealth=$r_crtHealth-$damage;
                $_SESSION['rival']['crrHealth'] = $r_crtHealth;

            }
            else
            {
                $damage=calcDamage($r_weaponDmg,$_SESSION['rival']['ATK'],$playerDEF,$r_weaponCDmg);
                // $output.="<p> Your roll was $roll.</p>";
                // $output.="<p> The damage was $damage.</p>";
                $output.="
                    <p>You attempt to parry $r_name's next attack. You are too slow and are left wide open. $r_name strikes again landing a critical hit. You take massive damage</p>
                    
                    ";
                //take health from player
                $p_crtHealth=$p_crtHealth-$damage;
                $_SESSION['player']['crrHealth'] = $p_crtHealth;
               
            }
        break;
    }
    //change the phase so player from attacking to defending or vice versa
    if($_SESSION['phase'] == true)
    {
        $_SESSION['phase'] = false;
       
    }
    else
    {
        $_SESSION['phase'] = true;
        
    }
}
else{
    $move = "";
}
//--------------------------------------------------------


//check to see if either player or rival lost in the last turn
if($_SESSION['player']['crrHealth'] < 1 || $_SESSION['rival']['crrHealth'] < 1)
{
    
    //unset phase so it doesn't influence next duel
    unset($_SESSION['phase']);
    //update sql database
    if($_SESSION['player']['crrHealth'] <= 0)
    {
        // set heth to 0 incase it was minus
        $p_crtHealth = 0;
        //clear session or player and rival
        unset($_SESSION['player']);
        unset($_SESSION['rival']);
        unset($_SESSION['phase']);
        unset($_SESSION['check']);
        unset($_SESSION['rivalWeapon']);
        unset($_SESSION['playerWeapon']);
        $action= "
            <script> duelEnd();</script>
            <p>Sorry you have lost this duel. Learn from your mistakes and strive to do better for your opponent will only grow stronger from this encounter.<p>
            <div>
            <button id=\"11\" class=\"duelEnd\">Continue</button>
            </div>
            ";
    }
    else
    {
        // set heth to 0 incase it was minus
        $r_crtHealth = 0;
        unset($_SESSION['player']);
        unset($_SESSION['rival']);
        unset($_SESSION['phase']);
        unset($_SESSION['check']);
        unset($_SESSION['rivalWeapon']);
        unset($_SESSION['playerWeapon']);
        $action= "
        <script> duelEnd();</script>
        <p>You have won this duel today. Do not let victory go to your head. Get stronger and keep moving forward. </p>
        <div>
        <button id=\"13\" class=\"duelEnd\">Continue</button>
        </div>
        ";
    }
}
else //duel goes on
{
    
    //if duel has just commenced determine wether attacking or defending first
    //query SPD stat from players
    //set variable called $_SESSION['phase'] to be true or false 
    //this variable will be used to determine wether you are defending or attacking
    if(!isset($_SESSION['phase'])){
        if(($_SESSION['player']['SPD']) > ($_SESSION['rival']['SPD']))
        {
            $_SESSION['phase'] = true;
            //means player is attacking first
        }
        else
        {
            $_SESSION['phase'] = false;
            // player is defending first
        }
    }


    if($_SESSION['phase'] == true)
    {
        
        $action=<<<_END
        
        <script> duel(); </script>
        <p>You stand ready to attack. Do you..</p>
        <div>
        <button id="strike" class="duel">strike</button>
        <button id="feint" class="duel">Feint</button>
        <button id="taunt" class="duel">Taunt</button><br>
        </div>
        
        
       
_END;
    }
    else
    {
        
        $action=<<<_END
        
        <script> duel(); </script>
        <p>Your rival stands before you poised to strike. Do you..</p>
        <div>
        <button id="block" class="duel">Block</button>
        <button id="parry" class="duel">Parry</button>
        <button id="dodge" class="duel">Dodge</button><br>
        </div>
        
        
        
_END;
    }
}
//game functions
//strike
//function takes value to check against, the players roll, the players weapon strike value and the rival weapons block value
//this add the roll to the players weapon and compares to the check value plus the rival weapon
//returns true if a successful attack and false if failed 
function strike($check,$roll,$pATK,$rDEF,$p_STR,$r_STR){
    
    if(($roll+$pATK+$p_STR)>=($check+$rDEF+$r_STR)){
        return true; 
    }
    else{
        return false; 
    } 
}
//feint
//works same as previous function but uses weapon feint value
function feint($check,$roll,$pATK,$rDEF,$p_SKL,$r_SKL){
    if(($roll+$pATK+($p_SKL))>=($check+$rDEF+($r_SKL))){
        return true; 
    }
    else{
        return false;  
    }
}
//taunt
//check player and rivals charisma
function taunt($check,$roll,$p_CHA,$r_CHA){
    if(($roll+($p_CHA))>=($check+($r_CHA))){
        return true;  
    }
    else{
         return false; 
    }

}
//block
function block($check,$roll,$pATK,$rDEF){
    if(($roll+$pATK)>=($check+$rDEF)){
        return true;  
    }
    else{
         return false;   
    }
}
//dodge
function dodge($check,$roll,$p_SPD,$r_SPD){ 
    if(($roll+($p_SPD))>=($check+($r_SPD))){
        return true;
    }
    else{
        return false;  
    }
}
//parry
function parry($check,$roll,$pATK,$rDEF,$p_SKL,$r_SKL){
    if(($roll+$pATK+($p_SKL))>=($check+$rDEF+($r_SKL))){
        return true; 
    }
    else{
        return false;  
    }
}
//calcDamage
// function takes the weapon damage the players damage and a modifier and calculates the damage done
function calcDamage($weapon, $ATK, $DEF, $modifier){ 
    $total=0;
    for ($x = 0; $x < $weapon; $x+=1){
        $total=$total+rand(4,6);
    }
    $plus=($ATK*$modifier);
    $damage=($total+$plus)-$DEF;
    $final=ceil($damage);
    return $final;
}
//critDamage
function critDamage($totalHealth, $crit){
    $damage=($totalHealth/100)*$crit;
    return $damage;
}
$player_display=<<<_END
<div id="player-panel">
    <h2>$p_name</h2>
        <div class="player-stats">
            <div class="game-avatar">
                <img class="images" src="$p_avatar" title="character" alt="player image wah">
            </div>
            <div class="stats">
                <progress class="health-bar" value="$p_crtHealth" max="$p_ttlHealth"></progress>
                <p>ATK: $p_ATK DEF: $p_DEF <br>SPD: $p_SPD SKL: $p_SKL STR: $p_STR CHA: $p_CHA </p>
            </div>
        </div>
    <div class="drop-container"> 
        <input class="menu-btn" type="checkbox" id="menu-btn">
        <label class="menu-icon" for="menu-btn">
            <span class="nav-icon"></span>
        </label>
        <div class="dropdown">
            <h3>$p_weaponName</h3>
            <div class="weapon-display">    
                    
                <div class="player-stats">
                    <div class="weapon-avatar">
                        <img class="images" src="$p_weaponImage">
                    </div>
                    <div class="stats">
                        <p>DMG:$p_weaponDmg CRT:$p_weaponCDmg STRIKE:$p_weaponStrike<br> FEINT:$p_weaponFeint BLOCK:$p_weaponBlock PARRY:$p_weaponParry </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
_END;

$duel_display=<<<_END
<div id="display-panel">
    <div class="duel-message">
        $output
    </div>
    <div class="duel-action">
        $action
    </div>
</div>
_END;


$rival_display=<<<_END
<div id="rival-panel">
    <h2>$r_name</h2>
    <div class="player-stats">
        <div class="game-avatar">
            <img class="images" src="$r_avatar" title="character" alt="player image wah">
        </div>
        <div class="stats">
            <progress class="health-bar" value="$r_crtHealth" max="$r_ttlHealth"></progress>
            <p>ATK: $r_ATK DEF: $r_DEF <br>SPD: $r_SPD SKL: $r_SKL STR: $r_STR CHA: $r_CHA </p>
        </div>
    </div>

    <div class="drop-container"> 
        <input class="menu-btn" type="checkbox" id="menu-btn-2">
        <label class="menu-icon" for="menu-btn-2">
            <span class="nav-icon"></span>
        </label>
        <div class="dropdown">
            <h3>$r_weaponName</h3>
            <div class="weapon-display">    
                
                <div class="player-stats">
                    <div class="weapon-avatar">
                        <img class="images" src="$r_weaponImage">
                    </div>
                    <div class="stats">
                        <p>DMG:$r_weaponDmg CRT:$r_weaponCDmg STRIKE:$r_weaponStrike<br> FEINT:$r_weaponFeint BLOCK:$r_weaponBlock PARRY:$r_weaponParry </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
_END;




echo $player_display;
echo $duel_display;
echo $rival_display;


?>

