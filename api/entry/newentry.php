<?php

session_start();
 
// include database and object files
include_once '../objekter/database.php';
include_once '../objekter/entry.php';
include_once '../objekter/vin.php';

 // get database connection
$database = new Database();
$db = $database->getConnection();

// Opprett vinobjekt
$vin = new Vin($db);
$vin->varenummer = filter_input(INPUT_POST, 'varenummer');

$stmt = $vin->read_single();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num == 0){

    // Koble til polets API
    // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
    require_once 'HTTP/Request2.php';

    $request = new Http_Request2('https://apis.vinmonopolet.no/products/v0/details-normal');
    $url = $request->getUrl();

    $headers = array(
        // Request headers
        'Ocp-Apim-Subscription-Key' => 'db1292c2fb974eb488a1007327471759',
    );

    $request->setHeader($headers);

    $parameters = array(
        // Request parameters
        'productId' => filter_input(INPUT_POST, 'varenummer'),
    );

    $url->setQueryVariables($parameters);
    $request->setMethod(HTTP_Request2::METHOD_GET);

    // Request body
    $request->setBody("{body}");


    try
    {
        $response = $request->send();
        $json = substr(($response->getBody()),1,-1); //Fjern square brackets foran og bak
        $dictionary = json_decode($json,true); //true gjør json returnerer array

    }
    catch (HttpException $ex)
    {
        echo $ex;
        
    }

    // Setter feltene
    $vin->varenavn = $dictionary["basic"]["productShortName"];
    $vin->aargang = $dictionary["basic"]["vintage"];

    $vin->produsent = $dictionary["logistics"]["manufacturerName"];
    $vin->produsentId = $dictionary["logistics"]["manufacturerId"];
    $vin->land = $dictionary["origins"]["origin"]["country"];
    $vin->landId = $dictionary["origins"]["origin"]["countryId"];
    $vin->distrikt = $dictionary["origins"]["origin"]["region"];
    $vin->distriktId = $dictionary["origins"]["origin"]["regionId"];
    $vin->underdistrikt = $dictionary["origins"]["origin"]["subRegion"];
    $vin->underdistriktId = $dictionary["origins"]["origin"]["subRegionId"];

    $vin->volum = $dictionary["basic"]["volume"];
    $vin->pris = $dictionary["prices"][0]["salesPrice"];
    $vin->alkoholprosent = $dictionary["basic"]["alcoholContent"];

    $vin->vintype = $dictionary["classification"]["subProductTypeName"];
    $vin->vintypeId = $dictionary["classification"]["subProductTypeId"];

    $vin->raastoff = json_encode($dictionary["ingredients"]["grapes"]);
    $vin->metode = $dictionary["properties"]["productionMethodStorage"];

    $vin->passertil1 = $dictionary["description"]["recommendedFood"][0]["foodDesc"];
    $vin->passertil2 = $dictionary["description"]["recommendedFood"][1]["foodDesc"];
    $vin->passertil3 = $dictionary["description"]["recommendedFood"][2]["foodDesc"];

    $vin->farge = $dictionary["description"]["characteristics"]["colour"];
    $vin->lukt = $dictionary["description"]["characteristics"]["odour"];
    $vin->smak = $dictionary["description"]["characteristics"]["taste"];
    $vin->fylde = $dictionary["description"]["fullness"];
    $vin->friskhet = $dictionary["description"]["freshness"];
    $vin->garvestoffer = $dictionary["description"]["tannins"];
    $vin->sødme = $dictionary["description"]["sweetness"];
    $vin->bitterhet = $dictionary["description"]["bitterness"];
    
    if(!$vin->create()){
        $vin_arr=array(
            "status" => false,
            //"message" => "Varenummeret eksisterer ikke.",
            "message" => print_r($vin)

        );
    }
}

$entry = new Entry($db);
$entry->brukernavn = $_POST['brukernavn'];
$entry->varenummer = $_POST['varenummer'];
$entry->beholdning = $_POST['beholdning'];


if($entry->create()){
    $vin_arr=array(
        "status" => true,
        "message" => "Suksess! La til en ny vin i vinkjelleren.",

    );
}
else{
    $vin_arr=array(
        "status" => false,
        "message" => "Error. Vinen er allerede i vinkjelleren."
        
    );
}

        
print_r(json_encode($vin_arr));
