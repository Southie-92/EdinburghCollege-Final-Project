<?php





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
    </header>
    <div class="wrapper">
    <div class="container">
        <div class="landing-image">
            <p>image here</p>
        </div>
        <div id="form-wrapper">
            <script> login(); reg();</script>
            <div>
                <form class="form" id="f-login" action="index.php" method="post">
                
                <input type="email"  aria-label="e-mail" placeholder="e-mail" name="email" id="email" size="30">
                <input type="password"  aria-label="password" placeholder="password" name="pwd" id="pwd" size="30">
                <input type="submit" id="login" name="login" value="Login">
                </form>
            </div>
            <div>
                <form class="form" id="f-register" action="index.php" method="post">
                    
                    <input type="text"  aria-label="name" placeholder="name" name="name" id="name" size="30">
                    <input type="text"  aria-label="username" placeholder="username" name="username" id="username" size="30">
                    <input type="email"  aria-label="e-mail" placeholder="e-mail" name="email" id="reg-email" size="30">
                    <input type="password"  aria-label="password" placeholder="password" name="pwd" id="reg-pwd" size="30">
                    <input type="password" aria-label="confirm password" placeholder="Confirm password" name="pwdConfirm" id="pwdConfirm" size="30">
                    <input type="submit" id="reg" name="register" value="Register">
                </form>
            </div>
        </div>
    </div>

    </div>
    <footer>
   
    </footer>
</body>
</html>