<?php
session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");

//if no one is logged in set page to default
if(!isset($_SESSION['uID'])){
    $display_block=<<<_END
    
    <p><a href="index.php" >Login</a> to create a character and player or search through the encyclopedia and learn more about Tir Na Darrach</p>
    
    _END;
}
else{
    // check if user is an admin and display admin bar if they are
    $sql="SELECT adminlevel from user where uID =$_SESSION[uID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $case =$row['adminlevel'];
    //show diferent display based on admin level
    $script="<script> adminNav(); </script>";
    switch($case){
        // 0 means user only no admin privllages
        case "0":
            $adminDisplay=<<<_END
            $case
            <form method="POST" action="admin.php">
                <div class="admin-nav">
                    <div class="settings-btn">      
                        <button type="submit" value="1" name="submit"><img src="images/settingsIcon.png" class="images" alt="Settings"></button>
                    </div>
                </div> 
            </form>
_END;
        break;
        // 1 means the are story contributers and can upload new scenarios and choices
        case "1":
            $adminDisplay=<<<_END
            $case
            <form method="POST" action="admin.php">
            <div class="admin-nav">
                <div class="settings-btn">      
                    <button type="submit" value="1" name="submit"><img src="images/settingsIcon.png" class="images" alt="Settings"></button>
                </div>
                <div class="admin-btn">
                    <button type="submit"  name="submit" value="3">Characters</button>
                </div>
                <div class="admin-btn">
                    <button type="submit"  name="submit" value="2">Story</button>
                </div> 
            </div> 
        </form>
_END;
            break;
            //means full admin privlages 
        case "2":
            $adminDisplay=<<<_END
            $case
                
            <form method="POST" action="admin.php">
                <div class="admin-nav">
                    <div class="settings-btn">      
                        <button type="submit" value="1" name="submit"><img src="images/settingsIcon.png" class="images" alt="Settings"></button>
                    </div>
                    <div class="admin-btn">
                        <button type="submit"  name="submit" value="4">Users</button>
                    </div>
                    <div class="admin-btn">
                        <button type="submit"  name="submit" value="3">Characters</button>
                    </div>
                    <div class="admin-btn">
                        <button type="submit"  name="submit" value="2">Story</button>
                    </div> 
                </div> 
            </form>
                
            
_END;
            break;
    }


    $display_block="<script>charDelete();</script>";
    $sql="SELECT charater.cID, charater.playerName, charater.avatar,  charater.tHealth, charater.cHealth, charater.weaponID, weapon.image FROM charater INNER JOIN weapon ON charater.weaponID=weapon.weaponID WHERE uID = $_SESSION[uID]";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //each user can have two characters if they have two display
    if(mysqli_num_rows($result) == 2){
        while ($row = mysqli_fetch_array($result)) {
            $totalHealth=$row['tHealth'];
            $currentHealth=$row['cHealth'];
            $display_block.=<<<_END

            <div class="character">
                <div>
                    <h3>$row[playerName]</h3>
                </div>
                <div class="avatar-home">
                    <div class="avatar">
                        <img class="images" src="$row[avatar]" alt="player avatar">
                    </div>
                    <div class="avatar">
                        <img class="images" src="$row[image]" alt="player avatar">
                    </div>
                </div>
                <div>
                    <progress class="health-bar" title="$currentHealth:$totalHealth" value="$currentHealth" max="$totalHealth"></progress>
                </div>
                <div>
                    <form action="game.php" method="POST">
                    <input type="hidden" id="char" value="$row[cID]" name="continue">
                    <input type="submit" value="Continue">
                    </form>
                    <button id="$row[cID]" class="deleteCharacter">Delete</button>
                </div>
            </div>
                    
_END;
        }
         
    }
    elseif(mysqli_num_rows($result) ==1){
        $row = mysqli_fetch_array($result);
        $totalHealth=$row['tHealth'];
        $currentHealth=$row['cHealth'];
        $display_block.=<<<_END
        <div class="character">
            <h3>
                $row[playerName]
            </h3>
            <div class="avatar-home">
                <img src="$row[avatar]" alt="player avatar">
            </div>
            <div>
                <progress class="health-bar" title="$currentHealth:$totalHealth" value="$currentHealth" max="$totalHealth"></progress>
            </div>
            <div>
                <form action="game.php" method="POST">
                <input type="hidden" value="$row[cID]" name="continue">
                 <input type="submit"  value="Continue">
                 </form>
                 <button class="deleteCharacter">Delete</button>
            </div>
        </div>
        <div class="message">
        <a class="new-character" href="character_creation.php">Create New Character</a>
        </div>
_END;
    }
    elseif(mysqli_num_rows($result) ==0){
        $display_block.=<<<_END
        <div class="message">
        <a class="new-character" href="character_creation.php">Create New Character</a>
        </div>
_END;
    }

    
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
                <li>
                    <div class="title-symbol"><p>Tree here</p></div>
                </li>
                <li><a href="logout.php" >Logout</a></li>
            </ul>
        </nav>
        </div>
    
    <!-- Image loader -->
<div id='loader'>
  <img src='images/loading.gif' alt="loading" width='32px' height='32px'>
</div>
<?php echo $adminDisplay ?>
    </header>
    
   <div class="wrapper">
        <div class="home-display">
            <div id="character-select">
                <?php echo $display_block; ?>
            </div>
            <div class="encyclopedia-home">
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
    </div>
    <footer>
    
        
    
    </footer>
</body>
</html>