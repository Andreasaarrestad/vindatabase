<?php
session_start();


$brukernavn = $_POST['brukernavn'];

// include database and object files
include '../objekter/database.php';
include '../objekter/entry.php';
include '../objekter/vin.php';




// get database connection
$database = new Database();
$db = $database->getConnection();

$entry = new Entry($db);
$entry->brukernavn = $brukernavn;

$stmt = $entry->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
   
    $return_arr=array();
    $return_arr["vin"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        
        $vin = new Vin($db);
        $vin->varenummer = $varenummer;
        $stmt2 = $vin->read_single();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        
        extract($row2);
    
        // create array
        $vin_item=array(
                "entryId" => $entryId,
                "varenummer" => $varenummer,
                "varenavn" => $varenavn,
                "aargang" => $aargang,
                "produsent" => $produsent,
                "produsentId" => $produsentId,
                "land" => $land,
                "landId" => $landId,
                "distrikt" => $distrikt,
                "distriktId" => $distriktId,
                "underdistrikt" => $underdistrikt,
                "underdistriktId" => $underdistriktId,
                "volum" => $volum,
                "pris" => $pris,
                "alkoholprosent" => $alkoholprosent,
                "vintype" => $vintype,
                "vintypeId" => $vintypeId,
                "raastoff" => $raastoff,
                "metode" => $metode,
                "passertil1" => $passertil1,
                "passertil2" => $passertil2,
                "passertil3" => $passertil3,
                "farge" => $farge,
                "lukt" => $lukt,
                "smak" => $smak,
                "fylde" => $fylde,
                "friskhet" => $friskhet,
                "garvestoffer" => $garvestoffer,
                "bitterhet" => $bitterhet,
                "sødme" => $sødme,
                "beholdning" => $beholdning,
                "dato" => $dato,
                "tid" => $tid,
                "notater" => $notater,
                "minvurdering" => $minvurdering
            );
            array_push($return_arr["vin"], $vin_item);
    }
 
    echo json_encode($return_arr["vin"]);
}
else{
    echo json_encode(array());
}

