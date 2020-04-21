<?php
ini_set('display_errors',1);
session_start();

include '../objekter/database.php';
include '../objekter/bruker.php';

$brukernavn = $_POST['brukernavn'];
$passord1 = $_POST['passord1'];
$passord2 = $_POST['passord2'];

if($passord1 != $passord2) {
    $return_array=array(
        "status" => false,
        "message" => "Passordene må være like."
    );
}
else {

    // Koble til databasen
    $database = new Database();
    $db = $database->getConnection();

    $bruker = new Bruker($db);
    $bruker->brukernavn = $brukernavn;
    $bruker->passord = $passord1;

    if($bruker->sign_up()) {
        $return_array=array(
            "status" => true,
            "message" => "Ny bruker opprettet!"
        );
    } 
    else {
        $return_array=array(
            "status" => false,
            "message" => "Opptatt brukernavn, velg et annet."
        );
    }
}

print_r(json_encode($return_array));

?>