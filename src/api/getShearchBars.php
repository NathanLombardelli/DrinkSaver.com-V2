<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require './db_connection.php';
require './verifKey.php';


$keyUrl = '';
$Fumeur = '0';
$Interieur = '0';
$Exterieur = '0';
$Toilettes= '0';
$ToilettesPay='0';
$Wifi = '0';
$Manger = '0';
$Billard = '0';
$Kicker = '0';
$Dart = '0';
$prod = '';


if ( isset($_GET['key']) ) {
    $keyUrl = $_GET["key"];
}

if ( isset($_GET['Fumeur']) ) {
    $Fumeur = $_GET["Fumeur"];
}

if ( isset($_GET['Interieur']) ) {
    $Interieur = $_GET["Interieur"];
}

if ( isset($_GET['Exterieur']) ) {
    $Exterieur = $_GET["Exterieur"];
}

if ( isset($_GET['Toilettes']) ) {
    $Toilettes = $_GET["Toilettes"];
}

if ( isset($_GET['ToilettesPay']) ) {
    $ToilettesPay = $_GET["ToilettesPay"];
}

if ( isset($_GET['Wifi']) ) {
    $Wifi = $_GET["Wifi"];
}

if ( isset($_GET['Manger']) ) {
    $Manger = $_GET["Manger"];
}

if ( isset($_GET['Kicker']) ) {
    $Kicker = $_GET["Kicker"];
}


if ( isset($_GET['Billard']) ) {
    $Billard = $_GET["Billard"];
}


if ( isset($_GET['Dart']) ) {
    $Dart = $_GET["Dart"];
}

if ( isset($_GET['prod']) ) {
    $prod = $_GET["prod"];
}

$conn = createConnection();

if ($conn != null && $keyUrl != '' && verifKey($conn,$keyUrl)) {


    // Créer la requête SQL en utilisant les valeurs récupérées
    $query = "SELECT * FROM bars b
    join cartes c on c.idBar = b.BarID
    join produits p on p.ProduitID = c.idProduit";


    $conditions = array();

    if ($Fumeur == 1) {
        $conditions[] = "b.Fumeur = 1";
    }
    if ($Interieur == 1) {
        $conditions[] = "b.Interieur = 1";
    }
    if ($Exterieur == 1) {
        $conditions[] = "b.Exterieur = 1";
    }
    if ($Toilettes == 1) {
        $conditions[] = "b.Toilettes = 1";
    }
    if ($ToilettesPay == 1) {
        $conditions[] = "b.ToilettesPayante = 1";
    }
    if ($Wifi == 1) {
        $conditions[] = "b.Wifi = 1";
    }
    if ($Manger == 1) {
        $conditions[] = "b.manger = 1";
    }
    if ($Billard == 1) {
        $conditions[] = "b.billard = 1";
    }
    if ($Kicker == 1) {
        $conditions[] = "b.kicker = 1";
    }
    if ($Dart == 1) {
        $conditions[] = "b.dart = 1";
    }
    if ($prod != '') {
        $conditions[] = "p.Name like '$prod'";
    }

    // Concaténer les conditions avec "AND"
    if (!empty($conditions)) {
        $query .= ' Where ';
        $query .= implode(" AND ", $conditions);
    }


    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bars = array();

        // Parcours des résultats de la table "bars"
        while ($barRow = $result->fetch_assoc()) {
            // Récupérer les lignes correspondantes de la table "cartes" pour l'idBar

                $idBar = $barRow['BarID'];
                $cartesQuery = "SELECT * FROM cartes WHERE idBar = $idBar";
                $cartesResult = $conn->query($cartesQuery);

                // Tableau pour stocker les cartes du bar
                $cartes = array();

                // Parcours des résultats de la table "cartes" pour l'idBar
                while ($carteRow = $cartesResult->fetch_assoc()) {
                    // Ajout de chaque carte au tableau
                    $cartes[] = $carteRow;
                }

                // Ajout des données du bar et ses cartes au tableau des bars
                $barRow['cartes'] = $cartes;

            $bars[] = $barRow;
        }
        $json = json_encode($bars);

        // Affichage du JSON
        echo $json;
    } else {
        echo 'row null';
        echo json_encode(array());
    }

}else{
    echo '$conn != null && $keyUrl != null && verifKey($conn,$keyUrl)';
    echo json_encode(array());
}
$conn->close();
