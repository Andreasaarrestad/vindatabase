<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="maincss.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
        
    </head>
<body>

    

    <nav class="navbar navbar-inverse ">
         <div class="container">
            <div class="container-fluid ">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Winemaster</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="vinkjeller.php">Vinkjeller</a></li>
                        <li><a href="#">Rangeringer</a></li>
                        <li><a href="#">Om siden</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $login_session ?></a></li>
                        <li><a href="api/bruker/logout.php"><span class="glyphicon glyphicon-log-in"></span> Logg ut</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>   
    
    <div class="container">
              
        
      

        <?php echo $content; ?>
        
        
    </div>
    
    <br>
    
   
 
    <br>
    
</body>
</html>
