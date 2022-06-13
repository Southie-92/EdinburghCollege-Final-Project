<?php
include_once("db_connect.php");
session_start();

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

//display the section chosen by the user
if(isset($_POST['submit'])){
    $case= $_POST['submit'];
}


// $display_block=<<<_END
// _END;
switch($case){
    //user account settings
    case "1":
        $sql="SELECT name, username, email FROM user WHERE uID = $_SESSION[uID] ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);

        $display_block=<<<_END
         <h2>Account Details</h2>
        <div class="account-details">
        <h3>$row[username]</h3>
        <p>$row[name]</p>
        <p>$row[email]</p>
        <button class="account-edit">Edit</button>
        <button class="delete-account">Delete my account</button>
        </div>
_END;
        $sql="SELECT playerName, avatar FROM charater WHERE uID = $_SESSION[uID] ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $display_block.="<div class=\"characters\">";
        while($row = mysqli_fetch_array($result)){
            $display_block.=<<<_END
            <div class="character-details">
                <h3>$row[playerName]</h3>
                <div class="avatar">
                <img class="images" src="$row[avatar]" alt="player avatar">
                </div>
                <button class="account-edit">Change name</button>
                <button class="delete-account">Delete</button>
            </div>
    _END;
        }
        $display_block.="</div>";
        break;
    // story settings and upload section 
    case "2":
    $sql_main="SELECT storyID, name, theme, description, finished FROM story ORDER BY storyID ASC";
    $result_main = mysqli_query($conn, $sql_main) or die(mysqli_error($conn));
    //
    $display_finished="";
    $display_unfinished="";
    while ($row_main = mysqli_fetch_array($result_main)) {
        if ($row_main['finished']=='yes') {
            //find total number of players who have completed the story
            $sql="SELECT cID FROM totalprogress WHERE storyID=$row_main[storyID] AND completed=1";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $playerCompleted=mysqli_num_rows($result);
            //find total number of players who have started the story by checking if scenario is greater then starting point
            $sql="SELECT cID FROM totalprogress WHERE storyID=$row_main[storyID] AND scenarioID>=2";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $playerStarted=mysqli_num_rows($result);
            //find total amount of players who have found the quest
            $sql="SELECT cID FROM totalprogress WHERE storyID=$row_main[storyID]";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $playerFound=mysqli_num_rows($result);
            //find total amount of active players as a comparison
            $sql="SELECT cID FROM charater";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $totalPLayers=mysqli_num_rows($result);
            $display_finished.=<<<_END
            <div class="story">
                <h3>$row_main[name]</h3>
                <p>$row_main[theme]</p>
                <p>$row_main[description]</p>
                <p>Players found: $playerFound/$totalPLayers</p>
                <p>Players started: $playerStarted/$totalPLayers</p>
                <p>Players completed: $playerCompleted/$totalPLayers</p>
                <button id="$row_main[storyID]" class="edit-story">Edit Story</button>
                <button id="$row_main[storyID]" class="delete-story">Delete Story</button>
            </div>
_END;
        }
        else{
            $display_unfinished.=<<<_END
            <div class="story">
                <h3>$row_main[name]</h3>
                <p>$row_main[theme]</p>
                <p>$row_main[description]</p>
                <button id="$row_main[storyID]" class="continue-story">Continue Story</button>
                <button id="$row_main[storyID]" class="delete-story">Delete Story</button>
            </div>
_END;
        }
    }
    $display_block=<<<_END
    <script> storyDelete(); storyCreate(); storyContinue(); </script>

    <div class="story-display">
        <div>
        <button id="1" class="create-story">New Story</button>
        </div>
        <div>
            <h2>Unfinished stories</h2>
            $display_unfinished
        </div>
        <div>
            <h2>Finished stories</h2>
            $display_finished
        </div>
    </div>
_END;
   
        break;
    //character analytic information
    case "3":
        $sql="SELECT storyID from story";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $storyTotal=mysqli_num_rows($result)-1;
        $sql="SELECT cID FROM charater";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $totalCharacters=mysqli_num_rows($result);
        $characterArray=array();
        $display_block="<div class=\"all-stats\">";
        while($row = mysqli_fetch_array($result)){
            array_push($characterArray,$row['cID']);
        }
        for($i=0;$i<$totalCharacters;$i++){
            $sql="SELECT charater.playerName, charater.avatar from charater where cID = $characterArray[$i]";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            $name=$row['playerName'];
            $avatar=$row['avatar'];
            $sql="SELECT cID FROM totalprogress WHERE cID=$characterArray[$i] AND completed=1";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $completedTotal=mysqli_num_rows($result);
            $sql="SELECT totalprogress.cID, story.theme FROM totalprogress INNER JOIN story ON totalprogress.storyID=story.storyID WHERE cID=$characterArray[$i] AND completed=1 AND theme='fae'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $faeTotal=mysqli_num_rows($result);
            $sql="SELECT totalprogress.cID, story.theme FROM totalprogress INNER JOIN story ON totalprogress.storyID=story.storyID WHERE cID=$characterArray[$i] AND completed=1 AND theme='human'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $humanTotal=mysqli_num_rows($result);
            $display_block.=<<<_END
                <div class="character-stats">
                    <div><h3>$name</h3></div><div><p>Total Stories Completed-- $completedTotal/$storyTotal</p><p>Fae stories completed--$faeTotal</p><p>Human stories completed--$humanTotal</p></div>
                </div>
        
        _END;
           
        }
         $display_block.="</div>";
        

        


        break;
    //user details and master account settings
    case "4":
        $sql="SELECT name, username, email, adminlevel FROM user";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);
        $display_block="<div class=\"user-list\">";
        while($row = mysqli_fetch_array($result)){
            $display_block.=<<<_END
                <div class="user-details">
                <div><h3>Name:</h3> <p>$row[name] <p></div>
                <div><h3>Username:</h3><p> $row[username]<p></div>
                <div><h3>E-mail:</h3><p>$row[email]<p></div>
                <div><h3>Admin Level:</h3><p>$row[adminlevel]</div>
                <button class="user-edit">Edit account</button>
                <button class="delete-user">Delete account</button>
                </div>
_END;   
            
        }
        $display_block.="</div>";
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
                <li>
                    <div class="title-symbol"><p>Tree here</p></div>
                </li>
                <li><a href="logout.php" >Logout</a></li>
            </ul>
        </nav>
    </div>
    <?php echo $adminDisplay ?>
   
    <!-- Image loader -->
<div id='loader'>
  <img src='images/loading.gif' alt="loading" width='32px' height='32px'>
</div>
    </header>
    <div class="wrapper">
        <div id="settings-display">
            <?php
           
                echo $display_block; 
            
            ?>
        </div>
    </div>
    <footer>
    
    </footer>
</body>
</html>

