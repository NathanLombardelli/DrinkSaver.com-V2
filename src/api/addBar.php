<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require './db_connection.php';

$conn = createConnection();

$Exterieur = $_POST['Exterieur'];
if ($Exterieur == 'on') {
    $Exterieur = 1;
} else {
    $Exterieur = 0;
}


$Interieur = $_POST['Interieur'];
if ($Interieur == 'on') {
    $Interieur = 1;
} else {
    $Interieur = 0;
}


$Fumeur = $_POST['Fumeur'];
if ($Fumeur == 'on') {
    $Fumeur = 1;
} else {
    $Fumeur = 0;
}


$Toilettes = $_POST['Toilettes'];
if ($Toilettes == 'on') {
    $Toilettes = 1;
} else {
    $Toilettes = 0;
}


$Wifi = $_POST['Wifi'];
if ($Wifi == 'on') {
    $Wifi = 1;
} else {
    $Wifi = 0;
}


$ToilettesPayante = $_POST['ToilettesPayante'];
if ($ToilettesPayante = 'on') {
    $ToilettesPayante = 1;
} else {
    $ToilettesPayante = 0;
}


$manger = $_POST['manger'];
if ($manger == 'on') {
    $manger = 1;
} else {
    $manger = 0;
}


$dart = $_POST['dart'];
if ($dart == 'on') {
    $dart = 1;
} else {
    $dart = 0;
}


$billard = $_POST['billard'];
if ($billard == 'on') {
    $billard = 1;
} else {
    $billard = 0;
}


$kicker = $_POST['kicker'];
if ($kicker == 'on') {
    $kicker = 1;
} else {
    $kicker = 0;
}


if ($conn != null) {

    try {
        $stmt = $conn->prepare("INSERT INTO bars (Name, Latitude, Longitude, MapsUrl, Image, MinCard, Ouverture, Fermeture, Exterieur, Interieur, Fumeur, Toilettes, Wifi, ToilettesPayante, manger, happyHour, dart, billard, kicker) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
        $stmt->bind_param("sssssissiiiiiiisiii", $_POST['Name'], $_POST['Latitude'], $_POST['Longitude'], $_POST['MapsUrl'], $_POST['Image'], $_POST['MinCard'], $_POST['Ouverture'], $_POST['Fermeture'], $Exterieur, $Interieur, $Fumeur, $Toilettes, $Wifi, $ToilettesPayante, $manger, $_POST['happyHour'], $dart, $billard, $kicker);
        $stmt->execute();
    } catch (Exception $e) {
        $error = array();
        $error[] = 'Erreur de requête';
        echo json_encode($error);
    }

    $stmt->close();
    $conn->
    close();

    $error = array();
    $error[] = 'Success';
    echo json_encode($error);

    header('Location: https://drinksaver.be/FormBars?result=1');
    exit();

} else {
    header('Location: https://drinksaver.be/FormBars?result=1');
    exit();
}