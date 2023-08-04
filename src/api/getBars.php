<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require './db_connection.php';

$conn = createConnection();

if ($conn != null ) {


    // Récupérer le corps de la requête
    $jsonBody = file_get_contents('api://input');
    $body = json_decode($jsonBody, true);

    $checkFumeur = $body['checkFumeur'];
    $checkInterieur = $body['checkInterieur'];
    $checkExterieur = $body['checkExterieur'];
    $checkToilettes = $body['checkToilettes'];
    $checkToilettesPay = $body['checkToilettesPay'];
    $checkWifi = $body['checkWifi'];
    $checkManger = $body['checkManger'];
    $checkBillard = $body['checkBillard'];
    $checkKicker = $body['checkKicker'];
    $checkDart = $body['checkDart'];
    $biere = $body['biere'];
    $carte = $body['carte'];

    // Créer la requête SQL en utilisant les valeurs récupérées
    $query = "SELECT * FROM bars";
    $conditions = array();

    if ($checkFumeur == "true") {
        $conditions[] = "Fumeur = 1";
    }
    if ($checkInterieur == "true") {
        $conditions[] = "Interieur = 1";
    }
    if ($checkExterieur == "true") {
        $conditions[] = "Exterieur = 1";
    }
    if ($checkToilettes == "true") {
        $conditions[] = "Toilettes = 1";
    }
    if ($checkToilettesPay == "true") {
        $conditions[] = "ToilettesPayante = 1";
    }
    if ($checkWifi == "true") {
        $conditions[] = "Wifi = 1";
    }
    if ($checkManger == "true") {
        $conditions[] = "manger = 1";
    }
    if ($checkBillard == "true") {
        $conditions[] = "billard = 1";
    }
    if ($checkKicker == "true") {
        $conditions[] = "kicker = 1";
    }
    if ($checkDart == "true") {
        $conditions[] = "dart = 1";
    }
    if (!empty($biere)) {
        $conditions[] = "barID IN (SELECT idBar FROM cartes WHERE idProduit = (SELECT ProduitID from produits where name = '$biere'))";
    }

    // Concaténer les conditions avec "AND"
    if (!empty($conditions)) {
        $query .= implode(" AND ", $conditions);
    } else {
        $query .= "1"; // Si aucune condition n'est spécifiée, sélectionner toutes les lignes
    }
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bars = array();

        // Parcours des résultats de la table "bars"
        while ($barRow = $result->fetch_assoc()) {
            // Récupérer les lignes correspondantes de la table "cartes" pour l'idBar
            if ($carte == "true") {
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
            }
            $bars[] = $barRow;
        }
        $json = json_encode($bars);

        // Affichage du JSON
        echo $json;
    } else {
        echo json_encode(array());
    }

}else{
    echo json_encode(array());
}
$conn->close();