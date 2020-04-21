<?php
    ini_set('display_errors',1);
    session_start();
    
   
?>

<html>
   
   <head>
      <title>Login Page</title>
      
      <script src="jquery-3.4.1.min.js"></script>
      <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="maincss.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
       
       <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                
                  
                <div class="container-fluid">
                    
                    <br>
                    <h2>Vinnettside</h2>
                    <br>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Logg inn</a></li>
                        <li><a data-toggle="tab" href="#menu1">Registrer deg</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <br>
                            <form role="form">
                                <div class="form-group row">
                                    <div class="col-xs-5">
                                        <label for="brukernavn">Brukernavn:</label><input type = "text" name = "brukernavn" id="brukernavn" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-5">
                                        <label for="passord">Passord:</label><input type = "password" name = "passord" id="passord" class="form-control" />
                                    </div>
                                </div>
                                <button type = "button" class="btn btn-primary mb-2" onclick="login()" >Submit</button>

                            </form>
                        </div>
                        <div id="menu1" class="tab-pane fade">

                            <form role="form">
                                <br>
                                <div class="form-group">
                                    <div class="form-group row">
                                        <div class="col-xs-5">
                                            <label for="brukernavnNy">Brukernavn:</label><input type = "text" name = "brukernavnNy" id="brukernavnNy" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-5">
                                            <label for="passordNy1">Passord:</label><input type = "password" name = "passordNy1" id="passordNy1" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-5">
                                            <label for="passordNy2">Confirm:</label><input type = "password" name = "passordNy2" id="passordNy2" class="form-control" />
                                        </div>
                                    </div>
                                    <button type = "button" class="btn btn-primary mb-2" onclick="signup()" >Submit</button>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        
	
       
            <div class="col-md-6">
              
                    <img src="kevin-kelly-PPneSBqfCCU-unsplash.jpg" style="height:100%;float:right;">
            
            </div>
        </div>
       </div>
   

   </body>
</html>

<script>
    function login() {
        
        $.ajax(
        {
            type: "POST",
            url: 'api/bruker/login.php',
            dataType: 'json',
            data: {
                brukernavn: $("#brukernavn").val(),
                passord: $("#passord").val()        
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    console.log("Logget inn!");
   
                    window.location.href = 'vinkjeller.php';
                }
                else {
                    alert(result['message']);
                    console.log(result['message']);
                    
                }
            }
        });
    } 
    
    function signup() {
        
        $.ajax(
        {
            type: "POST",
            url: 'api/bruker/signup.php',
            dataType: 'json',
            data: {
                brukernavn: $("#brukernavnNy").val(),
                passord1: $("#passordNy1").val(),
                passord2: $("#passordNy2").val()       
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert(result['message']);

                    window.location.href = 'index.php';
                }
                else {
                    alert(result['message']);
                    console.log(result['message']);
  
                }
            }
        });
    } 
    
</script>

