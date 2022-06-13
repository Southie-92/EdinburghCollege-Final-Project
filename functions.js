
//login and register are submitted stop default form action and sending via ajax
function login(){
    $(document).ready(function() {
        $('#login').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "login",
                    email: $('#email').val(),
                    pwd:  $('#pwd').val()
            
                },
                success: function(data)
                {
                    $("#form-wrapper").html(data);
                }
            });
        });
    });
}
function reg(){
    $(document).ready(function() {
        $('#reg').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "reg",
                    name: $('#name').val(),
                    username: $('#username').val(),
                    email: $('#reg-email').val(),
                    pwd:  $('#reg-pwd').val(),
                    cPwd:  $('#pwdConfirm').val()
            
                },
                success: function(data)
                {
                    $("#form-wrapper").html(data);
                }
            });
        });
    });
}

function storyCreate(){
    $(document).ready(function() {
        $('button.create-story').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: myVal,
                    
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function storyCreation(){
    $(document).ready(function() {
        $('#newStory').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: 2,
                    name: $('#storyName').val(),
                    desc: $('#storyDesc').val(),
                    theme: $('#storyTheme').val()
                    
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function scenarioEntry(){
    $(document).ready(function() {
        $('#scenarioEntry').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: 3,
                    id: $('#scenarioID').val(),
                    desc: $('#scenario').val(),
                    function: $('#scenarioFunction').val(),
                    value: $('#value').val(),
                    choice: $('#choice').val()
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function choiceEntry(){
    $(document).ready(function() {
        $('#choiceEntry').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: 4,
                    id_0: $('#scenarioID_0').val(),
                    choice_0: $('#choice_0').val(),
                    class_0: $('#class_0').val(),
                    item_0: $('#item_0').val(),
                    function_0: $('#function_0').val(),
                    value_0: $('#value_0').val(),
                    id_1: $('#scenarioID_1').val(),
                    choice_1: $('#choice_1').val(),
                    class_1: $('#class_1').val(),
                    item_1: $('#item_1').val(),
                    function_1: $('#function_1').val(),
                    value_1: $('#value_1').val(),
                    id_2: $('#scenarioID_2').val(),
                    choice_2: $('#choice_2').val(),
                    class_2: $('#class_2').val(),
                    item_2: $('#item_2').val(),
                    function_2: $('#function_2').val(),
                    value_2: $('#value_2').val(),
                    id_3: $('#scenarioID_3').val(),
                    choice_3: $('#choice_3').val(),
                    class_3: $('#class_3').val(),
                    item_3: $('#item_3').val(),
                    function_3: $('#function_3').val(),
                    value_3: $('#value_3').val()
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function choiceTarget(){
    $(document).ready(function() {
        $('button.target-choice').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: 5,
                    ID: myVal,
                    
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function choiceAlTTarget(){
    $(document).ready(function() {
        $('button.altTarget-choice').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: 5,
                    altID: myVal,
                    
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function storyContinue(){
    $(document).ready(function() {
        $('button.continue-story').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: 4,
                    continueID: myVal,
                    
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function storyFinish(){
    $(document).ready(function() {
        $('button.continue-story').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-create",
                    case: 5,
                    finish: myVal,
                    
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function storyDelete(){
    $(document).ready(function() {
        $('button.delete-story').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "story-delete",
                    id: myVal,
                    
                },
                success: function(data)
                {
                    $("#settings-display").html(data);
                }
            });
        });
    });
}
function charDeleteConfirm(){
    $(document).ready(function() {
        $('button.deleteCharacterConfirm').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "char-delete",
                    confirm: myVal,
                    char: id,
                },
                success: function(data)
                {
                    $("#character-select").html(data);
                }
            });
        });
    });
}
function charDelete(){
    $(document).ready(function() {
        $('button.deleteCharacter').click(function(e) {
            var myVal = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'scripts.php',
                data: {
                    script: "char-delete",
                    char: myVal,
                    
                },
                success: function(data)
                {
                    $("#character-select").html(data);
                }
            });
        });
    });
}

//button to go to next page of form and save choices made
function formNav(){   $(document).ready(function() {
    $('button.btn-create').click(function(e) {
        var myVal = $(this).attr('id');
        var avatar =$("input[name='avatar']:checked").val();
        var type =$("input[name='type']:checked").val();
        var weapon =$("input[name='weapon']:checked").val();
        
        $.ajax({
            type: 'POST',
            url: 'creation.php',
            data: {value: myVal,
                    name: $('#name').val(),
                    avatar: avatar,
                    type: type,
                    weapon: weapon,
            },
            success: function(data)
            {
                $("#character-create").html(data);
            }
            
        });
        
    });
});
}

//roll for att and defence on character creation
function roll(){
    $('button.roll-btn').click(function(e) {
        var myVal = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: 'creation.php',
            data: {ArollStage: myVal},
            success: function(data)
            {
                $("#character-create").html(data);
            }
            
        });
        
    });
}
function rollDEF(){
    $('button.rollDEF').click(function(e) {
        var myVal = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: 'creation.php',
            data: {DrollStage: myVal},
            success: function(data)
            {
                $("#character-create").html(data);
            }
            
        });
        
    });
}




function rollDEF(){

}
//alert(myVal);
// when player choose a link within the encyclopedia retrive and display requested information 

function wiki(){   $(document).ready(function() {
    $('button.encyc').click(function(e) {
        var myVal = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: 'encyclopedia.php',
            data: {tab: myVal},
            success: function(data)
            {
                $("#right-panel").html(data);
            }
        });
    });
});
}

// when a player chooses an action in thew game send choice update database and display new scenario  
function choice(){   $(document).ready(function() {
    $('button.choice').click(function(e) {
       
       var myChoice =$(this).attr('id');
       $.ajax({
        type: 'POST',
        url: 'game_display.php',
        data: {choice: myChoice},
        success: function(data)
        {
            $("#player-actions").html(data);
        }
    });
    });
});
}
//when a player clicks on item from inventory update database and display results
function inventory(){   $(document).ready(function() {
    $('button.invent').click(function(e) {
       
       var myItem =$(this).attr('id');
       $.ajax({
        type: 'POST',
        url: 'game_display.php',
        data: {item: myItem},
        success: function(data)
        {
            $("#left-panel").html(data);
        }
    });
    });
});
}
//when player searches in encyclopedia search database and display results
function searchEncyc(){
    $(document).ready(function() {
        $('#searchEncyc').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'encyclopedia.php',
                data: {search: $('#search').val()},
                success: function(data)
                {
                    $("#right-panel").html(data);
                }
            });
        });
    });
}

//when a player clicks on item from inventory update database and display results
function itemEncyc(){   $(document).ready(function() {
    $('button.item').click(function(e) {
       
       var myItem =$(this).attr('id');
       $.ajax({
        type: 'POST',
        url: 'encyclopedia.php',
        data: {itemEncyc: myItem},
        success: function(data)
        {
            $("#right-panel").html(data);
        }
    });
    });
});
}
//when a player selects an option in the duel send and display information
function duel(){   $(document).ready(function() {
    $('button.duel').click(function(e) {
       
       var myMove =$(this).attr('id');
       $.ajax({
        type: 'POST',
        url: 'duel.php',
        data: {move: myMove},
        success: function(data)
        {
            $("#game-board").html(data);
        }
    });
    });
});
}
//start the duel
function duelStart(){   $(document).ready(function() {
    $('button.duelStart').click(function(e) {
       
       var myChoice=$(this).attr('id');
       $.ajax({
        type: 'POST',
        url: 'duel.php',
        data: {choice: myChoice},
        success: function(data)
        {
            $("#game-board").html(data);
        }
    });
    });
});
}
//end the duel
function duelEnd(){   $(document).ready(function() {
    $('button.duelEnd').click(function(e) {
       
       var myChoice =$(this).attr('id');
       $.ajax({
        type: 'POST',
        url: 'full_display.php',
        data: {choice: myChoice},
        success: function(data)
        {
            $("#game-board").html(data);
        }
    });
    });
});
}

//display loading icon during ajax requests
$(document).ajaxStart(function(){
    // Show image container
    $("#loader").show();
  });
  $(document).ajaxComplete(function(){
    // Hide image container
    $("#loader").hide();
  });