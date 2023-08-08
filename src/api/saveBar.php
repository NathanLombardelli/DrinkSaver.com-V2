<?php
// Vérifier si le formulaire a été soumis
require 'vendor/autoload.php'; // Inclure l'autoloader de PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $name = $_POST["name"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $mapsUrl = $_POST["mapsUrl"];
    $image = $_POST["image"];
    $minCard = $_POST["minCard"];
    $ouverture = $_POST["ouverture"];
    $fermeture = $_POST["fermeture"];
    $exterieur = isset($_POST["exterieur"]) ? 1 : 0;
    $interieur = isset($_POST["interieur"]) ? 1 : 0;
    $fumeur = isset($_POST["fumeur"]) ? 1 : 0;
    $toilettes = isset($_POST["toilettes"]) ? 1 : 0;
    $wifi = isset($_POST["wifi"]) ? 1 : 0;
    $toilettesPayante = isset($_POST["toilettesPayante"]) ? 1 : 0;
    $manger = isset($_POST["manger"]) ? 1 : 0;
    $happyHour = $_POST["happyHour"];
    $dart = $_POST["dart"];
    $kicker = $_POST["kicker"];
    $billard = $_POST["billard"];

    $servername = "be820041-001.eu.clouddb.ovh.net";
    $username = "technique";
    $password = "Awxcert1999";
    $dbname = "drinksaverDB";
    $port = 35718;

    // Créer une connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Vérifier si la connexion a réussi
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM bars WHERE Name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $result = $stmt->get_result();
    $rowCount = $result->num_rows;
    $message="";

    //UPDATE
    if ($rowCount > 0) {
        $row = $result->fetch_assoc();
        $lastInsertedIdBar = $row["BarID"];
        $stmt->close();

        if ($row["Name"] != $name || $row["Latitude"] != $latitude || $row["Longitude"] != $longitude ||
            $row["MapsUrl"] != $mapsUrl || $row["Image"] != $image || $row["MinCard"] != $minCard ||
            $row["Ouverture"] != $ouverture || $row["Fermeture"] != $fermeture || $row["Exterieur"] != $exterieur ||
            $row["Interieur"] != $interieur || $row["Fumeur"] != $fumeur || $row["Toilettes"] != $toilettes ||
            $row["Wifi"] != $wifi || $row["ToilettesPayante"] != $toilettesPayante || $row["Manger"] != $manger ||
            $row["HappyHour"] != $happyHour || $row["billard"] != $billard || $row["kicker"] != $kicker ||
            $row["dart"] != $dart) {

            $stmt = $conn->prepare("UPDATE bars SET Name = ?, Latitude = ?, Longitude = ?, MapsUrl = ?, Image = ?, MinCard = ?, Ouverture = ?, Fermeture = ?, Exterieur = ?, Interieur = ?, Fumeur = ?, Toilettes = ?, Wifi = ?, ToilettesPayante = ?, manger = ?, happyHour = ?, dart = ?, kicker = ?, billard = ? WHERE BarID = ?");
            $stmt->bind_param("sssssdiiiiiiiiisiiii", $name, $latitude, $longitude, $mapsUrl, $image, $minCard, $ouverture, $fermeture, $exterieur, $interieur, $fumeur, $toilettes, $wifi, $toilettesPayante, $manger, $happyHour, $dart, $kicker, $billard, $lastInsertedIdBar);
            if ($stmt->execute()) {
                $message .= "Les données ont été mis a jour";
            } else {
                $message .= "Aucune donnée à mettre à jour";
            }
        }
    } else {
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO bars (Name, Latitude, Longitude, MapsUrl, Image, MinCard, Ouverture, Fermeture, Exterieur, Interieur, Fumeur, Toilettes, Wifi, ToilettesPayante, manger, happyHour, dart, kicker, billard) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssdiiiiiiiiisiii", $name, $latitude, $longitude, $mapsUrl, $image, $minCard, $ouverture, $fermeture, $exterieur, $interieur, $fumeur, $toilettes, $wifi, $toilettesPayante, $manger, $happyHour, $dart, $kicker, $billard);
        // Préparer la requête d'insertion des données
        /*  $stmt = $conn->prepare("INSERT INTO bars (Name, Latitude, Longitude, Maps_url, Image, Min_card, Ouverture, Fermeture, Exterieur, Interieur, Fumeur, Toilettes, Wifi, Toilettes_payante, manger, happy_hour)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssdiiiiiiiiis", $name, $latitude, $longitude, $mapsUrl, $image, $minCard, $ouverture, $fermeture, $exterieur, $interieur, $fumeur, $toilettes, $wifi, $toilettesPayante, $manger, $happyHour);
        */

        if ($stmt->execute()) {
            $lastInsertedIdBar = $conn->insert_id;
            $message .= "Le bar a été enregistré avec succès";
        } else {
            $message .= "Erreur lors de l'enregistrement du bar";
        }
    }
    $stmt->close();


    $countProduit = 0;
    $errorProduit = 0;
    $countCarte = 0;
    $errorCarte = 0;
    if (isset($_FILES["fichier"])) {
        $fichier = $_FILES["fichier"]["tmp_name"];

        if(!empty($fichier)) {
            // Charger le fichier Excel
            $spreadsheet = IOFactory::load($fichier);

            // Sélectionner la première feuille du fichier
            $worksheet = $spreadsheet->getActiveSheet();
            // Parcourir les lignes du fichier
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Parcourir toutes les cellules, même vides

                $colonne1 = $cellIterator->current()->getValue(); // Valeur de la première colonne
                $cellIterator->next();
                $colonne2 = $cellIterator->current()->getValue(); // Valeur de la deuxième colonne

                $colonne3 = "";//A CHANGER QUAND IL Y AURA IMAGE URL


                //AJOUT DANS PRODUITS

                $stmt = $conn->prepare("SELECT * FROM produits WHERE Name = ?");
                $stmt->bind_param("s", $colonne1);
                $stmt->execute();

                $result = $stmt->get_result();
                $rowCount = $result->num_rows;

                if ($rowCount > 0) {
                    $row = $result->fetch_assoc();
                    $lastInsertedIdProduit = $row["ProduitID"];
                    $stmt->close();

                    if(empty($row["Image"])) {
                        if ($row["Name"] != $colonne1 || $row["Image"] != $colonne3) {
                            $stmt = $conn->prepare("UPDATE produits SET Name = ?, Image = ? WHERE ProduitID = ?");
                            $stmt->bind_param("ssi", $colonne1, $colonne3, $lastInsertedIdProduit);
                            if ($stmt->execute()) {
                                printf("Les données ont été mis a jour");
                            } else {
                                printf("Aucune donnée à mettre à jour");
                            }
                        }
                    } else {
                        if ($row["Name"] != $colonne1) {
                            $stmt = $conn->prepare("UPDATE produits SET Name = ? WHERE ProduitID = ?");
                            $stmt->bind_param("ssi", $colonne1, $lastInsertedIdProduit);
                            if ($stmt->execute()) {
                                printf("Les données ont été mis a jour");
                            } else {
                                printf("Aucune donnée à mettre à jour");
                            }
                        }
                    }
                } else {
                    $stmt->close();
                    $stmt = $conn->prepare("INSERT INTO produits (Name, Image) 
                            VALUES (?, ?)");
                    $stmt->bind_param("ss", $colonne1, $colonne3);

                    if ($stmt->execute()) {
                        $countProduit++;
                        $lastInsertedIdProduit = $conn->insert_id;
                    } else {
                        $errorProduit++;
                    }
                }


                //AJOUT DANS CARTES

                $stmt = $conn->prepare("SELECT * FROM cartes WHERE idProduit = ? and idBar = ?");
                $stmt->bind_param("ii", $lastInsertedIdProduit, $lastInsertedIdBar);
                $stmt->execute();

                $result = $stmt->get_result();
                $rowCount = $result->num_rows;

                if ($rowCount > 0) {
                    $stmt->close();

                    if ($row["idProduit"] != $lastInsertedIdProduit || $row["idBar"] != $lastInsertedIdBar || $row["prix"] != $colonne2) {
                        $stmt = $conn->prepare("UPDATE cartes SET idProduit = ?, idBar = ?, prix = ? WHERE idProduit = ? and idBar = ?");
                        $stmt->bind_param("iidii", $lastInsertedIdProduit, $lastInsertedIdBar, $colonne2, $lastInsertedIdProduit, $lastInsertedIdBar);
                        if ($stmt->execute()) {
                            printf("Les données ont été mis a jour");
                        } else {
                            printf("Aucune donnée à mettre à jour");
                        }
                    }
                } else {
                    $stmt->close();
                    $stmt = $conn->prepare("INSERT INTO cartes (idProduit, idBar, prix) 
                            VALUES (?, ?, ?)");
                    $stmt->bind_param("iid", $lastInsertedIdProduit, $lastInsertedIdBar, $colonne2);

                    if ($stmt->execute()) {
                        $countCarte++;
                    } else {
                        $errorCarte++;
                    }
                }
                $stmt->close();
            }
        }
    }


    $conn->close();

    $message .= "nombre de produit par bar ajoute:$countCarte nombre de produit ajoute:$countProduit nombre erreur produit par bar ajoute:$errorCarte nombre erreur de nouveau produit ajoute:$errorProduit       Voulez-vous continuer à encoder des bars ?";

    // Afficher le message dans une boîte de dialogue
    echo '<script>var retour = confirm("' . $message . '");if(retour) {window.location.href = "index.php";} else {window.location.href = "index.php";}</script>';

    exit;
}


