<?php
session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");
//this page runs various scripts on the database depending on which post variable is set and generates an out if required
//use with ajax calls to display the out
// use comments to search through scripts
//contents-------ctrl-f to search-------------------------------------------
//login
//registration
//character deletion
//story-delete
//new-story

switch($_POST['script']){
    case "login":
        //login
    // strip tags from given email address
    $email = strip_tags($_POST['email']);
    $email = stripslashes($email);
    
   
    // encrypt given password
    $pwdEncrypted = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
   
    // query database for email address and password given
    $sql = "SELECT uID, password FROM user WHERE email = '$email'";
    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));

    // if number of rows returned is greater than zero
    if (mysqli_num_rows($results) > 0)
    {
        $row = mysqli_fetch_array($results);

        $passwordOK = password_verify($_POST['pwd'], $row['password']);

        if ($passwordOK == true)
        {
            // add login details to session variables
            $_SESSION['uID']=$row['uID'];

            //display message and give link to go to main page
            $output =<<<_END
            <div class="form-message">
               <p>You are now logged in.</p>
               <a href="home.php">Enter Here</a>
            </div>
_END;
        }
        else
        {
            // add username/password not found to display_block
            $output =<<<_END
            <div class="form-message">>
                <p class="alert">Password does not match.</p>
            </div>
                <script> login(); reg();</script>
                <form class="form" id="f-login" action="index.php" method="post">
               <label for="f-login">Login</label>
               <input type="email"  size="40"  aria-label="e-mail" placeholder="e-mail" name="email" id="email">
               <input type="password" size="40"  aria-label="password" placeholder="password" name="pwd" id="pwd">
               <input type="submit" id="login" name="login" value="Login">
               </form>
_END;
        }
    }
    else
    {
        // add username/password not found to display_block
        $output = <<<_END
        <div class="form-message">
            <p>Can't find that username.</p>
            <p>
            <a href="index.php">Sign up Here</a>
            </p>
        </div>
_END;
    }
        break;
    case "reg":
        //registration
    //password check
    if ($_POST['pwd'] != $_POST['cPwd'])
    {
       
        // add "passwords don't match" message to display_block
        $output=<<<_END
        <script> login(); reg();</script>
        <div class="form-message>
            <p>Your confirm passwords did not match</p>
        </div>
        <form class="form" id="f-register" action="index.php" method="post">
           <label for="f-register">Register</label>
           <input type="text" size="40"  aria-label="name" placeholder="name" name="name" id="name">
           <input type="text" size="40"  aria-label="username" placeholder="username" name="username" id="username">
           <input type="email"  aria-label="e-mail" placeholder="e-mail" name="email" id="reg-email">
           <input type="password" size="40"  aria-label="password" placeholder="password" name="pwd" id="reg-pwd">
           <input type="password" size="40"  aria-label="confirm password" placeholder="Confirm password" name="pwdConfirm" id="pwdConfirm">
           <input type="submit" id="reg" name="register" value="Register">
       </form>
_END;
    }
    else{
       $display_block="";
       //check if email and or username have been used
       $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

       $sql = "SELECT email FROM user WHERE email = '$email'";
       $results = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
       if (mysqli_num_rows($results) > 0) {
           
           $output=<<<_END
           <script> login(); reg();</script>
           <div class="form-message>
           <p>Someone's used that username address before</p>
           </div>
           <form class="form" id="f-register" action="index.php" method="post">
              <label for="f-register">Register</label>
              <input type="text"  aria-label="name" placeholder="name" name="name" id="name">
              <input type="text"  aria-label="username" placeholder="username" name="username" id="username">
              <input type="email"  aria-label="e-mail" placeholder="e-mail" name="email" id="reg-email">
              <input type="password"  aria-label="password" placeholder="password" name="pwd" id="reg-pwd">
              <input type="password" aria-label="confirm password" placeholder="Confirm password" name="pwdConfirm" id="pwdConfirm">
              <input type="submit" id="reg" name="register" value="Register">
          </form>
_END;
       } 
        else{
           $username = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
           $sql = "SELECT username FROM user WHERE username = '$username'";
           $results = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                
           if (mysqli_num_rows($results) > 0) {
               
               $output=<<<_END
               <script> login(); reg();</script>
               <p class="alert">Someone's used that username before</p>
               <form class="form" id="f-register" action="index.php" method="post">
                   <label for="f-register">Register</label>
                   <input type="text"  aria-label="name" placeholder="name" name="name" id="name">
                   <input type="text"  aria-label="username" placeholder="username" name="username" id="username">
                   <input type="email"  aria-label="e-mail" placeholder="e-mail" name="email" id="reg-email">
                   <input type="password"  aria-label="password" placeholder="password" name="pwd" id="reg-pwd">
                   <input type="password" aria-label="confirm password" placeholder="Confirm password" name="pwdConfirm" id="pwdConfirm">
                   <input type="submit" id="reg" name="register" value="Register">
               </form>
_END;
           } 
            else{
                   //encrypt password
                   $pwdEncrypted = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
                   $name = filter_var($_POST['name'], FILTER_SANITIZE_EMAIL);
                
                   // store information into the database
                   $sql = "INSERT INTO user VALUES (NULL, '$name', '$username', '$email', '$pwdEncrypted', 0)";
                   $results = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                   // add login details to session variables
                   $sql = "SELECT uID FROM user WHERE email = '$email'";
                   $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                   $row = mysqli_fetch_array($results);
               
                    $_SESSION['uID'] = $row['uID'];

                    //display message and give link to go to main page
                    $output =<<<_END
                   <p>You are now registered.</p>
                   <div class="message">
                   <a href="home.php">Enter Here</a>
                   </div>
_END;
               }
       }
   }
        break;
        case "char-delete":
           
            //character deletion
            
           if(isset($_POST['confirm'])){
                if($_POST['confirm']==1){
                    $sql="DELETE FROM charater WHERE cID = $_POST[char]";
                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                    $output=<<<_END
                    <p>Your character has been stricken from the records feel free to create another and rejoin the adventures</p>
                    <div class="message">
                    
                    <a href="home.php">Click here to start again</a>
                    </div>
_END;
                }
                elseif($_POST['confirm']==2){
                    $output=<<<_END
                    <p>Your character lives to adventure another day click below to go back and forget about this whole ordeal</p>
                    <div class="message">
                    <a href="home.php">Click here to forget</a>
                    </div>
_END;
                }
            }
            elseif(isset($_POST['char']))
            {
                $sql="SELECT cID, playerName, avatar FROM charater WHERE cID=$_POST[char]";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                $row = mysqli_fetch_array($results);
                $output=<<<_END
                <script>charDeleteConfirm();</script>
                <div class="character">
                    <div>
                        <h3>$row[playerName]</h3>
                    </div>
                    <div class="avatar-home">
                        <div class="avatar">
                            <img class="images" src="$row[avatar]" alt="player avatar">
                        </div>
                    </div>
                </div>
                <div class="character-delete">
                    <p>Are you sure you wanted to delete this character all progress and rivals will be gone forever.</p>
                    <div class="confirmation">
                        <script>var id=$_POST[char];</script>
                        <button class="deleteCharacterConfirm" id="1" value="1">Yes delete this character</button>
                        <button class="deleteCharacterConfirm" id="2" value="2">Nevermind go back</button>
                    </div>
                </div>
_END;
            }
            break;
            case "story-delete":
                if(is_numeric($_POST['id'])){
                    $_SESSION['storyID']=$_POST['id'];
                    $sql="SELECT name FROM story WHERE storyID =$_SESSION[storyID]";
                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                    $row = mysqli_fetch_array($results);
                    $output=<<<_END
                        <script> storyDelete(); </script>
                        <div class="message">
                            <p>Are you sure you want to delete the story "$row[name]". All records will be permanently lost and all players will futhermore have no access to it</p>
                            <form method="POST" action="admin.php"><button type="submit"  name="submit" value="2">Go Back</button></form>
                            <button id="delete" class="delete-story">Yes Delete</button>
                        </div>
    _END;
                }
                elseif($_POST['id']=='delete'){
                    $sql="DELETE FROM story where storyID = $_SESSION[storyID]";
                    unset($_SESSION['storyID']);
                    $output=<<<_END
                    
                    <div class="message">Story has been deleted</div>
                    <div><form method="POST" action="admin.php"><button type="submit"  name="submit" value="2">Go Back</button></form></div>
_END;
                }
             
                break;
                case "story-create":
                    switch($_POST['case']){
                        case "1";
                        //display initial form for story details
                        $output=<<<_END
                        <script> storyCreation(); </script>
                        <div>
                        <form class="story-form">
                            <input type="text" name="storyName" id="storyName" placeholder="Story Name" aria-label="Story Name">
                            <textarea name="story Description" id="storyDesc" placeholder="Story description here" aria-label="story description" rows="10" col="30"></textarea>
                            <select name="theme" id="storyTheme">
                                <option value="fae">Fae</option>
                                <option value="human">Human</option>
                            </select>
                            <input type="submit" id="newStory" value="Create New Story">
                        </form>
                        </div>
                        
_END;
                        break;
                        case "2";
                        //create a new story and select it from database. save to session for future reference
                        $sql="INSERT INTO story VALUES(NULL, '$_POST[theme]', '$_POST[name]', '$_POST[desc]', 'no')";
                        $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        $sql="SELECT storyID FROM story ORDER BY storyID DESC LIMIT 1";
                        $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        $row = mysqli_fetch_array($results);
                        $_SESSION['storyID']=$row['storyID'];
                        //create the first scenario for the story and select ID so it can be passed along the form
                        $sql="INSERT INTO scenario VALUES(NULL, $_SESSION[storyID], NULL, NULL, NUll)";
                        $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        $sql="SELECT scenarioID FROM scenario ORDER BY scenarioID DESC LIMIT 1";
                        $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        $row = mysqli_fetch_array($results);
                        //display form for the first scenario information here will update the scenario just made
                        $output=<<<_END
                        <script> scenarioEntry(); </script>
                        <form class="story-form">
                        <input type="hidden" value="$row[scenarioID]" id="scenarioID">
                        <textarea name="scenario" id="scenario" placeholder="New Scenario" aria-label="Scenario" rows="10" col="30"></textarea>
                        <label for="scenarioFunction">Function</label>
                        <select name="scenarioFunction" id="scenarioFunction">
                                <option value="NULL">NULL</option>
                                <option value="health">health</option>
                                
                            </select>
                        <input type="text" name="value" id="value" placeholder="Value" aria-label="function value">
                        <label for="choice">How many choices:</label>
                        <select name="choice" id="choice">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                         </select>
                    
                        <input type="submit" id="scenarioEntry" value="Continue">
                        </from>
_END;
                        break;
                        case "3";
                        //update the scenario from previous page and display the number of choices to be made
                        if($_POST['value']==""){
                           $value="NULL"; 
                        }
                        else{
                            $value=$_POST['value'];
                        }
                        $sql="UPDATE scenario SET prompt='$_POST[desc]', storyFunction=$_POST[function], value=$value WHERE scenarioID=$_POST[id]";
                        
                        $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        if($_POST['choice']!=0){
                            $choices="";
                            for($i=0;$i<$_POST['choice'];$i++){
                                $choices.=<<<_END
                                    <div>
                                    <input type="hidden" id="scenarioID_$i" value="$_POST[id]">
                                    <textarea name="choice_$i" id="choice_$i" placeholder="Choice text here" aria-label="Choice text" rows="10" col="15"></textarea>
                                    <label for="class_$i">Class:</label>
                                    <select name="class_$i" id="class_$i">
                                        <option value="choice">choice</option>
                                        <option value="duelStart">Duel Start</option>
                                        <option value="duelEnd">Duel End</option>
                                            
                                    </select>
                                    <input type="text" name="item_$i" id="item_$i" placeholder="item ID" aria-label="item id">
                                    <label for="function_$i">Function:</label>
                                    <select name="function_$i" id="function_$i">
                                            <option value="go">go</option>
                                            <option value="rollCheck">Roll Check</option>
                                            <option value="give">give</option>
                                            <option value="take">take</option>
                                            <option value="resume">resume</option>
                                            <option value="equipWeapon">Equip Weapon</option>
                                            <option value="saveLoc">Save Location</option>
                                            <option value="raiseATK">Raise ATK</option>
                                            <option value="raiseDEF">Raise DEF</option>
                                            <option value="raiseHealth">Raise Health</option>
                                        </select>
                                    <input type="text" name="value_$i" id="value_$i" placeholder="value" aria-label="function value">
                                    </div>
    _END;
                            }
                            $output=<<<_END
                            
                            <script> choiceEntry(); </script>
                            <form method="POST" action="scripts.php" class="story-form">
                            $choices
                            <input type="submit" id="choiceEntry" value="Continue">
                            </form>
                           
    _END;
                        }
                        else{
                            $output=<<<_END
                            
                            <script> storyContinue() </script>
                            <div class="message"><p>You have ended this path in the story click below to continue any paths left unfinished</p></div>
                            <button id="$_SESSION[storyID]" class="continue-story">Continue Story</button>
                            
                           
    _END;
                        }

                        break;
                        case "4";
                        //determine which choices were made and enter them into the database
                        //these choices lack a target and/or an alt target this will be used to determine what part of the story to create next
                        
                        if(isset($_POST['id_0'])){
                            if($_POST['value_0']==""){
                                $value="NULL";
                            }
                            else{
                                $value=$_POST['value_0'];
                            }
                            if($_POST['item_0']==""){
                                $item="NULL";
                            }
                            else{
                                $item=$_POST['item_0'];
                            }
                            $sql="INSERT INTO choice VALUES(NULL,$_POST[id_0],$_SESSION[storyID],'$_POST[class_0]','$_POST[choice_0]',$item,'$_POST[function_0]',$value,NULL,NULL)";
                            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        }
                        if(isset($_POST['id_1'])){
                            if($_POST['value_1']==""){
                                $value="NULL";
                            }
                            else{
                                $value=$_POST['value_1'];
                            }
                            if($_POST['item_1']==""){
                                $item="NULL";
                            }
                            else{
                                $item=$_POST['item_1'];
                            }
                            $sql="INSERT INTO choice VALUES(NULL,$_POST[id_1],$_SESSION[storyID],'$_POST[class_1]','$_POST[choice_1]',$item,'$_POST[function_1]',$value,NULL,NULL)";
                            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        }
                        if(isset($_POST['id_2'])){
                            if($_POST['value_2']==""){
                                $value="NULL";
                            }
                            else{
                                $value=$_POST['value_2'];
                            }
                            if($_POST['item_2']==""){
                                $item="NULL";
                            }
                            else{
                                $item=$_POST['item_2'];
                            }
                            $sql="INSERT INTO choice VALUES(NULL,$_POST[id_2],$_SESSION[storyID],'$_POST[class_2]','$_POST[choice_2]',$item,'$_POST[function_2]',$value,NULL,NULL)";
                            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        }
                        if(isset($_POST['id_3'])){
                            if($_POST['value_3']==""){
                                $value="NULL";
                            }
                            else{
                                $value=$_POST['value_3'];
                            }
                            if($_POST['item_3']==""){
                                $item="NULL";
                            }
                            else{
                                $item=$_POST['item_3'];
                            }
                            $sql="INSERT INTO choice VALUES(NULL,$_POST[id_3],$_SESSION[storyID],'$_POST[class_3]','$_POST[choice_3]',$item,'$_POST[function_3]',$value,NULL,NULL)";
                            $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                        }
                        //if the user is continuing the story from a previous session rewrite the session for the story ID
                        if(isset($_POST['continueID'])){
                            $_SESSION['storyID']=$_POST['continueID'];
                        }
                         //check if link has been set and link choices with chosen scenario
                if(isset($_POST['link'])){
                    $sql="UPDATE choice SET targetID=$_POST[ID] WHERE choiceID=$_SESSION[choiceID]";
                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                    unset($_SESSION['choiceID']);
                }
                if(isset($_POST['altLink'])){
                    $sql="UPDATE choice SET targetID=$_POST[ID] WHERE choiceID=$_SESSION[choiceID]";
                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                    unset($_SESSION['choiceID']);
                }
                //select all choices in this story that do not have a target or alt target.
                //display as buttons that create the scenario they will go to.
                $sql="SELECT choiceID, text FROM choice WHERE storyID=$_SESSION[storyID] AND targetID IS NULL";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                //set variable as empty and fill as needed query later if empty
                $buttons="";
                if(mysqli_num_rows($results) > 0){
                    while($row = mysqli_fetch_array($results)){
                        $buttons.="<div>
                        <h2>Choices</h2>
                                        <div class=\"choice-text\">$row[text]</div>
                                        <div class=\"story-btns\">
                                        <button class=\"target-choice\" id=\"$row[choiceID]\">New Scenario</button>
                                        <button class=\"link-scenario\" id=\"$row[choiceID]\">Link to Scenario</button>
                                        </div>
                                    </div>";
                    }
                }
                $sql="SELECT choiceID, text FROM choice WHERE storyID=$_SESSION[storyID] AND gameFunction='rollCheck' AND altTargetID IS NULL";
                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                if (mysqli_num_rows($results) > 0) {
                    while ($row = mysqli_fetch_array($results)) {
                        $buttons.="<div>
                        <h2>Alternitve Paths<h2>
                                        <div class=\"story-btns\">
                                        <div class=\"choice-text\">$row[text]</div>
                                        <button class=\"altTarget-choice\" id=\"$row[choiceID]\">Next Scenario</button>
                                        <button class=\"alt-link-scenario\" id=\"$row[choiceID]\">Link to Scenario</button>
                                        </div>
                                    </div>";
                    }
                }
                //if buttons variable is empty all choices have a target and therefore the story is finished
                //create button to set story to finished
                if($buttons==""){
                    $buttons="<div>
                                <div class=\"choice-text\">
                                <p>Your story is now complete and ready to go live</p>
                                <button class=\"finish-story\" id=\"$_SESSION[storyID]\">Finish story</button>
                                </div>
                            </div>";
                } 
                $output=<<<_END
                <script> choiceTarget(); choiceAlTTarget(); storyFinish(); linkScenario(); altLinkScenario(); </script>
                $buttons
                
                
                
                
_END;
                        break;
                        case "5":
                            //check to see if story has been finished
                            //if yes display message saying story is live
                            if(isset($_POST['finish'])){
                                $sql="UPDATE story SET finished='yes' WHERE storyID=$_POST[finish]";
                                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                $output=<<<_END
                                <script>adminNav();</script>
                                    <div class="message">
                                        <p>Congratulations another story is now complete and now live for users to experience</p>
                                        <div class="admin-btn">
                                            <button type="submit"  name="submit" value="2">Back to Story</button>
                                        </div> 
                                    </div>
_END;
                            }
                            //if not finished create new scenario slect id and update the choice with either the target or alt target
                            else{
                                if(isset($_POST['ID'])){
                                    $sql="INSERT INTO scenario VALUES(NULL, $_SESSION[storyID], NULL, NULL, NUll)";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $sql="SELECT scenarioID FROM scenario ORDER BY scenarioID DESC LIMIT 1";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $row = mysqli_fetch_array($results);
                                    //save scenario information to help user know what scenario and choice precceded they one they are making now 
                                    $scenarioID=$row['scenarioID'];
                                
                                    //update choice
                                    $sql="UPDATE choice SET targetID=$row[scenarioID] WHERE choiceID=$_POST[ID]";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    //save choice information for display
                                    $sql="SELECT text, scenarioID FROM choice WHERE choiceID=$_POST[ID]";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $row = mysqli_fetch_array($results);
                                    $choice=$row['text'];
                                    //select prompt from previous scenario to display
                                    $sql="SELECT prompt FROM scenario WHERE scenarioID=$row[scenarioID]";
                                    echo $sql;
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $row = mysqli_fetch_array($results);
                                    $scenarioDesc=$row['prompt'];
                                   }
                                   elseif(isset($_POST['altID'])){
                                    $sql="INSERT INTO scenario VALUES(NULL, $_SESSION[storyID], NULL, NULL, NUll)";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $sql="SELECT scenarioID FROM scenario ORDER BY scenarioID DESC LIMIT 1";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $row = mysqli_fetch_array($results);
                                    //save scenario information to help user know what scenario and choice precceded they one they are making now 
                                    $scenarioID=$row['scenarioID'];
                                    
                                    //save choice information for display
                                    $sql="UPDATE choice SET altTargetID=$scenarioID WHERE choiceID=$_POST[altID]";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    //save choice information for display
                                    $sql="SELECT text, scenarioID FROM choice WHERE choiceID=$_POST[altID]";
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $row = mysqli_fetch_array($results);
                                    $choice=$row['text'];
                                    //select prompt from previous scenario to display
                                    $sql="SELECT prompt FROM scenario WHERE scenarioID=$row[scenarioID]";
                                   
                                    $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                    $row = mysqli_fetch_array($results);
                                    $scenarioDesc=$row['prompt'];
                                   }
                                    
                                    $output=<<<_END
                                    <script> scenarioEntry(); </script>
                                    <div class="prompt"><h2>Previous Scenario</h2><p>$scenarioDesc</p></div>
                                    <div class="choice"><h3>Choice made<ph3><p>$choice</p></div>
                                    <form class="story-form">
                                    <input type="hidden" value="$scenarioID" id="scenarioID">
                                    <textarea name="scenario" id="scenario" placeholder="New Scenario" aria-label="Scenario" rows="10" col="30"></textarea>
                                    <label for="scenarioFunction">Function</label>
                                    <select name="scenarioFunction" id="scenarioFunction">
                                            <option value="NULL">NULL</option>
                                            <option value="health">health</option>      
                                        </select>
                                    <input type="text" name="value" id="value" placeholder="Value" aria-label="function value">
                                    <label for="choice">How many choices:</label>
                                    <select name="choice" id="choice">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="0">0</option>
                                     </select>
                                
                                    <input type="submit" id="scenarioEntry" value="Continue">
                                    </from>
                                    
_END;
                            }
                           
                        break;
                        case "6":
                            if (isset($_POST['ID'])) {
                                $_SESSION['choiceID']=$_POST['ID'];
                                $sql="SELECT scenarioID, prompt FROM scenario WHERE stroyID=$_SESSION[storyID] ORDER BY scenarioID DESC";
                                
                                $results = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                $output="<script> link(); </script>";
                                while ($row = mysqli_fetch_array($results)) {
                                    $scenarioDesc=$row['prompt'];
                                    $output.=<<<_END
                                        <div class="prompts">
                                            <p>$scenarioDesc</p>
                                            <button class="link" id="$row[scenarioID]">Link</button>
                                        </div>
_END;
                        }
                            }
                            elseif(isset($_POST['altID'])){
                                $_SESSION['choiceID']=$_POST['ID'];
                                $sql="SELECT scenarioID, prompt FROM scenario WHERE stroyID=$_SESSION[storyID] ORDER BY scenarioID DESC";
                                
                                $results = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                                $output="<script> link(); </script>";
                                while($row = mysqli_fetch_array($results)){
                                $scenarioDesc=$row['prompt'];
                                    $output.=<<<_END
                                        <div class="prompts">
                                            <p>$scenarioDesc</p>
                                            <button class="alt-link" id="$row[scenarioID]">Link</button>
                                        </div>
_END;
                            }
            
                            }
                            
                            
                            
                break;

                    }
                break;
}












if(isset($output)){
    echo $output;
}
else{
    echo("why");
    echo $_POST['script'];

}
?>


