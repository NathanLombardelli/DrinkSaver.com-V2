<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require './db_connection.php';



    $conn = createConnection();

    if ($conn != null) {

        $jsonBody = file_get_contents('php://input');
        $body = json_decode($jsonBody, true);
        $idBar = $body['idBar'];
        $offset = $body['offset'];
        $limit = $body['limit'];


        $stmt = $conn->prepare("SELECT * FROM cartes WHERE idBar = ? LIMIT ? OFFSET ?");
        $stmt->bind_param("iii", $idBar, $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Tableau pour stocker les données
            $listeAlcool = array();

            // Parcours des résultats
            while ($row = $result->fetch_assoc()) {
                // Ajout de chaque ligne au tableau
                $idProduit = $row['idProduit'];
                $stmt = $conn->prepare("SELECT * FROM produits WHERE ProduitID = ?");
                $stmt->bind_param("i", $idProduit);
                $stmt->execute();
                $produit = $stmt->get_result();

                if ($produit->num_rows > 0) {
                    $produitFinal = $produit->fetch_assoc();
                    $row['name'] = $produitFinal['Name'];
                    $row['image'] = $produitFinal['Image'];
                    $listeAlcool[] = $row;
                }
            }

            // Conversion du tableau en format JSON
            $json = json_encode($listeAlcool);

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






