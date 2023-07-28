<?php

require './db_connection.php';

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    $conn = createConnection();

    if ($conn != null) {

        $stmt = $conn->prepare("SELECT * FROM produits");
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Tableau pour stocker les données
            $produits = array();

            // Parcours des résultats
            while ($row = $result->fetch_assoc()) {
                // Ajout de chaque ligne au tableau
                $produits[] = $row;
            }

            // Conversion du tableau en format JSON
            $json = json_encode($produits);

            // Affichage du JSON
            echo $json;
        } else {
            echo json_encode(array());
        }

        $stmt->close();
        $conn->close();

    }else{
        echo json_encode(array());
    }



