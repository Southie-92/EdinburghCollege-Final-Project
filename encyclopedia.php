<?php
session_start();
//session_start();
//Connect to database through seperate page
include_once("db_connect.php");
//set JS code ready to be written in new display
$script = "<script> wiki(); searchEncyc(); itemEncyc(); </script>";
//set encyclopedia head as a string
$head=<<<_END
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
_END;

//check if player has hit Encyclopedia tabs
if (isset($_POST['tab'])) {
    $tab=$_POST['tab'];
    
    
    switch ($tab) {
    case "home":
        $display_block=<<< _END
        $head
        <div class="ency-border-main">
            <div class="ency-content">
                <p>In game encyclopedia </p>
            </div>
        </div>
        </div>
_END;
        break;
    case "map":
        $display_block = <<< _END
        $head  
        <div class="ency-border-main"> 
        <div class="ency-content">
        <h3>Map goes here</h3>
        </div>
        </div>
_END;
        break;
    case "quest":
        $display_block = <<< _END
        $head
        <div class="ency-border-main">
        <div class="ency-content">
        <h3>Quest Info here</h3>
        </div>
        </div>
_END;
        break;
    case "books":
        $display_block = <<< _END
        $head
        <div class="ency-border-main">
        <div class="ency-content">
        <h3>Book list here</h3>
        </div>
        </div>
_END;

        break;
    }
}
elseif(isset($_POST['itemEncyc']))
{
    $id=$_POST['itemEncyc'];
    $sql="SELECT name, description FROM item WHERE itemID = $id";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    //<h3>$row[name]</h3>
      //  <p>$row[description]</p>
    $display_block=<<<_END
    $head
    <div class="item-display">
    <h3>$row[name]</h3>
    <p>$row[description]</p>
    </div>
_END;


}
//check if player is using search bar
elseif((!isset($_POST['search']) || $_POST['search']==""))
{
   $sql="empty";
    $display_block=<<< _END
        $head
        <div class="message">   
            <p>Sorry you haven't entered any search terms.</p>
        </div>
        <p>In game encyclopedia </p>
        
_END;
    
}
//if searchbar not empty then show filtered results
elseif(isset($_POST['search']))
{
    // save the search as variable
    $k = trim($_POST['search']);
    //make query string ready for information to add on to
    $query="";
    $displayWords="";
    //seperate each keyword
    $keywords = explode(' ',$k);
    foreach($keywords as $word)
    {
        $query.=" name LIKE '%".$word."%' OR";
        $displayWords.="$word ";
    }
    $strlen=strlen($query)-3;
    $query=substr($query,0, $strlen);
    //set up sql query
    //search items
    $sql="SELECT * FROM item WHERE $query";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result_count=mysqli_num_rows($result);


    $final_count=$result_count;
    // if search is successful
    if ($final_count > 0) {
        //load results as buttons
        $items="";
        while($row = mysqli_fetch_array($result))
        {
            $items.="<button id=\"$row[itemID]\" class=\"item\" >$row[name]</button><br>";
        }
        // display search information
        $display_block=<<<_END
        $head
            <div class=\"searchResults\">
            <p>$final_count results found</p>
            
            </div>
            <div class=\"searchWords\">
            <p>Your results for $displayWords</p>
            </div>
            <div class=search-items>
                $items
            </div>

_END;
        
    }
    else{
        // display message nothing found in search
        $display_block=<<<_END
        $head
        <div class=\"searchResults\">
                <p>$final_count results found</p>
               
             </div>
             <div class=\"searchWords\">
             <p>Sorry no results for $displayWords were found.</p>
             </div>

_END;
    }
}







echo $script;
echo $display_block;

?>