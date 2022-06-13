<?php
session_start();
include_once("db_connect.php");
//check if person is logged in
if(!isset($_SESSION['uID']))
{
    header("Location: index.php");
}
if(!isset($_SESSION['stage'])){
    $_SESSION['stage']=1;
}
switch($_SESSION['stage']){
    case "1":


        $display_block=<<<_END
        <script> formNav(); </script>
        <h2>Part 1/4</h2>
        <input type="text" name="name" id="name" placeholder="Your character Name">
        <h3>Choose your avatar.</h3>
        <div class="avatars">
            <div class="avatar">
            <label>
                
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-2.png" unchecked>
                <img class="images" src="images/avatar/avatar-2.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-1.png" unchecked>
                <img class="images" src="images/avatar/avatar-1.png" alt="avatar image">
            </label>
            </div>
            
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-3.png" unchecked>
                <img class="images" src="images/avatar/avatar-3.png" alt="avatar image">
            </label>
            </div>
            
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-4.png" unchecked>
                <img class="images" src="images/avatar/avatar-4.png" alt="avatar image">
            </label>
            </div>
            
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-5.png" unchecked>
                <img class="images" src="images/avatar/avatar-5.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-6.png" unchecked>
                <img class="images" src="images/avatar/avatar-6.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-7.png" unchecked>
                <img class="images" src="images/avatar/avatar-7.png" alt="avatar image">
            </label>
            </div>
           
            <div class="avatar">
            <label>
                <input type="radio" name="avatar" id="avatar" value="images/avatar/avatar-8.png" unchecked>
                <img class="images" src="images/avatar/avatar-8.png" alt="avatar image">
            </label>
            </div>
            
        </div> 
        
            <button class="btn-create" id="2">Next</button>
_END;


        break;
        case "2":
            switch ($_SESSION['ATKRoll']) {
                case "0":
                    
                    
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
                    $display_rollDEF=<<<_END
                    <div>
                        <div class="roll">
                            <p> Highest ATK roll = $_SESSION[highestATKroll]</p>
                        </div> 
                    </div>
                    <div>
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
        <button class="btn-create" id="3" >Go back</button>
_END;

        $display_block=$display_weapons;


        break;
        case "5":
            //display chosen elements to user
            $sql="SELECT name,image FROM type WHERE typeID = $_SESSION[type]";
            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
            $row = mysqli_fetch_array($results);
            $typeName=$row['name'];
            $typeImage=$row['image'];
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
                <li><a href="logout.php" >Logout</a></li>
            </ul>
        </nav>
        </div>
    <!-- Image loader -->
<div id='loader'>
  <img src='images/loading.gif' alt="loading" width='32px' height='32px'>
</div>
    </header>
    <div class="wrapper"> 
    <h1 class="title">Character Creation</h1>
        <div id="character-create">
        
            <?php echo $display_block; ?>
        
        </div>
    </div>
    <footer>
    
        
    </footer>
</body>
</html>