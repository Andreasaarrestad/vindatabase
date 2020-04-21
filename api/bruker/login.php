<?php

session_start();

include '../objekter/database.php';
include '../objekter/bruker.php';
      
// Koble til databasen
$database = new Database();
$db = $database->getConnection();

$bruker = new Bruker($db);

$bruker->brukernavn = $_POST['brukernavn'];
//$bruker->passord = base64_encode($_POST['passord']); ETTERPÅ om d funker
$bruker->passord = $_POST['passord'];    


if($bruker->sign_in()->rowCount() > 0) {
    $_SESSION['login_user']  = $bruker->brukernavn;

    $return_array=array(
        "status" => true,
        "message" => "Successfully logged in!"
    );

} 
else {

    $return_array=array(
        "status" => false,
        "message" => "Wrong password bruh"
    );

  
}

print_r(json_encode($return_array));

?>