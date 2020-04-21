<?php
 
// include database and object files
include_once '../objekter/database.php';
include_once '../objekter/entry.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 

$entry = new Entry($db);
 

$entry->entryId = $_POST['entryId'];
$entry->minvurdering = $_POST['minvurdering'];
$entry->notater = $_POST['notater'];
$entry->beholdning = $_POST['beholdning'];

    
if($entry->update()){
    $vin_arr=array(
        "status" => true,
        "message" => $entry->minvurdering
    );
}
else{
    $vin_arr=array(
        "status" => false,
        "message" => print_r($vin)
    );
}
print_r(json_encode($vin_arr));
