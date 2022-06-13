<?php
session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");
// set session variables if the user has chosen anything or gone back to make a change
if(!isset($_SESSION['stage'])){
    $_SESSION['stage']=1;
}
if(isset($_POST['value']))
{
    $_SESSION['stage']=$_POST['value']; 
}

if($_POST['avatar']!=""){
    $_SESSION['avatar']=$_POST['avatar'];
}
if($_POST['name']!=""){
    $_SESSION['name']=$_POST['name'];
}
if($_POST['type']!=""){
    $_SESSION['type']=$_POST['type'];
}
if($_POST['weapon']!=""){
    $_SESSION['weapon']=$_POST['weapon'];
}
//break character creation into 4 seperate parts with a display and final confirmation
switch ($_SESSION['stage']) {
    case "1":

//name and avatar (avatars hardcoded for now)
        $display_block=<<<_END
        <script> formNav(); </script>
        <h2>Part 1/4</h2>
        <input type="text" name="name" id="name" placeholder="Your character Name">
        
        <h3>Your avatar</h3>
        <div class="avatars">
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-2.png">
                <img class="images" src="images/avatar/avatar-2.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-1.png">
                <img class="images" src="images/avatar/avatar-1.png" alt="avatar image">
            </label>
            </div>
            
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-3.png">
                <img class="images" src="images/avatar/avatar-3.png" alt="avatar image">
            </label>
            </div>
            
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-4.png">
                <img class="images" src="images/avatar/avatar-4.png" alt="avatar image">
            </label>
            </div>
            
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-5.png">
                <img class="images" src="images/avatar/avatar-5.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-6.png">
                <img class="images" src="images/avatar/avatar-6.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-7.png">
                <img class="images" src="images/avatar/avatar-7.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-8.png">
                <img class="images" src="images/avatar/avatar-8.png" alt="avatar image">
            </label>
            </div>
            
        </div> 
        
            <button class="btn-create" id="2">Next</button>
_END;

        break;
        //determin attack and defence stats for the game
    case "2":

        if (!isset($_SESSION['ATKRoll'])) {
            $_SESSION['ATKRoll']=0;   
        } 
        elseif(isset($_POST['ArollStage'])) {
            $_SESSION['ATKRoll']=$_POST['ArollStage'];
        }
        
       
        //new switch statement while attack and defence are being rolled
        switch ($_SESSION['ATKRoll']) {
            case "0":
                if(isset($_POST['ArollStage'])){
                    $_SESSION['ATKroll']=$_SESSION['ATKroll']+1;
                }
                
                $display_roll=<<<_END
                <div>
                    <div class="roll">
                    <p>Roll for your attack here. This will contribute to how much damage you can do. Highest out of three rolls.</p>
                    </div>
                    <button class="roll-btn" id="1">Roll</button>
                </div>
            
_END;
            break;
            case "1":
                //save highest roll in the session same for defence roll
                if(isset($_POST['ArollStage'])){
                    $_SESSION['ATKroll']=$_SESSION['ATKroll']+1;
                }
                $roll=rand(2, 12);
                $_SESSION['highestATKroll']=$roll;
                $display_roll=<<<_END
                <div>
                    <div class="roll">
                        <p> ATK Roll 1 = $roll</p>
                    </div>
                    <div class="roll">
                        <p> Highest ATK roll = $_SESSION[highestATKroll]</p>
                    </div>
                    <button class="roll-btn" id="2">Roll</button>
                </div>
_END;
            
            break;
            case "2":
                if(isset($_POST['ArollStage'])){
                    $_SESSION['ATKroll']=$_SESSION['ATKroll']+1;
                }
                $roll=rand(2, 12);
                if ($roll> $_SESSION['highestATKroll']) {
                    $_SESSION['highestATKroll']=$roll;
                }
                
                $display_roll=<<<_END
                <div>
                    <div class="roll">
                        <p> ATK Roll 2 = $roll</p>
                    </div>
                    <div class="roll">
                        <p> Highest ATK roll = $_SESSION[highestATKroll]</p>
                    </div>
                    <button class="roll-btn" id="3">Roll</button>
                </div>
_END;

            break;
            case "3":
                if(isset($_POST['ArollStage'])){
                    $_SESSION['ATKroll']=$_SESSION['ATKroll']+1;
                }
                $roll=rand(2, 12);
                if ($roll> $_SESSION['highestATKroll']) {
                    $_SESSION['highestATKroll']=$roll;
                }
                
                $display_roll=<<<_END
                <div>
                    <div class="roll">
                        <p> ATK Roll 3 = $roll</p>
                    </div>
                    <div class="roll">
                        <p> Highest ATK roll = $_SESSION[highestATKroll]</p>
                    </div>
                </div>   
                <div>  
                    <div class="roll">
                    <p>Roll for your defence here. This will help mitigate damage you take Highest out of three rolls.</p>
                    </div> 
                    <button class="roll-btn" id="5">Roll</button>
                </div>
_END;
            break;
            
            case "5":
                if(isset($_POST['DrollStage'])){
                    $_SESSION['DEFroll']=$_SESSION['DEFroll']+1;
                }
                $roll=rand(2,12);
                $_SESSION['highestDEFroll']=$roll;
                $display_rollDEF=<<<_END
                <div>
                    <div class="roll">
                        <p> Highest ATK roll = $_SESSION[highestATKroll]</p>
                    </div> 
                </div>
                <div>
                    <div class="roll">
                        <p> Roll 1 = $roll</p>
                    </div>
                    <div class="roll">
                        <p> Highest DEF roll = $_SESSION[highestDEFroll]</p>
                    </div>
                    <button class="roll-btn" id="6">Roll</button>
                </div>
_END;
                
                break;
            case "6":
                if(isset($_POST['ArollStage'])){
                    $_SESSION['ATKroll']=$_SESSION['ATKroll']+1;
                }
                $roll=rand(2,12);
                if($roll> $_SESSION['highestDEFroll']){
                    $_SESSION['highestDEFroll']=$roll;
                }
                
                $display_rollDEF=<<<_END
                <div>
                <div class="roll">
                    <p> Highest ATK roll = $_SESSION[highestATKroll]</p>
                </div> 
                </div>
                
                <div>
                    <div class="roll">
                        <p> Roll 2 = $roll</p>
                    </div>
                    <div class="roll">
                        <p> Highest DEF roll = $_SESSION[highestDEFroll]</p>
                    </div>
                    <button class="roll-btn" id="7">Roll</button>
                </div>
_END;   
                
                break;
            case "7":
                
                $roll=rand(2,12);
                if($roll> $_SESSION['highestDEFroll']){
                    $_SESSION['highestDEFroll']=$roll;
                }
                
                $display_rollDEF=<<<_END
                <div>
                    <div class="roll">
                        <p> Highest ATK roll = $_SESSION[highestATKroll]</p>
                    </div> 
                </div>
                
                <div>
                    <div class="roll">
                        <p> Roll 3 = $roll</p>
                    </div>
                    <div class="roll">
                        <p> Highest DEF roll = $_SESSION[highestDEFroll]</p>
                    </div>  
                </div>    
_END; 
                break;
        }     

    $display_block=<<<_END
    <script> formNav(); roll(); </script>
    <h2>Part 2/4</h2>
    <div class="description">
            <div class="roll-display">
                <div id="rollATK">
                    $display_roll
                </div>
                <div id="rollDEF">
                    $display_rollDEF 
                </div>
            </div>
        </div>
    
    <button class="btn-create" id="3">Next</button>
    <button class="btn-create" id="1">Go back</button>
    
_END;

        break;
    case "3":
        $sql="SELECT * FROM type";
        $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        $display_type="<h2>Part 3/4</h2><h3>Character Type</h3><p class=\"type-stats\">Choose the type of charater you want to be.</p><div class=\"avatars\">";
        while($row = mysqli_fetch_array($results)){
            $display_type.=<<<_END
            <script> formNav(); </script>
            <div class="type">
                <h3>$row[name]</h3>
                <p class="type-stats">SPD: $row[SPD] SKL: $row[SKL] STR: $row[STR] CHA: $row[CHA]</p>
                <label>
                <input type="radio" name="type" id="type" value="$row[typeID]" unchecked>
                <img class="images" src="$row[image]" alt="type image">
                <div class="description">
                <p>$row[description]</p>
                </div>
                </label>
        
            </div>
            
        _END;
        }
        $display_type.=<<<_END
        </div><button class="btn-create" id="4">Next</button>
        <button class="btn-create" id="2">Go back</button>
_END;

        $display_block=$display_type;


        break;
    case "4":
        $sql="SELECT * FROM weapon WHERE weaponID = 3 OR weaponID = 9";
        $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        $display_weapons="<h2>Part 4/4</h2><h3>Starting Weapon</h3><p class=\"type-stats\">Choose the weapon to start of your adventure.</p><div class=\"avatars\">";
        while($row = mysqli_fetch_array($results)){
            $display_weapons.=<<<_END
            <script> formNav(); </script>
            <div class="weapon">
                <h3>$row[weaponName]</h3>
                <p class="type-stats">DMG:$row[dmg] CRITDMG:$row[cDmg] STRIKE:$row[strike] FEINT:$row[feint] BLOCK:$row[block] PARRY:$row[parry]</p>
                <label>
                <input type="radio" name="weapon" id="weapon" value="$row[weaponID]" unchecked>
                <img class="images" src="$row[image]" alt="type image">
                <div class="description">
                    <p>$row[description]</p>
                </div>
                </label>
            </div>
            
        _END;
        }
        $display_weapons.=<<<_END
        </div><button class="btn-create" id="5">Next</button>
        <button class="btn-create" id="3">Go back</button>
_END;

        $display_block=$display_weapons;


        break;
        case "5":
            //display chosen elements to user
            $sql="SELECT * FROM type WHERE typeID = $_SESSION[type]";
            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            $row = mysqli_fetch_array($results);
            $typeName=$row['name'];
            $typeImage=$row['image'];
            //save values to add to character in the next stage
            $_SESSION['SPD']=$row['SPD'];
            $_SESSION['SKL']=$row['SKL'];
            $_SESSION['STR']=$row['STR'];
            $_SESSION['CHA']=$row['CHA'];
            $sql="SELECT weaponName,image FROM weapon WHERE weaponID = $_SESSION[weapon]";
            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            $row = mysqli_fetch_array($results);
            $weaponName=$row['weaponName'];
            $weaponImage=$row['image'];
            $display_block=<<<_END
            <script> formNav(); </script>
            <h2>Confirmation<h2>
            <div class="confirm-nav">
            <button class="btn-create" id="1" >Stage 1</button>
            <button class="btn-create" id="2" >Stage 2</button>
            <button class="btn-create" id="3" >Stage 3</button>
            <button class="btn-create" id="4" >Stage 4</button>
            </div>
            <h3>$_SESSION[name]</h3>
            <p class="type-stats">
            ATK:$_SESSION[highestATKroll]
            DEF:$_SESSION[highestDEFroll]
            </p>
            <div class="final-character">
                
                <div class="avatar-confirm">
                    <img src="$_SESSION[avatar]" alt= "player avatar">
                </div>
                <div class="avatar-confirm">
                
                <img src="$typeImage" alt= "player type">
                </div>
                <div class="avatar-confirm">
                <img src="$weaponImage" alt= "player weapon">
                </div>
            </div>
            <button class="btn-create" id="6" >Confirm Character</button>
_END;
        break;
        case "6":
            // insert charater to database and generate random rivals with the new character id
            $sql ="INSERT INTO charater VALUES(NULL,'$_SESSION[uID]','$_SESSION[avatar]','$_SESSION[name]','$_SESSION[type]', 200, 200, '$_SESSION[highestATKroll]','$_SESSION[highestDEFroll]','$_SESSION[SPD]','$_SESSION[SKL]','$_SESSION[STR]','$_SESSION[CHA]','$_SESSION[weapon]')";
            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            //clear session memory
            unset($_SESSION['avatar']); unset($_SESSION['highestATKroll']); unset($_SESSION['highestDEFroll']); unset($_SESSION['name']); unset($_SESSION['type']); unset($_SESSION['weapon']); unset($_SESSION['SPD']); unset($_SESSION['SKL']); unset($_SESSION['STR']); unset($_SESSION['CHA']);
            //select new character to get id by ordering from highest to lowest
            $sql="SELECT cID from charater WHERE uID = $_SESSION[uID] ORDER BY cID DESC";
            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            $row = mysqli_fetch_array($results);
            //set character as logged in, in session 
            $_SESSION['cID']=$row['cID'];
            // set progress in database at the beginning
            $sql="INSERT INTO totalprogress VALUES ($_SESSION[cID],1,1,1,0)";
            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            //set array of rival names this will be replaced later
            $maleNames=array('Oisín','Finn','Fionn','Cian','Darragh','Cillian','Rian','Tadgh','Eoghan','Odhran','Donnacha','Ruari','Conor','Fiachra','Daithi','Fergal');
            $maleNameSIze=sizeof($maleNames)-1;
            $femaleNames=array('Caoimhe','Saoirse','Ciara','Niamh','Roisin','Clodagh','Aisling','Sadhbh','Eimear','Meabh','Sinead','Fiona','Siobhan','Dearbhla','Bronagh');
            $femaleNameSIze=sizeof($femaleNames)-1;
            $suffixList=array('the Crazed','the Gentle','the Mad','the Brave','the Craven','the Gallant','the Saint','the Just','the Kind','the Impaler','the Weak','the Strong','the Bard');
            $suffixListSIze=sizeof($suffixList)-1;
            // two for loops to create rivals two male and two female
            for($i=0;$i<2;$i++){
                // generate rival name and attack and defence values and avatar
                $rivalName=$maleNames[rand(0,$maleNameSIze)]." ".$suffixList[rand(0,$suffixListSIze)];
                $r_ATK=rand(6,15);
                $r_DEF=rand(6,15);
                $avatars=array(2,4,6,8);
                $avatar=$avatars[rand(0,3)];
                // select a type by randomly querying the database
                $sql="SELECT typeID FROM type ORDER BY RAND() LIMIT 1";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                $row = mysqli_fetch_array($results);
                $type=$row['typeID'];
                //find attributes for type
                $sql="SELECT SPD, SKL, STR, CHA FROM type WHERE typeID = $type";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                $row = mysqli_fetch_array($results);
                $SPD=$row['SPD'];
                $SKL=$row['SKL'];
                $STR=$row['STR'];
                $CHA=$row['CHA'];
                $sql="SELECT weaponID FROM weapon ORDER BY RAND() LIMIT 1";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                $row = mysqli_fetch_array($results);
                $weapon=$row['weaponID'];
                //insert into the rival table
                //random health equal or lower to player
                $health=rand(150,200);
                $sql="INSERT INTO rival VALUES(NULL,'$_SESSION[cID]','images/avatar/avatar-$avatar.png','$rivalName', $type, $health, $health, $r_ATK, $r_DEF, $SPD, $SKL, $STR, $CHA, $weapon, 0)";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            }
            for($i=0;$i<2;$i++){
                // generate rival name and attack and defence values and avatar
                $rivalName=$femaleNames[rand(0,$femaleNameSIze)]." ".$suffixList[rand(0,$suffixListSIze)];
                $r_ATK=rand(6,15);
                $r_DEF=rand(6,15);
                $avatars=array(1,3,5,7);
                $avatar=$avatars[rand(0,3)];
                // select a type by randomly querying the database
                $sql="SELECT typeID FROM type ORDER BY RAND() LIMIT 1";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                $row = mysqli_fetch_array($results);
                $type=$row['typeID'];
                //find attributes for type
                $sql="SELECT SPD, SKL, STR, CHA FROM type WHERE typeID = $type";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                $row = mysqli_fetch_array($results);
                $SPD=$row['SPD'];
                $SKL=$row['SKL'];
                $STR=$row['STR'];
                $CHA=$row['CHA'];
                $sql="SELECT weaponID FROM weapon ORDER BY RAND() LIMIT 1";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                $row = mysqli_fetch_array($results);
                $weapon=$row['weaponID'];
                //insert into the rival table
                //random health equal or lower to player
                $health=rand(150,200);
                $sql="INSERT INTO rival VALUES(NULL,'$_SESSION[cID]','images/avatar/avatar-$avatar.png','$rivalName', $type, $health, $health, $r_ATK, $r_DEF, $SPD, $SKL, $STR, $CHA, $weapon, 0)";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            }
            $display_block=<<<_END
            <div class="description">
                <p>Your character and rivals have been created enjoy your adventure.</p>
            </div>
            <div>
                <form action="game.php"><input type="submit" value="Enter Game"></form>
            </div>
            <div>
                <form action="home.php"><input type="submit" value="Go back to Character Select"></form>
            </div>
_END;
        break;
}



echo $display_block;

?>