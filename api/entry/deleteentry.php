<?php
 
// include database and object files
include_once '../objekter/database.php';
include_once '../objekter/entry.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare doctor object
$entry = new Entry($db);
 
// set doctor property values
$entry->entryId = $_POST['entryId'];
 
// remove the doctor
if($entry->delete()){
    $vin_arr=array(
        "status" => true,
        "message" => "Successfully Removed!"
    );
}
else{
    $vin_arr=array(
        "status" => false,
        "message" => "Feil i deleteentry"
    );
}
print_r(json_encode($vin_arr));


