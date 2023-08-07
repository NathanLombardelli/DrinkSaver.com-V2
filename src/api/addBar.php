<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require './db_connection.php';


$conn = createConnection();

echo $_POST['Name'] . '<br>';
echo $_POST['Latitude'] . '<br>';
echo $_POST['Longitude'] . '<br>';
echo $_POST['MapsUrl'] . '<br>' ;
echo $_POST['Image'] . '<br>';
echo $_POST['MinCard'] . '<br>';
echo $_POST['Ouverture'] . '<br>';
echo $_POST['Fermeture'] . '<br>';
// check = on / ''
$exterieur = $_POST['Exterieur'];
if($exterieur == 'on'){
    $exterieur = 1;
}else{
    $exterieur = 0;
}
echo $exterieur . '<br>';

$Interieur = $_POST['Interieur'];
if($Interieur == 'on'){
    $Interieur = 1;
}else{
    $Interieur = 0;
}
echo $Interieur. '<br>';

$Fumeur = $_POST['Fumeur'];
if($Fumeur =='on'){
    $Fumeur = 1;
}else{
    $Fumeur = 0;
}
echo $Fumeur . '<br>';

$Toilettes = $_POST['Toilettes'];
if($Toilettes == 'on'){
    $Toilettes = 1;
}else{
    $Toilettes = 0;
}
echo $Toilettes . '<br>';

$Wifi = $_POST['Wifi'];
if($Wifi == 'on'){
    $Wifi = 1;
}else{
    $Wifi = 0;
}
echo $Wifi . '<br>';

$ToilettesPayante = $_POST['ToilettesPayante'];
if($ToilettesPayante = 'on'){
    $ToilettesPayante = 1;
}else{
    $ToilettesPayante = 0;
}
echo $ToilettesPayante . '<br>';

$manger = $_POST['manger'];
if($manger == 'on'){
    $manger = 1;
}else{
    $manger = 0;
}
echo $manger . '<br>';
echo $_POST['happyHour'] . '<br>';

$dart = $_POST['dart'];
if($dart == 'on'){
    $dart = 1;
}else{
    $dart = 0;
}
echo $dart . '<br>';

$billard = $_POST['billard'];
if($billard == 'on'){
    $billard = 1;
}else{
    $billard = 0;
}
echo $billard . '<br>' ;

$kicker = $_POST['kicker'];
if($kicker == 'on'){
    $kicker = 1;
}else{
    $kicker = 0;
}
echo $kicker . '<br>';


if ($conn != null ) {

        $stmt = $conn->prepare("INSERT INTO bars (Name, Latitude, Longitude, MapsUrl, Image, MinCard, Ouverture, Fermeture, Exterieur, Interieur, Fumeur, Toilettes, Wifi, ToilettesPayante, manger, happyHour, dart, billard, kicker) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
        $stmt->bind_param("sssssissiiiiiiisiiis", $_POST['Name'], $_POST['Latitude'], $_POST['Longitude'], $_POST['MapsUrl'], $_POST['Image'], $_POST['MinCard'], $_POST['Ouverture'], $_POST['Fermeture'], $Exterieur, $Interieur, $Fumeur, $Toilettes, $Wifi, $ToilettesPayante, $manger, $_POST['happyHour'], $dart, $billard, $kicker);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            echo 'Succes';
        } else {
            $error =  array();
            $error[] = 'Erreur Résultat de requête';
            echo json_encode($error);
        }

        $stmt->close();
        $conn->close();


}else{
    $error =  array();
    $error[] = 'Erreur de connection a la Base de Donnée';
    echo json_encode($error);
}
