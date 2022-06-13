<?php


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="functions.js"></script>
</head>
<body>
    <header>
    <div class="banner">
    <h1>Lorem ipsum dolor sit amet.</h1>
    </div>
    </header>
    <div class="wrapper">
        <div class="game-board">
            <div id="player-actions">
                <div class="left-panel">
                    <h2>Game Stats</h2>
                    <div class="pic">
                        <h3>Image here</h3>
                    </div>
                    <div class="stats">
                        <p>Health</p>
                        <p>Stamina</p>
                        <p>Player Stats</p>
                    </div>
                    <div class="inventory">
                        <p>Inventory goes here</p>
                    </div>
                </div>
                <div id="game" class="mid-panel">
                    <script>choice();</script>
                    <h2>Game</h2>
                    <div id="description" class="content">
                        <div class="prompt">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi assumenda inventore cum recusandae sint asperiores enim dignissimos velit ratione, magnam laudantium debitis veniam maxime numquam odit aperiam consequuntur quos dolor.
                            </p>
                        </div>
                        <button id="1" class="choice" >north</button>
                        <button id="2" class="choice" >east</button>
                        <button id="3" class="choice" >south</button>
                        <button id="4" class="choice" >west</button>
                    </div>
                </div>
            </div>
            <div id="encyc" class="right-panel">
            <script> wiki();</script>
                <h2>Item name</h2>
               <div class="item-description">

                   <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dignissimos ad rem molestiae, unde debitis nesciunt pariatur voluptates ab? Sint vero maxime voluptates earum tempore quaerat corporis neque, facilis veniam magnam!
                    Sequi, ratione dolor cum nemo totam sit culpa ad minima incidunt. Explicabo temporibus, ratione beatae dolorum omnis aliquam quis molestiae repudiandae est non quos animi natus vero maiores modi inventore!
                    Iure aliquam recusandae est unde aperiam. Eligendi ex odit velit soluta a eius necessitatibus et consectetur fugiat voluptas? Labore ipsum eaque illum, iste ut quis dolores debitis molestiae ad officia!
                    </p>
                </div>
                <button id="blue" class="item" >blue</button>
                <button id="red" class="item" >red</button>
                <button id="yellow" class="item" >yellow</button>
                <button id="green" class="item" >green</button>
            </div>
        </div>
    </div>
   
    <footer>
    <div class="banner">
        <h2>Lorem ipsum dolor sit amet.</h2>
    </div>
    </footer>
</body>
</html>